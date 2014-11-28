<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		 
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	
<div class="summary entry-summary">
<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
<?php

//add_action( 'woocommerce_single_product_summary_cust', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary_cust', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary_cust', 'woocommerce_template_single_meta', 21 );
add_action( 'woocommerce_single_product_summary_cust_cart', 'woocommerce_template_single_add_to_cart', 30 );

do_action( 'woocommerce_single_product_summary_cust' );
global $product, $woocommerce_loop;
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs">
	<?php //echo do_action('woocommerce_single_product_summary_cust');?>
	<ul class="tabs" id="printtab">
			<li  class="<?php echo $key ?>_tab">
					<a  href="#tab-get_printed"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', "GET PRINTED", $key ) ?></a>
			   <?php $upsells = $product->get_upsells();
					if ( sizeof( $upsells ) > 0 ){?>
			   </li>
					<li  class="<?php echo $key ?>_tab">
					<a  href="#tab-get_downloaded"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', "DOWNLOAD", $key ) ?></a>
			    </li>
			    <?php } ?>
	</ul>
		
	
<?php endif; ?>
	<div class="panel entry-content" id="tab-get_printed">
			<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5) ;
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 ); 
			do_action( 'woocommerce_single_product_summary' );
			
		?>
</div>
<div  class="panel entry-content" id="tab-get_downloaded">



<?php

$productTemp=$product;
$upsells = $product->get_upsells();

if ( sizeof( $upsells ) < 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;
$count=0;
if ( $products->have_posts() ) : ?>

	<div class="upsells products">

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php 
				$pr = get_product($upsells[$count] );
				
				// code to aceess file download id
				global $wpdb;
				$results = $wpdb->get_results("SELECT download_id FROM wp_woocommerce_downloadable_product_permissions where product_id=".$pr->id);
				foreach($results as $result){
				$str=$pr->get_file_download_path($result->download_id);
				echo substr($str,strrpos($str,'/')+1,  strlen($str)) ."<br>";
				}
			
			$product=$pr;
			do_action( 'woocommerce_single_product_summary_cust_cart' );
			//echo do_shortcode("[add_to_cart id='".$upsells[$count]."']");
				$count++;
				?>
              
			<?php endwhile;    $product=$productTemp;// end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;
?>




</div>
</div>
	</div><!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
