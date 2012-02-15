<?php
 /**
 * Template name: English
 * @package WordPress
 * @subpackage AMTY
 */
 	$theme->set_english();
	get_header();
?>
					<div class="aside column small-column first-column" role="complementary">
						<?php dynamic_sidebar( 'Left column sidebar' ); ?>
					</div>

					<div class="column medium-column">
						<div class="section post-section clear-children" role="main">
<?php while( have_posts() ): the_post();?>
							<div class="article post-article clear-children">
								<?php get_template_part( 'loop', 'page' );?>
							</div>
<?php endwhile;?>
						</div>
					</div>
					<div class="aside column small-column" role="complementary">
						<?php dynamic_sidebar( 'Right column sidebar' ); ?>
					</div>
<?php get_footer(); ?>