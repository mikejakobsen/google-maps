<?php
defined( 'ABSPATH' ) OR exit;

include_once(plugin_dir_path(__FILE__) . _DS . 'styles.php');
include_once(plugin_dir_path(__FILE__) . _DS . 'explore.php');


function admin_perform_post (){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        //Perform the post for the tab that was selected        
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : null; 
        
        if($active_tab == 0){ admin_styles_head(0); }
        if($active_tab == 1){ admin_explore_head(1); }
        
        //401 next page
        if(!headers_sent()){
            header('Location: '. $_SERVER['REQUEST_URI']);
            exit();
        }
    }
}

function admin_enqueue_script($hook){

    //Only include the javascript in our page
    if($hook != 'appearance_page_snazzy_maps') return;
        
    //Include the javascript
    $handle = 'admin-snazzymaps-js';
    wp_enqueue_script($handle, plugins_url('index.js', __FILE__), $deps = array('jquery'),
                      $ver = VERSION);
    wp_localize_script($handle, 'SnazzyData', array('API_KEY' => API_KEY,
                                                  'API_BASE' => API_BASE,
                                                  'USER_API_KEY' => get_option('MySnazzyAPIKey', null)));
    
    //Include the bower components
    $bower_components = array(
        //history js
        'history.js' . _DS . 'scripts' . 
        _DS . 'bundled' . _DS . 'html5' .
        _DS . 'native.history.js',
        //simplequerystring
        'simple-query-string' . _DS . 'src' . 
        _DS . 'simplequerystring.min.js',
        //mustache
        'mustache' . _DS . 'mustache.min.js'
    );
    foreach((array)$bower_components as $index => $bower_component){
        wp_enqueue_script("admin-bower-component-$index", 
                resourceURL('bower_components' . _DS . $bower_component),
                $deps = array(),
                $ver = VERSION); 
    }
    
    //Load CSS
    wp_enqueue_style('admin-snazzymaps-css', 
                      plugins_url('index.css', __FILE__),
                      $deps = array(),
                      $ver = VERSION); 
}

function admin_add_custom_content(){
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : '0'; 
?>
    <div class="wrap sm-plugin">
        <script id="style-template" type="text/template">
            <form action="?page=snazzy_maps&tab=0" method="POST" class="col-sm-6 col-md-4 style">
                <div class="sm-style">
                    <div class="sm-map">
                        <img src="{{imageUrl}}" alt="{{name}}"/>
                    </div>
                    <div class="sm-content info">
                        <h3>{{name}}</h3>
                        <button class="button button-primary button-large" type="submit">Gem</button>   
                        <input type="hidden" name="new_style" value=""/> 
                    </div>
                </div>
            </form>   
        </script>   
        <div class="row">  
            <div class="nav-tab-container col-md-12">                       
                <h2 class="nav-tab-wrapper">
                    <?php
                        $tabs = array('Vælg Layout', 'Gå på opdagelse');
                        foreach((array)$tabs as $index => $tab){
                        ?>
                            <a href="?page=snazzy_maps&tab=<?php echo $index;?>"
                               class="nav-tab <?php echo $active_tab == $index ? 'nav-tab-active' : '';?>">
                                <?php echo $tab;?>
                            </a>
                        <?php
                        }
                    ?>
                </h2>         
                <?php if($active_tab == 0) { admin_styles_tab(0); } ?>     
                <?php if($active_tab == 1) { admin_explore_tab(1); } ?>
            </div>                
        </div>    
    </div>
<?php } ?>
