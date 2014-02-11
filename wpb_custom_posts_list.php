<?php
/**
 * Plugin Name: Custom posts list widget
 * Plugin URI: http://technocrat.org.ua/custom-posts-list-widget-2/
 * Description:  Widget to display the list of posts, pages or other types of pages by custom array.
 * Version: The Plugin's Version Number, e.g.: 0.1
 * Author: Osadchyi Sergii
 * Author URI: http://technocrat.org.ua
 * License: A "Custom posts list widget" license name e.g. GPL2
 */

// Custom posts list
class wp_custom_posts_list extends WP_Widget {

	function __construct() {
		parent::__construct(
		'wpb_custom_post_list', 

		__('Custom posts list', 'wpb_custom_posts_list'), 

		array( 'description' => __( 'This widget show post list by your custom option.', 'wpb_custom_post_list' ), ) 
		);
	}
	
	// Widget frontend
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		$custom_option = $instance['custom_array'];
		eval('$option = array('.$custom_option.');');
		query_posts( $option );  
 		while( have_posts() ){ 								
			the_post();    
			if ($instance['thumbail_show']=='checked') $img = '<div style="float: left; padding: 5px;">'.get_the_post_thumbnail( get_the_ID(), array($instance[ 'thumbail_width' ], $instance[ 'thumbail_height' ]) ).'</div>';
			if ($instance['excerpt_show']=='checked') $excerpt = '<div style="float: left;">'.get_the_excerpt().'</div>';
				else $excerpt = '';
			echo '<li><h4><a href="'.get_the_title().'">' . get_the_title() . '</a></h4>
				'.$img.$excerpt.'
				</li>';   
		}   
		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Title', 'wpb_widget_domain' );
		}
		
		if ( isset( $instance[ 'custom_array' ] ) ) {
			$custom_array = $instance[ 'custom_array' ];
		}
		else {
			$custom_array = __( "'posts_per_page'=>'5'", 'wpb_widget_domain' );
		}
		
		if ( isset( $instance[ 'excerpt_show' ] ) ) {
			$excerpt_show = $instance[ 'excerpt_show' ];
		}
		else {
			$excerpt_show = __( "", 'wpb_widget_domain' );
		}
		
		if ( isset( $instance[ 'thumbail_show' ] ) ) {
			$thumbail_show = $instance[ 'thumbail_show' ];
		}
		else {
			$thumbail_show = __( "", 'wpb_widget_domain' );
		}
		
		if ( isset( $instance[ 'thumbail_width' ] ) ) {
			$thumbail_width = $instance[ 'thumbail_width' ];
		}
		else {
			$thumbail_width = __( "150", 'wpb_widget_domain' );
		}
		
		if ( isset( $instance[ 'thumbail_height' ] ) ) {
			$thumbail_height = $instance[ 'thumbail_height' ];
		}
		else {
			$thumbail_height = __( "150", 'wpb_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'excerpt_show' ); ?>"><?php _e( 'Show excerpt:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'excerpt_show' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_show' ); ?>" type="checkbox" value="checked" <?php echo esc_attr( $excerpt_show ); ?> style="float: right!important; width: 30%;" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'thumbail_show' ); ?>"><?php _e( 'Show thumbnail:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'thumbail_show' ); ?>" name="<?php echo $this->get_field_name( 'thumbail_show' ); ?>" type="checkbox" value="checked" <?php echo esc_attr( $thumbail_show ); ?> style="float: right!important; width: 30%;" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'thumbail_size' ); ?>"><?php _e( 'Size:' ); ?></label> 
		</p>
		<p>
		Width: <input class="widefat" id="<?php echo $this->get_field_id( 'thumbail_width' ); ?>" name="<?php echo $this->get_field_name( 'thumbail_width' ); ?>" type="text" value="<?php echo esc_attr( $thumbail_width ); ?>" size="3" style="float: right!important; width: 30%;" />
		</p>
		<p>
		Height:
		<input class="widefat" id="<?php echo $this->get_field_id( 'thumbail_height' ); ?>" name="<?php echo $this->get_field_name( 'thumbail_height' ); ?>" type="text" value="<?php echo esc_attr( $thumbail_height ); ?>"  size="3" style="float: right!important; width: 30%;"  />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'custom_array' ); ?>"><?php _e( 'Custom array:' ); ?></label> 
		<textarea  class="widefat" id="<?php echo $this->get_field_id( 'custom_array' ); ?>" name="<?php echo $this->get_field_name( 'custom_array' ); ?>"><?php echo esc_attr( $custom_array ); ?></textarea>
		</p>

		<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['excerpt_show'] = ( ! empty( $new_instance['excerpt_show'] ) ) ? strip_tags( $new_instance['excerpt_show'] ) : '';
		$instance['thumbail_show'] = ( ! empty( $new_instance['thumbail_show'] ) ) ? strip_tags( $new_instance['thumbail_show'] ) : '';
		$instance['thumbail_width'] = ( ! empty( $new_instance['thumbail_width'] ) ) ? strip_tags( $new_instance['thumbail_width'] ) : '';
		$instance['thumbail_height'] = ( ! empty( $new_instance['thumbail_height'] ) ) ? strip_tags( $new_instance['thumbail_height'] ) : '';
		$instance['custom_array'] = ( ! empty( $new_instance['custom_array'] ) ) ? strip_tags( $new_instance['custom_array'] ) : '';
		return $instance;
	}
} 


function wpb_load_widget() {
	register_widget( 'wp_custom_posts_list' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

?>