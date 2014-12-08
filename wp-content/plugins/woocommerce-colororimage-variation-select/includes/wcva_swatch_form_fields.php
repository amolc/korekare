<?php
class wcva_swatch_form_fields {
    /*
	  * load default dropdown select
	  * @param - $name
	  * @param - $options
	  */
     public function wcva_load_dropdown_select($name,$options,$selected_value) {
	  $this->wcva_load_radio_select($name,$options,$selected_value,$hidden=true);
	   ?> <select id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" name="attribute_<?php echo sanitize_title( $name ); ?>">
							<option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
							<?php
							

									// Get terms if this is a taxonomy - ordered
									if ( taxonomy_exists( $name ) ) {

										$orderby = wc_attribute_orderby( $name );

										switch ( $orderby ) {
											case 'name' :
												$args = array( 'orderby' => 'name', 'hide_empty' => false, 'menu_order' => false );
											break;
											case 'id' :
												$args = array( 'orderby' => 'id', 'order' => 'ASC', 'menu_order' => false, 'hide_empty' => false );
											break;
											case 'menu_order' :
												$args = array( 'menu_order' => 'ASC', 'hide_empty' => false );
											break;
										}

										$terms = get_terms( $name, $args );

										foreach ( $terms as $term ) {
											if ( ! in_array( $term->slug, $options ) )
												continue;

											echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
										}
									} else {

										foreach ( $options as $option ) {
											echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
										}

									}
								
							?>
						</select>
	 
	<?php }
	 
