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
	</head>
	<body id="amty" <?php body_class();?>>
		<div id="page-container">
			<div id="page-header" class="header">
				<div id="language">
				<?php if( $theme->english ):?>
					<a class="lang-se" href="/wordpress">På svenska</a>
					<?php $navigation_name = 'english-navigation'; ?>
				<?php else: ?>
					<a class="lang-en" href="/wordpress/en">In English</a>
					<?php $navigation_name = 'top-navigation'; ?>
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
