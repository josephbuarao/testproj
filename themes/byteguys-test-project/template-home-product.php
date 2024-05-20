<?php
/* Template Name: Homepage Product */

get_header( 'shop' );
do_action( 'woocommerce_before_main_content' );
?>

<div id="primary" class="content-area woocommerce">
    <main id="main" class="site-main" role="main">
        <div class="wrapper">
            <div class="product">
                <?php
                
                // Replace with your product ID
                $product_id = 15; 
                $product = wc_get_product( $product_id );

                if ( $product ) :
                    setup_postdata( $product->get_id() ); ?>

                    <div class="product-details-wrapper">
                        <div class="product-gallery-wrapper">
                            <?php // Output product gallery
                                echo '<div class="product-gallery">';
                                    do_action( 'woocommerce_before_single_product_summary' );
                                echo '</div>';
                            ?>
                        </div>

                        <div class="product-information-wrapper">
                            <?php 
                                // Output product title
                                echo '<h1 class="product-title">' . $product->get_name() . '</h1>';

                                // Output product price
                                echo '<p class="price">Price: ' . $product->get_price_html() . '</p>';

                                //Add To Cart
                                woocommerce_template_single_add_to_cart();
                            ?>
                        </div>
                    </div>

                    <div class="product-description-wrapper">
                        <?php 
                        // Output product description
                        echo '<div class="product-description">';
                            echo wp_kses_post( $product->get_description() );
                        echo '</div>';
                        ?>
                    </div>

                <?php wp_reset_postdata();
                else :
                    echo '<p>Product not found.</p>';
                endif;
                ?>
            </div>    
        </div>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );

do_action( 'woocommerce_after_single_product_summary' );
?>
