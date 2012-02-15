<?php
 /**
 * @package WordPress
 * @subpackage AMTY
 */
	get_header();
?>
					<div class="aside column small-column first-column" role="complementary">
						<?php dynamic_sidebar( 'Left column sidebar' ); ?>
					</div>

					<div class="column medium-column">
						<div class="section post-section clear-children" role="main">
							<div class="header">
								<h1>Nyheter</h1>
							</div>
							<?php query_posts('cat=-85'); ?>
<?php while( have_posts() ): the_post();?>
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