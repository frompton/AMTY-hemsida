<?php
 /**
 * @package WordPress
 * @subpackage AMTY
 */
    global $theme;
?>
<?php if( has_post_thumbnail() ):?>
					<a href="<?php the_permalink();?>"><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'article-image' ) );?></a>
<?php endif;?>
					<div class="header">
<?php if( !is_front_page() ):?>
						<h1><a href="<?php the_permalink();?>"><?php the_title();?></a></h1>
<?php else:?>
						<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
<?php endif;?>
					</div>
					<div class="content">
						<?php has_excerpt() ? the_excerpt(): the_content( '...' );?>
					</div>
					<div class="context">
						<p><a href="<?php the_permalink();?>" class="more"><?php echo __( 'Läs hela nyheten &raquo;', $theme->domain );?></a></p>
						<iframe scrolling="no" frameborder="0" class="twitter-share-button twitter-count-horizontal" tabindex="0" allowtransparency="true" src="http://platform0.twitter.com/widgets/tweet_button.html?_=1300983158148&amp;count=horizontal&amp;lang=en&amp;url=<?php echo urlencode( get_permalink() );?>&amp;text=<?php echo urlencode( get_the_title() );?>" style="width: 110px; height: 20px;" title="Twitter For Websites: Tweet Button"></iframe>
						<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink();?>&amp;layout=button_count&amp;show_faces=false&amp;width=90&amp;action=like&amp;font&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe>
						<p>
							<span class="time"><?php echo sprintf( __( 'Publicerad %s kl. %s i kategorin ', $theme->domain ), get_the_date(), get_the_time() );?></span>
							<span class="category"><?php $theme->the_categories();?></span>
							<?php echo get_the_tag_list( '<div class="taglist"><span class="tag">' . __( 'Tags:', $theme->domain ) . '</span> ', ', ', '</div>' );?>
						</p>
					</div>