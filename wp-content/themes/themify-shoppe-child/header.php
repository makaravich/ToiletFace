<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
	<?php
	wp_head();
	?>   
    </head>
    <body <?php body_class(); ?>>

	<?php
	global $themify;
	themify_body_start(); // hook 
	if (themify_theme_show_area('search_button')) {
	    get_template_part('includes/search-box');
	}
	?>
	<div id="pagewrap" class="tf_box hfeed site">
         <div class="top_mobile_header_content">
         	<?php dynamic_sidebar( 'top-bar-left'); ?>
         </div>

	    <?php if (themify_theme_show_area('header') && themify_theme_do_not_exclude_all('header')) : ?>

		<?php
			$header_design=  themify_theme_get_header_design();
			$cl='tf_box tf_w';
			if($header_design==='header-left-pane' || $header_design==='header-right-pane'){
				$cl.=' tf_scrollbar';
			}
		?>
    	    <div id="headerwrap" <?php themify_theme_header_background('header',$cl) ?>>
		    <?php
		    $header_widgets = themify_theme_show_area('top_bar_widgets');
		    $show_cart = themify_is_woocommerce_active() && themify_theme_show_area('cart');
		    $cart_style = $show_cart === true ? themify_get_cart_style():false;
			global $woocommerce;
		    $total = $show_cart === true ? $woocommerce->cart->get_cart_contents_count() : 0;
		    if ($header_widgets) {
			ob_start();
			get_template_part('includes/top-bar-widgets');
			$header_widgets= ob_get_contents();
			ob_end_clean();
            echo $header_widgets;
		    } // exclude top_bar_widgets 
		    ?>
    		<!-- /Top bar widgets -->

		    <?php themify_header_before(); // hook   ?>

    		<header id="header" class="pagewidth tf_box tf_rel clearfix" itemscope="itemscope" itemtype="https://schema.org/WPHeader">

			<?php
			$show_mobile_menu = themify_theme_do_not_exclude_all('mobile-menu');
			$show_menu_navigation = $show_mobile_menu && themify_theme_show_area('menu_navigation');
			$cart_is_dropdown=$cart_style==='dropdown';
			themify_header_start(); // hook 
			?>

			<?php if ($show_menu_navigation===true): ?>
			    <?php if ($show_cart === true && $header_design!=='header-left-pane'&& $header_design!=='header-right-pane'&& $header_design!=='header-minbar-left'&& $header_design!=='header-minbar-right'): ?>
			    
			    <div class="mobile-account-menu">
			        <a href="https://toiletface.co.uk/my-account/">
			            <i class="icon-user">
					    <?php echo themify_get_icon('user','ti'); ?>
					</i>
			        </a>
			    </div>
				<div id="cart-link-mobile" class="tf_hide tf_text_dec">
				    <a <?php if ($cart_is_dropdown === false && $cart_style !== 'link_to_cart'): ?>id="cart-link-mobile-link"<?php endif; ?> class="icon-menu tf_right" href="<?php echo $cart_is_dropdown === true || $cart_style === 'link_to_cart' ? wc_get_cart_url() : '#slide-cart'; ?>">
					<i class="icon-shopping-cart">
					    <?php echo themify_get_icon('shopping-cart','ti'); ?>
					</i>
					<span class="icon-menu-count<?php if ($total <= 0): ?> cart_empty<?php endif; ?>"><?php echo $total; ?></span>
				    </a>
				    <?php 
					if($cart_style !== 'slide-out' && $cart_style !== 'link_to_cart'){
						themify_get_ecommerce_template('includes/shopdock');
					}
				    ?>
				</div>
			    <?php endif; ?>
			    <a id="menu-icon" class="tf_text_dec tf_box" href="#mobile-menu"><span class="menu-icon-inner tf_vmiddle tf_inline_b tf_rel tf_box"></span>
			    <span class="menu-name">Menu</span>
			    </a>
			<?php endif; ?>

    		    <div class="logo-wrap tf_inline_b tf_rel">
			    <?php
			    if (themify_theme_show_area('site_logo')) {
				echo themify_logo_image();
			    }
			    if (themify_theme_show_area('site_tagline')) {
				echo themify_site_description();
			    }
			    ?>
			    <div id="site-logo-mobile"><a href="https://toiletface.co.uk" title="Toilet Face"><img src="https://toiletface.co.uk/wp-content/uploads/2021/08/logo-smaller-no-icon.png"  alt="Toilet Face" title="logo-for-Header"  class="site-logo-image"></a></div>
    		    </div>
				<?php
				if($header_design==='header-slide-left' || $header_design==='header-slide-right'){ 
				    include THEME_DIR.'/includes/header-icons.php';
				}
				?>
				<div class="mob-search"><?php echo do_shortcode( '[widget id="woocommerce_product_search-4"]' ); ?></div>
				
			<div id="mobile-menu" class="sidemenu sidemenu-off<?php if($header_design!=='header-left-pane' && $header_design!=='header-right-pane'):?> tf_scrollbar<?php endif;?>">
			    <?php if ($header_design === 'header-overlay'): ?>
				    <div class="overlay-menu-sticky">
			    <?php endif; ?>
			    <?php include 'includes/header-icons.php'; ?>
                <?php themify_mobile_menu_start(); // hook   ?>
                <?php if (themify_theme_show_area('menu_navigation')): ?>
                <nav id="main-nav-wrap" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">
                	 <?php echo get_product_search_form(); ?>
                    <?php themify_menu_nav( array( 'walker' => new Themify_Mega_Menu_Walker) );?>
                    <!-- /#main-nav -->

                </nav>

                <?php
                endif;
                if ($header_widgets) {
                echo $header_widgets;
                } // exclude top_bar_widgets
                ?>
                <a id="menu-icon-close" class="tf_hide tf_text_dec tf_close" aria-label="<?php _e('Close menu','themify'); ?>" href="#mobile-menu"></a>

                <?php themify_mobile_menu_end(); // hook ?>
			    <?php if ($header_design === 'header-overlay'): ?>
				</div>
			    <?php endif; ?>
			</div>
			<?php if ($themify->sticky_sidebar) : ?>
			    <div id="toggle-mobile-sidebar-button" class="open-toggle-sticky-sidebar toggle-sticky-sidebar tf_hide">
					<i class="mobile-sticky-sidebar-icon "></i>
			    </div>
			<?php endif; ?>
    		    <!-- /#mobile-menu -->

			<?php if ($cart_style === 'slide-out'): ?>
			    <div id="slide-cart" class="sidemenu sidemenu-off tf_block tf_overflow tf_box">
				<a id="cart-icon-close" class="tf_close"></a>
				<?php themify_get_ecommerce_template('includes/shopdock'); ?>
			    </div>
			    <!-- /#slide-cart -->
			<?php endif; ?>

			<?php themify_header_end(); // hook   ?>

    		</header>
    		<!-- /#header -->

		    <?php themify_header_after(); // hook   ?>

    	    </div>
	    <?php endif; ?>
	    <!-- /#headerwrap -->

	    <div id="body" class="tf_clear tf_box tf_mw clearfix">
		<?php themify_layout_before(); //hook