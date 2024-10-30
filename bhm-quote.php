<?php
/*
Plugin Name: Random Quote
Description: Display a random quote in a sidebar.
Version: 0.1
Author: Brian H. Marston
Author URI: http://fatdays.com/
License: GPLv2 or later
*/

add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'bhm_quote',
		array(
			'labels' => array(
				'name' => __( 'Quotes' ),
				'singular_name' => __( 'Quote' ),
    			'add_new' => 'Add New',
    			'add_new_item' => 'Add New Quote',
    			'edit_item' => 'Edit Quote',
    			'new_item' => 'New Quote',
    			'all_items' => 'All Quotes',
    			'view_item' => 'View Quote',
    			'search_items' => 'Search Quotes',
    			'not_found' =>  'No quotes found',
    			'not_found_in_trash' => 'No quotes found in Trash' 
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'quotes'),
			'supports' => array('title','editor','post-formats'),
		)
	);
}

add_filter( 'option_default_post_format', 'custom_default_post_format' );
// Posts of type bhm_quote will be quotes by default, but all other post types
// will be the default set on the Settings > Writing admin panel
function custom_default_post_format( $format ) {
    global $post_type;

    return ( $post_type == 'bhm_quote' ? 'quote' : $format );
}

add_filter( 'enter_title_here', 'custom_enter_title' );
function custom_enter_title( $input ) {
    global $post_type;

    if ( 'bhm_quote' == $post_type )
        return __( 'Enter citation here', 'bhm-quote' );

    return $input;
}

// Define columns shown when listing quotes
add_filter("manage_bhm_quote_posts_columns", "set_quote_columns");
function set_quote_columns($columns)
{
	$columns = array(
		'cb' => '<input type="checkbox">',
		'title' => 'Citation',
		'description' => 'Quote'
	);
	return $columns;
}

// Define what to show in each column when listing quotes
add_action("manage_bhm_quote_posts_custom_column", "custom_columns", 10, 2);
function custom_columns($column, $post_id)
{
	global $post;
    switch ($column) {
		case "description":
			the_excerpt();
			break;
    }
}

// Remove media button from quote editing screen
add_action('admin_head','remove_media_buttons');
function remove_media_buttons() {
	global $current_screen;
	if ($current_screen->post_type == 'bhm_quote') {
		remove_all_actions('media_buttons');
	}
}

// register Quote_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "quote_widget" );' ) );



class Quote_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'quote_widget', // Base ID
			'Quote', // Name
			array( 'description' => __( 'Display a random quote from your collection', 'bhm-quote' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;


	    // Retrieve one random quote
	    $args = array(
	        'post_type' => 'bhm_quote',
	        'posts_per_page' => 1,
	        'orderby' => 'rand'
	    );
	    $query = new WP_Query( $args );
	    // Build output string
	    if ($query->found_posts) {
			$quote = '<div class="quote">&#8220;' . $query->post->post_content . '&#8221;</div>';
			$quote .= '<div class="citation">&mdash; ' . $query->post->post_title . '</div>';
			$quote .= '<div class="all-quotes">[<a href="' . get_post_type_archive_link('bhm_quote') . '">View All</a>]</div>';
		} else {
			$quote = "No quotes found";
		}
	    echo $quote;


		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'bhm-quote' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

} // class Quote_Widget

?>