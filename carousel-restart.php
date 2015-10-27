<?php
/*
Plugin Name: Carousel Restart
Description: A Simple Carousel click on icon next for the next item "posts [categorie(s) or all] or pages [all]" and back to start after click on previous arrow !
Author: Jordan Morand
Version: 1.0
*/

function carousel_restart(){
    add_menu_page('Carousel Restart', 'Carousel/Restart', 'edit_posts', 'carousel-restart/views/view.php','','dashicons-exerpt-view',99);
}
add_action('admin_menu','carousel_restart');

function plugin_carousel() {
    //GET ALL OPTIONS FOR CAROUSEL 
    $nameCarousel = get_option('carousel_restart_name');
    $typeCarousel = get_option('carousel_restart_type');
    $catCarousel = get_option('carousel_restart_slug_category');
    $nbActiveCarousel = get_option('carousel_restart_nbactiveitems');
    $titleCarousel = get_option('carousel_restart_title');
    $excerptCarousel = get_option('carousel_restart_excerpt');
    $imageCarousel = get_option('carousel_restart_image');

if($typeCarousel=='post'):
$argsPost = array(
    'posts_per_page' => 100,
	'post_type' => $typeCarousel,
	'post_status' => 'publish',
        'category_name' => $catCarousel,
	
);
$items = get_posts($argsPost);
elseif($typeCarousel=='page'):
    $argsPage = array(
        'posts_per_page' => 100,
        'post_type' => $typeCarousel,
        'post_status' => 'publish',
        
);
$items = get_pages($argsPage);
endif;

// IMAGE PREV & NEXT ICON
$iconNext =  plugins_url( 'img/Next-icon.png', __FILE__ ).'';
$iconPrev =  plugins_url( 'img/Previous-icon.png', __FILE__ ).'';

// TITLE + NAVIGATION WITH BOOTSTRAP !
$data = '
<div style="clear: both;"></div>
<div class="carousel-restart">
<div class=" title"><h2 class="shortcode_title">'.$nameCarousel.'</h2></div>
<div class=" navigation">
<a href="#" class="next-agenda"><img src="'.$iconNext.'" alt="icon-next" class="img-responsive"></a>
<a href="#" class="prev-agenda"><img src="'.$iconPrev.'" alt="icon-next" class="img-responsive"></a>
</div>'; 
$data .= '<ul class="items-carousel-restart">';

//EACH POST OR PAGE 
foreach($items as $item): setup_postdata($item);

//URL IMG THUMBNAIL
$src = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), $imageCarousel );
$urlImage = $src[0];

//ADD STYLE SIZE FOR ACTIVE ITEMS
if($nbActiveCarousel==2):
    $col = 'icr-col-2';
elseif($nbActiveCarousel==4):
    $col = 'icr-col-4';
elseif($nbActiveCarousel==6):
    $col = 'icr-col-6';
elseif($nbActiveCarousel==8):
    $col = 'icr-col-8';
elseif($nbActiveCarousel==10):
    $col = 'icr-col-10';
endif;

//VAR THE EXCERPT
$excerpt = get_the_excerpt();

//SETTING-UP ITEM 
	$data .= '<li class="'.$col.'  item-carousel-restart">'; 
	$data .= '<a href="'.$item->guid.'">';
	if($imageCarousel=='none'): else: $data .= '<img src="'.$urlImage.'" alt="image-featured" class="img-responsive">'; endif;
	if($titleCarousel): $data .= '<h4>'.$item->post_title.'</h4>'; endif;
	if($excerptCarousel): $data .= '<p>'.$excerpt.'</p>'; endif; 
	$data .= '</a>';
	$data .= '</li>';
        
endforeach;
$data .= '</ul>';
$data .='</div>';

return $data;
}
add_shortcode( 'carousel-restart', 'plugin_carousel' );


add_action( 'wp_enqueue_scripts', 'stylesheet_carousel_restart' );
function stylesheet_carousel_restart() {
    wp_register_style( 'style-carousel-restart', plugins_url('style-carousel-restart.css', __FILE__) );
    wp_enqueue_style( 'style-carousel-restart' );
}

