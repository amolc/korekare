<?php
/**
 * variable template 
 * Originally Modified from Woocommerce Core
 * @author 		WooThemes
 * @package 	WooCommerce/templates/single-product/add-to-cart/variable.php
 * @version     2.1.6
 */



global $woocommerce, $product, $post;
  $woo_version              =  wcva_get_woo_version_number();
  $_coloredvariables        =  get_post_meta( $post->ID, '_coloredvariables', true );

?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

  
<script type="text/javascript">
    var product_variations_<?php echo $post->ID; ?> = <?php echo json_encode( $available_variations ) ?>;
</script> 

   
<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) : ?>
	
		<table class="variations" cellspacing="0">
			<tbody>
				<?php  $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; 
				      
					  if (isset( $_coloredvariables[$name]['display_type'])) {
				        $attribute_display_type  = $_coloredvariables[$name]['display_type'];
					  }
					  
					   $taxonomies = array($name);
	                   $args = array(
                         'hide_empty' => 0
                       );
	                   $newvalues = get_terms( $taxonomies, $args);
					   
					   
					    if (isset($_coloredvariables[$name]['label'])) {
					        $labeltext=$_coloredvariables[$name]['label'];
					     } else {
                            if ($woo_version <2.1) {
	                          		$labeltext=$woocommerce->attribute_label( $name );  
	                        } else {
	                                $labeltext=wc_attribute_label( $name );
	                        }
                        }	

						
                ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title($name); ?>"><?php if (isset($labeltext) && ($labeltext != '')) { echo $labeltext; } else { echo wc_attribute_label( $name ); } ?></label></td>
						<td class="value"> <?php
						
							if ( is_array( $options ) ) {

									if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
										$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
									} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
										$selected_value = $selected_attributes[ sanitize_title( $name ) ];
									} else {
										$selected_value = '';
									}	
                            }
						
						$fields = new wcva_swatch_form_fields();	
									
                        if (isset($attribute_display_type) && ($attribute_display_type  == "colororimage"))	{ ?>
						
                              <div class="wcvaswatch"> 
							   <?php   $fields->wcva_load_colored_select($name,$options,$_coloredvariables,$newvalues,$selected_value); ?>
						      </div> <?php
						  
						    if ( sizeof($attributes) == $loop )
								echo '<br /><a class="reset_variations" href="#reset">' . __( 'Clear selection', 'wcva' ) . '</a>';
                        
						 } elseif (isset($attribute_display_type) && ($attribute_display_type  == "radio"))  {
						     $fields->wcva_load_radio_select($name,$options,$selected_value);
						    
							if ( sizeof($attributes) == $loop )
								echo '<br /><a class="reset_variations" href="#reset">' . __( 'Clear selection', 'wcva' ) . '</a>';
                          
						 } else {
                            $fields->wcva_load_dropdown_select($name,$options,$selected_value);
                            
							if ( sizeof($attributes) == $loop )
								echo '<br /><a class="reset_variations" href="#reset">' . __( 'Clear selection', 'wcva' ) . '</a>';
                         
						 }	
						 
						?></td>
					</tr>
				
		        <?php endforeach;?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:none;">
			<?php do_action( 'woocommerce_before_single_variation' ); ?>

			<div class="single_variation"></div>

			<div class="variations_button">
				<?php woocommerce_quantity_input(); ?>
				<button type="submit" class="single_add_to_cart_button button alt">
				<?php 
				
				 if ($woo_version <2.1) {
	                          	echo apply_filters('single_add_to_cart_text', __( 'Add to cart', 'woocommerce' ), $product->product_type);
	                        
							} else {
	                          
							    echo $product->single_add_to_cart_text();
	                    }
				
				?>
				</button>
			</div>

			<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id" value="" />

			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>

		    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php else : ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'wcva' ); ?></p>

	<?php endif; ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' );
     
	 
	 
	 