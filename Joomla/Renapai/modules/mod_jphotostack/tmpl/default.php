<?php

/*------------------------------------------------------------------------
# J Photostack
# ------------------------------------------------------------------------
# author                Md. Shaon Bahadur
# copyright             Copyright (C) 2012 j-download.com. All Rights Reserved.
# @license -            http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites:             http://www.j-download.com
# Technical Support:    http://www.j-download.com/request-for-quotation.html
-------------------------------------------------------------------------*/

    defined('_JEXEC') or die('Restricted access');

    $name1              =       $params->get( 'name1', '' );
    $description1       =       $params->get( 'description1', '' );
    $thum1              =       $params->get( 'thum1', '' );

    $name2              =       $params->get( 'name2', '' );
    $description2       =       $params->get( 'description2', '' );
    $thum2              =       $params->get( 'thum2', '' );

    $name3              =       $params->get( 'name3', '' );
    $description3       =       $params->get( 'description3', '' );
    $thum3              =       $params->get( 'thum3', '' );

    $name4              =       $params->get( 'name4', '' );
    $description4       =       $params->get( 'description4', '' );
    $thum4              =       $params->get( 'thum4', '' );

    $name5              =       $params->get( 'name5', '' );
    $description5       =       $params->get( 'description5', '' );
    $thum5              =       $params->get( 'thum5', '' );

    $name6              =       $params->get( 'name6', '' );
    $description6       =       $params->get( 'description6', '' );
    $thum6              =       $params->get( 'thum6', '' );

    $name7              =       $params->get( 'name7', '' );
    $description7       =       $params->get( 'description7', '' );
    $thum7              =       $params->get( 'thum7', '' );

    $name8              =       $params->get( 'name8', '' );
    $description8       =       $params->get( 'description8', '' );
    $thum8              =       $params->get( 'thum8', '' );

    $name9              =       $params->get( 'name9', '' );
    $description9       =       $params->get( 'description9', '' );
    $thum9              =       $params->get( 'thum9', '' );

    $name10              =       $params->get( 'name10', '' );
    $description10       =       $params->get( 'description10', '' );
    $thum10              =       $params->get( 'thum10', '' );

?>
<html>
<head>
    <link rel="stylesheet" href="modules/mod_jphotostack/tmpl/css/style.css" type="text/css" media="screen" charset="utf-8" />
    <script src="modules/mod_jphotostack/tmpl/js/jquery.min.js"></script>
