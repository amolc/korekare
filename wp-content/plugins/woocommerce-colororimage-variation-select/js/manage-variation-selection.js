(function($j) {
   

    $j('.reset_variations').click(function(){
	           $j(".wcva_attribute_radio").prop('checked', false); 
			   $j("form.variations_form").find('.variations select').val('');
			   $j("input[name=variation_id]").val('');
			   var productimage =  $j(".attachment-shop_single").attr('data-o_src');
			   var imagetitle   =  $j(".attachment-shop_single").attr('data-o_title');
			   var imagehref    =  $j(".woocommerce-main-image").attr('data-o_href');
			   $j('.attachment-shop_single').attr('src', productimage);
			   $j('.attachment-shop_single').attr('title', imagetitle);
			   $j('.woocommerce-main-image').attr('href', imagehref);
			   $j('.woocommerce-main-image').attr('title', imagetitle);
               $j('.single_variation_wrap').hide();
			   $j(this).hide();
			   var is_selected             = false;
			     if ( is_selected ) {
 
                if ( $j(this).css('visibility') == 'hidden' )
                    $j(this).css('visibility','visible').hide().fadeIn();
 
            } else {
 
                $j(this).css('visibility','hidden');
 
            }
		});
	
	
	
         $j('form.variations_form').on( 'change', '.variations input:radio', function( event ) {
             
            $jmain_form = $j(this).closest('form.variations_form');
			$j("input[name=variation_id]").val('').change();
                 $j(this).trigger( 'validate_variations', [ '', false ] );
            } );
		
		
 
        
        $j('form.variations_form').on( 'validate_variations', function( event, exclude, focus ) {
            var if_variable_set             = false;
            var is_selected                 = false;
            var format            = {};
            var $jmain_form                 = $j(this);
            var $jreset_variations          = $jmain_form.find('.reset_variations');
 
            $jmain_form.find('.variations input:radio:checked').each( function() {
 
                if ( $j(this).val().length == 0 ) {
                    if_variable_set = false;
                } else {
                    is_selected = true;
					if_variable_set = true;
                }
 
                if ( exclude && $j(this).attr('name') == exclude ) {
 
                    if_variable_set = false;
                    format[$j(this).attr('name')] = '';
 
                } else {
                        
						value = $j(this).val().replace(/&/g, '&');
                        value = $j(this).val().replace(/"/g, '"');
                        value = $j(this).val().replace(/'/g, "'");
                        value = $j(this).val().replace(/</g, '<');
                        value = $j(this).val().replace(/>/g, '>');
                        
                        if_variable_set = true;
                    
                format[ $j(this).attr('name') ] = value;
 
                }
 
            });
 
            var pid                    = parseInt( $jmain_form.attr( 'data-product_id' ) );
            var all_variations         = window[ "product_variations_" + pid ];
            var available_matches      = get_variation_match( all_variations, format );
            var $jproduct              = $j(this).closest( '.product' );
            var $jshop_single_image    = $jproduct.find( 'div.images img:eq(0)' );
            var $jshop_single_link     = $jproduct.find( 'div.images a.zoom:eq(0)' );
			var productimage =  $j(".attachment-shop_single").attr('data-o_src');
			var imagetitle   =  $j(".attachment-shop_single").attr('data-o_title');
			var imagehref    =  $j(".woocommerce-main-image").attr('data-o_href');
            
 
            if ( if_variable_set ) {
 
                var variation = available_matches.pop();
 
                if ( variation ) {
                if ( ! exclude ) {
                    $jmain_form.find('.single_variation_wrap').slideDown('200');
                }
                    
                    $jmain_form
                        .find('input[name=variation_id]')
                        .val( variation.variation_id )
                        .change();
                     
                    $jmain_form.trigger( 'if_match_found', [ variation ] );
 
                } else {
 
                    
                    if ( ! exclude ) {
                    $jmain_form.find('.single_variation_wrap').slideUp('200');
                }
                    
 
                }
 
            } else {
 
                $jmain_form.trigger( 'update_variation_values', [ available_matches ] );
 
                if ( ! focus )
                   if ( ! exclude ) {
                    $jmain_form.find('.single_variation_wrap').slideUp('200');
                }
 
            }
 
            if ( is_selected ) {
 
                if ( $jreset_variations.css('visibility') == 'hidden' )
                    $jreset_variations.css('visibility','visible').hide().fadeIn();
 
            } else {
 
                $jreset_variations.css('visibility','hidden');
 
            }
 
        } );
 
        
     $j('form.variations_form').on( 'if_match_found', function( event, variation ) {
            var $jmain_form = $j(this);
            
            var $jproduct              = $j(this).closest( '.product' );
            var $jshop_single_image    = $jproduct.find( 'div.images img:eq(0)' );
            var $jshop_single_link     = $jproduct.find( 'div.images a.zoom:eq(0)' );
             
            
			
		    var $jproduct              = $j(this).closest( '.product' );
            var $jshop_single_image    = $jproduct.find( 'div.images img:eq(0)' );
            var $jshop_single_link     = $jproduct.find( 'div.images a.zoom:eq(0)' );
			var productimage           =  $j(".attachment-shop_single").attr('data-o_src');
			var imagetitle             =  $j(".attachment-shop_single").attr('data-o_title');
			var imagehref              =  $j(".woocommerce-main-image").attr('data-o_href');
 
            var variation_image = variation.image_src;
            var variation_link = variation.image_link;
            var variation_title = variation.image_title;
 
            $jmain_form.find('.variations_button').show();
            $jmain_form.find('.single_variation').html( variation.price_html + variation.availability_html );
 
            if ( ! productimage ) {
                productimage = ( ! $jshop_single_image.attr('src') ) ? '' : $jshop_single_image.attr('src');
                $jshop_single_image.attr('data-o_src', productimage );
            }
 
            if ( ! imagehref ) {
                imagehref = ( ! $jshop_single_link.attr('href') ) ? '' : $jshop_single_link.attr('href');
                $jshop_single_link.attr('data-o_href', imagehref );
            }
 
            if ( ! imagetitle ) {
                imagetitle = ( ! $jshop_single_image.attr('title') ) ? '' : $jshop_single_image.attr('title');
                $jshop_single_image.attr('data-o_title', imagetitle );
            }
 
            if ( variation_image && variation_image.length > 1 ) {
                
                    $jshop_single_image.attr( 'src', variation_image )
                    $jshop_single_image.attr( 'alt', variation_title )
                    $jshop_single_image.attr( 'title', variation_title );
                    $jshop_single_link.attr( 'href', variation_link );
            } else {
                
                    $jshop_single_image.attr( 'src', productimage )
                    $jshop_single_image.attr( 'alt', imagetitle )
                    $jshop_single_image.attr( 'title', imagetitle );
                    $jshop_single_link.attr( 'href', imagehref );
            }
 
            var $jsingle_variation_wrap = $jmain_form.find('.single_variation_wrap');
 
            if ( variation.sku )
                 $jproduct.find('.product_meta').find('.sku').text( variation.sku );
            else
                 $jproduct.find('.product_meta').find('.sku').text('');
 
            $jsingle_variation_wrap.find('.quantity').show();
             
            if ( ! variation.is_in_stock && ! variation.backorders_allowed ) {
                $jmain_form.find('.variations_button').hide();
            }
             
            if ( variation.min_qty )
                $jsingle_variation_wrap.find('input[name=quantity]').attr( 'data-min', variation.min_qty ).val( variation.min_qty );
            else
                $jsingle_variation_wrap.find('input[name=quantity]').removeAttr('data-min');
 
            if ( variation.max_qty )
                $jsingle_variation_wrap.find('input[name=quantity]').attr('data-max', variation.max_qty);
            else
                $jsingle_variation_wrap.find('input[name=quantity]').removeAttr('data-max');
 
            if ( variation.is_sold_individually == 'yes' ) {
                $jsingle_variation_wrap.find('input[name=quantity]').val('1');
                $jsingle_variation_wrap.find('.quantity').hide();
            }
 
            $jsingle_variation_wrap.slideDown('200').trigger( 'show_variation', [ variation ] );
 
        } );
 
    
    $j('form.variations_form .variations input:radio').change();
 
 

    /*
	 * find matching variation
	 */
    function get_variation_match( product_variations, format ) {
        var matching = [];
 
        for (var i = 0; i < product_variations.length; i++) {
            var variation    = product_variations[i];
            var variation_id = variation.variation_id;
            var attrs1       = variation.attributes;
			var attrs2       = format;
			 
            if ( validate_variations( attrs1, attrs2 ) ) {
                matching.push(variation);
            }
        }
        return matching;
    }
	
	
	
    var loop=0;
    
    function validate_variations( attrs1, attrs2 ) {
        var match = true;
        for ( attr_name in attrs1 ) {
			var attribute1="";
			 var attribute2="";
            if(loop>1)
			{
			 attribute1 = String(attrs1[ attr_name ]).toLowerCase();
             attribute2 = String(attrs2[ attr_name ]).toLowerCase();
			}
			else
			{
			 attribute1 = attrs1[ attr_name ];
             attribute2 = attrs2[ attr_name ];
			 loop++;
			}
			

            if ( attribute1 !== undefined && attribute2 !== undefined && attribute1.length != 0 && attribute2.length != 0 && attribute1 != attribute2 ) {
                match = false;
            }
        }
        return match;
    }
	
	$j('form.variations_form').on( 'change', '.variations select', function( event ) {
             
           var id =  $j(this).attr('id');
              $j("input[name='attribute_"+id+"'][value='"+this.value+"']").attr("checked","checked");
	          $j("input[name=variation_id]").val('').change();
              $j(this).trigger( 'validate_variations', [ '', false ] );
            } );
 
})(jQuery);