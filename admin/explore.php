<?php
defined( 'ABSPATH' ) OR exit;


define('PAGE_SIZE', 6);

function render_options($options, $selected){
    foreach((array)$options as $value => $text){
    ?>
        <option value="<?php echo $value;?>"
                <?php echo $value == $selected ? 'valgt' : '' ?>>
                <?php echo $text;?>
        </option>
    <?php
    }  
}

function admin_explore_head($tab){

}

function admin_explore_tab($tab){ 
    
    $sort = isset($_GET['sort']) ? $_GET['sort'] : ''; 
    $color = isset($_GET['color']) ? $_GET['color'] : ''; 
    $text = isset($_GET['text']) ? $_GET['text'] : '';
?>
  
    <div id="explore-list">
        <form id="search-form" class="clearfix">
           <div class="search-box">
               <input name="text" type="text" placeholder="Søg.." value="<?php echo $text ?>"/>
               <button class="button" type="submit">Søg..</button>
            </div>
        </form>
        <div id="filters" class="clearfix">
            <select class="form-control" name="sort">
                <option value="">Sorter efter..</option>
                <?php
                    $options = array("popular" => "Populære",
                                     "recent" => "Nyeste",
                                     "name" => "Navn");
                    render_options($options, $sort);
                ?>
            </select> 
            <select class="form-control" name="color">
                <option value="">Farve</option>
                <?php
                    $options = array("black" => "Sort",
                                     "blue" => "Blå",
                                     "gray" => "Grå",
                                     "green" => "Grøn",
                                     "multi" => "Multi",
                                     "orange" => "Orange",
                                     "purple" => "Lilla",
                                     "red" => "Rød",
                                     "white" => "Hvid",
                                     "yellow" => "Gul");
                    render_options($options, $color);
                ?>
            </select>
        </div>
        <div class="tablenav top clearfix">
            <div class="tablenav-pages">
                <span class="displaying-num"> kort</span>
                <span class="pagination-links">
                    <a class="first-page" title="Første side" href="#">«</a>
                    <a class="prev-page" title="Forrige side" href="#">‹</a>
                    <span class="paging-input">
                        <label for="current-page-selector" class="screen-reader-text">Vælg side</label>
                        <input class="current-page" id="current-page-selector" title="Current page" type="text" name="paged" value="1" size="1"> 
                        af 
                        <span class="total-pages">#</span>
                    </span>
                    <a class="next-page" title="Næste side" href="#">›</a>
                    <a class="last-page" title="Forrige side" href="#">»</a>
                </span>
            </div>              
        </div>

        <div class="results row">
        </div>
        <div class="search-error nothing" style="display:none;">
            <p>Ingen kort :(</p>
        </div>     

        <div class="tablenav bottom clearfix">
            <div class="tablenav-pages">
                <span class="displaying-num"> kort</span>
                <span class="pagination-links">
                    <a class="first-page" title="Første side" href="#">«</a>
                    <a class="prev-page" title="Forrige side" href="#">‹</a>
                    <span class="paging-input">
                        <label for="current-page-selector" class="screen-reader-text">Vælg side</label>
                        <input class="current-page" id="current-page-selector" title="Nuværende side" type="text" name="paged" value="1" size="1"> 
                        af 
                        <span class="total-pages">#</span>
                    </span>
                    <a class="next-page" title="Næste side" href="#">›</a>
                    <a class="last-page" title="Forrige side" href="#">»</a>
                </span>
            </div>
        </div>
    </div>
<?php } ?>
