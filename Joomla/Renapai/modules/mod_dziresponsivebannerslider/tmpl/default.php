<?php
/**
 * @package		DZIResponsiveBannerSlider
 * @subpackage	mod_dziresponsivebannerslider
 * @copyright	Copyright (C) 2005 - 2013 Devzoneindian. All rights reserved.
 * @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;
$baseurl = JURI::base();
$doc = JFactory::getDocument();
$doc->setMetaData('viewport', 'width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;', true);
?>

<link href="modules/mod_dziresponsivebannerslider/css/dziresponsivebannerslider.css" rel="stylesheet"  type="text/css" media="screen" />

<div id="bannerSlider <?php echo $moduleclass_sfx; ?>" class="loading">
    <?php if (count($banners) > 0) : ?>
        <div class="flexslider" <?php if ($slider_type == '3') : ?> id="slider" <?php endif; ?>>
            <ul class="slides">
                <?php foreach ($banners as $banner) :?>
                    <?php $img = json_decode($banner->params); ?>
                    <?php if ($img->imageurl) : ?>
                        <li <?php if ($slider_type == '2'): ?>data-thumb="<?php echo $img->imageurl; ?>" <?php endif; ?> >
                            <?php if($banner->clickurl && $onclick == 1) { ?>
							<a href="<?php echo $banner->clickurl; ?>" target="<?php echo $target; ?>"><img src="<?php echo $img->imageurl; ?>" alt="<?php $banner->name; ?>" /></a>
							<?php }else{ ?>
							<img src="<?php echo $img->imageurl; ?>" alt="<?php $banner->name; ?>" />
							<?php } ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php
    else :
        echo 'Please add banners under category :<b>' . $cat_title . '</b>';
    endif;
    ?>
    <?php
    // Slider with thumbnail slider
    if ($slider_type == '3') :
        ?>
        <div id="carousel" class="flexslider">
            <ul class="slides">
                <?php foreach ($banners as $banner) : ?>
        <?php $img = json_decode($banner->params); ?>
        <?php if ($img->imageurl) : ?>
                        <li>
                            <img src="<?php echo $img->imageurl; ?>" alt="<?php $banner->name; ?>" />
                        </li>
        <?php endif; ?>
        <?php endforeach; ?>
            </ul>	
        </div>	
<?php endif; ?>    
</div>

<!-- jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="modules/mod_dziresponsivebannerslider/js/jquery-1.7.min.js">\x3C/script>')</script>

<!-- FlexSlider -->
<script defer src="modules/mod_dziresponsivebannerslider/js/jquery.flexslider.js"></script>  
<script type="text/javascript">
    
    $(window).load(function(){
        // Basic Slider
        <?php if ($slider_type == '1') : ?>
        $('.flexslider').flexslider({            
            animation: "slide",
			controlNav: <?php echo isset($navigation)?$navigation:'false'; ?>,            
            start: function(slider){
                $('#bannerSlider').removeClass('loading');
            }
        });
        <?php endif; ?>
        // Slider with thumbnail control nav pattern
        <?php if ($slider_type == '2') : ?>
        $('.flexslider').flexslider({            
            animation: "slide",            
            controlNav: "thumbnails",
            start: function(slider){
                $('#bannerSlider').removeClass('loading');
            }
        });
        <?php endif; ?>
        // Slider with thumbnail slider
        <?php if ($slider_type == '3') : ?>
        $('#carousel').flexslider({
            animation: "slide",
            controlNav: <?php echo isset($navigation)?$navigation:'false'; ?>,
            animationLoop: false,
            slideshow: false,
            itemWidth: 210,
            itemMargin: 5,
            asNavFor: '#slider'
        });

        $('#slider').flexslider({
            animation: "slide",
            controlNav: <?php echo isset($navigation)?$navigation:'false'; ?>,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel",
            start: function(slider){
                $('#bannerSlider').removeClass('loading');
            }
        });
        <?php endif; ?>
        // Basic Carousel
        <?php if ($slider_type == '4') : ?>
        $('.flexslider').flexslider({            
            animation: "slide",
            animation: "slide",
            animationLoop: false,
            itemWidth: 210,
            itemMargin: 5,
            start: function(slider){
                $('#bannerSlider').removeClass('loading');
            }
        });
        <?php endif; ?>
        // Carousel with min and max ranges
        <?php if ($slider_type == '5') : ?>
        $('.flexslider').flexslider({
            // Basic Slider
            animation: "slide",  
            animationLoop: false,
            itemWidth: 210,
            itemMargin: 5,
            minItems: 2,
            maxItems: 3,
            start: function(slider){
                $('#bannerSlider').removeClass('loading');
            }
        });
        <?php endif; ?>
        // Carousel with dynamic min/max ranges
        <?php if ($slider_type == '6') : ?>
        $('.flexslider').flexslider({            
            animation: "slide",    
            animationLoop: false,
            itemWidth: 210,
            itemMargin: 5,
            minItems: getGridSize(), // use function to pull in initial value
            maxItems: getGridSize(), // use function to pull in initial value		
            start: function(slider){
                $('#bannerSlider').removeClass('loading');
            }
        });
        // store the slider in a local variable
        var $window = $(window), flexslider;
        // tiny helper function to add breakpoints
        function getGridSize() {
            return (window.innerWidth < 600) ? 2 :
                (window.innerWidth < 900) ? 3 : 4;
        }
        // check grid size on resize event
        $window.resize(function() {
            var gridSize = getGridSize();

            flexslider.vars.minItems = gridSize;
            flexslider.vars.maxItems = gridSize;
        });
        <?php endif; ?>

    });
</script>

<!-- Optional FlexSlider Additions -->
<script src="modules/mod_dziresponsivebannerslider/js/jquery.easing.js" type="text/javascript"></script>
<script src="modules/mod_dziresponsivebannerslider/js/jquery.mousewheel.js" type="text/javascript"></script>  