</head>
<body>
		<div id="ps_slider" class="ps_slider">
			<a class="prev disabled"></a>
			<a class="next disabled"></a>
			<div id="ps_albums">
                <?php if($name1 or $description1 or $thum1){ ?>
    				<div class="ps_album" style="opacity:0;">
                        <img src="<?php echo $thum1; ?>" alt=""/>
                        <div class="ps_desc">
                            <h2><?php echo $name1; ?></h2>
                            <span><?php echo $description1; ?></span>
                        </div>
                    </div>
                <?php } ?>
                <?php if($name2 or $description2 or $thum2){ ?>
    				<div class="ps_album" style="opacity:0;">
                        <img src="<?php echo $thum2; ?>" alt=""/>
                        <div class="ps_desc">
                            <h2><?php echo $name2; ?></h2>
                            <span><?php echo $description2; ?></span>
                        </div>
                    </div>
                <?php } ?>
                <?php if($name3 or $description3 or $thum3){ ?>
    				<div class="ps_album" style="opacity:0;">
                        <img src="<?php echo $thum3; ?>" alt=""/>
                        <div class="ps_desc">
                            <h2><?php echo $name3; ?></h2>
                            <span><?php echo $description3; ?></span>
                        </div>
                    </div>
                <?php } ?>
                <?php if($name4 or $description4 or $thum4){ ?>
    				<div class="ps_album" style="opacity:0;">
                        <img src="<?php echo $thum4; ?>" alt=""/>
                        <div class="ps_desc">
                            <h2><?php echo $name4; ?></h2>
                            <span><?php echo $description4; ?></span>
                        </div>
                    </div>
                <?php } ?>
                <?php if($name5 or $description5 or $thum5){ ?>
    				<div class="ps_album" style="opacity:0;">
                        <img src="<?php echo $thum5; ?>" alt=""/>
                        <div class="ps_desc">
                            <h2><?php echo $name5; ?></h2>
                            <span><?php echo $description5; ?></span>
                        </div>
                    </div>
                <?php } ?>
                <?php if($name6 or $description6 or $thum6){ ?>
    				<div class="ps_album" style="opacity:0;">
                        <img src="<?php echo $thum6; ?>" alt=""/>
                        <div class="ps_desc">
                            <h2><?php echo $name6; ?></h2>
                            <span><?php echo $description6; ?></span>
                        </div>
                    </div>
                <?php } ?>
                <?php if($name7 or $description7 or $thum7){ ?>
    				<div class="ps_album" style="opacity:0;">
                        <img src="<?php echo $thum7; ?>" alt=""/>
                        <div class="ps_desc">
                            <h2><?php echo $name7; ?></h2>
                            <span><?php echo $description7; ?></span>
                        </div>
                    </div>
                <?php } ?>
                <?php if($name8 or $description8 or $thum8){ ?>
    				<div class="ps_album" style="opacity:0;">
                        <img src="<?php echo $thum8; ?>" alt=""/>
                        <div class="ps_desc">
                            <h2><?php echo $name8; ?></h2>
                            <span><?php echo $description8; ?></span>
                        </div>
                    </div>
                <?php } ?>
                <?php if($name9 or $description9 or $thum9){ ?>
    				<div class="ps_album" style="opacity:0;">
                        <img src="<?php echo $thum9; ?>" alt=""/>
                        <div class="ps_desc">
                            <h2><?php echo $name9; ?></h2>
                            <span><?php echo $description9; ?></span>
                        </div>
                    </div>
                <?php } ?>
                <?php if($name10 or $description10 or $thum10){ ?>
    				<div class="ps_album" style="opacity:0;">
                        <img src="<?php echo $thum10; ?>" alt=""/>
                        <div class="ps_desc">
                            <h2><?php echo $name10; ?></h2>
                            <span><?php echo $description10; ?></span>
                        </div>
                    </div>
                <?php } ?>
			</div>
		</div>

		<div id="ps_overlay" class="ps_overlay" style="display:none;"></div>
		<a id="ps_close" class="ps_close" style="display:none;"></a>
		<div id="ps_container" class="ps_container" style="display:none;">
			<a id="ps_next_photo" class="ps_next_photo" style="display:none;"></a>
		</div>
		<script type="text/javascript">
            $(function() {
				/**
				* navR,navL are flags for controlling the albums navigation
				* first gives us the position of the album on the left
				* positions are the left positions for each of the 5 albums displayed at a time
				*/
                var navR,navL	= false;
				var first		= 1;
				var positions 	= {
					'0'		: 0,
					'1' 	: 170,
					'2' 	: 340,
					'3' 	: 510,
					'4' 	: 680
				}
				var $ps_albums 		= $('#ps_albums');
				/**
				* number of albums available
				*/
				var elems			= $ps_albums.children().length;
				var $ps_slider		= $('#ps_slider');

				/**
				* let's position all the albums on the right side of the window
				*/
				var hiddenRight 	= $(window).width() - $ps_albums.offset().left;
				$ps_albums.children('div').css('left',hiddenRight + 'px');

				/**
				* move the first 5 albums to the viewport
				*/
				$ps_albums.children('div:lt(5)').each(
					function(i){
						var $elem = $(this);
						$elem.animate({'left': positions[i] + 'px','opacity':1},800,function(){
							if(elems > 5)
								enableNavRight();
						});
					}
				);

				/**
				* next album
				*/
				$ps_slider.find('.next').bind('click',function(){
					if(!$ps_albums.children('div:nth-child('+parseInt(first+5)+')').length || !navR) return;
					disableNavRight();
					disableNavLeft();
					moveRight();
				});

				/**
				* we move the first album (the one on the left) to the left side of the window
				* the next 4 albums slide one position, and finally the next one in the list
				* slides in, to fill the space of the first one
				*/
				function moveRight () {
					var hiddenLeft 	= $ps_albums.offset().left + 163;

					var cnt = 0;
					$ps_albums.children('div:nth-child('+first+')').animate({'left': - hiddenLeft + 'px','opacity':0},500,function(){
							var $this = $(this);
							$ps_albums.children('div').slice(first,parseInt(first+4)).each(
								function(i){
									var $elem = $(this);
									$elem.animate({'left': positions[i] + 'px'},800,function(){
										++cnt;
										if(cnt == 4){
											$ps_albums.children('div:nth-child('+parseInt(first+5)+')').animate({'left': positions[cnt] + 'px','opacity':1},500,function(){
												//$this.hide();
												++first;
												if(parseInt(first + 4) < elems)
													enableNavRight();
												enableNavLeft();
											});
										}
									});
								}
							);
					});
				}

				/**
				* previous album
				*/
				$ps_slider.find('.prev').bind('click',function(){
					if(first==1  || !navL) return;
					disableNavRight();
					disableNavLeft();
					moveLeft();
				});

				/**
				* we move the last album (the one on the right) to the right side of the window
				* the previous 4 albums slide one position, and finally the previous one in the list
				* slides in, to fill the space of the last one
				*/
				function moveLeft () {
					var hiddenRight 	= $(window).width() - $ps_albums.offset().left;

					var cnt = 0;
					var last= first+4;
					$ps_albums.children('div:nth-child('+last+')').animate({'left': hiddenRight + 'px','opacity':0},500,function(){
							var $this = $(this);
							$ps_albums.children('div').slice(parseInt(last-5),parseInt(last-1)).each(
								function(i){
									var $elem = $(this);
									$elem.animate({'left': positions[i+1] + 'px'},800,function(){
										++cnt;
										if(cnt == 4){
											$ps_albums.children('div:nth-child('+parseInt(last-5)+')').animate({'left': positions[0] + 'px','opacity':1},500,function(){
												//$this.hide();
												--first;
												enableNavRight();
												if(first > 1)
													enableNavLeft();
											});
										}
									});
								}
							);
					});
				}

				/**
				* disable or enable albums navigation
				*/
				function disableNavRight () {
					navR = false;
					$ps_slider.find('.next').addClass('disabled');
				}
				function disableNavLeft () {
					navL = false;
					$ps_slider.find('.prev').addClass('disabled');
				}
				function enableNavRight () {
					navR = true;
					$ps_slider.find('.next').removeClass('disabled');
				}
				function enableNavLeft () {
					navL = true;
					$ps_slider.find('.prev').removeClass('disabled');
				}

				var $ps_container 	= $('#ps_container');
				var $ps_overlay 	= $('#ps_overlay');
				var $ps_close		= $('#ps_close');
				/**
				* when we click on an album,
				* we load with AJAX the list of pictures for that album.
				* we randomly rotate them except the last one, which is
				* the one the User sees first. We also resize and center each image.
				*/
				$ps_albums.children('div').bind('click',function(){
					var $elem = $(this);
					var album_name 	= 'album' + parseInt($elem.index() + 1);
					var $loading 	= $('<div />',{className:'loading'});
					$elem.append($loading);
					$ps_container.find('img').remove();

				   	$.get('index.php?option=com_jphotostack&format=raw', {album_name:album_name} , function(data) {
                        var items_count	= data.length;
						for(var i = 0; i < items_count; ++i){
							var item_source = ''+data[i];
							var cnt 		= 0;
							$('<img />').load(function(){
								var $image = $(this);
								++cnt;
								resizeCenterImage($image);
								$ps_container.append($image);
								var r		= Math.floor(Math.random()*41)-20;
								if(cnt < items_count){
									$image.css({
										'-moz-transform'	:'rotate('+r+'deg)',
										'-webkit-transform'	:'rotate('+r+'deg)',
										'transform'			:'rotate('+r+'deg)'
									});
								}
								if(cnt == items_count){
									$loading.remove();
									$ps_container.show();
									$ps_close.show();
									$ps_overlay.show();
								}
							}).attr('src',item_source);
						}
				   	},'json');
				});

				/**
				* when hovering each one of the images,
				* we show the button to navigate through them
				*/
				$ps_container.live('mouseenter',function(){
					$('#ps_next_photo').show();
				}).live('mouseleave',function(){
					$('#ps_next_photo').hide();
				});

				/**
				* navigate through the images:
				* the last one (the visible one) becomes the first one.
				* we also rotate 0 degrees the new visible picture
				*/
				$('#ps_next_photo').bind('click',function(){
					var $current 	= $ps_container.find('img:last');
					var r			= Math.floor(Math.random()*41)-20;

					var currentPositions = {
						marginLeft	: $current.css('margin-left'),
						marginTop	: $current.css('margin-top')
					}
					var $new_current = $current.prev();

					$current.animate({
						'marginLeft':'250px',
						'marginTop':'-385px'
					},250,function(){
						$(this).insertBefore($ps_container.find('img:first'))
							   .css({
									'-moz-transform'	:'rotate('+r+'deg)',
									'-webkit-transform'	:'rotate('+r+'deg)',
									'transform'			:'rotate('+r+'deg)'
								})
							   .animate({
									'marginLeft':currentPositions.marginLeft,
									'marginTop'	:currentPositions.marginTop
									},250,function(){
										$new_current.css({
											'-moz-transform'	:'rotate(0deg)',
											'-webkit-transform'	:'rotate(0deg)',
											'transform'			:'rotate(0deg)'
										});
							   });
					});
				});

				/**
				* close the images view, and go back to albums
				*/
				$('#ps_close').bind('click',function(){
					$ps_container.hide();
					$ps_close.hide();
					$ps_overlay.fadeOut(400);
				});

				/**
				* resize and center the images
				*/
				function resizeCenterImage($image){
					var theImage 	= new Image();
					theImage.src 	= $image.attr("src");
					var imgwidth 	= theImage.width;
					var imgheight 	= theImage.height;

					var containerwidth  = 460;
					var containerheight = 330;

					if(imgwidth	> containerwidth){
						var newwidth = containerwidth;
						var ratio = imgwidth / containerwidth;
						var newheight = imgheight / ratio;
						if(newheight > containerheight){
							var newnewheight = containerheight;
							var newratio = newheight/containerheight;
							var newnewwidth =newwidth/newratio;
							theImage.width = newnewwidth;
							theImage.height= newnewheight;
						}
						else{
							theImage.width = newwidth;
							theImage.height= newheight;
						}
					}
					else if(imgheight > containerheight){
						var newheight = containerheight;
						var ratio = imgheight / containerheight;
						var newwidth = imgwidth / ratio;
						if(newwidth > containerwidth){
							var newnewwidth = containerwidth;
							var newratio = newwidth/containerwidth;
							var newnewheight =newheight/newratio;
							theImage.height = newnewheight;
							theImage.width= newnewwidth;
						}
						else{
							theImage.width = newwidth;
							theImage.height= newheight;
						}
					}
					$image.css({
						'width'			:theImage.width,
						'height'		:theImage.height,
						'margin-top'	:-(theImage.height/2)-10+'px',
						'margin-left'	:-(theImage.width/2)-10+'px'
					});
				}
            });
        </script>
</body>
</html>