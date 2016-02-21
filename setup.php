<?php
/**
 * displays a form for creating a new plugin
 * after submitting, a new plugin will be created in the plugins dir.
 * after successfull creation the RW Demo Plugin Skeleton will be disabled.
 */
 
if ( class_exists( 'RW_Demo_Plugin' ) ) {

    function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        echo  '<ul><b>'.basename($dst) .'</b>';
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    if(! in_array($file, array('.git','.idea'))){
                        recurse_copy($src . '/' . $file,$dst . '/' . $file);
                    }
                }
                else {
                    if(! in_array($file, array('.gitignore'))) {
                        copy($src . '/' . $file, $dst . '/' . $file);
                        echo '<li style="margin-left:50px"><i>' . $file . '</i></li>';
                    }
                }
            }
        }
        echo '</ul>';
        closedir($dir);
    }

    function relpace_demo($file)
    {

        $name = trim($_POST['name']);
        $url = trim($_POST['url']);
        $author = trim($_POST['author']);
        $description = trim($_POST['description']);
        $class = trim($_POST['class']);
        $class_hyphon = strtolower( str_replace('_', '-',$class) );
        $class_underscore = strtolower( $class );


        $content = file_get_contents($file);

        $content = str_replace('RW Demo Plugin', $name, $content);
        $content = str_replace('Demo Author', $author, $content);
        $content = str_replace('http://author.de', $url, $content);
        $content = str_replace('RW_Demo_Plugin', $class, $content);
        $content = str_replace('rw-demo-plugin', $class_hyphon, $content);
        $content = str_replace('rw_demo_plugin', $class_underscore, $content);
        $content = str_replace('@TODO Description', $description, $content);
        $content = str_replace("include('setup.php');", '', $content);

        file_put_contents($file, $content);

        echo ' - '. basename($file)."<br>";
    }


    add_action('plugins_loaded', 'rw_clone_plugin' );
    function rw_clone_plugin(){


        if(
            isset($_POST['name'] )  && $_POST['name']   != 'RW '    &&
            isset($_POST['class'])  && $_POST['class']  != 'RW_'    &&
            isset($_POST['author']) && $_POST['author'] != ''       &&
            isset($_POST['url'])    && $_POST['url']    != ''
        ){
            $class = trim($_POST['class']);
            $class_hyphon = strtolower( str_replace('_', '-',$class) );

            RW_Demo_Plugin::$plugin_dir;

            $clonedir = dirname(dirname(__FILE__)) .'/'. $class_hyphon.'/';

            $origindir = RW_Demo_Plugin::$plugin_dir;

            if(file_exists($clonedir)){
                wp_die('Das zu erzeugende Plugin existiert bereits');
            }

            echo '<b>Ein neues Plugin</b> wird unter '.$clonedir.' angelegt<hr><ul>';

            recurse_copy($origindir,$clonedir);

            echo '</ul><hr><b>Dateien werden modifiziert:</b><br>';

            rename ($clonedir.'rw-demo-plugin.php',$clonedir.$class_hyphon.'.php');

            relpace_demo ($clonedir.$class_hyphon.'.php');
            relpace_demo ($clonedir.'js/javascript.js');
            relpace_demo ($clonedir.'css/style.css');
            relpace_demo ($clonedir.'templates/functions.php');
            relpace_demo ($clonedir.'README.md');
            relpace_demo ($clonedir.'readme.txt');

            $inc_dir = $clonedir.'inc/';

            $dir = opendir( $inc_dir );
            while(false !== ( $file = readdir($dir)) ) {
                if (( $file != '.' ) && ( $file != '..' )) {
                    if (! is_dir($inc_dir . '/' . $file) ) {

                        $clone_file = str_replace('RW_Demo_Plugin', $class,$file);
                        rename ($inc_dir.'/'.$file,$inc_dir.'/'.$clone_file);

                        relpace_demo($inc_dir.'/'.$clone_file);
                    }
                }
            }
            closedir($dir);
            deactivate_plugins( plugin_basename( RW_Demo_Plugin::$plugin_filename ) );
            unlink($clonedir.'setup.php');

            wp_die('<hr><b>Vorgang erfolgreich beendet.</b> Das RW Demo Plugin wurde abschließend deaktiviert. <a href="?">weiter</a>');
        }

        ?>
        <h2>Plugingerüst generieren</h2>
        <p>Nach Ausfüllen und Absenden wird ein  neues Plugin im Plugin Verzeichniss  unter dem Verzeichnisnamen der Basisklasse dieser Wordpress-Intanz erzeugt.</p>
        <form method="post">
            <table>
                <tr>
                    <td style="font-size: 80%;"><b>Plugin Name</b> ( <i> z.B.: RW Activity Feed</i> )</td>
                    <td><input name="name" value="RW " style="width:300px"></td>
                </tr>
                <tr>
                    <td style="font-size: 80%;"><b>Basis Klasse</b> ( <i>z.B.: RW_Activity_Feed</i> )</td>
                    <td><input name="class" value="RW_" style="width:300px"></td>
                </tr>
                <tr>
                    <td style="font-size: 80%;"><b>Autor Name</b></td>
                    <td><input name="author" value="" style="width:300px"></td>
                </tr>
                <tr>
                    <td style="font-size: 80%;"><b>Autor Url</b></td>
                    <td><input name="url" value="" style="width:300px"></td>
                </tr>
                <tr>
                    <td style="font-size: 80%;"><b>Kurzbeschreibung des Plugins</b></td>
                    <td><textarea name="description" style="width:300px"></textarea></td>
                </tr>

            </table>

            <br>
            <br>
            <input type="submit" value="Plugin Verzeichnis dieses Blogs erzeugen">
        </form>

        <?php
        wp_die();
    }


}
