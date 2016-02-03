<?php
/**
 * @TODO Class RW_Demo_Plugin_Autoloader
 *
 * Autoloader for the plugin
 *
 * @package   @TODO RW Demo Plugin
 * @author    @TODO Frank Staude
 * @license   GPL-2.0+
 * @link      @TODO  https://github.com/rpi-virtuell/plugin-skeleton
 */

class RW_Demo_Plugin_Autoloader { // @TODO Klassenname
    /**
     * Registers autoloader function to spl_autoload
     *
     * @since   0.0.1
     * @access  public
     * @static
     * @action  @TODO  rw_sticky_activity_autoload_register
     * @return  void
     */
    public static function register() {
        spl_autoload_register( 'RW_Demo_Plugin_Autoloader::load' ); //@TODO  Klassenname
        do_action( 'rw_demo_plugin_autoload_register' ); // @TODO  Hookname
    }

    /**
     * Unregisters autoloader function with spl_autoload
     *
     * @ince    0.0.1
     * @access  public
     * @static
     * @action  @TODO rw_sticky_activity_autoload_unregister
     * @return  void
     */
    public static function unregister() {
        spl_autoload_unregister( 'RW_Demo_Plugin_Autoloader::load' ); //@TODO  Klassenname
        do_action( 'rw_demo_plugin_autoload_unregister' ); // @TODO Hookname
    }

    /**
     * Autoloading function
     *
     * @since   0.0.1
     * @param   string  $classname
     * @access  public
     * @static
     * @return  void
     */
    public static function load( $classname ) {
        // only PHP 5.3, use now __DIR__ as equivalent to dirname(__FILE__).
        $file =  __DIR__ . DIRECTORY_SEPARATOR . ucfirst( $classname ) . '.php';
        if( file_exists( $file ) ) {
            require_once $file;
        }
    }
}
