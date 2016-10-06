<?php
?>
<div class="width962 center">
    <h1 class="form_title text_align_left">User Setting</h1>
    <div class="form_open_profile"></div>
    <div class="float_left width468 center">
        <h2 class="form_title font18 text_align_left">Account Data</h2>
        <div class="error_message">
            <?php echo @$validation_errors;?>
            <?php if($this->session->flashdata('upload_error')) { echo $this->session->flashdata('upload_error');} ?>
        </div>
        <div class="warning_message"><?php if($this->session->flashdata('update_success')) { echo $this->session->flashdata('update_success');} ?></div>
        <form action="<?php echo site_url("home/log/edit_user");?>" id="form_register_member" method="post" enctype="multipart/form-data">
            <div class="form_label">
                <label for="user_name">Profile Picture</label>
            </div>
            <div class="form_input">
                <?php if($thumb_url != NULL): ?>
                    <img src="<?php echo $thumb_url; ?>" id="picture_upload" width="92" style="margin-left: 167px; width: 92px;"/>
                <?php else: ?>
                    <img src="<?php echo site_url('upload/users/no-picture.jpg'); ?>" id="picture_upload" width="92" style="margin-left: 167px; width: 92px;"/>
                <?php endif; ?>
				<div  style="margin-left: 250px;">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
                        <span class="ui-button-icon-primary ui-icon ui-icon-plusthick"></span>
                        <span class="ui-button-text">
                        <i class="icon-plus icon-white"></i>
                        <span>Browse Picture</span>
                        </span>
                        <input type="file" multiple="" name="files"  onchange="readURL(this);">
                        </span>
                    <div class="span5 fileupload-progress fade">
                    </div>
				</div>
            </div>
            <div class="clear"></div>
			<p>&nbsp;</p>
			<script type="text/javascript">
			function readURL(input) 
			{
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#picture_upload').attr('src', e.target.result);
					}

					reader.readAsDataURL(input.files[0]);
				}
			}			
			</script>
            <div class="form_label">
                <label for="user_name">User Name</label>
            </div>
            <div class="form_input" style="height:80px;">
                <div class="input_text">
                    <input type="text" name="user_name" id="user_name" class="width250" value="<?php echo set_value('user_name') ? set_value('user_name') : $username;?>"/>
                </div>
                <span class="error_message" id="user_name_error"><label for="user_name" generated="true" class="error checked"><?php echo form_error('user_name'); ?></label></span>
            </div>
            <div class="clear"></div>
            <div class="form_label">
                <label for="user_name">First Name</label>
            </div>
            <div class="form_input" style="height:80px;">
                <div class="input_text">
                    <input type="text" name="first_name" id="first_name" class="width250" value="<?php echo set_value('first_name') ? set_value('first_name') : $first_name;?>"/>
                </div>
                <span class="error_message" id="first_name_error"><label for="first_name" generated="true" class="error checked"><?php echo form_error('first_name'); ?></label></span>
            </div>
            <div class="clear"></div>
            <div class="form_label">
                <label for="user_name">Last Name</label>
            </div>
            <div class="form_input" style="height:80px;">
                <div class="input_text">
                    <input type="text" name="last_name" id='last_name' class="width250" value="<?php echo set_value('last_name') ? set_value('last_name') : $last_name;?>"/>
                </div>
                <span class="error_message" id="last_name_error"><label for="last_name" generated="true" class="error checked"><?php echo form_error('last_name'); ?></label></span>
            </div>
            <div class="clear"></div>
            <div class="form_label">
                <label for="user_name">Email</label>
            </div>
            <div class="form_input" style="height:80px;">
                <div class="input_text">
                    <input type="text" name="email" id="email" class="width250" value="<?php echo set_value('email') ? set_value('email') : $email;?>"/>
                </div>
                <span class="error_message" id="email_error"><label for="email" generated="true" class="error checked"><?php echo form_error('email'); ?></label></span>
            </div>
            <div class="clear"></div>
            <div class="form_label">
                <label for="user_name" size="200">Password</label>
            </div>
            <div class="form_input" style="height:80px;">
                <div class="input_text">
                    <input type="password" name="password" id="password" class="width250"/>
                </div>
                <span class="error_message" id="password_error"><label for="password" generated="true" class="error checked"><?php echo form_error('password'); ?></label></span>
            </div>
            <div class="clear"></div>
            <div class="form_label">
                <label for="user_name" size="200">Retype Password</label>
            </div>
            <div class="form_input" style="height:80px;">
                <div class="input_text">
                    <input type="password" name="retype_password" id="retype_password" class="width250"/>
                </div>
                <span class="error_message" id="retype_password_error"><?php echo form_error('retype_password'); ?></span>
            </div>
            <div class="clear"></div>
    </div>
    <div class="float_left width468 center font9">
            <h2 class="form_title font18 text_align_left">Undergraduate Information</h2>
            <div class="form_label">
                <label for="user_name">Bachelors Degree</label>
            </div>
            <div class="form_input" style="height:80px;">
                <div class="input_text">
                    <input type="text" name="bachelor_degree" id="bachelor_degree" class="width250" value="<?php echo set_value('bachelor_degree') ? set_value('bachelor_degree') : $bachelor_degree;?>"/>
                </div>
                <span class="error_message" id="bachelor_degree_error" ><?php echo form_error('bachelor_degree'); ?></span>
            </div>
            <div class="clear"></div>
            <div class="form_label">
                <label for="user_name">University Attended</label>
            </div>
            <div class="form_input" style="height:80px;">
                <div class="input_text">
                    <input type="text" name="university_bachelor" id="university_bachelor" class="width250" value="<?php echo set_value('university_bachelor') ? set_value('university_bachelor') : $university_bachelor;?>"/>
                </div>
                <span class="error_message" id="university_bachelor_error"><?php echo form_error('university_bachelor'); ?></span>
            </div>
            <div class="clear"></div>
        <h2 class="form_title font18 text_align_left">Post Graduate Information</h2>
            <div class="form_label">
                <label for="user_name">Masters Degree</label>
            </div>
            <div class="form_input" style="height:80px;">
                <div class="input_text">
                    <input type="text" name="master_degree" id="master_degree" class="width250"  value="<?php echo set_value('master_degree') ? set_value('master_degree') : $master_degree;?>"/>
                </div>
                <span class="error_message" id="master_degree_error"><?php echo form_error('master_degree'); ?></span>
            </div>
            <div class="clear"></div>
            <div class="form_label">
                <label for="user_name">University Attended</label>
            </div>
            <div class="form_input" style="height:80px;">
                <div class="input_text">
                    <input type="text" name="university_master" id="university_master" class="width250" value="<?php echo $university_master;?>"/>
                </div>
                <span class="error_message" id="university_master_error"><?php echo form_error('university_master'); ?></span>
            </div>
            <div class="clear"></div>
            <div class="form_label">
                &nbsp;
            </div>
            <div class="form_input middle right">
                <button type="submit" class="button_loggin font18 text_align_left">&nbsp;&nbsp;&nbsp;Save</button>
            </div>
            <div class="clear"></div>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            </form>
    </div>
    <div class="clear"></div>
