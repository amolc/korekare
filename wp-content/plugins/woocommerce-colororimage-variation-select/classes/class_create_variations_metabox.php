<?php
class wcva_add_colored_variation_metabox {
    /*
	 * Construct
	 * since version 1.0.0
	 */
       public function __construct() {
	   
	     add_action('admin_enqueue_scripts', array(&$this, 'wcva_register_scripts'));
	     add_action('woocommerce_product_write_panel_tabs', array($this, 'wcva_add_colored_variable_metabox'));
	     add_action('woocommerce_product_write_panels', array($this, 'colored_variable_tab_options'));
	     add_action('woocommerce_process_product_meta', array($this, 'process_product_meta_colored_variable_tab'), 10, 2);
	   
	   }
	/*
	 * Add metabox tab
	 * since version 1.0.0
	 */
	   public function wcva_register_scripts() {
	   
	      wp_register_script( 'wcva-meta', ''.wcva_PLUGIN_URL.'js/wcva-meta.js' );
	      wp_register_script( 'jquery.accordion', ''.wcva_PLUGIN_URL.'js/jquery.accordion.js' );
	      wp_register_style( 'wcva-meta', ''.wcva_PLUGIN_URL.'css/wcva-meta.css' );
	      wp_register_style( 'jquery.accordion', ''.wcva_PLUGIN_URL.'css/jquery.accordion.css' );
	      wp_register_style( 'example-styles', ''.wcva_PLUGIN_URL.'css/example-styles.css' );
          $translation_array = array( 
		      'uploadimage'    => __( 'Choose an image' ,'wcva'),
			  'useimage'       => __( 'Use Image' ,'wcva'),
			  'placeholder'    => wedd_placeholder_img_src(),
		    );
           wp_localize_script( 'wcva-meta', 'wcvameta', $translation_array );
	     
	   
	     
	   }
	/*
	 * Add metabox tab
	 * since version 1.0.0
	 */
	   
       public function wcva_add_colored_variable_metabox() {
	   ?>
        <a href="#colored_variable_tab_data"><li class="colored_variable_tab show_if_variable" ><?php _e('Variation Select', 'wcva'); ?></a></li>
	   <?php }
	

