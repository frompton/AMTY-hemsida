<?php 
if (function_exists('wp_pagenavi')) {
	wp_pagenavi();
} else {
?>
<div class="navigation">
	<div class="nav-next"><?php next_posts_link( __( 'Next <span class="meta-nav">&rarr;</span>', 'jigoshop' ) ); ?></div>
	<div class="nav-previous"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Previous', 'jigoshop' ) ); ?></div>
</div>
<?php
}
