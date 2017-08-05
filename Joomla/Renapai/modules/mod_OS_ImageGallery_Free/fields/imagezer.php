<?php
/**
 * @package OS_ImageGallery_Free
 * @subpackage  OS_ImageGallery_Free
 * @copyright Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Anton Panchenko(nix-legend@mail.ru); 
 * @Homepage: http://www.ordasoft.com
 * @version: 1.0 
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * */
// No direct access
defined('_JEXEC') or die;
jimport('joomla.filesystem.file');
class JFormFieldImagezer extends JFormField {
    protected $type = 'Imagezer';
    public $_name = 'Imagezer';
    protected function getLabel() {
        return '';
    }

    function fetchElement($name, $value, &$node, $control_name) {
        $id = JRequest::getInt('id', 0);
        if (!$id) {
            $cid = JRequest::getVar('cid', array(0));
            $id = $cid[0];
        }
        return $this->_build($id, 'params['.$name.']', $value);
    }

    protected function _build($moduleID, $name, $value) {
        /* @var JDocument $document */
        require_once dirname(__FILE__)."/../helpers/cleaner.php";
        $items =json_decode(base64_decode($value));
        checkFiles($items,$moduleID);
        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::root() . "modules/mod_OS_ImageGallery_Free/assets/css/jquery-ui-1.10.3.custom.min.css");
        $document->addStyleSheet(JURI::root() . "modules/mod_OS_ImageGallery_Free/assets/css/fileuploader.css");
        $document->addStyleSheet(JURI::root() . "modules/mod_OS_ImageGallery_Free/assets/css/admin_style.css");
        $document->addStyleSheet(JURI::root() . "modules/mod_OS_ImageGallery_Free/assets/css/basic.css");
        if(version_compare(JVERSION, "3.2.0",'lt')) {
            $document->addScript(JURI::root() . "modules/mod_OS_ImageGallery_Free/assets/js/jquery-1.7.1.min.js");
        }
        $document->addScript(JURI::root() . "modules/mod_OS_ImageGallery_Free/assets/js/base64.js");
        $document->addScript(JURI::root() . "modules/mod_OS_ImageGallery_Free/assets/js/fileuploader.js");
        $document->addScript(JURI::root() . "modules/mod_OS_ImageGallery_Free/assets/js/jquery-ui-1.10.3.custom.min.js");
        ?>

