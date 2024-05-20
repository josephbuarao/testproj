<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package ByteGuys_Test_Project
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function byteguys_test_project_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'byteguys_test_project_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function byteguys_test_project_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'byteguys_test_project_pingback_header' );


// Enable WooCommerce product gallery features (zoom, lightbox, slider)
add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');

function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}

add_action( 'wp', 'remove_image_zoom_support', 100 );



// Add cart icon with total amount in the menu bar
function byteguys_test_project_woo_menu_cart_total($menu, $args) {
    // Check if the current menu location is 'primary' (adjust according to your menu location)
    if ( 'menu-1' === $args->theme_location ) {
		ob_start();
        $cart_count = WC()->cart->get_cart_contents_count(); // Get cart item count
        $cart_url = wc_get_cart_url(); // Get cart URL

        // Create menu item with only item count
        ?>
        <li class="menu-item menu-item-type-cart">
            <a class="cart-contents" href="<?php echo esc_url($cart_url); ?>" title="<?php esc_attr_e('View your shopping cart'); ?>">
			<i class="fas fa-shopping-cart"></i> <span class="count"><?php echo $cart_count; ?></span>
            </a>
        </li>
        <?php
        $menu .= ob_get_clean();
    }
    return $menu;
}

//add_filter('wp_nav_menu_items', 'byteguys_test_project_woo_menu_cart_total', 10, 2);

add_action('template_redirect', function() {
    if (is_shop()) {
        wp_redirect(home_url());
        exit;
    }
});
