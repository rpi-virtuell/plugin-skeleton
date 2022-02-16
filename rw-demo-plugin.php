<?php
/*
 * Plugin Name: Ajax Demo Plugin
*/

class AJAX_Demo_Plugin {

	public function __construct() {

        //ajax action: request_via_ajax
		add_action( 'wp_ajax_request_via_ajax', array( $this, 'request_via_ajax' ) );

        //options page von der aus das ajay ausgeführt werden soll
		add_action( 'admin_menu', array($this,'add_options_page') );

	}

    //Option page im Menü einhängen
	public function add_options_page() {

		add_options_page( 'Ajax Plugin Options Page',
            'Ajax Plugin',
            'manage_options',
            'rw-ajax-plugin',
            array($this, 'display_options_page')
        );

	}

    //Hier kommt die Ajaxanfrage an  (@see line 11)
	public function request_via_ajax() {

        //$_POST auswerten
		$search = isset($_POST['search_input'])?$_POST['search_input']:'';

        //die Rückantwort muss immer in Form eines arrrays sein
        $return = array(
           'results' => array ("<hr>","<p>Es wurde nach $search gefragt</p>","<hr>")
        );

        //als json versenden
        wp_send_json( $return );
		die();
	}


    //inhalt der Optionspage in der auch das Ajax ausgeführt wird
	public function display_options_page() {
		?>
		<h1>Ajax Plugin Options Page</h1>
        <input id="suche" placeholder="Tippe was">
        <div id="results">Ausgabe der Ergebnisse aus der Ajax-Abfrage</div>


		<script>

            // Script erst laden, wenn das Document vollständig ausgebout ist
            jQuery( document ).ready(function ($){

                //Ajax soll ausgelöst werden wenn im Input Feld geschrieben wird
                $( document ).on( 'keydown', '#suche', function() {
                    //ajax anfrage via Javascript an server schicken
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,                    // ajaxurl: global wp var
                        data: {                          // daten die per POST an den Server geschickt werden sollen
                            action: 'request_via_ajax',  // ajax action @see line 11
                            search_input: $('#suche').val()
                        },

                        //Ajax anfrage hat geklappt
                        success: function (data, textStatus, XMLHttpRequest) { //erfolgreiche anfrage

                            if($('#results')){

                                $('#results').html(''); //Ausgabe in das div#results schreiben:
                                for(const result of data.results){

                                    $('#results').append(  result  + '<br>');

                                }
                            }
                        },

                        //Ajax anfrage hat nicht geklappt
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                });
            });
		</script>
		<?php
	}
}
new AJAX_Demo_Plugin();
