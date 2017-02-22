<?php
defined( 'ABSPATH' ) OR exit;

    function _getStyleIndex(&$styles, $id){
        foreach((array)$styles as $index => $style){
            if($style['id'] == $id){
                return $index;
            }
        }
        return null;
    }
    function _getStyle(&$styles, $id){
        $index = _getStyleIndex($styles, $id);
        return !is_null($index) ? $styles[$index] : null;
    }

    function _styleAction(&$style, $action){
        return "?page=snazzy_maps&tab=0&action=$action&style=" . $style['id'];
    };

    function admin_styles_head($tab){   
        
        $styles = get_option('SnazzyMapStyles', null);
        if($styles == null){
            $styles = array();
        }        
        
        
        //When a new style is selected we have to go through some checks
        if(isset($_POST['new_style'])){
            $json = new SnazzyMaps_Services_JSON();
            $newStyle = _object_to_array($json->decode(urldecode($_POST['new_style'])));
            if(!_getStyle($styles, $newStyle['id'])){
                $styles[] = $newStyle;
                update_option('SnazzyMapStyles', $styles);
            }            
        }
    }

    function admin_styles_tab($tab){
        
        $styles = get_option('SnazzyMapStyles', null);
        if($styles == null){
            $styles = array();
        }
                
                
        if(isset($_GET['action']) && $_GET['action'] == 'delete_style'){
            $index = _getStyleIndex($styles, $_GET['style']);
            $defaultStyle = get_option('Maps', null);  
            if(!is_null($index)){                
                $oldStyle = $styles[$index];
                array_splice($styles, $index, 1);    
                update_option('SnazzyMapStyles', $styles);     
            }
        }
        
        //Enable the specified style
        if(isset($_GET['action']) && $_GET['action'] == 'enable_style'){
            $index = _getStyleIndex($styles, $_GET['style']);
            if(!is_null($index)){
                update_option('Maps', $styles[$index]);
            }        
        }
        
        //Disable the specified style        
        if(isset($_GET['action']) && $_GET['action'] == 'disable_style'){
            $index = _getStyleIndex($styles, $_GET['style']);
            $defaultStyle = get_option('Maps', null);    
            if(!is_null($index) && !is_null($defaultStyle) 
                && $styles[$index]['id'] == $defaultStyle['id']){
                delete_option('Maps');
            }        
        }
        
        
        $defaultStyle = get_option('Maps', null);
        
        //Used during testing
        if(isset($_GET['clear_styles'])){
            delete_option('SnazzyMapStyles');
        }
?>
            
        <?php if (count($styles) > 0) { ?>
            <div class="results row">
                <?php foreach((array)$styles as $index => $style){ 
                    $isEnabled = !is_null($defaultStyle) && $defaultStyle['id'] == $style['id'];
                ?>        
                    <div class="style col-sm-6 col-md-4 <?php echo $isEnabled ? 'Aktiv' : '';?>">
                        <div class="sm-style">
                            <div class="sm-map">
                                <img src="<?php echo $style['imageUrl']; ?>"
                                     alt="<?php echo $style['name']; ?>"/>
                                <?php
                                if($isEnabled) {
                                ?>    
                                    <span class="overlay-icon">
                                        <span class="icon-checkmark"></span>
                                    </span>
                                <?php 
                                } ?>
                            </div>
                            <div class="sm-content info">
                                <h3><?php echo $style['name']; ?></h3>
                                <?php
                                if($isEnabled){
                                ?>                    
                                    <a href="<?php echo _styleAction($style, 'disable_style'); ?>" 
                                        class="button button-secondary button-large">Deaktiver</a>
                                <?php
                                }
                                else{ 
                                ?>                    
                                    <a href="<?php echo _styleAction($style, 'enable_style'); ?>" 
                                        class="button button-primary button-large">Aktiver</a>
                                <?php 
                                } ?>
                            </div>
                        </div>
                    </div>     
                <?php } ?>
            </div>
        <?php }else{ ?>            
            <div class="nothing">
                <p>Det ser ud til at du endnu ikke har fundet nogle Kort Layout</p>
                <p><a href="?page=snazzy_maps&tab=1">Gå på opdagelse</a> og find et kort der passer til din hjemmeside.</p>
            </div>
        <?php } ?>

<?php } ?>
