<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7 ltie8 ltie9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8 ltie9" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php bloginfo('name'); ?>  <?php wp_title(); ?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php 
		global $theme_option, $gdlr_post_option;
		if( !empty($gdlr_post_option) ){ $gdlr_post_option = json_decode($gdlr_post_option, true); }
		
		wp_head(); 
	?>
</head>

<body <?php body_class(); ?>>
<?php
	$body_wrapper = '';
	if($theme_option['enable-boxed-style'] == 'boxed-style'){
		$body_wrapper = 'gdlr-boxed-style';
		if( !empty($theme_option['boxed-background-image']) && is_numeric($theme_option['boxed-background-image']) ){
			$alt_text = get_post_meta($theme_option['boxed-background-image'] , '_wp_attachment_image_alt', true);	
			$image_src = wp_get_attachment_image_src($theme_option['boxed-background-image'], 'full');
			echo '<img class="gdlr-full-boxed-background" src="' . $image_src[0] . '" alt="' . $alt_text . '" />';
		}else if( !empty($theme_option['boxed-background-image']) ){
			echo '<img class="gdlr-full-boxed-background" src="' . $theme_option['boxed-background-image'] . '" />';
		}
	}
?>
<div class="body-wrapper <?php echo $body_wrapper; ?>">
	<?php 
		// page style
		if( empty($gdlr_post_option) || empty($gdlr_post_option['page-style']) ||
			  $gdlr_post_option['page-style'] == 'normal' || 
			  $gdlr_post_option['page-style'] == 'no-footer'){ 
			  
		$header_class  = 'gdlr-header-' . $theme_option['header-style'];
		$header_class .= ($theme_option['enable-float-menu'] != 'disable')? ' float-menu': '';
	?>
	<header class="gdlr-header-wrapper <?php echo $header_class; ?>">

		<!-- top navigation -->
		<?php if( empty($theme_option['enable-top-bar']) || $theme_option['enable-top-bar'] == 'enable' ){ ?>
		<div class="top-navigation-wrapper">
			<div class="top-navigation-container container">
				
				<div class="top-navigation-right">
				<div class="top-navigation-left">					<ul class="gdlr-top-menu sf-menu" id="gdlr-top-navigation" >						<?php do_action('gdlr_top_left_menu'); ?>					</ul>				</div>	
					<div class="top-social-wrapper">
						<?php gdlr_print_header_social(); ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<?php } ?>
		
		<div class="gdlr-header-substitute">
			<div class="gdlr-header-inner">
				<div class="gdlr-header-container container">
					<!-- logo -->
                                        <div  id="logoDiv">
                                        <div class="gdlr-logo">
						<?php echo (is_front_page())? '<h1>':''; ?>
						<a href="<?php echo home_url(); ?>" >
							<?php 
								if(empty($theme_option['logo-id'])){ 
									echo gdlr_get_image(GDLR_PATH . '/images/logo.png');
								}else{
									echo gdlr_get_image($theme_option['logo-id']);
								}
							?>						
						</a>
						<?php echo (is_front_page())? '</h1>':''; ?>
					</div>
                                        </div>
					<?php 
						// navigation for style 1
						if( $theme_option['header-style'] == 'style-1' ){
							echo '<div class="gdlr-navigation-wrapper gdlr-style-1">';
							get_template_part( 'header', 'nav' ); 
							echo '</div>';
						}else if( $theme_option['header-style'] == 'style-2' ){
							echo '<div class="gdlr-logo-right-text">';
							echo gdlr_content_filter($theme_option['right-text']);
							echo '</div>';
						}
						
						// mobile navigation
						if( class_exists('gdlr_dlmenu_walker') && ( empty($theme_option['enable-responsive-mode']) || $theme_option['enable-responsive-mode'] == 'enable' ) ){
							echo '<div class="gdlr-responsive-navigation dl-menuwrapper" id="gdlr-responsive-navigation" >';
							echo '<button class="dl-trigger">Open Menu</button>';
							wp_nav_menu( array(
								'theme_location'=>'main_menu', 
								'container'=> '', 
								'menu_class'=> 'dl-menu gdlr-main-mobile-menu',
								'walker'=> new gdlr_dlmenu_walker() 
							) );						
							echo '</div>';
						}						
					?>
					
					<div class="clear"></div>
				</div>
			</div>
		</div>
		
		<?php 
			// navigation for style 2
			if( strpos($theme_option['header-style'], 'style-2') !== false ){
				echo '<div class="gdlr-navigation-substitute">';
				echo '<div class="gdlr-navigation-wrapper gdlr-' . $theme_option['header-style'] . '">';
				echo '<div class="gdlr-navigation-container container">';
				echo '<div class="gdlr-navigation-slide-bar"></div>';
				get_template_part( 'header', 'nav' ); 
				echo '<div class="clear"></div>';
				echo '</div>'; // gdlr-navigation-container
				echo '</div>'; // gdlr-navigation-wrapper
				echo '</div>'; // gdlr-navigation-substitute
			}

		?>
		<div class="clear"></div>
		<?php if( empty($theme_option['enable-top-search']) || $theme_option['enable-top-search'] == 'enable' ){ ?>
		<div class="gdlr-nav-search-form" id="gdlr-nav-search-form">
			<div class="gdlr-nav-search-container container"> 
			<form method="get" action="<?php  echo home_url(); ?>">
				<i class="icon-search"></i>
				<input type="submit" id="searchsubmit" class="style-2" value="">
				<div class="search-text" id="search-text">
					<input type="text" value="" name="s" id="s" autocomplete="off" data-default="<?php _e("Type keywords..." , "gdlr_translate"); ?>" >
				</div>
				<div class="clear"></div>
			</form>
			</div>
		</div>	
		<?php } 
			get_template_part( 'header', 'title' ); 
		?>
	</header>
	<?php } // page style ?>
	<div class="content-wrapper">    
