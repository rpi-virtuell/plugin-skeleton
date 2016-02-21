<?php
/**
* Class RW_Demo_Plugin_Settings
*
* Creates s setting page and a menu entry in wp backend
*
* @package      RW Demo Plugin
* @author       Demo Author
* @license      GPL-2.0+
* @link         https://github.com/rpi-virtuell/rw-demo-plugin
* @since        0.0.2
*/
class RW_Demo_Plugin_Settings {

    static public $option_name = 'rw-demo-plugin';
    static public $options;

    static public function init(){

        self::check_nonce_requests();
        self::init_options();

        add_action( 'admin_menu', array('RW_Demo_Plugin_Settings','options_page') );
        add_action( 'network_admin_menu', array('RW_Demo_Plugin_Settings','options_page') );

        //enable custum dashboard widget
        //add_action('wp_dashboard_setup', array('RW_Demo_Plugin_Settings', 'dashboard_widgets') );
    }


    /**
     * @TODO: Create the form fields in one or more sections
     * @use_action: admin_menu
    */
    static public function options_page(  ) {

        //add a options page 
        add_options_page( 'rw-demo-plugin', 'RW Demo Plugin', 'manage_options', 'rw-demo-plugin', array('RW_Demo_Plugin_Settings', 'the_options_form') );


        /* --- Create a first Section 1 ----- */
        
        //@TODO Titel des Optionsbereich 1
        $section_title = 'Choose Plugin Options';

        /**
         * @TODO Einleitungstext im Optionsbereich 1
         */

        register_setting( 'section_1', RW_Demo_Plugin_Settings::$option_name );

        add_settings_section(
            'rw-demo-plugin-setting-page',                                          // id of the setting page
            __( 'Sample Options', RW_Demo_Plugin::get_textdomain() ),        // section title
            function(){                                                             // intro text before the input fields
                _e( 'Section intro Description....', RW_Demo_Plugin::get_textdomain() );
            },
            'section_1'
        );


        /* --- Create form fiels to the first Section 1 ----- */

        /**
         * TODO Eingabefelder für Optionen
         *  Beispiele: 
         */

        /* --- Checkbox 1 ----- */

        function rw_checkbox_1_draw(  ) {

            $optname = 'option1';

            $options = RW_Demo_Plugin_Settings::$options;   //read exiting value from wp options table
            $checked = ( isset( $options[$optname] ) && $options[$optname] ) ? true : false;
            ?>
            <input class="rw-demo-plugin-option-checkbox" type='checkbox' name='<?php echo RW_Demo_Plugin_Settings::$option_name; ?>[<?php echo $optname;?>]' <?php checked( $checked ); ?> value='1'>
            <?php _e('If activated ... ',RW_Demo_Plugin::get_textdomain()) ; ?>
            <?php

        }
        add_settings_field(
            'option1',                                              // Option Index
            __( 'Check this', RW_Demo_Plugin::get_textdomain() ),   // Label
            'rw_checkbox_1_draw',                                   // function to draw HTML Input
            'section_1',                                            // section slug
            'rw-demo-plugin-setting-page'                           // id der setting page
        );

        /* --- Textfield ----- */
        function rw_textfield_draw(  ) {
            $options = RW_Demo_Plugin_Settings::$options;
            ?>
            <input class="rw-demo-plugin-option-textfield" type='text' name='<?php echo RW_Demo_Plugin_Settings::$option_name; ?>[option2]' value='<?php echo $options['option2']; ?>'>
            <?php
        }

        add_settings_field(
            'option2',
            __( 'A Textbox', RW_Demo_Plugin::get_textdomain() ),
            'rw_textfield_draw',
            'section_1',
            'rw-demo-plugin-setting-page'
        );

        /* --- Selectbox ----- */

        function rw_selectfield_draw(  ) {
            $options = RW_Demo_Plugin_Settings::$options;

            $pages = get_pages();
            foreach ( $pages as $page ) {
                $selected = ($options['option3'] == $page->ID)? ' selected':'';
                $select_option = '<option value="' . $page->ID  . '"'.$selected.'>';
                $select_option .= $page->post_title;
                $select_option .= '</option>';

            }

            ?>
            <select class="rw-demo-plugin-option-select" type='text' name='<?php echo RW_Demo_Plugin_Settings::$option_name; ?>[option3]' selected='<?php echo $options['option3']; ?>'>
                <option><?php  echo __('Please Choose',RW_Demo_Plugin::get_textdomain()); ?></option>
                <?php  echo $select_option; ?>
            </select>
            <?php
        }


        add_settings_field(
            'option3',
            __( 'Select a Page', RW_Demo_Plugin::get_textdomain() ),
            'rw_selectfield_draw',
            'section_1',
            'rw-demo-plugin-setting-page'
        );

    }

