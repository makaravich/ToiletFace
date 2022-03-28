<?php
function wpdocs_theme_name_scripts() {
    wp_enqueue_style( 'style-name', get_stylesheet_uri() );
     wp_enqueue_style( 'responsive-css-style', 
get_stylesheet_directory_uri()."/responsive.css" );
     wp_enqueue_style( 'custom-css-style', 
get_stylesheet_directory_uri()."/custom.css" );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );


if ( ! function_exists( 'mytheme_register_nav_menu' ) ) {
 
    function mytheme_register_nav_menu(){
        register_nav_menus( array(
            'mobile1_menu' => __( 'mobile Menu', 'text_domain' )
        ) );
    }
    add_action( 'after_setup_theme', 'mytheme_register_nav_menu', 0 );
}


// old website filters and shortcode
// Change WooCommerce "Related products" text

add_filter('gettext', 'change_rp_text', 10, 3);
add_filter('ngettext', 'change_rp_text', 10, 3);

function change_rp_text($translated, $text, $domain)
{
     if ($text === 'Related products' && $domain === 'woocommerce') {
         $translated = esc_html__('You May Also Like', $domain);
     }
     return $translated;
}


add_shortcode('my-gallery', 'my_gallery_func');
function my_gallery_func($atts, $content){
    ob_start();
    $path = WooCommerce::plugin_path();
    include($path . '/templates/single-product/product-thumbnails.php');
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/**
 * Remove product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    
    unset( $tabs['reviews'] ); 			// Remove the reviews tab
    unset( $tabs['additional_information'] );  	// Remove the additional information tab

    return $tabs;
}

/**
 * Add a custom product data tab
 */
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
	
	// Adds the new tab
	
	$tabs['test_tab'] = array(
		'title' 	=> __( 'Delivery', 'woocommerce' ),
		'priority' 	=> 20,
		'callback' 	=> 'woo_new_product_tab_content'
	);
	$tabs['test_tab1'] = array(
		'title' 	=> __( 'Customer Reviews', 'woocommerce' ),
		'priority' 	=> 30,
		'callback' 	=> 'woo_new_product_tab_content_review'
	);

	return $tabs;

}
function woo_new_product_tab_content() {

	// The new tab content

	echo '<h2>New Product Tab</h2>';
	echo '
<p>We ship <strong>worldwide</strong> from our Sheffield (UK) printers, Monday to Friday. Items are posted in a reinforced box, preventing any damage in transit.</p>
<p><strong>Delivery to the United Kingdom (domestic)</strong></p>
<table border="0" style="border-collapse: collapse; width: 100%; background-color: #ed7d31; border-color: #ed7d31; color: #fff; margin-bottom: 10px;">
<tbody>
<tr>
<td style="width: 33.3333%; text-align: center;"><img src="'.site_url().'/wp-content/uploads/2020/10/Delivery-Icon.-Standard-shipping.png" alt="" width="175" height="100" /></td>
<td style="width: 33.3333%;">
<p><strong>UK Standard Delivery </strong></p>
<p><strong>Hermes Tracked</strong></p>
<p><strong>&pound;2.79</strong></p>
</td>
<td style="width: 33.3333%;">
<p>Delivery within 6 &ndash; 7 working Days</p>
</td>
</tr>
</tbody>
</table>
<table border="0" style="border-collapse: collapse; width: 100%; background-color: #ed7d31; border-color: #ed7d31; color: #fff; margin-bottom: 10px;">
<tbody>
<tr>
<td style="width: 33.3333%; text-align: center;"><img src="'.site_url().'/wp-content/uploads/2020/10/Delivery-Icon.-Standard-shipping.png" alt="" width="175" height="100" /></td>
<td style="width: 33.3333%;">
<p><strong>UK Express Delivery </strong></p>
<p><strong>Hermes Tracked</strong></p>
<p><strong>&pound;4.99</strong></p>
</td>
<td style="width: 33.3333%;">
<p>Delivery within 3 &ndash; 5 working Days</p>
</td>
</tr>
</tbody>
</table>
<table border="0" style="border-collapse: collapse; width: 100%; background-color: #8da9db; border-color: #8da9db; color: #fff;">
<tbody>
<tr>
<td style="width: 33.3333%; text-align: center;"><img src="'.site_url().'/wp-content/uploads/2020/10/Delivery-Icon.-Express-shipping-shipping.png" alt="" width="175" height="100" /></td>
<td style="width: 33.3333%;">
<p><strong>UK Express Delivery </strong></p>
<p><strong>HermesTracked</strong></p>
<p><strong>&pound;7.79</strong></p>
</td>
<td style="width: 33.3333%;">
<p>Delivery within 2 working days</p>
</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<p>International Delivery (outside the UK)</p>
<p>All international orders are sentvia a tracked air mail courier (Royal Mail / Hermes / Landmark). Delivery starts at &pound;8.99 for orders 1kg or less and only increases by &pound;1.99 per 200g.</p>
<table border="0" style="border-collapse: collapse; width: 100%; background-color: #92d050; border-color: #92d050; color: #fff;">
<tbody>
<tr>
<td style="width: 33.3333%; text-align: center;"><img src="'.site_url().'/wp-content/uploads/2020/10/Delivery-Icon.-International-shipping-shipping.png" alt="" width="175" height="100" /></td>
<td style="width: 33.3333%;">
<p><strong>International Delivery</strong></p>
<p><strong>Europe &pound;8.99</strong></p>
<p><strong>Zone 1 &pound;9.99</strong></p>
<p><strong>Zone 2 &pound;12.99</strong></p>
</td>
<td style="width: 33.3333%;">
<p>Delivery Estimate</p>
<p>8 &ndash; 12&nbsp;&nbsp; Working Days</p>
<p>12 &ndash; 14 Working Days</p>
<p>12 &ndash; 14 Working Days</p>
</td>
</tr>
</tbody>
</table>
';
	
}
// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Add to Basket', 'woocommerce' ); 
}