</div>
<script type="text/javascript">
    $(document).ready
    (
        function()
        {
/*            jQuery.validator.addMethod("noSpace", function(value, element) { 
                return value.indexOf(" ") < 0 && value != ""; 
            }, "No space please and don't leave it empty");
*/
            $("#form_register_member").validate
            ( 
                {
                    rules: 
                    {
                        user_name: 
                        {
                            required: true,
                            minlength: 6,
                            noSpace : true
                        },
                        first_name: 
                        {
                            required: true,
                            minlength: 2
                        },
                        last_name: 
                        {
                            required: true,
                            minlength: 2
                        },
                        email: 
                        {
                            required: true,
                            email:true
                        },
                        password: 
                        {
                            required: true,
                            minlength: 6
                        },
                        retype_password: 
                        {
                            required: true,
                            minlength: 6,
                            equalTo: password
                        }
                    },
                    messages: 
                    {
                        user_name: 
                        {
                            required: "User Name Required",
                            minlength: "User Name minimum 6 character",
                            noSpace : "No Space in Username"
                        },
                        first_name: 
                        {
                            required: "First Name Required",
                            minlength: "First Name minimum 2 character"
                        },
                        last_name: 
                        {
                            required: "Last Name Required",
                            minlength: "Last Name minimum 2 character"
                        },
                        email: 
                        {
                            required: "Email Required",
                            email: "Invalid Email Format"
                        },
                        password: 
                        {
                            required: "Password Required",
                            minlength: "Password minimum 6 character"
                        },
                        retype_password: 
                        {
                            required: "Retype Password Required",
                            minlength: "Retype Password minimum 6 character",
                            equalTo: "Retype must be the same as Password"
                        }
                    },
                // the errorPlacement has to take the table layout into account
                errorPlacement: function(error, element) 
                {
                    element.parent("div").next("span").html("");
                    error.prependTo( element.parent("div").next("span") );
                },
                // specifying a submitHandler prevents the default submit, good for the demo
                submitHandler: function() 
                {
//                    if(($('#tos').is(':checked')))
//                    {
                        $("#form_register_member").submit();
//                    }
//                    else
//                    {
//                        $("#tos_error").html("You Must Agree with Terms of Service and Privacy Statement");
//                    }
                },
                // set this class to error-labels to indicate valid fields
                success: function(label) {
                // set &nbsp; as text for IE
                label.html("&nbsp;").addClass("checked");
                }
                });
                
                $("#user_name").change
                (
                    function()
                    {
                        var request = $.ajax({
                            url: '<?php echo site_url("user/user/check_user_name_update/");?>' ,
                            type: "POST",
                            data: "user_name=" + $("#user_name").val(),
                            dataType: "json",
                            beforeSend:function()
                            {
                            }
                        });

                        request.done(function(msg) 
                        {
                                if(msg.user_exist == "true")
                                {
                                    $("#user_name_error").html('username has been used');
                                }
                                else
                                {
                                    $("#user_name_error").html('');
                                }
                        }
                        );

                        request.fail(function(jqXHR, textStatus) 
                        {
                        });                        
                        
                    }
                );
                $("#email").change
                (
                    function()
                    {
                        var request = $.ajax({
                            url: '<?php echo site_url("user/user/check_email_update/");?>' ,
                            type: "POST",
                            data: "email=" + $("#email").val(),
                            dataType: "json",
                            beforeSend:function()
                            {
                            }
                        });

                        request.done(function(msg) 
                        {
                                if(msg.email_exist == "true")
                                {
                                    $("#email_error").html('email has been used');
                                }
                                else
                                {
                                    $("#email_error").html('');
                                }
                        }
                        );

                        request.fail(function(jqXHR, textStatus) 
                        {
                        });                        
                        
                    }
                );
        }
    );
</script>
<!--
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<script src="http://blueimp.github.com/JavaScript-Templates/tmpl.min.js"></script>
<script src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
<script src="http://blueimp.github.com/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js"></script>
<script src="http://blueimp.github.com/jQuery-Image-Gallery/js/jquery.image-gallery.min.js"></script>
<script src="<?php echo site_url('js/jquery.iframe-transport.js'); ?>"></script>
<script src="<?php echo site_url('js/jquery.fileupload.js'); ?>"></script>
<script src="<?php echo site_url('js/jquery.fileupload-fp.js'); ?>"></script>
<script src="<?php echo site_url('js/jquery.fileupload-ui.js'); ?>"></script>
<script src="<?php echo site_url('js/jquery.fileupload-jui.js'); ?>"></script>
<script src="<?php echo site_url('js/main.js'); ?>"></script>
-->
