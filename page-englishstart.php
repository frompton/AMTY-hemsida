<?php
 /**
 * Template name: Start page english
 * @package WordPress
 * @subpackage AMTY
 */
  	$theme->set_english();
	get_header();
    global $wpdb;
     // Variations
                $args = array(
                    'post_type'	  => 'product_variation',
                    'numberposts' => -1,
                    'post_status' => 'any', // Fixes draft products not being upgraded
                );

                $posts = get_posts( $args );


                foreach( $posts as $post ) {
                    $taxes = $wpdb->get_results("SELECT * FROM {$wpdb->postmeta} WHERE post_id = {$post->ID} AND meta_key LIKE 'tax_%' ");

                    $variation_data = array();
                    foreach( $taxes as $tax ) {
                        $variation_data[$tax->meta_key] = $tax->meta_value;

                    }
                    update_post_meta( $post->ID, 'variation_data', $variation_data );

                    print_r($variation_data);
                }
?>
					<div class="aside column small-column first-column" role="complementary">
						<?php dynamic_sidebar( 'Left column sidebar' ); ?>
					</div>

					<div class="column medium-column">
						<div class="section post-section clear-children" role="main">
							<div class="header">
								<h1>News</h1>
							</div>
<?php 

	$newsposts = new WP_Query(
		array(
			'post_type' => 'post',
			'category_name' => 'news' 
		)
	);
?>
<?php while( $newsposts->have_posts() ): $newsposts->the_post();?>
							<div class="article post-article clear-children">
								<?php get_template_part( 'loop', 'index' );?>
							</div>
<?php endwhile;?>
						</div>
					</div>
					<div class="aside column small-column" role="complementary">
						<?php dynamic_sidebar( 'Right column sidebar' ); ?>
					</div>
<?php get_footer(); ?>