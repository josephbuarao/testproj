<?php
class TestProject {
    private $settings;

    public function __construct() {
        $this->settings = new TestProject_Plugin_Settings();
        // Add other initialization tasks...

        add_action('admin_menu', array($this, 'add_plugin_menu'));
        add_action( 'woocommerce_cart_calculate_fees', array($this, 'implment_discount')  );
    }

    public function add_plugin_menu() {
        add_options_page('Discount By Country', 'Discount By Country', 'manage_options', 'discount-by-country-settings', array($this, 'render_settings_page'));
    }

    public function render_settings_page() {
        // Render settings page HTML here
        ?>
        <div class="wrap">
            <h2>Discount By Country Plugin Settings</h2>
            
            <form method="post" action="options.php">
                <?php
                settings_fields('testproj_options');
                do_settings_sections('testproj_options');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }


    public function implment_discount( $cart ){
        $countries = get_option('testproj_option_name');

        //print_r( $options );

        // Configures IP2Location.io API key
        $config = new \IP2LocationIO\Configuration('5118A7B3E0FFC77AEF6A00037EAA9CDA');

        $customer_ip = $this->get_customer_ip();

        // Lookup ip address geolocation data
        $ip2locationio = new IP2LocationIO\IPGeolocation($config);
        try {
            $result = $ip2locationio->lookup($customer_ip);
            
            //Set Default Discount
            $country_discount = 0;
            
            foreach( $countries as $country){
                for( $i = 0; $i < count( $country); $i++ ){
                    
                    if( $result->country_code === $country[$i]['country']){
                        $country_name       = $country[$i]['country'];
                        $country_discount   = $country[$i]['discount'];
                    }
                }
            }

            // Calculate the discount
            $discount = ( $cart->subtotal * $country_discount ) / 100;

            // Add the discount
            $cart->add_fee( 'Discount (' .$country_discount  . '%)', -$discount );
            
        } catch(Exception $e) {
            var_dump($e->getCode() . ": " . $e->getMessage());
        }

    }


    private function get_customer_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED']) && !empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && !empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR']) && !empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED']) && !empty($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        // Handle multiple IP addresses (e.g., in HTTP_X_FORWARDED_FOR)
        if (strpos($ipaddress, ',') !== false) {
            $ipaddress = explode(',', $ipaddress)[0];
        }

        return $ipaddress;
    }
    
    
    
    

}
