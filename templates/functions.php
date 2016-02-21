<?php
/**
 * put your custom functions here
 */

/**
 * @example create top message on a Blogsite
 *
 * @param $post_object
 */
function rw_demo_plugin_action( $post_object ) {
    ?>
        <div class="rw-demo-plugin-message">
        Message to the <a href="#">World</a>
    </div>
    <?php
}
add_action( 'wp_head', 'rw_demo_plugin_action' );
do_action( 'rw_demo_plugin_action' );