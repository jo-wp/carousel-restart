<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<h1>Settings Carousel Restart</h1>
<p>Development : Jordan Morand
    <br>
    Contact : <a href="mailto:jordan.morand@gmail.com">jordan.morand@gmail.com</a></p>
<h3>Custom</h3>
<?php
if(!get_option('')):
    add_option($k,$v);
endif;   
if($_POST){
foreach($_POST as $k=>$v){update_option($k,$v);}
}

$nameCarousel = get_option('carousel_restart_name');
    $typeCarousel = get_option('carousel_restart_type');
    $catCarousel = get_option('carousel_restart_slug_category');
    $nbActiveCarousel = get_option('carousel_restart_nbactiveitems');
    $titleCarousel = get_option('carousel_restart_title');
    $excerptCarousel = get_option('carousel_restart_excerpt');
    $imageCarousel = get_option('carousel_restart_image');
?>
<form action="admin.php?page=carousel-restart/views/view.php" method="post">
    <h4>Name Carousel </h4>
    <input type="text" name="carousel_restart_name" value="<?php echo $nameCarousel; ?>">
    <h4>Type : </h4>
    Post <input <?php if($typeCarousel=='post'):echo 'checked="checked"'; endif; ?> type="radio" name="carousel_restart_type" value="post"> or Pages <input <?php if($typeCarousel=='page'):echo 'checked="checked"'; endif; ?> type="radio" name="carousel_restart_type" value="page">
    <h4>Post Category :</h4>
    <?php 
    $args=array(
        'type'  =>'post'
    );
    $categories = get_categories($args);
    ?>
    <select name="carousel_restart_slug_category">
        <option>Select an category</option>
        <?php foreach($categories as $cat): ?>
            <option value="<?php echo $cat->slug ?>" <?php if($catCarousel==$cat->slug): echo 'selected="selected" '; endif;?>><?php echo $cat->name; ?></option>
        <?php endforeach; ?>
    </select>
    
    <h4>Number active items</h4>
    2 <input <?php if($nbActiveCarousel==2):echo 'checked="checked"'; endif; ?>  type="radio" name="carousel_restart_nbactiveitems" value="2">
    4 <input <?php if($nbActiveCarousel==4):echo 'checked="checked"'; endif; ?> type="radio" name="carousel_restart_nbactiveitems" value="4">
    6 <input <?php if($nbActiveCarousel==6):echo 'checked="checked"'; endif; ?> type="radio" name="carousel_restart_nbactiveitems" value="6">
    8 <input <?php if($nbActiveCarousel==8):echo 'checked="checked"'; endif; ?> type="radio" name="carousel_restart_nbactiveitems" value="8">
    10 <input <?php if($nbActiveCarousel==10):echo 'checked="checked"'; endif; ?> type="radio" name="carousel_restart_nbactiveitems" value="10">
    <h4>Show Title</h4>
    Yes <input type="radio" name="carousel_restart_title" value="1" <?php if($titleCarousel==1):echo 'checked="checked"'; endif; ?>>
    No <input type="radio" name="carousel_restart_title" value="0" <?php if($titleCarousel==0):echo 'checked="checked"'; endif; ?>>
    <h4>Show Excerpt</h4>
    Yes <input type="radio" name="carousel_restart_excerpt" value="1" <?php if($excerptCarousel==1):echo 'checked="checked"'; endif; ?>>
    No <input type="radio" name="carousel_restart_excerpt" value="0" <?php if($excerptCarousel==0):echo 'checked="checked"'; endif; ?>>
    <h4>Show Image Size </h4>
    None <input type="radio" name="carousel_restart_image" value="none" <?php if($imageCarousel=='none'):echo 'checked="checked"'; endif; ?>>
    Full <input type="radio" name="carousel_restart_image" value="full" <?php if($imageCarousel=='full'):echo 'checked="checked"'; endif; ?>>
    Large <input type="radio" name="carousel_restart_image" value="large" <?php if($imageCarousel=='large'):echo 'checked="checked"'; endif; ?>>
    Medium <input type="radio" name="carousel_restart_image" value="medium" <?php if($imageCarousel=='medium'):echo 'checked="checked"'; endif; ?>>
    Thumbnail <input type="radio" name="carousel_restart_image" value="thumbnail" <?php if($imageCarousel=='thumbnail'):echo 'checked="checked"'; endif; ?>>
    <p>
    <button class="btn btn-default" type="submit">Modify</button>
    </p>
</form>