<?php
/**
 * Class RW_Demo_Plugin_Core
 *
 * Autoloader for the plugin
 *
 * @package   RW Demo Plugin
 * @author    Demo Author
 * @license   GPL-2.0+
 * @link      https://github.com/rpi-virtuell/rw-demo-plugin
 */
class RW_Demo_Plugin_Core {

    /**
     * Constructor
     *
     * @since   0.0.2
     * @access  public
     */
    function __construct() {

    }
    /**
     * runs on action hook init
     *
     * @since   0.0.2
     * @access  public
     * @static
     * @return  void
     * @use_action: init
     */
    public static function init() {



    }


    /**
     * Load custom Stylesheet
     *
     * @since   0.0.2
     * @access  public
     * @static
     * @return  void
     * @use_action: wp_enqueue_scripts
     */
    public static function enqueue_style() {
        wp_enqueue_style( 'customStyle',RW_Demo_Plugin::$plugin_url . '/css/style.css' );
    }

    /**
     * Load custom javascript
     *
     * @since   0.0.2
     * @access  public
     * @static
     * @return  void
     * @use_action: wp_enqueue_scripts
     */
    public static function enqueue_js() {

        wp_enqueue_script( 'rw_demo_plugin_ajax_script',RW_Demo_Plugin::$plugin_url . '/js/javascript.js' );

    }

    //TODO: add wp_ajax-response-actions in rootfile
    //TODO: add javasript ajax calls
    //TODO: add corresponding response functions like this
    /**
     * Example of Ajax response
     *
     * @since   0.0.2
     * @access  public
     * @static
     * @return  void
     * @use_action: wp_ajax_rw_demo_plugin_core_ajaxresponse
     */
    public static function ajaxresponse(){

        echo json_encode(
            array(
                    'success' =>  true
                ,   'msg'=>'Ajax Example. <em>Users time on click</em> : <b>'.
                            $_POST['message'] .
                            '</b> ( scripts locatet in: inc/'.
                            basename(__FILE__).' (Line: '.__LINE__.
                            ') | js/javascript.js )'
            )
        );

        die();

    }
}