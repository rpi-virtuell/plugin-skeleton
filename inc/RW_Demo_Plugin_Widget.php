<?php
/**
 * Class RW_Demo_Plugin_Widget
 *
 * Widget for the plugin
 *
 * @package   RW Demo Plugin
 * @author    Demo Author
 * @license   GPL-2.0+
 * @link      https://github.com/rpi-virtuell/rw-demo-plugin
 */
class RW_Demo_Plugin_Widget extends WP_Widget {

    // Register and load the widget
    public static function init() {
        register_widget( 'RW_Demo_Plugin_Widget' );
    }

    function __construct() {
        parent::__construct(
        // Base ID of your widget
            'RW_Demo_Plugin_Widget',

            // Widget name will appear in UI
            __('RW Demo Plugin Widget', RW_Demo_Plugin::get_textdomain()),

            // @TODO Widget description
            array( 'description' => __( 'Your Widget Description ...', RW_Demo_Plugin::get_textdomain() ), )
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {
        if(! isset($instance['title'])) $instance['title']='' ;
        $title = apply_filters( 'widget_title', $instance['title'] );
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        // @TODO create the Widget Content
        echo __( 'Hello, World!', RW_Demo_Plugin::get_textdomain() );

        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Widget Name', RW_Demo_Plugin::get_textdomain() );
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}

