<div id="data">
    <h1>Site Setting</h1>
    <div id="site_setting" class="width1100">
        <form action="<?php echo site_url("admin/site_setting/update_settings");?>" method="post" id="form_site_settings">
        <div id="loading_bar_insert"></div>
        <div class="warning_message"><?php echo $warning_message;?></div>
                <div class="form_label">
                    <label for="site_title">Title</label>
                </div>
                <div class="form_input width800">
                    <div class="input_text width250 float_left">
                        <input type="text" name="site_title" id="site_title" class="width250" value='<?php echo set_value('site_title') ? set_value('site_title') : $site_title;?>'/>
                    </div>
                    <span class="error_message" id="site_title_error"><?php echo $site_title_error;?></span>
<!--                    <br/>-->
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="site_title">Slogan</label>
                </div>
                <div class="form_input width800">
                    <div class="input_text width250 float_left">
                        <input type="text" name="site_slogan" id="site_slogan" class="width250" value='<?php echo set_value('site_slogan') ? set_value('site_slogan') : $site_slogan;?>'/>
                    </div>
                    <span class="error_message" id="site_slogan_error"><?php echo $site_slogan_error;?></span>
<!--                    <br/>-->
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="site_meta_description">Meta Description</label>
                </div>
                <div class="form_input width800">
                    <div class="input_text width250 float_left">
                        <input type="text" name="site_meta_description" id="site_meta_description" class="width250" value='<?php echo $site_meta_description;?>'/>
                    </div>
                    <span class="error_message" id="site_meta_description_error"><?php echo $site_meta_description_error;?></span>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="site_meta_keyword">Meta Keyword</label>
                </div>
                <div class="form_input width800">
                    <div class="input_text width250 float_left">
                        <input type="text" name="site_meta_keyword" id="site_meta_keyword" class="width250" value='<?php echo $site_meta_keyword;?>'/>
                    </div>
                    <span class="error_message" id="site_meta_keyword_error"><?php echo $site_meta_keyword_error;?></span>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="site_admin_email">Admin Email</label>
                </div>
                <div class="form_input width800">
                    <div class="input_text width250 float_left">
                        <input type="text" name="site_admin_email" id="site_admin_email" class="width250" value='<?php echo $site_admin_email;?>'/>
                    </div>
                    <span class="error_message" id="site_admin_email_error"><?php echo $site_admin_email_error;?></span>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="site_date_format">Date Format</label>
                </div>
                <div class="form_input width800">
                    <div class="input_text width250 float_left">
                        <input type="text" name="site_date_format" id="site_date_format" class="width250" value='<?php echo $site_date_format;?>'/>
                    </div>
                    <span class="error_message" id="site_date_format_error"><?php echo $site_date_format_error;?></span>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="site_date_format">Require Activation?</label>
                </div>
                <div class="form_input width800">
                    <div class="input_text width250 float_left">
                        <input type="radio" name="site_require_activation" value="1" <?php echo $site_require_activation == 1 ? " checked " : ''; ?>/>Yes
                        <input type="radio" name="site_require_activation" value="0" <?php echo $site_require_activation == 0 ? " checked " : ''; ?>/>No
                    </div>
                    <span class="error_message" id="site_require_activation_error"></span>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    &nbsp;
                </div>
                <div class="form_input middle right  width800">
                    <button type="submit" class="button_proccess" id="add_article_button">Update</button>
                </div>
                </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready
    (
        function()
        {
            $("#form_site_settings").validate
            ( 
                {
                    rules: 
                    {
                        site_title: 
                        {
                            required: true,
                            minlength: 2
                        },
                        site_meta_description: 
                        {
                            required: true,
                            minlength: 2
                        },
                        site_meta_keyword: 
                        {
                            required: true,
                            minlength: 2
                        },
                        site_admin_email: 
                        {
                            required: true,
                            minlength: 2
                        },
                        site_date_format: 
                        {
                            required: true,
                            minlength: 2
                        }
                    },
                    messages: 
                    {
                        site_title: 
                        {
                            required: "Title Required",
                            minlength: "Title Required"
                        },
                        site_meta_description: 
                        {
                            required: "Meta Description Required",
                            minlength: "Meta Description Required"
                        },
                        site_meta_keyword: 
                        {
                            required: "Meta Keyword Required",
                            minlength: "Meta Keyword Required"
                        },
                        site_admin_email: 
                        {
                            required: "Admin Email Required",
                            minlength: "Admin Email Required"
                        },
                        site_date_format: 
                        {
                            required: "Date Format Required",
                            minlength: "Date Format Required"
                        }
                    },
                // the errorPlacement has to take the table layout into account
                errorPlacement: function(error, element) 
                {
//                    $("#site_title_error").html("");
//                    $("#site_meta_description_error").html("");
//                    $("#site_meta_keyword_error").html("");
//                    $("#site_admin_email_error").html("");
//                    $("#site_date_format_error").html("");
                    error.prependTo( element.parent("div").next("span") );
                },
                // specifying a submitHandler prevents the default submit, good for the demo
                submitHandler: function() 
                {
                    $("#form_site_settings").submit();
                },
                // set this class to error-labels to indicate valid fields
                success: function(label) {
                // set &nbsp; as text for IE
                label.html("&nbsp;").addClass("checked");
                }
                });
	
        
//            $("#site_title").change(
//                function()
//                {
//                    if($("#site_title").val().length == 0)
//                    {
//                        $("#site_title_error").html("Title is Required");
//
//                    }
//                }
//            )
//                
//            $("#site_meta_keyword").change(
//                function()
//                {
//                    if($("#site_meta_keyword").val().length == 0)
//                    {
//                        $("#site_meta_keyword_error").html("Meta Keyword is Required");
//
//                    }
//                }
//            )
//            $("#site_meta_description").change(
//                function()
//                {
//                    if($("#site_meta_description").val().length == 0)
//                    {
//                        $("#site_meta_description_error").html("Meta Description is Required");
//
//                    }
//                }
//            )
//            $("#site_admin_email").change(
//                function()
//                {
//                    if($("#site_admin_email").val().length == 0)
//                    {
//                        $("#site_admin_email_error").html("Admin Email is Required");
//
//                    }
//                }
//            )
//            $("#site_date_format").change(
//                function()
//                {
//                    if($("#site_date_format").val().length == 0)
//                    {
//                        $("#site_date_format_error").html("Admin Email is Required");
//
//                    }
//                }
//            )

                
        }
    );
</script>
