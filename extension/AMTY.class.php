<?php
/*
 * @package WordPress
 * @subpackage {Themename}
 */
	
	require( dirname( __FILE__ )  . '/Base.class.php' );
	require( dirname( __FILE__ )  . '/Theme.class.php' );
	require( dirname( __FILE__ )  . '/Jigoshop.class.php' );
	require( dirname( __FILE__ )  . '/widgets/jigoshop_AZ.php' );


	if( !class_exists( 'AMTY' ) ){
		class AMTY extends BZ_Theme{

			protected $domain = 'amty';
			
			protected $teaser = NULL;
			protected $custompost = NULL;
			protected $english = false;
			
			public function __construct(){

				parent::__construct();

				$this->jigoshop = new BZ_Jigoshop();
				add_action( 'widgets_init', array( &$this, 'wp_register_sidebars' ) );
				add_filter( 'wp_get_attachment_image_attributes', array( &$this, 'wp_get_attachment_image_attributes' ) );

				add_custom_background();

				add_custom_image_header('', array($this, 'amty_admin_header_style'));
				define( 'HEADER_IMAGE_WIDTH',  571 );
				define( 'HEADER_IMAGE_HEIGHT', 70 );

				register_default_headers( array(
					'original' => array(
						'url' => '%s/image/headers/amty-logo.png',
						'thumbnail_url' => '%s/image/headers/amty-logo-thumbnail.png',
						'description' => __( 'Den gamla', $this->domain )
					)
				));
			}
			public function set_english() {
				$this->english = true;
			}
			/*
			*	@return void
			*/
			public function wp_register_sidebars(){
				register_sidebar( array(
					'name' => __( 'Left column sidebar', $this->domain ),
					'id' => 'sidebar_left',
					'description' => __( 'Add widgets here.', $this->domain ),
					'before_widget' => '<div id="%1$s" class="article widget-article clear-children %2$s">',
					'before_title' => '<h2>',
					'after_title' => '</h2>',
					'after_widget' => '</div>'
				) );
				register_sidebar( array(
					'name' => __( 'Left column sidebar - shop', $this->domain ),
					'id' => 'sidebar_left_shop',
					'description' => __( 'Add widgets here.', $this->domain ),
					'before_widget' => '<div id="%1$s" class="article widget-article clear-children %2$s">',
					'before_title' => '<h2>',
					'after_title' => '</h2>',
					'after_widget' => '</div>'
				) );
				register_sidebar( array(
					'name' => __( 'Right column sidebar', $this->domain ),
					'id' => 'sidebar_right',
					'description' => __( 'Add widgets here.', $this->domain ),
					'before_widget' => '<div id="%1$s" class="article widget-article clear-children %2$s">',
					'before_title' => '<h2>',
					'after_title' => '</h2>',
					'after_widget' => '</div>'
				) );
				register_sidebar( array(
					'name' => __( 'Right column sidebar - shop', $this->domain ),
					'id' => 'sidebar_right_shop',
					'description' => __( 'Add widgets here.', $this->domain ),
					'before_widget' => '<div id="%1$s" class="article widget-article clear-children %2$s">',
					'before_title' => '<h2>',
					'after_title' => '</h2>',
					'after_widget' => '</div>'
				) );
			}
			public function wp_get_attachment_image_attributes($attr ) {
				$attr['title'] = '';
				
				return $attr;
			}

			public function amty_header_style() {
				
			}
			public function amty_admin_header_style() {
				echo '<style>.appearance_page_custom-header #headimg { min-height: 70px;}</style>';
			}
			/*
			*	@param null $post_id int
			*	@return void
			*/
			public function the_categories( $post_id = NULL ){
				echo $this->get_the_categories( $post_id );
			}

			/*
			*	@param null $post_id int
			*	@return string
			*/
			public function get_the_categories( $post_id = NULL ){
				return implode( ', ', $this->get_the_categories_list( $post_id ) );
			}

			/*
			*	@param null $post_id int
			*	@return array
			*/
			public function get_the_categories_list( $post_id = NULL ){
				if( !$post_id ){
					global $post;
					$post_id = $post->ID;
				}

				$categories = get_the_category( $post_id );

				$links = array();
				foreach( $categories as $category ){
					array_push( $links, '<a href="' . sprintf( '%s/%s/%s', get_option( 'siteurl' ), get_option( 'category_base' ), $category->category_nicename ) . '" class="category-link">' . $category->cat_name . '</a>' );
				}
				return $links;
			}

		}
	}