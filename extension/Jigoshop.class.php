<?php

	if( !class_exists( 'BZ_Jigoshop' ) ){
		class BZ_Jigoshop extends BZ_Base{

			protected $domain = 'bz-jigoshop';

			public function __construct(){
				add_action( 'init', array($this, 'wp_init') );

				remove_action('jigoshop_before_main_content', 'jigoshop_output_content_wrapper', 10);
				add_action('jigoshop_before_main_content', array($this, 'jigoshop_before_main_content'), 10);
				
				remove_action('jigoshop_after_main_content', 'jigoshop_output_content_wrapper_end', 10);
				add_action('jigoshop_after_main_content', array($this, 'jigoshop_after_main_content'), 10);
				
				remove_action('jigoshop_sidebar', 'jigoshop_get_sidebar', 10);
				add_action('admin_menu', array($this, 'jigoshop_admin_menu'));
				
				/* Pagination in loop-shop */
//				remove_action('jigoshop_pagination', 'jigoshop_pagination', 10);
//				add_action('jigoshop_pagination', array($this, 'jigoshop_pagination'), 10);

				remove_action('jigoshop_template_single_summary', 'jigoshop_template_single_excerpt', 20);
				//add_action('jigoshop_template_single_summary',  array(&$this, 'jigoshop_size_guide'), 10);
				
				/* HIDE EXTRA TAB FOR ATTRIBUTES */
				remove_action('jigoshop_product_tabs', 'jigoshop_product_attributes_tab', 20);
				remove_action('jigoshop_product_tab_panels', 'jigoshop_product_attributes_panel', 20);
				
				/* ADD META BOXES TO PRODUCTS */
				add_action('save_post', array($this, 'wp_save_post_metadata'));
				add_action('delete_post', array($this, 'wp_delete_post_metadata'));
				add_action('add_meta_boxes', array($this, 'wp_add_metadata_boxes'));
				
				/* SHOW TAB FOR EXTRA INFORMATION */
				add_action('jigoshop_product_tabs', array($this, 'jigoshop_product_extra_information_tab'), 20);
				add_action('jigoshop_product_tab_panels', array($this, 'jigoshop_product_extra_information_panel'), 20);

				add_filter('query_vars', array($this, 'wp_add_query_vars'));
				add_action('jigoshop_before_shop_loop', array($this, 'jigoshop_before_shop_loop'));

				//Remove field for Company on check out
				add_filter('jigoshop_billing_fields', array($this, 'jigoshop_billing_fields'));
				add_filter('jigoshop_shipping_fields', array($this, 'jigoshop_shipping_fields'));

				/* REGISTER NEW WIDGETS */
				add_action('widgets_init', array($this, 'wp_register_widgets'));
				
				/* A-Z FILTER */
				add_filter('loop-shop-posts-in', array($this, 'jigoshop_az_filter'));

				add_filter('widget_product_categories_args', array($this, 'test'));

				
			}
			public function test($args) {
				$args['order'] = 'DESC';

				return $args;
			}

			public function wp_init() {
				remove_post_type_support( 'product', 'comments' );
			}

			public function jigoshop_admin_menu() {
				add_submenu_page('jigoshop', __('Lagersaldo','jigoshop'), __('Lagersaldo','jigoshop'), 'manage_options', 'jigoshop_storevalue', array($this, 'jigoshop_store_value'));
			}

			public function jigoshop_store_value() {
                $result = $this->calculate_store_value();
				echo '<div class="wrap jigoshop">';
				echo '<div class="icon32 icon32-jigoshop-debug" id="icon-jigoshop"><br/></div>';
				echo '<h2>' . __('Lagersaldo','jigoshop') . '</h2>';
				echo '<p><strong>Totalt lagersaldo:</strong> ' . $result[0] . ' kr</p>';
                echo '<p><strong>Antal produkter med inköpspris:</strong> ' . $result[1] . '</p>';

				echo '</div>';
			}

			public function wp_register_widgets() {
				register_widget('Jigoshop_Widget_AZ_Filter');
                //register_widget('Jigoshop_Widget_Product_Categories_AMTY');
			}
			
			public function wp_add_metadata_boxes(){
				add_meta_box( $this->domain . '_extra_information_box', __( 'Extra information', $this->domain ), array( &$this, 'wp_extra_information_metabox_content' ), 'product', 'normal' );
			}			
			
			public function wp_extra_information_metabox_content( $post ){
				wp_nonce_field( plugin_basename( __FILE__ ), $this->domain . '-nonce' );
				$purchase_price = get_post_meta( $post->ID, '_' . $this->domain . '_purchase_price', true );
				$extra_information = get_post_meta( $post->ID, '_' . $this->domain . '_extra_information', true );
				$internal_information = get_post_meta( $post->ID, '_' . $this->domain . '_internal_information', true );
				require( dirname( __FILE__ ) . '/template/extra-information-metabox.tpl.php' );			
			}
			
			public function wp_save_post_metadata( $post_id ){
			
				if( !wp_verify_nonce( $_POST[$this->domain . '-nonce'], plugin_basename( __FILE__ ) ) ){
					return $post_id;
				}

				if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
					return $post_id;
				}

				if( 'page' == $_POST['post_type'] ) {
					if( !current_user_can( 'edit_page', $post_id ) ){
						return $post_id;
					}
				}else{
					if( !current_user_can( 'edit_post', $post_id ) ){
						return $post_id;
					}
				}
				if ( isset( $_POST[$this->domain . '_purchase_price'] ) ) {
                    $purchase_price = trim(str_replace(',', '.', $_POST[$this->domain . '_purchase_price']));
                    update_post_meta( $post_id, '_' . $this->domain . '_purchase_price', $purchase_price);
				}
				if ( isset( $_POST[$this->domain . '_extra_information'] ) ) {
					update_post_meta( $post_id, '_' . $this->domain . '_extra_information', $_POST[$this->domain . '_extra_information']);
				}
				if ( isset( $_POST[$this->domain . '_internal_information'] ) ) {
						update_post_meta( $post_id, '_' . $this->domain . '_internal_information', $_POST[$this->domain . '_internal_information']);
				}
			}

			public function wp_delete_post_metadata( $post_id ){
				$fp = fopen(dirname( __FILE__ ) . '/../log.txt', 'a');
				fputs($fp, 'Delete post meta: '. $post_id);
				fclose($fp);
				delete_post_meta( $post_id, '_' . $this->domain . '_extra_information' );
                delete_post_meta( $post_id, '_' . $this->domain . '_purchase_price' );
            }
			
			
			public function shop_small_image_size() {
				return 100;
			}
			
			public function jigoshop_before_main_content() {
				echo '	  
					<div class="aside column small-column first-column" role="complementary">
							';
				dynamic_sidebar( 'Left column sidebar - shop' );
				echo '</div>
				
					    <div class="column medium-column">
					    	<div class="section post-section clear-children" role="main">
				';
			}
			
			public function jigoshop_after_main_content() {
				echo '
					</div>
				</div>
				<div class="aside column small-column" role="complementary">';
		    	dynamic_sidebar( 'Right column sidebar - shop' );
				echo '</div>';
			}
			
			public function wp_add_query_vars($vars) {
				$new_vars = array('filter');
				$vars = $new_vars + $vars;
				return $vars;
			}


			public function jigoshop_before_shop_loop() {
				global $wp_query;

				if ( is_tax('product_cat')  ) :
					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
					$filter_var = get_query_var('filter');
					$filters = array();
					$type_filters = array(16,17,54,63);
					$genre_filters = array(28,32,36,38);
					$parent = $term->parent;
					$current = $term->term_id;
					if ($parent == 15) {
						if ( in_array($current, $type_filters ) ) {
							$filters = $genre_filters;
						} elseif ( in_array( $current, $genre_filters ) ) {
							$filters = $type_filters;
						}
						//$filters = get_term_children(62, 'product_cat');
					}

					if (!empty($filters)) {
						echo '<div class="custom-filter">';
						echo '	<h3>Filtrera på:</h3>';
						foreach ($filters as $filter) {
							$item = get_term_by( 'id', $filter, get_query_var( 'taxonomy' ));
							echo '<a class="filter filter-' . $item->slug . '"href="' . get_term_link( (int)$term->term_id, 'product_cat' ) . '?filter=' . $filter . '">' . $item->name . '</a>';
						}
						echo '</div>';
					}

					if ($filter_var) {
						$args = array_merge( $wp_query->query, 
							array(
								'tax_query' => array( 
									array(
										'taxonomy' => 'product_cat',
										'field' => 'id',
										'terms' => array((int)$filter_var, (int)$term->term_id),
										'operator' => 'AND',
									)
								)
							)
						);
						query_posts($args);
					}
	
				endif;
			}
			
			public function jigoshop_size_guide($post) {
				global $_product;
				if ($_product->has_attributes()) {
					echo '<a href="' . get_permalink(448) . '" class="size-guide-link" data-link="#size-guide">Så här har vi mätt</a>';
					echo '<div style="display: none"><div id="size-guide">' . $this->get_page_content(448) . '</div></div>';	
				}
				return;
			}
			
			public function jigoshop_product_extra_information_tab( $current_tab ) {
				global $_product;
				if ($_product->has_attributes()) {
					echo '<li' . ($current_tab=='#tab-extra-information' ? ' class="active"' : '') . '><a href="#tab-extra-information">' . __('Storleksguide', 'amty') . '</a></li>';
				}
			}	

			public function jigoshop_product_extra_information_panel() {
				global $_product;
				if ($_product->has_attributes()) {
					$extra_information = get_post_meta( $_product->id, '_' . $this->domain . '_extra_information', true );
					$extra_information = apply_filters('the_content', $extra_information);
					$extra_information = str_replace(']]>', ']]&gt;', $extra_information);
					echo '<div class="panel" id="tab-extra-information">';
					echo '<h2>' .  __('Storleksguide', 'amty' ) . '</h2>';
					echo '<a href="' . get_permalink(448) . '" class="size-guide-link" data-link="#size-guide">Så här har vi mätt</a>';
					echo '<div style="display: none"><div id="size-guide">' . $this->get_page_content(448) . '</div></div>';
					echo $extra_information;
					/*echo '<h2>' .  __('Storleksguide', 'amty' ) . '</h2>';

					echo '<div id="size-guide-inline">' . $this->get_page_content(448) . '</div>';*/
					echo '</div>';
				}
			}
			
			/**
			 * Pagination
			 **/
			public function jigoshop_pagination() {
				global $wp_query;
				if (  $wp_query->max_num_pages > 1 ) :
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
		    	endif;
			
			}

			public function get_page_content($pageId) {
				$include_page = get_page($pageId);
				$html = apply_filters('the_content', $include_page->post_content);
				$html = str_replace(']]>', ']]&gt;', $html);
				return $html;
			}

            public function calculate_store_value() {

                $total_price = 0;
                $products_with_price = 0;

                $args = array(
                    'post_type'	  => 'product',
                    'numberposts' => -1,
                    'post_status' => 'any'
                );

                $posts = get_posts( $args );

                foreach( $posts as $post ) {

                    $purchase_price = get_post_meta( $post->ID, '_' . $this->domain . '_purchase_price', true );
                    if (is_numeric( $purchase_price ) ) {

                        $attributes = (array) maybe_unserialize( get_post_meta($post->ID, 'product_attributes', true) );

                        if ( $this->has_variable_attributes( $attributes ) ) {
                            // Get all variations of the product
                            $variations = get_posts(array(
                                'post_type'   => 'product_variation',
                                'post_status' => array('draft', 'publish'),
                                'numberposts' => -1,
                                'orderby'     => 'id',
                                'order'       => 'desc',
                                'post_parent' => $post->ID
                            ));

                            foreach( $variations as $variation ) {
                                $stock = get_post_meta( $variation->ID, 'stock', true );
                                $variation_purchase_price = $purchase_price * $stock;
                                //DEBUG: echo $variation->post_title . ' - ' . $stock . ' - ' . $variation_purchase_price . '<br>';
                                $total_price = $total_price + $variation_purchase_price;
                            }

                        } else {
                            $stock = get_post_meta( $post->ID, 'stock', true );
                            $purchase_price = $purchase_price * $stock;
                            //DEBUG: echo $post->post_title . ' - ' . $stock . ' - ' . $purchase_price . '<br>';
                            $total_price = $total_price + $purchase_price;
                        }
                        $products_with_price++;
                    } elseif ($purchase_price != '') {
                        echo $post->ID . ' - ';
                    }

                }

                return array($total_price, $products_with_price);
            }
            public function jigoshop_billing_fields($fields) {
                $new_fields = array();
                foreach ($fields as $field) {
                    if ($field['name'] != 'billing-company') {
                        if ($field['name'] == 'billing-phone') {
                            $field['class'] = array('form-row-first');
                        }
                        array_push($new_fields, $field);
                        if ($field['name'] == 'billing-email') {
                            array_push( $new_fields, array( 'type' => 'input', 'class' => array('form-row-last'),  'name' => 'billing-email-validate', 'required' => 1, 'label' => __('Bekräfta e-post / Confirm Email address', 'jigoshop'), 'placeholder' => __('you@domain.com', 'jigoshop') ) );
                        }
                    }
                }
                array_push( $new_fields, array( 'type' => 'textarea', 'class' => array('form-row-full notes'),  'name' => 'order_comments', 'label' => __('Order Notes', 'jigoshop'), 'placeholder' => __('Notes about your order.', 'jigoshop') ) );
                return $new_fields;
            }
            public function jigoshop_shipping_fields($fields) {
                return array();
            }
            /**
             * Checks all the product attributes for variation defined attributes
             *
             * @param   mixed   Attributes
             * @return  bool
             */
            private function has_variable_attributes( $attributes ) {
                if ( ! $attributes )
                    return false;

                foreach ( $attributes as $attribute ) {
                    if ( isset($attribute['variation']) && $attribute['variation'] )
                        return true;
                }

                return false;
            }

			public function jigoshop_az_filter( $filtered_posts ) {

				if (isset($_GET['starting_letter'])) :
			
					$matched_products = array( 0 );
			
					$matched_products_query = get_posts(array(
						'post_type' => 'product',
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'tax_query' => array(
							array(
								'taxonomy' => 'product_type',
								'field' => 'slug',
								'terms' => 'grouped',
								'operator' => 'NOT IN'
							)
						)
					));
			
					if ($matched_products_query) :
			
						foreach ($matched_products_query as $product) :
							if (substr(lcfirst($product->post_title),0,1) ==  $_GET['starting_letter']) {
								$matched_products[] = $product->ID;
							}						
						endforeach;
			
					endif;
			
					// Get grouped product ids
					$grouped_products = get_objects_in_term( get_term_by('slug', 'grouped', 'product_type')->term_id, 'product_type' );
			
					if ($grouped_products) foreach ($grouped_products as $grouped_product) :
			
						$children = get_children( 'post_parent='.$grouped_product.'&post_type=product' );
			
						if ($children) foreach ($children as $product) :
							$first_letter = substr(lcfirst($product->post_title),0,1);

							if ($first_letter<=$_GET['starting_letter']) :
			
								$matched_products[] = $grouped_product;
			
								break;
			
							endif;
						endforeach;
			
					endforeach;
			
					$filtered_posts = array_intersect($matched_products, $filtered_posts);
			
				endif;
			
				return $filtered_posts;
			}
		}
	}
