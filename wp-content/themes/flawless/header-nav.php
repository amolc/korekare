<?php 
	if( has_nav_menu('main_menu') ){
		if( class_exists('gdlr_menu_walker') ){
			echo '<nav class="gdlr-navigation" id="gdlr-main-navigation" role="navigation">';
			wp_nav_menu( array(
				'theme_location'=>'main_menu', 
				'container'=> '', 
				'menu_class'=> 'sf-menu gdlr-main-menu',
				'walker'=> new gdlr_menu_walker() 
			) );
		}else{
			echo '<nav class="gdlr-navigation" role="navigation">';
			wp_nav_menu( array('theme_location'=>'main_menu') );
		}
		
		global $theme_option;
		if( empty($theme_option['enable-top-search']) || $theme_option['enable-top-search'] == 'enable' ){
			echo '<div class="gdlr-nav-search-form-button" id="gdlr-nav-search-form-button"><i class="icon-search"></i></div>';
		}
		echo '</nav>'; // gdlr-navigation
	}
?>