function carousel_restart_load_footer(){
    $nbActiveCarousel = get_option('carousel_restart_nbactiveitems');
?>
<script type="text/javascript">
$=jQuery.noConflict();  
$(function () {
    var $this = $('.item-carousel-restart');
    var total = $('.items-carousel-restart li').length;
    //ADD class id + $i for $nbActiveCarousel
    $this.each(function (i) {
        $(this).addClass('id-' + (i + 1));
        //Show just the 2 first 
        <?php if($nbActiveCarousel==2): ?>
        if ($(this).hasClass('id-1') || $(this).hasClass('id-2')) {
            $(this).addClass('show');
        }
        //Show just the 4 first 
        <?php elseif($nbActiveCarousel==4): ?>
        if ($(this).hasClass('id-1') || $(this).hasClass('id-2') || $(this).hasClass('id-3') || $(this).hasClass('id-4')) {
            $(this).addClass('show');
        }  
        //Show just the 6 first 
        <?php elseif($nbActiveCarousel==6): ?>
        if ($(this).hasClass('id-1') || $(this).hasClass('id-2') || $(this).hasClass('id-3') || $(this).hasClass('id-4') || $(this).hasClass('id-5') || $(this).hasClass('id-6')) {
            $(this).addClass('show');
        } 
        //Show just the 8 first 
        <?php elseif($nbActiveCarousel==8): ?>
        if ($(this).hasClass('id-1') || $(this).hasClass('id-2') || $(this).hasClass('id-3') || $(this).hasClass('id-4') || $(this).hasClass('id-5') || $(this).hasClass('id-6') || $(this).hasClass('id-7') || $(this).hasClass('id-8')) {
            $(this).addClass('show');
        }
        //Show just the 10 first 
        <?php elseif($nbActiveCarousel==10): ?>
        if ($(this).hasClass('id-1') || $(this).hasClass('id-2') || $(this).hasClass('id-3') || $(this).hasClass('id-4') || $(this).hasClass('id-5') || $(this).hasClass('id-6') || $(this).hasClass('id-7') || $(this).hasClass('id-8') || $(this).hasClass('id-9') || $(this).hasClass('id-10')) {
            $(this).addClass('show');
        }
        <?php else: ?>
        <?php endif; ?>
        else {
            $(this).addClass('hidden');
        }
        //ADD CLASS last AT LAST ITEM OF LIST
        if (i === total - 1) {
               $(this).addClass('last');
            }
    });
    //Click next
    $('.next-agenda').on('click', function (event) {
        event.preventDefault();
        $this.each(function (i) {
            if ($(this).hasClass('show')) {
                $(this).nextAll().slice(1, <?php echo $nbActiveCarousel ;?>).addClass('show');
                $(this).nextAll().slice(1, <?php echo $nbActiveCarousel ;?>).removeClass('hidden');
                $(this).addClass('hidden');
                $(this).removeClass('show');
                return false;
            }
        });
        if ($('.last').hasClass('last') && $('.last').hasClass('show')){
            $('.next-agenda img').css('display', 'none');
        }
    });

    //Click prev
    $('.prev-agenda').on('click', function (event) {
        event.preventDefault();
        
        $this.each(function (i) {
            <?php if($nbActiveCarousel==2): ?>
            if ($(this).hasClass('id-1') || $(this).hasClass('id-2')) {
                $(this).addClass('show');
                $(this).removeClass('hidden');
            }
            <?php elseif($nbActiveCarousel==4): ?>
            if ($(this).hasClass('id-1') || $(this).hasClass('id-2') || $(this).hasClass('id-3') || $(this).hasClass('id-4')) {
                $(this).addClass('show');
                $(this).removeClass('hidden');
            }
            <?php elseif($nbActiveCarousel==6): ?>
            if ($(this).hasClass('id-1') || $(this).hasClass('id-2') || $(this).hasClass('id-3') || $(this).hasClass('id-4') || $(this).hasClass('id-5') || $(this).hasClass('id-6')) {
                $(this).addClass('show');
                $(this).removeClass('hidden');
            }
            <?php elseif($nbActiveCarousel==8): ?>
            if ($(this).hasClass('id-1') || $(this).hasClass('id-2') || $(this).hasClass('id-3') || $(this).hasClass('id-4') || $(this).hasClass('id-5') || $(this).hasClass('id-6') || $(this).hasClass('id-7') || $(this).hasClass('id-8')) {
                $(this).addClass('show');
                $(this).removeClass('hidden');
            }
            <?php elseif($nbActiveCarousel==10): ?>
            if ($(this).hasClass('id-1') || $(this).hasClass('id-2') || $(this).hasClass('id-3') || $(this).hasClass('id-4') || $(this).hasClass('id-5') || $(this).hasClass('id-6') || $(this).hasClass('id-7') || $(this).hasClass('id-8') || $(this).hasClass('id-9') || $(this).hasClass('id-10')) {
                $(this).addClass('show');
                $(this).removeClass('hidden');
            }
            <?php endif; ?>
            else {
                $(this).addClass('hidden');
                $(this).removeClass('show');
            }
            
        });
        
        if ($('.last').hasClass('last') && $('.last').hasClass('hidden')) {
            $('.next-agenda img').css('display', 'block');
        }
    });
});
</script>
<?php
}
add_action('wp_footer', 'carousel_restart_load_footer');