	/*
	 * Adds metabox tab content
	 * since version 1.0.0
	 */
	   public function colored_variable_tab_options() {
	     global $post,$woocommerce;
	   
	        $woo_version        =  wcva_get_woo_version_number();
	        $_coloredvariables  = get_post_meta( $post->ID, '_coloredvariables', true );
	   
	        
			
	        wp_enqueue_script('wcva-meta');
	        wp_enqueue_script('jquery.accordion');
	        wp_enqueue_style('wcva-meta');
	        wp_enqueue_style('jquery.accordion');
	        wp_enqueue_style('jquery.accordion');
	        wp_enqueue_style('example-styles');
	        wp_enqueue_script('wp-color-picker');
            wp_enqueue_style( 'wp-color-picker' );
	        wp_enqueue_media();
	 
      ?>
	   

	 <div id="colored_variable_tab_data" class="panel woocommerce_options_panel">
	    
        <?php $product = get_product($post->ID); ?>
	    <?php if ( $product->product_type == 'variable' ) : ?>
	    <?php $product = new WC_Product_Variable( $post->ID ); ?> 
	    <?php $attributes = $product->get_variation_attributes(); ?>
	    <?php endif;  ?>

	    <br />
	    <div class="colororimagediv">
	      <table class="widefat" width="100%" border="0">
	       <tr>
	         <th width="30%" ><span class="wcvaheader"><?php echo __('Attribute Name','wcva'); ?> </span></th>
	         <th width="70%" ><span class="wcvaheader"><?php echo __('Type','wcva'); ?></span></th>
	         </tr>
	      </table>
	     <br />
         
		<?php $attrnumber=0; $displaytypenumber=0; ?>
        <?php if ((!empty($attributes)) && (sizeof($attributes) >0)) { ?>
	    <?php foreach ($attributes as $key=>$values) { ?>
	    <?php 
		
	      if ( taxonomy_exists( sanitize_title( $key ) ) ) {
			  
			      $terms = get_terms( sanitize_title($key), array('menu_order' => 'ASC') );
			  } 
        
        ?>
	
	    <div class="main-content">
	     <div class="accordion-container">
	      <div class="accordion collapsed">
		    <div class="accordion-header" data-action="accordion" style="position: relative;">
			  <div class="attribute-label" style="position: absolute; top: 10px; left: 10px; font-family:Sans-serif; font-size:14px; ">
			  <?php
			  if ($woo_version <2.1) {
	                          		echo $woocommerce->attribute_label( $key );  
	                        } else {
	                                echo wc_attribute_label( $key );
	                        }
							
			  ?>
			  </div>
			    
			  <div class="mainpreviewdiv" style="height: 25px; position: absolute top: 5px; right: 5px; margin-left:170px;">
		  
                <?php 
				if (isset($_coloredvariables[$key]['display_type'])) {
				  switch($_coloredvariables[$key]['display_type']) {
				    case "none":
				     echo '<strong>'.__('Dropdown Select','wcva').'</strong>';
				    break;
				  
				    case "colororimage":
				     echo '<strong>'.__('Color/Image Select','wcva').'</strong>';
				    break;
				  
				    case "radio":
				     echo '<strong>'.__('Radio Select','wcva').'</strong>';
				    break;
				  
				    
				     
				} 
				} else {
				    echo '<strong>'.__('Dropdown Select','wcva').'</strong>';
				}  
				?>
			    
			  </div>
		</div>
		<div class="accordion-content">
         <p class="form-field"><label for="_label_text"><span class="wcvaformfield"><?php echo __('Label Text','wcva'); ?></span></label>
		 <input type="text" name="coloredvariables[<?php echo $key; ?>][label]" value="<?php if (isset($_coloredvariables[$key]['label'])) { echo $_coloredvariables[$key]['label'];} else { 
		 
		     if ($woo_version <2.1) { echo $woocommerce->attribute_label( $key );  } else { echo wc_attribute_label($key); } }
		   ?>">
		 </p>
		 
		 <p class="form-field"><label for="_display_type"><span class="wcvaformfield"><?php echo __('Display Type','wcva'); ?></span></label>
	       <select name="coloredvariables[<?php echo $key; ?>][display_type]" class="wcvadisplaytype">
	         <option value="none" <?php if (isset($_coloredvariables[$key]['display_type']) && ($_coloredvariables[$key]['display_type'] == 'none')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('Dropdown Select ( Default )','wcva'); ?></span></option>
		     <option value="colororimage" <?php if (isset($_coloredvariables[$key]['display_type']) && ($_coloredvariables[$key]['display_type'] == 'colororimage')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('Image or Color','wcva'); ?></span></option>
		     <option value="radio" <?php if (isset($_coloredvariables[$key]['display_type']) && ($_coloredvariables[$key]['display_type'] == 'radio')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('Radio Select','wcva'); ?></span></option>
	       </select>
	     </p>
		 
		<div class="wcvaimageorcolordiv" style="<?php if (isset($_coloredvariables[$key]['display_type']) && ($_coloredvariables[$key]['display_type'] == 'colororimage')) { echo 'display:;'; } else { echo 'display:none;'; } ?>">
		
		 
		 <p class="form-field"><label for="_display_size"><span class="wcvaformfield"><?php echo __('Display Size','wcva'); ?></span></label>
		    <select name="coloredvariables[<?php echo $key; ?>][size]">
	         <option value="small"  <?php if (isset($_coloredvariables[$key]['size']) && ($_coloredvariables[$key]['size'] == 'small')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('Small (32px * 32px)','wcva'); ?></span></option>
		     <option value="extrasmall" <?php if (isset($_coloredvariables[$key]['size']) && ($_coloredvariables[$key]['size'] == 'extrasmall')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('Extra Small (22px * 22px)','wcva'); ?></span></option>
		     <option value="medium" <?php if (isset($_coloredvariables[$key]['size']) && ($_coloredvariables[$key]['size'] == 'medium')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('Middle (40px * 40px)','wcva'); ?></span></option>
		     <option value="big" <?php if (isset($_coloredvariables[$key]['size']) && ($_coloredvariables[$key]['size'] == 'big')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('Big (60px * 60px)','wcva'); ?></span></option>
		     <option value="extrabig" <?php if (isset($_coloredvariables[$key]['size']) && ($_coloredvariables[$key]['size'] == 'extrabig')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('Extra Big (90px * 90px)','wcva'); ?></span></option>
		    </select>
			
		    <select name="coloredvariables[<?php echo $key; ?>][displaytype]">
	         <option value="square" <?php if (isset($_coloredvariables[$key]['displaytype']) && ($_coloredvariables[$key]['displaytype'] == 'square')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('Square','wcva'); ?></span></option>
		     <option value="round" <?php if (isset($_coloredvariables[$key]['displaytype']) && ($_coloredvariables[$key]['displaytype'] == 'round')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('Round','wcva'); ?></span></option>
		    </select>
		 </p>
		 
		 <p class="form-field"><label for="_show_name"><span class="wcvaformfield"><?php echo __('Show Attribute Name','wcva'); ?></span></label>
	        <select name="coloredvariables[<?php echo $key; ?>][show_name]" class="wcvadisplaytype">
	         <option value="no" <?php if (isset($_coloredvariables[$key]['show_name']) && ($_coloredvariables[$key]['show_name'] == 'no')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('No','wcva'); ?></span></option>
		     <option value="yes" <?php if (isset($_coloredvariables[$key]['show_name']) && ($_coloredvariables[$key]['show_name'] == 'yes')) { echo 'selected'; }?>><span class="wcvaformfield"><?php echo __('Yes','wcva'); ?></span></option>
		    </select>
	     </p>
		 
		 
		 <table class="widefat" width="100%" border="0">
	     <tr>
	     <th width="30%" ><span class="wcvaheader"><?php echo __('Value','wcva'); ?> </span></th>
	     <th width="70%" ><span class="wcvaheader"><?php echo __('Color/Image Preview','wcva'); ?></span></th>
	     </tr>
	     </table>
		 <br />
		 <?php $attrsubnumber=0; 
         foreach ($values as $value) {
		     if (isset($_coloredvariables[$key]['displaytype'])) { 
			    
				$displaytype = $_coloredvariables[$key]['displaytype']; 
				   
				   } else {$displaytype=''; }
				   
		        $valuetitle            = sanitize_title( $value );
		    
		 
		
               if (isset($terms)) {
				     foreach ( $terms as $term ) {
									   
                          if ( $term->slug != $value  ) continue; { 
										$valuetitle             = $term->name;
										$globalthumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) );
		                                $globaldisplay_type 	= get_woocommerce_term_meta($term->term_id, 'display_type', true );
		                                $globalcolor 	        = get_woocommerce_term_meta($term->term_id, 'color', true );
									 }
			         }					   
		            }			  
		    
		  
		  
		  
		    if ((isset($_coloredvariables[$key]['values'])) && (isset($_coloredvariables[$key]['values'][$value]['image']))) {
	            
				   $thumb_id = $_coloredvariables[$key]['values'][$value]['image']; $url = wp_get_attachment_thumb_url( $thumb_id ); 
		  
		    } elseif (isset($globalthumbnail_id)) {
		    
			     $thumb_id=$globalthumbnail_id; $url = wp_get_attachment_thumb_url( $globalthumbnail_id );
		    }
		  
		   if ((isset($_coloredvariables[$key]['values'])) && (isset($_coloredvariables[$key]['values'][$value]['type']))) {
	      
		        $attrdisplaytype = $_coloredvariables[$key]['values'][$value]['type'];
		  
		    } elseif (isset($globaldisplay_type)) {
		  
		        $attrdisplaytype = $globaldisplay_type;
		    }
		  
		  
		  if ((isset($_coloredvariables[$key]['values'])) && (isset($_coloredvariables[$key]['values'][$value]['color']))) {
	          
			    $attrcolor = $_coloredvariables[$key]['values'][$value]['color'];
		  
		  } elseif (isset($globalcolor)) {
		        
				$attrcolor = $globalcolor;
		  }
		 
		   ?>
	        
		<div class="accordion-container">
         <div class="accordion collapsed">
			<div class="accordion-header" data-action="accordion" style="position: relative;">	
				<div class="attribute-label" style="position: absolute; top: 10px; left: 10px; font-family:Sans-serif; font-size:14px; ">
				<?php echo $valuetitle; ?>
				</div>
					<div class="previewdiv" style="height: 25px;height: 25px; top: 5px; right: 5px; margin-left:170px;"><?php 
					if (isset($attrdisplaytype))  :
                    switch($attrdisplaytype) {
	                   case "Color":
	                     ?>
	                    <a class="imagediv_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" style="<?php if ($displaytype == "round") { echo '-moz-border-radius: 99em; -webkit-border-radius: 99em;'; } ?> display: inline-block; background-color: <?php if (isset($attrcolor)) { echo  $attrcolor; } else { echo 'grey'; } ?>;height: 22px;width: 22px;"></a>                                                              
	                    <?php
	                   break;
					   
	                    case "Image":
	                     ?>
	                     <a class="imagediv_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" style="<?php if ($displaytype == "round") { echo '-moz-border-radius: 99em; -webkit-border-radius: 99em;'; } ?>"><img src="<?php if (isset($url)) { echo $url; } ?>" width="22px" height="22px" style="<?php if ($displaytype == "round") { echo '-moz-border-radius: 99em; -webkit-border-radius: 99em;'; } ?>"></a>
	                     <?php
	                    break;
	                }
					endif;
	                ?></div>
		    </div>
		 
		 
         <div class="accordion-content">
		 <p class="form-field"><label for="_display_type"><span class="wcvaformfield"><?php echo __('Display Type','wcva'); ?></span></label> 
		 <select name="coloredvariables[<?php echo $key; ?>][values][<?php echo $value; ?>][type]" id="coloredvariables-<?php echo $attrnumber; ?>-values-<?php echo $attrsubnumber; ?>-type" class="wcvacolororimage">
	     <option value="Color" <?php if ((isset($attrdisplaytype))  && $attrdisplaytype == "Color" ) { echo 'selected'; } ?>><?php echo __('Color','wcva'); ?></option>
		 <option value="Image" <?php if ((isset($attrdisplaytype)) && $attrdisplaytype == "Image" ) { echo 'selected'; } ?>><?php echo __('Image','wcva'); ?></option>
		 </select>
		 </p>
		 <div class="wcvacolordiv" id="coloredvariables-<?php echo $attrnumber; ?>-values-<?php echo $attrsubnumber; ?>-color"  style="<?php if ((isset($attrdisplaytype)) && ($attrdisplaytype == "Image") ) { echo 'display:none;'; } else { echo 'display:;'; } ?>">
		 <p class="form-field">
		 <label for="_chose_color"><span class="wcvaformfield"><?php echo __('Chose Color','wcva'); ?></span></label> 
	     <input name="coloredvariables[<?php echo $key; ?>][values][<?php echo $value; ?>][color]" type="text" class="wcvaattributecolorselect" value="<?php if (isset($attrcolor)) { echo  $attrcolor; } else { echo '#ffffff'; }  ?>" data-default-color="#ffffff">
		 </p>
		 </div>
	
		  
		 <div class="wcvaimagediv" id="coloredvariables-image" style="<?php if ((isset($attrdisplaytype))  && ($attrdisplaytype == "Image")) { echo 'display:;'; } else { echo 'display:none;'; } ?>">
		 <p class="form-field"><label for="_chose_image"><span class="wcvaformfield"><?php echo __('Chose Image','wcva'); ?></span></label> 
	     <div class="facility_thumbnail" id="facility_thumbnail_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" style="margin-left:160px;"><img src="<?php echo $url; ?>" width="60px" height="60px" /></div>
				<div  class="image-upload-div" id="<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" style="line-height:60px; margin-left:160px;">
					<input type="hidden" class="facility_thumbnail_id_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?>" name="coloredvariables[<?php echo $key; ?>][values][<?php echo $value; ?>][image]" value="<?php echo $thumb_id; ?>"/>
					<button type="submit" class="upload_image_button_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?> button"><?php _e( 'Upload/Add image', 'wcva' ); ?></button>
					<button type="submit" class="remove_image_button_<?php echo $attrnumber; ?>_<?php echo $attrsubnumber; ?> button"><?php _e( 'Remove image', 'wcva' ); ?></button>
				</div>
		  </p>
		  </div>
		  </div>
		  </div>
		 
		 </div>
		 <?php $attrsubnumber++;
		       $globalthumbnail_id = ''; 
			   $globaldisplay_type = 'Color';
			   $globalcolor        =  'grey';
		       } ?>
	 
	    </div>
		</div>
		
	</div>
	
    </div>			
    
	<?php $attrnumber++; ?>
	</div>
	
	<?php 
	/*
	
	*/
	
	} }
   	?>
	</div>
	 </div>
	
	 <?php
    }
	
	
	/*
	 * Adds save metabox tab options
	 * since version 1.0.0
	 */
    
    public function process_product_meta_colored_variable_tab($post_id) {
	    
	      if (isset($_POST['coloredvariables']))
	         update_post_meta( $post_id, '_coloredvariables', $_POST['coloredvariables'] );
		
	   
        
	}	
	   
}
new wcva_add_colored_variation_metabox();

?>