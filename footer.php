<?php
/**
 * @package WordPress
 * @subpackage AMTY
 */
?>
			</div><!-- #page-content -->
			<div id="page-footer" class="footer" role="contentinfo">
				<div id="footer-content">
					<p>AMTY - A Message To You - Since 1991</p>
                    <p class="contact-info">AMTY, Box 794, 12002 Årsta, Sweden</p>
					<?php wp_nav_menu( array(
					    'theme_location' => 'footer-navigation',
					    'menu_class' => 'nav',
					    'container' => 'div',
					    'container_id' => 'footer-nav',
					    'container_class' => 'nav',
					    'depth'=> '1'
					) ); ?>
				</div>
			</div><!-- #page-footer -->
		</div><!-- #page-container -->

<!-- wp_footer -->	
<?php wp_footer(); ?>
<!-- /wp_footer -->
	</body>
</html>