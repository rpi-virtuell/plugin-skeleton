/**
 * @package   RW Demo Plugin
 * @author    Demo Author
 * @license   GPL-2.0+
 * @link      https://github.com/rpi-virtuell/rw-demo-plugin
 */

jQuery(document).ready(function($){

    $('#rw-demo-plugin-setting-page-ajaxresponse').parent().hide();


    $( document ).on( 'click', 'body', function() {

        var d=new Date();

        $.ajax({
            type: 'POST',
            url: ajaxurl,     // the variable ajaxurl is prepared by wp core
            data: {
                action: 'rw_demo_plugin_core_ajaxresponse',
                message: d.toString()
            },
            success: function (data, textStatus, XMLHttpRequest) {

                readData = $.parseJSON(data);
                console.log($.parseJSON(data));

                if($('#rw-demo-plugin-setting-page-ajaxresponse')){
                    $('#rw-demo-plugin-setting-page-ajaxresponse').html(  readData.msg  );
                    $('#rw-demo-plugin-setting-page-ajaxresponse').parent().show();
                }


            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    });    
    
});

