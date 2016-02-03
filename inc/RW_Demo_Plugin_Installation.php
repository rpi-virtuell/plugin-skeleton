<?php
/**
 * @TODO  Class RW_Demo_Plugin_Installation
 *
 * Contains some helper code for plugin installation
 *
 * @package   @TODO RW Demo Plugin
 * @author    @TODO Frank Staude
 * @license   GPL-2.0+
 * @link      @TODO https://github.com/rpi-virtuell/plugin-skeleton
 */
class RW_Demo_Plugin_Installation { //@TODO  Klassenname
    /**
     * Check some thinks on plugin activation
     *
     * @since   0.0.1
     * @access  public
     * @static
     * @return  void
     */
    public static function on_activate() {

        // check WordPress version
        if ( ! version_compare( $GLOBALS[ 'wp_version' ], '4.0', '>=' ) ) {
            deactivate_plugins( RW_Demo_Plugin::$plugin_filename ); //@TODO  Klassename
            die(
            wp_sprintf(
                '<strong>%s:</strong> ' .
                __( 'This plugin requires WordPress 4.0 or newer to work', RW_Demo_Plugin::get_textdomain() )
                , RW_Demo_Plugin::get_plugin_data( 'Name' )  // @TODO  2x Klassenname
            )
            );
        }


        // check php version
        if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
            deactivate_plugins( RW_Demo_Plugin::$plugin_filename ); // @TODO  Klassenanme
            die(
            wp_sprintf(
                '<strong>%1s:</strong> ' .
                __( 'This plugin requires PHP 5.3 or newer to work. Your current PHP version is %1s, please update.', RW_Demo_Plugin::get_textdomain() )
                , RW_Demo_Plugin::get_plugin_data( 'Name' ), PHP_VERSION  //@TODO  2x Klassenname
            )
            );
        }

        // check buddypress @TODO  Nur wenn BuddyPress activity für das Plugin nötig ist
        if ( ! function_exists( 'bp_activities' ) ) {
            deactivate_plugins( RW_Demo_Plugin::$plugin_filename ); //@TODO  Klassenname
            die(
            wp_sprintf(
                '<strong>%1s:</strong> ' .
                __( 'This plugin requires BuddyPress to work.', RW_Sticky_Activity::get_textdomain() )
                , RW_Sticky_Activity::get_plugin_data( 'Name' ), PHP_VERSION
            )
            );
        }

        // @TODO  Hier weitere Checks einbaun die das Plugin ggf als Abhängigkeiten hat. MU, bbPress usw
    }

    /**
     * Clean up after deactivation
     *
     * Clean up after deactivation the plugin
     *
     * @since   0.0.1
     * @access  public
     * @static
     * @return  void
     */
    public static function on_deactivation() {

    }

    /**
     * Clean up after uninstall
     *
     * Clean up after uninstall the plugin.
     * Delete options and other stuff.
     *
     * @since   0.0.1
     * @access  public
     * @static
     * @return  void
     *
     */
    public static function on_uninstall() {

    }
}
