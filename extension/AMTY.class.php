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
            public function test_upgrade() {
                // convert products

                $args = array(
                    'post_type'	  => 'product',
                    'numberposts' => -1,
                    'post_status' => 'any', // Fixes draft products not being upgraded
                );

                $posts = get_posts( $args );

                foreach( $posts as $post ) {


                    $product_attributes = get_post_meta( $post->ID, 'product_attributes', true );

                    if ( is_array($product_attributes) ) {
                     /*   foreach( $product_attributes as $key => $attribute ) {

                            // We use true/false for these now
                            if ( isset( $attribute['visible'] ) )
                                $attribute['visible']     = ( $attribute['visible'] == 'yes' ) ? true : false;

                            if ( isset( $attribute['variation'] ) )
                                $attribute['variation']   = ( $attribute['variation'] == 'yes' ) ? true : false;

                            if ( isset( $attribute['is_taxonomy'] ) )
                                $attribute['is_taxonomy'] = ( $attribute['is_taxonomy'] == 'yes' ) ? true : false;

                            $product_attributes[$key] = $attribute;
                        }

                        update_post_meta( $post->ID, 'product_attributes', $product_attributes );
                     */
                        print_r($product_attributes);
                    }

                }

                // Variations
                $args = array(
                    'post_type'	  => 'product_variation',
                    'numberposts' => -1,
                    'post_status' => 'any', // Fixes draft products not being upgraded
                );

                $posts = get_posts( $args );
/*
                foreach( $posts as $post ) {

                    // Convert SKU key to lowercase
                    $wpdb->update( $wpdb->postmeta, array('meta_key' => 'sku'), array('post_id' => $post->ID, 'meta_key' => 'sku') );

                    // Convert 'price' key to regular_price
                    $wpdb->update( $wpdb->postmeta, array('meta_key' => 'regular_price'), array('post_id' => $post->ID, 'meta_key' => 'price') );

                    $taxes = $wpdb->get_results("SELECT * FROM {$wpdb->postmeta} WHERE post_id = {$post->ID} AND meta_key LIKE 'tax_%' ");

                    // Update catch all prices
                    $parent_id = $post->post_parent;
                    $parent_reg_price = get_post_meta( $parent_id, 'regular_price', true );
                    $parent_sale_price = get_post_meta( $parent_id, 'sale_price', true );

                    if ( ! get_post_meta( $post->ID, 'regular_price', true) && $parent_reg_price )
                        update_post_meta( $post->ID, 'regular_price', $parent_reg_price );

                    if( ! get_post_meta( $post->ID, 'sale_price', true) && $parent_sale_price )
                        update_post_meta( $post->ID, 'sale_price', $parent_sale_price );

                    $variation_data = array();
                    foreach( $taxes as $tax ) {
                        $variation_data[$tax->meta_key] = $tax->meta_value;
                        delete_post_meta( $post->ID, $tax->meta_key );
                    }

                    update_post_meta( $post->ID, 'variation_data', $variation_data );

                }*/
            }

		}
	}