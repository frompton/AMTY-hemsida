<?php
 /**
 * @package WordPress
 * @subpackage AMTY
 */
    global $theme;
?>
					<?php if( has_post_thumbnail() ) {?>
						<a href="<?php the_permalink();?>"><?php the_post_thumbnail( 'medium', array( 'class' => 'article-image-small' ) );?></a>
					<?php }?>
					<div class="header">
						<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
						<span class="time"><?php echo sprintf( __( 'Publicerad %s kl. %s i kategorin ', $theme->domain ), get_the_date(), get_the_time() );?></span>
						<span class="category"><?php $theme->the_categories();?></span>
					</div>
					<div class="content clear-children">


						<?php has_excerpt() ? the_excerpt(): the_content( '...' );?>

						<p><a href="<?php the_permalink();?>" class="more"><?php echo __( 'Läs hela nyheten &raquo;', $theme->domain );?></a></p>

					</div>