// To change add to cart text on product archives(Collection) page
// Upwork: Bruce: Disabled as per request on March 9 2022
/*
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Personalise it', 'woocommerce' );
}
*/
function woo_new_product_tab_content_review() {
	echo '<h1 class="khmer-bold" style="color: #210a63;">We love our customers!</h1>  <p class="khmer" style="color: #000;">We love our customers and it would appear they love us too! Below is a live stream of our reviews taken from our Facebook Page (please tag us) and Google Review Page.</p> <p class="khmer" style="color: #000;"> We aim for a <strong>5-star rating on every transaction</strong>. We pride ourselves on our customer service and endeavour to exceed customer expectations. You will receive an email link 14 days after your purchase from Toilet Face giving you the option to leave feedback.</p>';
	
	echo '<div style="text-align:center; margin-bottom: 30px;"><div data-token="ZS8oDWijZ8InHmcsVqwrFNOky1IkZYuYWOdsAXoH5mJj1SVZLQ" class="romw-badge"></div>
<script src="https://reviewsonmywebsite.com/js/embedLoader.js?id=16985fd9e429040ba7c6" type="text/javascript"></script>';

	echo '<div data-token="CPo0zWHGsSsYczo5JUt9Sz6gzHpx6eILZjRoNhDM4EZ78zDsKB" class="romw-badge"></div>
<script src="https://reviewsonmywebsite.com/js/embedLoader.js?id=16985fd9e429040ba7c6" type="text/javascript"></script></div>';

	
	echo '<div data-token="ful9GdsfzED8EuJPO92rBqccT4s4ik2yIKLPhsEYuJOLwY0Dxz" class="romw-reviews"></div> 
<script src="https://reviewsonmywebsite.com/js/embedLoader.js?id=16985fd9e429040ba7c6" type="text/javascript"></script>';
}



//Hide Price Range for WooCommerce Variable Products
add_filter( 'woocommerce_variable_sale_price_html', 
'lw_variable_product_price', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 
'lw_variable_product_price', 10, 2 );

function lw_variable_product_price( $v_price, $v_product ) {

// Product Price
$prod_prices = array( $v_product->get_variation_price( 'min', true ), 
                            $v_product->get_variation_price( 'max', true ) );
$prod_price = $prod_prices[0]!==$prod_prices[1] ? sprintf(__('%1$s', 'woocommerce'), 
                       wc_price( $prod_prices[0] ) ) : wc_price( $prod_prices[0] );

// Regular Price
$regular_prices = array( $v_product->get_variation_regular_price( 'min', true ), 
                          $v_product->get_variation_regular_price( 'max', true ) );
sort( $regular_prices );
$regular_price = $regular_prices[0]!==$regular_prices[1] ? sprintf(__('%1$s','woocommerce')
                      , wc_price( $regular_prices[0] ) ) : wc_price( $regular_prices[0] );

if ( $prod_price !== $regular_price ) {
$prod_price = '<del>'.$regular_price.$v_product->get_price_suffix() . '</del> <ins>' . 
                       $prod_price . $v_product->get_price_suffix() . '</ins>';
}
return $prod_price;
}

add_filter( 'woocommerce_checkout_fields' , 'override_billing_checkout_fields', 20, 1 );
function override_billing_checkout_fields( $fields ) {
    $fields['billing']['billing_phone']['placeholder'] = 'Recommended (used by courier)';
    return $fields;
}


add_shortcode("novelty_cat","novelty_cat_funct");
function novelty_cat_funct(){
	$result = "";
	$args = array( 'post_type' => 'product', 'posts_per_page' => 8,'product_cat' => 'novelty-toilet-rolls', 'orderby' =>'date','order' => 'ASC' );
  $loop = new WP_Query( $args );
  $result .= '<div class="gutter-none p_container clearfix">';
foreach ($loop->posts as $key => $value) {
	$featured_img_url = get_the_post_thumbnail_url($value->ID,'full');
	$title = get_the_title($value->ID);
	$result .= '<div class="col4-1 p_container_inner">
  <a href="'.get_the_permalink($value->ID).'"><img src="'.$featured_img_url.'"></a>
  <p><a href="'.get_the_permalink($value->ID).'">'.$title.'</a></p>
	</div>';
	
}
$result .= '</div>';
return $result;

}

