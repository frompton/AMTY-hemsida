<?php
/**
 * @package WordPress
 * @subpackage AMTY
 */
 global $theme;
?><!DOCTYPE html>
<html <?php language_attributes();?> class="bz-scope">
	<head>
		<meta charset="<?php bloginfo( 'charset' );?>">
		<title><?php wp_title( '--', true, 'right' ); ?> <?php bloginfo( 'name' ); ?></title>
		<link href='http://fonts.googleapis.com/css?family=Terminal+Dosis:400,500' rel='stylesheet' type='text/css'>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' );?>">
<?php if ( is_home() ):?>
		<meta name="description" content="<?php bloginfo( 'description' );?>">
<?php endif;?>
<!-- wp_head -->
<?php wp_head();?>
<!-- /wp_head -->
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-30899635-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
	</head>
	<body id="amty" <?php body_class();?>>
    <div class="page-bg">
		<div id="page-container">
			<div id="page-header" class="header">
				<div id="header-tools">
				<?php if( $theme->english ):?>
					<a class="lang-se" href="/">På svenska</a>
					<?php $navigation_name = 'english-navigation'; ?>
                    <a class="facebook" href="https://www.facebook.com/amessagetoyou">Like us on Facebook</a>
					<a class="instagram" href="https://instagram.com/amty_ska_since_91">Follow us on Instagram</a>
				<?php else: ?>
					<a class="lang-en" href="/en">In English</a>
					<?php $navigation_name = 'top-navigation'; ?>
                    <a class="facebook" href="https://www.facebook.com/amessagetoyou">Gilla oss på Facebook</a>
					<a class="instagram" href="https://instagram.com/amty_ska_since_91">Följ oss på Instagram</a>
				<?php endif; ?>
				</div>
<?php if( !is_front_page() ):?>
				<div id="logo"><a href="<?php echo home_url( '/' );?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) );?>"><img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" /></a></div>
<?php else:?>
				<h1 id="logo"><a href="<?php echo home_url( '/' );?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) );?>"><img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" /></a></h1>
<?php endif;?>
				<?php wp_nav_menu( array(
				    'theme_location' => $navigation_name,
				    'menu_class' => 'nav',
				    'container' => 'div',
				    'container_id' => 'top-nav',
				    'container_class' => 'nav',
				    'depth'=> '1'
				) ); ?>

			</div><!-- #page-header -->
			<div id="page-content" class="clear-children">