    /**
     * @TODO Create the settings form
     *
     * @usedBy: add_options_page()
     * @since 0.0.2
     */
    static public function the_options_form(){

        ?>
        <form class="rw-demo-plugin-option-form" action='options.php' method='post'>

            <h1><?php _e('Settings'); ?> > RW Demo Plugin </h1>
            <?php
            _e('Settings for RW Demo Plugin',RW_Demo_Plugin::get_textdomain());

            echo '<hr>';

            //slot for js/ajax messages
            echo '<div class="notice notice-info"><p id="rw-demo-plugin-setting-page-ajaxresponse" ></p></div>';

            settings_fields( 'section_1' );
            do_settings_sections( 'section_1' );


            echo '<hr>';

            submit_button();

            self::print_set_defaults_button();

            ?>

        </form>
        <hr>
        RW Demo Plugin <?php echo __('was developed by',RW_Demo_Plugin::get_textdomain()); ?> Demo Autor (rpi-virtuell).
        <?php
    }

    /**
     * set default values for this plugin in the wp options table
     *
     * @since 0.0.2
     */
    static public function init_options(){

        RW_Demo_Plugin_Settings::$options = get_option( RW_Demo_Plugin_Settings::$option_name );
        if(!RW_Demo_Plugin_Settings::$options){

            update_option(RW_Demo_Plugin_Settings::$option_name,array(
                'option1'=>0,
                'option2'=>'default wert',
                'option3'=>''
            ));

        }

    }

    /**
     * checks incomming url request
     *
     */
    static function check_nonce_requests () {

        //Beispiel: Alle Plugin Einstellungen in der DB löschen set_defaults_button()

        if (isset($_GET['rw_demo_plugin_nonce']) && wp_verify_nonce($_GET['rw_demo_plugin_nonce'], 'set_defaults_button' ) ) {

            delete_option(RW_Demo_Plugin_Settings::$option_name);

            wp_redirect(admin_url( 'options-general.php?page=rw-demo-plugin&action=set_defaults_button' ));

        }elseif (isset($_GET['action']) && $_GET['action']=='set_defaults_button') {

            $url = admin_url( 'options-general.php?page=rw-demo-plugin' );
            RW_Demo_Plugin::notice_admin('success',RW_Demo_Plugin::$plugin_name. ': alle Einstellungen wurden zurückgesetzt. <b>[<a href="'.$url.'">Ok. Hide Notice.</a>]</b>');

        }
    }

    /**
     * Button (link) used in the form of settings page
     *
     * @since 0.0.2
     */
    static function print_set_defaults_button () {

        //use Wordpress Nonces for url based commands ( https://codex.wordpress.org/Wordpress_Nonce_Implementation )

        $nonce_url = wp_nonce_url( admin_url( 'options-general.php?page=rw-demo-plugin' ), 'set_defaults_button', 'rw_demo_plugin_nonce' );

        if (!isset($_GET['rw_demo_plugin_nonce'])) {
            ?>
            <a href="<?php print $nonce_url; ?>" class="button">
                <?php echo __('Reset all settings to default', RW_Demo_Plugin::get_textdomain()); ?>
            </a>
            <?php
        }
    }


    /**
     * Add a custom Dashboard widget to the rop of the widgets
     * @use_action wp_dashboard_setup
     *
     * @link https://codex.wordpress.org/Dashboard_Widgets_API
     */
    public static  function dashboard_widgets(){
        global $wp_meta_boxes;

        wp_add_dashboard_widget('rw_demo_plugin_widget',  __( 'RW Demo Plugin Help' , RW_Demo_Plugin::get_textdomain()), function(){
            echo __( 'Some Instructions to config this plugin...' , RW_Demo_Plugin::get_textdomain());
        });

        $origin_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
        $my_widget = array( 'example_dashboard_widget' => $origin_dashboard['rw_demo_plugin_widget'] );

        unset( $origin_dashboard['rw_demo_plugin_widget'] );
        $new_dashboard = array_merge( $my_widget, $origin_dashboard );
        // Save the sorted array back into the original metaboxes
        $wp_meta_boxes['dashboard']['normal']['core'] = $new_dashboard;

        //remove wordpress feeds widget
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    }


}