add_filter( 'woocommerce_billing_fields', 'ts_unrequire_wc_phone_field');
function ts_unrequire_wc_phone_field( $fields ) {
$fields['billing_phone']['required'] = false;
return $fields;
}


// if ( ! function_exists( 'yith_wc_barcodes_and_qr_filter_call_back' ) ) {
//     function yith_wc_barcodes_and_qr_filter_call_back( $order_id ){
//         ob_start();
//         $css = ob_get_clean();
//         YITH_YWBC()->show_barcode( $order_id, true, $css );
//     }
//     add_action( 'yith_wc_barcodes_and_qr_filter','yith_wc_barcodes_and_qr_filter_call_back', 10, 1 );
// }


// @Jun 24 2021
// if ( ! function_exists( 'yith_wc_barcodes_and_qr_filter_call_back' ) ) {
//     function yith_wc_barcodes_and_qr_filter_call_back( $order ){
//         ob_start();
//         $css = ob_get_clean();
//         YITH_YWBC()->show_barcode( $order->get_order_number(), true, $css );
//     }
//     add_action( 'wcdn_after_branding','yith_wc_barcodes_and_qr_filter_call_back', 10, 1 );
// }



if ( ! function_exists( 'yith_wc_barcodes_and_qr_filter_call_backoo' ) ) {
    function yith_wc_barcodes_and_qr_filter_call_backoo( $order ){
        ob_start();
        ?>
        </br>
        </br>
        <?php
        $css = ob_get_clean();
        YITH_YWBC()->show_barcode( $order->id, true, $css );
    }
    add_action( 'wcdn_after_info','yith_wc_barcodes_and_qr_filter_call_backoo', 10, 1 );
}



/**
 * wc_shipment_tracking_add_custom_provider
 *
 * Adds custom provider to shipment tracking
 * Change the country name, the provider name, and the URL (it must include the %1$s)
 * Add one provider per line
*/

add_filter( 'wc_shipment_tracking_get_providers' , 'wc_shipment_tracking_add_custom_provider' );

function wc_shipment_tracking_add_custom_provider( $providers ) {
	
	$providers['United Kingdom']['Ship station'] = 'https://www.myhermes.co.uk/track#/parcel/%1$s';
	return $providers;
	
}

add_filter( 'woocommerce_shipment_tracking_default_provider', 'custom_woocommerce_shipment_tracking_default_provider' );

function custom_woocommerce_shipment_tracking_default_provider( $provider ) {
	$provider = 'Ship station'; 
	return $provider;
}
add_action( 'wp_footer', function() { ?>
	<script>
jQuery( document ).ready(function() {
	var scrollTarget = jQuery('#product-title').offset().top;
	jQuery(window).scroll(function() {
		var scroll = jQuery(window).scrollTop();
  	if(scroll >= scrollTarget){
    	jQuery(".module-add-to-cart").addClass("fixed");
  	} else {
	  jQuery(".module-add-to-cart").removeClass("fixed");
  	}
});
	
});
</script>
<?php } );


function example_serif_font_and_large_address() {
    ?>
    <style>	
            p:nth-of-type(4n) {
                display: none !important;
            }
    </style>
    <?php
}
add_action( 'wcdn_head', 'example_serif_font_and_large_address', 20 ); 

// Upwork: 2022/02/28 (by bruce@parsed.nl) 
// Add images to admin order screen (and anywhere else this filter is used)
// NOTE: Adding the images to the PDF is done in the template override `woocommerce/print-order/print-content.php`
/*
add_filter('woocommerce_order_item_display_meta_value', function($meta_value, $meta, $item) {
    if (in_array($meta->key, ['Preview', 'Upload your image'])) {
        $link = $meta->value;
        try {
            $link = @new \SimpleXMLElement($link);
            $link = $link['href'];
            $meta_value = '<img src="' . $link . '" style="max-width: 150px;">';
        } catch (Exception $ex) {
            // do nothing
        }
    }
    return $meta_value;
}, 99, 3);
*/

// Not used: old PDF plugin
// add_action('wpi_order_item_meta_start', function( &$item, $order) {
//     var_dump($item->get_data()); die();
// }, 99, 2);

// Front-end (among others: checkout)
/* This might be causing an issue with previews in the back-end
add_filter( 'woocommerce_get_item_data', function($item_data, $cart_item) {
    foreach ( $item_data as $key => $data ) {
        try {
            $link = @new \SimpleXMLElement($data['value']);
            $link = $link['href'];
            $value = '<img src="' . $link . '" style="max-width: 150px;">';
            $data['value'] = $value;
            $item_data[$key] = $data;
        } catch (Exception $ex) {
            // do nothing
        }
    }

    return $item_data;
}, 999999999 + 1,  2); // fire after wc_customily_show_custom_data_in_cart filter
*/

/*
if (current_user_can('manage_options')) {
    require_once(__DIR__ . '/wip.php');
}
*/
// END Upwork
