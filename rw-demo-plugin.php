<?php
/*
 * Plugin Name:       RW Demo Plugin
*/

class AJAX_Demo_Plugin {

	public function __construct() {

        //ajax action: request_via_ajax
		add_action( 'wp_ajax_request_via_ajax', array( $this, 'request_via_ajax' ) );

        //options page von der aus das ajay ausgeführt werden soll
		add_action( 'admin_menu', array($this,'add_options_page') );

	}

	public function request_via_ajax($data) {

		wp_send_json($data);
		die();
	}


	public function add_options_page() {

		add_options_page( 'Ajax Plugin Options Page', 'Ajax Plugin', 'manage_options', 'rw-ajax-plugin', array($this, 'display_options_page') );

	}
	public function display_options_page() {
		?>
		<h1>Ajax Plugin Options Page</h1>
		<button class="test">Test</button>


		<script>

            $( document ).on( 'click', 'button', function() {
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,     // the variable ajaxurl is prepared by wp core
                    data: {
                        action: 'request_via_ajax',  // ajax action @see line 11
                        search_input: 'test'
                    },
                    success: function (data, textStatus, XMLHttpRequest) {
                        readData = $.parseJSON(data);
                        console.log($.parseJSON(data));

                        if($('#results')){

                            $('#results').append(  readData.toString()  );
                        }

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });

            });

		</script>
		<?php
	}
}
new AJAX_Demo_Plugin();
