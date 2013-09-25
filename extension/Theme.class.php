<?php

	if( !class_exists( 'BZ_Theme' ) ){
		class BZ_Theme extends BZ_Base{

			protected $domain = 'bz-theme';

			public function __construct(){
				
				add_filter( 'login_errors', array( &$this, 'wp_remove_login_errors' ) );
				add_action( 'after_setup_theme', array( &$this, 'wp_register_thumbnail_support' ) );
				add_action( 'setup_theme', array( &$this, 'wp_setup_language' ) );
				add_action( 'init', array( &$this, 'wp_register_navigation' ) );
				add_action( 'wp_enqueue_scripts', array( &$this, 'wp_setup_resources' ) );
				add_action( 'admin_enqueue_scripts', array( &$this, 'wp_setup_admin_resources' ) );
				add_filter( 'the_generator', array( &$this, 'wp_remove_version' ) );
				add_action( 'wp_print_scripts', array( &$this, 'wp_add_paths' ) );
				add_filter('widget_text', 'do_shortcode');
				
					
			}


			/**
			* 	@param $error string
			* 	@return string
			*/
			public function wp_remove_login_errors( $error ){
				return __( 'The username and/or password is wrong.', $this->domain );
			}

			/**
			* 	@return void
			*/
			public function wp_register_thumbnail_support(){
				add_theme_support( 'post-thumbnails' );
				set_post_thumbnail_size( 100, 100 ); 
			}

			/*
			*	@return void
			*/
			public function wp_setup_language(){
				load_textdomain( $this->domain, sprintf( '%s/language/%s-%s.mo', dirname( dirname( __FILE__ ) ), $this->domain, get_locale() ) );
			}

			/*
			*	@return void
			*/
			public function wp_register_navigation(){
				register_nav_menus( array( 
					'top-navigation' => __( 'Top menu', $this->domain ),
					'english-navigation' => __( 'English menu', $this->domain ),
					'footer-navigation' => __( 'Footer menu', $this->domain ) 
				) );
			}

			/*
			*	@return void
			*/
			public function wp_setup_resources(){
				wp_enqueue_style( 'reset', get_bloginfo( 'template_url' ) . '/style/reset.min.css', false, '1.0' );
    			wp_enqueue_style( 'common-css', get_bloginfo( 'template_url' ) . '/style/common.css', false, '1.0.1' );

    			wp_deregister_script( 'jquery' );
    			wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1' );
    			wp_enqueue_script( 'jquery' );
    			wp_enqueue_script( 'common-js', get_bloginfo( 'template_url' ) . '/script/common.js', false, '1.0.1', true );
			}
			/*
			*	@return void
			*/
			public function wp_setup_admin_resources(){
				wp_enqueue_style( 'admin-css', get_bloginfo( 'template_url' ) . '/style/admin.css', false, '1.0' );
			}
			/*
			*	@param $generator string
			*	@return string
			*/
			public function wp_remove_version( $generator ){
				return  '';
			}

			/*
			*	@return void
			*/
			public function wp_add_paths(){
				echo sprintf( '<script>var template_url = \'%s\', stylesheet_url = \'%s\', site_url = \'%s\', plugin_url = \'%s\', ajax_url = \'%s\';</script>',
					get_bloginfo( 'template_directory' ), get_bloginfo( 'stylesheet_directory' ), get_option( 'siteurl' ), WP_PLUGIN_URL, admin_url( 'admin-ajax.php' )
				);
			}			

		}
	}