	 /*
	  * Load radio select
	  * since 1.0.2
	  */
	 public function wcva_load_radio_select($name,$options,$selected_value,$hidden=null) { ?>
	 <fieldset style="<?php if (isset($hidden)) { echo 'display:none;';} ?>">
                    
                        <?php 
                            if ( is_array( $options ) ) {
 
								
                                if ( taxonomy_exists( sanitize_title( $name ) ) ) {
 
                                    $terms = get_terms( sanitize_title($name), array('menu_order' => 'ASC') );
									
                                    foreach ( $terms as $term ) {
                                        if ( ! in_array( $term->slug, $options ) ) continue;
                                        echo '<input type="radio" class="wcva_attribute_radio" value="' . strtolower($term->slug) . '" ' . checked( strtolower ($selected_value), strtolower ($term->slug), false ) . '  id="attribute_'.sanitize_title($name).'_'.sanitize_title($term->slug).'" name="attribute_'. sanitize_title($name).'">' . apply_filters( 'woocommerce_variation_option_name', $term->name ).'<br />';
                                    }
                                } else {
                                    foreach ( $options as $option )
                                        echo '<input type="radio" class="wcva_attribute_radio" value="' .esc_attr( sanitize_title( $option ) ) . '" ' . checked( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . ' id="attribute_'.sanitize_title($name).'_'.sanitize_title($option).'" name="attribute_'. sanitize_title($name).'">' . $option . '<br />';
                                }
                            }
                        ?>
    </fieldset>
    <?php 


	}
	 /*
	  * Load colored select
	  * since 1.0.0
	  */
     public function wcva_load_colored_select($name,$options,$_coloredvariables,$newvalues,$selected_value) {  
	
                            if ( is_array( $options ) ) {
 
                               
								
                                if ( taxonomy_exists( sanitize_title( $name ) ) ) {
 
                                    $terms = get_terms( sanitize_title($name), array('menu_order' => 'ASC') );
									
                                    foreach ( $terms as $term ) {
									   
                                        if ( ! in_array( $term->slug, $options ) ) continue; { 
										$this->wcva_display_image_select_block1($selected_value,$name,$term,$_coloredvariables,$newvalues);
									 }
									}
                                } else { 
                                    foreach ( $options as $option ) { 
							            $this->wcva_display_image_select_block2($selected_value,$name,$option,$_coloredvariables,$newvalues);
							      }
							   }
                            }


	} 
	
	 /*
	  * Get Image display
	  * since 1.0.2
	  */
	public function wcva_display_image_select_block1($selected_value,$name,$option,$_coloredvariables,$newvalues){ 
	   
		$globalthumbnail_id = ''; 
	    $globaldisplay_type = 'Color';
	    $globalcolor        =  'grey';     

        
			 foreach ($newvalues as $newvalue) {
	               if (isset($newvalue->slug) && (strtolower($newvalue->slug) == strtolower($option->slug))) {
		            
		                   $globalthumbnail_id 	= absint( get_woocommerce_term_meta( $newvalue->term_id, 'thumbnail_id', true ) );
		                   $globaldisplay_type 	= get_woocommerce_term_meta($newvalue->term_id, 'display_type', true );
		                   $globalcolor 	    = get_woocommerce_term_meta($newvalue->term_id, 'color', true );
		            }
		     }
			 
	
	         if ((isset($_coloredvariables[$name]['values'])) && (isset($_coloredvariables[$name]['values'][$option->slug]['image']))) {
	                  
					$thumb_id = $_coloredvariables[$name]['values'][$option->slug]['image']; $url = wp_get_attachment_thumb_url( $thumb_id ); 
		       
			     } elseif (isset($globalthumbnail_id)) {
		          
				    $thumb_id=$globalthumbnail_id; $url = wp_get_attachment_thumb_url( $globalthumbnail_id );
		     }
			 
			 
			 
		  
		     if ((isset($_coloredvariables[$name]['values'])) && (isset($_coloredvariables[$name]['values'][$option->slug]['type']))) {
	             
				    $attrdisplaytype = $_coloredvariables[$name]['values'][$option->slug]['type'];
		          
			     } elseif (isset($globaldisplay_type)) {
		         
				    $attrdisplaytype = $globaldisplay_type;
		     }
			 
		  
		     if ((isset($_coloredvariables[$name]['values'])) && (isset($_coloredvariables[$name]['values'][$option->slug]['color']))) {
	             
				    $attrcolor = $_coloredvariables[$name]['values'][$option->slug]['color'];
		            
			     } elseif (isset($globalcolor)) {
		      
			        $attrcolor = $globalcolor;
		     }
	             
			 
			 if (isset($_coloredvariables[$name]['size'])) {
		                      
					$thumbsize   = $_coloredvariables[$name]['size']; 
					$displaytype = $_coloredvariables[$name]['displaytype']; 
					$showname    = $_coloredvariables[$name]['show_name'];
					
				 } else {
					
					$thumbsize   = 'small';
					$displaytype = 'square';
					$showname    = 'no';
			 }
		                      
					$imageheight = $this->wcva_get_image_height($thumbsize); 
					$imagewidth  = $this->wcva_get_image_width($thumbsize); 
	            
	?>          <div class="swatchinput">
	            <input id="<?php echo $option->name; ?>" type="radio" class="wcva_attribute_radio" value="<?php echo esc_attr( sanitize_title( $option->name ) ); ?>" <?php echo checked( sanitize_title( $selected_value ), sanitize_title( $option->name ), false ); ?> id="attribute_<?php echo  sanitize_title($name); ?>_<?php echo  sanitize_title($option->name); ?>" name="attribute_<?php echo  sanitize_title($name); ?>">
			    
                    
		            
		                      
	                        <?php  
		        
		                      switch($attrdisplaytype) {
	                            case "Color":
	                              ?>
								  
								  <label class="wcvaswatchlabel <?php if ($displaytype == "round") { echo 'wcvaround'; } ?>" for="<?php echo $option->name; ?>" title="<?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?>" style="background-color:<?php if (isset($attrcolor)) { echo $attrcolor; } else { echo '#ffffff'; } ?>; width:<?php echo $imagewidth; ?>px; height:<?php echo $imageheight; ?>px;"></label>
					              <?php if (isset($showname) && ($showname == "yes")) { ?>
								  <span class="belowtext"><?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?></span>
								  <?php }
								  
	                            break;
	                            case "Image":
	                              ?>
								  
								  <label class="wcvaswatchlabel <?php if ($displaytype == "round") { echo 'wcvaround'; } ?>" for="<?php echo $option->name; ?>" title="<?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?>" style="background-image:url(<?php if (isset($url)) { echo $url; } ?>); width:<?php echo $imagewidth; ?>px; height:<?php echo $imageheight; ?>px;"></label>
	                              <?php if (isset($showname) && ($showname == "yes")) { ?>
								  <span class="belowtext"><?php echo apply_filters( 'woocommerce_variation_option_name', $option->name ); ?></span>
								  <?php }
								  
								break;
	                        } ?>
			               
				</div>	  
 	                   
                
				
       
    
	<?php }
	
	
	/*
	  * Get Image display
	  * since 1.0.2
	  */
	public function wcva_display_image_select_block2($selected_value,$name,$option,$_coloredvariables,$newvalues){ 
	   
		$globalthumbnail_id = ''; 
	    $globaldisplay_type = 'Color';
	    $globalcolor        =  'grey';     


			 foreach ($newvalues as $newvalue): 
	               if (isset($newvalue->slug) && (strtolower($newvalue->slug) == strtolower($option))) : 
		    
		                   $globalthumbnail_id 	= absint( get_woocommerce_term_meta( $newvalue->term_id, 'thumbnail_id', true ) );
		                   $globaldisplay_type 	= get_woocommerce_term_meta($newvalue->term_id, 'display_type', true );
		                   $globalcolor 	    = get_woocommerce_term_meta($newvalue->term_id, 'color', true );
		            endif; 
				   endforeach; 
	
	         if ((isset($_coloredvariables[$name]['values'])) && (isset($_coloredvariables[$name]['values'][$option]['image']))) {
	             $thumb_id = $_coloredvariables[$name]['values'][$option]['image']; $url = wp_get_attachment_thumb_url( $thumb_id ); 
		     } elseif (isset($globalthumbnail_id)) {
		          $thumb_id=$globalthumbnail_id; $url = wp_get_attachment_thumb_url( $globalthumbnail_id );
		     }
		  
		     if ((isset($_coloredvariables[$name]['values'])) && (isset($_coloredvariables[$name]['values'][$option]['type']))) {
	          $attrdisplaytype = $_coloredvariables[$name]['values'][$option]['type'];
		     } elseif (isset($globaldisplay_type)) {
		      $attrdisplaytype = $globaldisplay_type;
		     }
		  
		     if ((isset($_coloredvariables[$name]['values'])) && (isset($_coloredvariables[$name]['values'][$option]['color']))) {
	          $attrcolor = $_coloredvariables[$name]['values'][$option]['color'];
		     } elseif (isset($globalcolor)) {
		      $attrcolor = $globalcolor;
		     }
	             
						    if (isset($_coloredvariables[$name]['size'])) {
		                      $thumbsize   = $_coloredvariables[$name]['size']; 
							  $displaytype = $_coloredvariables[$name]['displaytype']; 
							  $showname = $_coloredvariables[$name]['show_name'];
							} else {
							  $thumbsize   = 'small';
							  $displaytype = 'square';
							  $showname = 'no';
							}
		                      $imageheight = $this->wcva_get_image_height($thumbsize); 
							  $imagewidth = $this->wcva_get_image_width($thumbsize); 
	
	?>          <div class="swatchinput">
	            <input id="<?php echo $option; ?>" type="radio" class="wcva_attribute_radio" value="<?php echo esc_attr( sanitize_title( $option ) ); ?>" <?php echo checked( sanitize_title( $selected_value ), sanitize_title( $option ), false ); ?> id="attribute_<?php echo  sanitize_title($name); ?>_<?php echo  sanitize_title($option); ?>" name="attribute_<?php echo  sanitize_title($name); ?>">
			    
                    
		            
		                      
	                        <?php  
		        
		                      switch($attrdisplaytype) {
	                            case "Color":
	                              ?>
								  <label class="wcvaswatchlabel <?php if ($displaytype == "round") { echo 'wcvaround'; } ?>" for="<?php echo $option; ?>" title="<?php echo $option; ?>" style="background-color:<?php if (isset($attrcolor)) { echo $attrcolor; } else { echo '#ffffff'; } ?>; width:<?php echo $imagewidth; ?>px; height:<?php echo $imageheight; ?>px;"></label>
					              <?php if (isset($showname) && ($showname == "yes")) { ?>
								  <span class="belowtext"><?php echo $option; ?></span>
								  <?php }
	                            break;
	                            case "Image":
	                              ?>
								  <label class="wcvaswatchlabel <?php if ($displaytype == "round") { echo 'wcvaround'; } ?>" for="<?php echo $option; ?>" title="<?php echo $option; ?>" style="background-image:url(<?php if (isset($url)) { echo $url; } ?>); width:<?php echo $imagewidth; ?>px; height:<?php echo $imageheight; ?>px;"></label>
	                              <?php if (isset($showname) && ($showname == "yes")) { ?>
								  <span class="belowtext"><?php echo $option; ?></span>
								  <?php }
								break;
	                        } ?>
			               
				</div>	  
 	                   
                
				
       
    
	<?php }
	
	 /*
	  * Get Image Height
	  * since 1.0.0
	  */
	 public function wcva_get_image_height($thumbsize) {
	     $height=32;
	  switch($thumbsize) {
	 
	     case "small":
	      $height=32;
	     break;
	 
	 
	     case "extrasmall":
	      $height=22;
	     break;
	 
	     case "medium":
	      $height=40;
	     break;
	 
	     case "big":
	      $height=60;
	     break;
	 
	     case "extrabig":
	      $height=90;
	     break;
	 
	     default : 
	      $height=32;
	 
	 
	   }
	 
	   return $height;
	 }
	 
	 /*
	  * Get Image Width
	  * since 1.0.0
	  */
	 public function wcva_get_image_width($thumbsize) {
	        $width=32;
	 
	  switch($thumbsize) {
	 
	     case "small":
	      $width=32;
	     break;
	 
	     case "extrasmall":
	      $width=22;
	     break;
	 
	     case "medium":
	      $width=40;
	     break;
	 
	     case "big":
	      $width=60;
	     break;
	 
	     case "extrabig":
	      $width=90;
	     break;
	 
	     default : 
	      $width=32;
	 
	  }
	 
	   return $width;
	 }
}

?>