        <script type="text/javascript">
           if($('.controls').length){
            $(document).on('keydown','.controls input.number', function(e){
             var data=$(this).val();
             var KeyID = (window.event) ? event.keyCode : e.keyCode;
             //console.log(KeyID);
             if((KeyID<48||KeyID>57) && KeyID!=8 && KeyID!=46 && KeyID!=116 && KeyID!=37 && KeyID!=39 ){
              $(this).val(data);
              return false;
             }
            });
           }
        </script>
        <div id="file-area">
            <noscript>
                <p>JavaScript disabled :(</p>
            </noscript>
        </div>

        <section id="wrapper">
            <ul id="images"></ul>
            <input id="json_query" type="hidden" name="jform[params][imagezer]" value="<?php echo $value ?>" type="text" >
        </section>
        <input type="hidden" value="Clear all" class="clear_all_btn">
        <?php

        $document->addScript(JURI::root() . "modules/mod_OS_ImageGallery_Free/assets/fileuploader/fileuploader.min.js");
        $document->addStyleSheet(JURI::root() . "modules/mod_OS_ImageGallery_Free/assets/fileuploader/fileuploader.css");

        // Remove temp files
        $items = json_decode(base64_decode($value));

        $html = '
			<div id="btss-message" class="clearfix"></div>
			<div id="btss-file-uploader">		
                <noscript>
					<p>' . JText::_('mod_OS_ImageGallery_Free_NOTICE_JAVASCRIPT') . '</p>
				</noscript>         
			</div>
			<ul id="btss-gallery-container" class="clearfix"></ul>
			';
        ?>
        <div id="dialog-form" title="Image options" style="display:none;">
           <fieldset>
                    <label for="name">Image name</label>
                    <input type="text" name="name" id="name" value="" class="text ui-widget-content ui-corner-all" />

                    <label for="description">Image alt</label>
                    <input type="text" name="description" id="description" value="" class="text ui-widget-content ui-corner-all" />
                    <input type="hidden" class="where" value="">
           </fieldset>
        </div>
        <script language="JavaScript">
            (function($) {

                var uploader = new qq.FileUploader({
                    element: document.getElementById('file-area'),
                    action: '<?php echo JURI::root() . "modules/mod_OS_ImageGallery_Free/file_uploader/uploader.php"; ?>',
                    params: {
                        id: '<?php echo $moduleID; ?>'
                    },
                    sizeLimit: 10 * 1024 * 1024,
                    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                    debug: false,
                    template:
                        '<div class="qq-uploader">' +
                            '<div class="qq-upload-drop-area"><p>drag and drop images here</p><span class="btnButton">Select images</span></div>' +
                            '<div class="qq-upload-button"><p>drag and drop images here</p><span class="pseudo_button">Select images</span></div>' +
                            '<ul class="qq-upload-list"></ul>' +
                            '</div><div style="display:none;" id="my_popup"><p>Popup content</p></div>',
                    onComplete: function (id, filename, responseJSON) {
                        //console.log(filename);
                        if (!responseJSON.success) {
                            //console.log(filename + ' - ' + responseJSON.message);
                        }
                        else {
                            if($("input#json_query").val() != "")
                            var $images = JSON.parse(Base64.decode($("input#json_query").val()));
                            if ($("input#json_query").val() != "") {
                                $images.push({'file':responseJSON.file,'alt':'', 'name':''});
                                $("#json_query").val(Base64.encode(JSON.stringify($images)));
                                refresh_data(append_button);
                            } else {
                                $images = new Array();
                                $images.push({'file':responseJSON.file,'alt':'', 'name':''});
                                $("#json_query").val(Base64.encode(JSON.stringify($images)));
                                refresh_data(append_button);
                            }
                        }
                    }
                });

                $(".qq-upload-button span, .qq-upload-button input").wrapAll("<div class='btnButton'></div>");

                function refresh_data(func){
                    setTimeout(function() {
                        var image_set = JSON.parse(Base64.decode($("input#json_query").val()));
                        var image_mass = new Array();
                        $.each(image_set, function(key,img){
                            image_mass.push("<li><img src=\"<?php echo JURI::root().'images/os_imagegallery_'.$moduleID.'/manager/'; ?>"+img.file+"\" alt=\""+img.alt+"\" name=\""+img.name+"\"><a item=\""+img.file+"\" class=\"rem_item\"></a><a name=\""+((typeof img.name == "undefined")? "":img.name )+"\" description=\""+((typeof img.alt == "undefined")? "":img.alt  )+"\" item=\""+img.file+"\" class=\"edit_item popup\"></a></li>");
                        });
                        $("ul#images").html(image_mass.join(""));
                        func();
                        },1000);
                }
                refresh_data(append_button);
                $("#images").sortable({
                    start : function(event, ui) {
                        ui.item.addClass('active');
                    },
                    stop : function(event, ui) {
                        ui.item.removeClass('active').effect("highlight", { color: '#000' }, 0, function() {
                            var mass = new Array();
                            $.each($('#images li img'), function(index, event) {
                                $(this).attr('ordering',parseInt(index, 10));
                                var filename = $(this).attr("src").split('/').pop();
                                mass.push({file:filename, alt:$(this).attr('alt'), name:$(this).attr("name")});
                            });
                            $("#json_query").val(Base64.encode(JSON.stringify(mass)));
                      //  window.location.hash = Base64.encode(JSON.stringify(mass));
                        });
                    }
                });
                $("#images").disableSelection();

                function append_button() {
                    $(".clear_all_btn").click(function(){
                        var $images = new Array();
                        $("#json_query").val(Base64.encode(JSON.stringify($images)));
                        $("ul#images li").fadeOut(1000, function() { $(this).remove();});
                    });

                    $(".rem_item").click(function(){
                        var file = $(this).attr("item");
                        var images = JSON.parse(Base64.decode(jQuery("input#json_query").val()));

                     //   console.log(images);
                        var $rem = $(this).parent();
                        if(images.length > 0){
                            $.each(images, function(k,img){
                                if(img.file == file) {
                                    $($rem).fadeOut(400, function() { $(this).remove();});

                                    images.splice(k,1);
                                    return false; //stop each
                                }
                            });

                            //console.log(images);
                        $("#json_query").val(Base64.encode(JSON.stringify(images)));
                        }
                    });
                    $( "#dialog-form" ).dialog({
                        autoOpen: false,
                        height: 245,
                        width: 560,
                        modal: true,
                        buttons: {
                            "Save": function() {
                                var where = $(this).find(".where").val();
                                var $image_set = JSON.parse(Base64.decode($("input#json_query").val()));
                                var tmp_this = this;
                                $.each($image_set, function(k,item) {
                                    if(item.file == where ) {
                                        $image_set[k].name= $(tmp_this).find("#name").val();
                                        $image_set[k].alt= $(tmp_this).find("#description").val();
                                        return false;
                                    }
                                });
                                $("a.edit_item[item='"+ $(this).find(".where").val() + "']").attr('name', $(this).find("#name").val());
                                $("a.edit_item[item='"+ $(this).find(".where").val() + "']").attr('description', $(this).find("#description").val());
                                $("input#json_query").val(Base64.encode(JSON.stringify($image_set)));
                                $(this).find(".where").val();
                                $(this).dialog("close");
                                $(this).css("height","1px");
                            }
                        },
                        close: function() {
                        }
                    });
                    $("a.popup").click(function(){
                        $("div#dialog-form input#name").val($(this).attr('name'));
                        $("div#dialog-form input#description").val($(this).attr('description'));
                        $("div#dialog-form input.where").val($(this).attr('item'));
                        $("#dialog-form").css("height","100%");
                        $("#dialog-form").dialog( "open");
                    });
                }

                $(function(){
                    var maxLen = 20;
                    var obj = $('.slideoptions');
                    obj.bind('keyup', function() {
                        this.value = this.value.replace(/[A-Za-z\W]/, '');
                    });
                    obj.bind('keydown', function() {
                        this.value = this.value.replace(/[A-Za-z\W]/, '');
                    });
                });

                $.widget("ui.tooltip", $.ui.tooltip, {
                    options: {
                          content: function () {
                            return $(this).prop('title');
                        }
                    }
                  });
                $(document).tooltip();

            })(jQuery);
        </script>
        <?php
        return $html;
    }

    protected function getInput() {
        JHtml::_('behavior.framework', true);
        JHtml::_('behavior.modal');

        $moduleID = $this->form->getValue('id');
        return $this->_build($moduleID, $this->name, $this->value);
    }
}