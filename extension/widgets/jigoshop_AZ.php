<?php
/**
 * A-Z Widget
 * 
 * Generates a list of letters to filter products by starting letter
 *
 */
 
function jigoshop_az_filter_init() {
	
	unset($_SESSION['starting_letter']);
	
	if (isset($_GET['starting_letter'])) :
		
		$_SESSION['starting_letter'] = $_GET['starting_letter'];
		
	endif;
	
}

add_action('init', 'jigoshop_az_filter_init');

class Jigoshop_Widget_AZ_Filter extends WP_Widget {

	/** constructor */
	function Jigoshop_Widget_AZ_Filter() {
		$widget_ops = array( 'description' => __( "Shows a starting letter filter in a widget which lets you narrow down the list of shown products in categories.", 'jigoshop') );
		parent::WP_Widget('az_filter', __('Jigoshop: A-Z Filter', 'jigoshop'), $widget_ops);
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract($args);
		
		if (!is_tax( 'product_cat' ) && !is_post_type_archive('product') && !is_tax( 'product_tag' )) return;
		if (get_query_var('filter')) return;
		
		global $_chosen_attributes, $wpdb, $all_post_ids;
				
		$title = $instance['title'];
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);
		
		echo $before_widget . $before_title . $title . $after_title;
		
		// Remember current filters/search
		$fields = '';
		
		if (get_search_query()) $fields = '<input type="hidden" name="s" value="'.get_search_query().'" />';
		if (isset($_GET['post_type'])) $fields .= '<input type="hidden" name="post_type" value="'.$_GET['post_type'].'" />';

		if ($_chosen_attributes) foreach ($_chosen_attributes as $attribute => $value) :
		
			$fields .= '<input type="hidden" name="'.str_replace('pa_', 'filter_', $attribute).'" value="'.implode(',', $value).'" />';
		
		endforeach;
		
		
		if (defined('SHOP_IS_ON_FRONT')) :
			$link = '';
		elseif (is_post_type_archive('product') || is_page( get_option('jigoshop_shop_page_id') )) :
			$link = get_post_type_archive_link('product');
		else :					
			$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
		endif;
		echo '<ul>';

		foreach(range('1', '9') as $letter) {
   			echo '<li><a href="' . $link . '?starting_letter=' . $letter . '"';
   			if ($letter == $_SESSION['starting_letter']) {
   				echo 'class="selected-letter" ';
   			}
   			echo '>' . $letter . '</a></li>';
		}
		foreach(range('a', 'z') as $letter) {
   			echo '<li><a href="' . $link . '?starting_letter=' . $letter . '"';
   			if ($letter == $_SESSION['starting_letter']) {
   				echo 'class="selected-letter" ';
   			}
   			echo '>' . $letter . '</a></li>';
		}
		echo '</ul>';		
		echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['title']) || empty($new_instance['title'])) $new_instance['title'] = __('Filter A-Z', 'jigoshop');
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		global $wpdb;
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'jigoshop') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
		<?php
	}
} // class Jigoshop_Widget_AZ_Filter