<?php
if(isset($error_message))
{
    echo $error_message;
}
?>
<form id="form1" action="<?php echo site_url("admin/article/upload/".(isset($article_id) ? $article_id : ''));?>" method="post" enctype="multipart/form-data">
    <div class="fieldset flash" id="fsUploadProgress">
    <span class="legend">Upload Queue</span>
    </div>
    <div id="divStatus">0 Files Uploaded</div>
    <div>
        <span id="spanButtonPlaceHolder" style="border:1px; border-color: #CCCCCC">Upload</span>
        <input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
    </div>
    <input type="hidden" name="article_id" id="page_id" value="<?php echo (isset($article_id) ? $article_id : ''); ?>"/>
</form>
<div class="loading_bar"></div>
<div id="files_list">
    
    
</div>
<script type="text/javascript">
            var swfu;

            window.onload = function() {
                    var settings = {
                            flash_url : "<?php echo site_url("swfupload/swfupload.swf"); ?>",
                            upload_url: "<?php echo site_url("admin/article/upload/".(isset($article_id) ? $article_id : ''));?>",
                            post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
                            file_size_limit : "100 MB",
                            file_types : "*.*",
                            file_types_description : "All Files",
                            file_upload_limit : 100,
                            file_queue_limit : 0,
                            custom_settings : {
                                    progressTarget : "fsUploadProgress",
                                    cancelButtonId : "btnCancel"
                            },
                            debug: false,

                            // Button settings
                            button_image_url: "images/TestImageNoText_65x29.png",
                            button_width: "65",
                            button_height: "29",
                            button_placeholder_id: "spanButtonPlaceHolder",
                            button_text: '<span class="theFont" style="padding:2px; border:2px; border-color:#cccccc;">Upload</span>',
                            button_text_style: ".theFont { font-size: 16; }",
                            button_text_left_padding: 12,
                            button_text_top_padding: 3,

                            // The event handler functions are defined in handlers.js
                            file_queued_handler : fileQueued,
                            file_queue_error_handler : fileQueueError,
                            file_dialog_complete_handler : fileDialogComplete,
                            upload_start_handler : uploadStart,
                            upload_progress_handler : uploadProgress,
                            upload_error_handler : uploadError,
                            upload_success_handler : uploadSuccess,
                            upload_complete_handler : uploadComplete,
                            queue_complete_handler : queueComplete	// Queue plugin event
                    };

                    swfu = new SWFUpload(settings);
            };
            function uploadComplete()
            {
                        var request = $.ajax({
                            url: '<?php echo site_url("admin/article/readdir/".$article_id);?>' ,
                            type: "POST",
                            data: "",
                            dataType: "json",
                            beforeSend:function()
                            {
                                $(".loading_bar").show();
                                $(".loading_bar").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/>");                                   
                            }
                        });

                        request.done(function(msg) 
                        {
                                if(msg.region_status = "success")
                                {
                                    $(".loading_bar").html("<font color='#339900'></font>&nbsp;").delay(5000).queue(function(n) {
                                        $(this).hide();
                                    });
                                    $("#files_list").html(msg.pic_data);

                                }
                        }
                        );

                        request.fail(function(jqXHR, textStatus) 
                        {
                            $(".loading_bar").html("<font color='#ff0000'>Error Happened</font>&nbsp;").delay(5000).queue
                                (
                                    function(n) 
                                    {
                                        $(this).hide();
                                    }
                                );                                                                           
                        });                        
                
            }
            function delete_pic(pic_name)
            {
                        var request = $.ajax({
                            url: '<?php echo site_url("admin/article/delete_pic/".$article_id);?>' ,
                            type: "POST",
                            data: "pic_name=" + pic_name,
                            dataType: "json",
                            beforeSend:function()
                            {
                                $(".loading_bar").show();
                                $(".loading_bar").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/>");                                   
                            }
                        });

                        request.done(function(msg) 
                        {
                                if(msg.region_status = "success")
                                {
                                    $(".loading_bar").html("<font color='#339900'></font>&nbsp;").delay(5000).queue(function(n) {
                                        $(this).hide();
                                    });
                                    uploadComplete();
                                }
                        }
                        );

                        request.fail(function(jqXHR, textStatus) 
                        {
                            $(".loading_bar").html("<font color='#ff0000'>Error Happened</font>&nbsp;").delay(5000).queue
                                (
                                    function(n) 
                                    {
                                        $(this).hide();
                                    }
                                );                                                                           
                        });                        
                
            }
            $(document).ready
            (
                function()
                {
                    uploadComplete();
                }
            );

    </script>

