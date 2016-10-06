<div id="data">
    <h1>Change Password</h1>
    <div id="site_setting">
        <form action="<?php echo site_url("admin/password/change_password");?>" method="post" id="form_password">
        <div id="loading_bar_insert"></div>
        <div class="warning_message"><?php echo $warning_message;?></div>
        <div class="error_message"><?php echo $error_message;?></div>
                <div class="form_label">
                    <label for="old_password">Old Password</label>
                </div>
                <div class="form_input width800">
                    <div class="input_text width250 float_left">
                        <input type="password" name="old_password" id="old_password" class="width250"/>
                    </div>
                    <span class="error_message" id="old_password_error"><?php echo $old_password_error;?></span>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="new_password">New Password</label>
                </div>
                <div class="form_input width800">
                    <div class="input_text width250 float_left">
                        <input type="password" name="new_password" id="new_password" class="width250"/>
                    </div>
                    <span class="error_message" id="new_password_error"><?php echo $new_password_error;?></span>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="new_password_confirm">Confirm New Password</label>
                </div>
                <div class="form_input width800">
                    <div class="input_text width250 float_left">
                        <input type="password" name="new_password_confirm" id="new_password_confirm" class="width250"/>
                    </div>
                    <span class="error_message" id="new_password_confirm_error"><?php echo $new_password_confirm_error;?></span>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    &nbsp;
                </div>
                <div class="form_input middle right width800">
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
            $("#form_password").validate
            ( 
                {
                    rules: 
                    {
                        old_password: 
                        {
                            required: true,
                            minlength: 6
                        },
                        new_password: 
                        {
                            required: true,
                            minlength: 6
                        },
                        new_password_confirm: 
                        {
                            required: true,
                            minlength: 6,
                            equalTo: new_password
                        }
                    },
                    messages: 
                    {
                        old_password: 
                        {
                            required: "Password Required",
                            minlength: "Password length is at least 6 character"
                        },
                        new_password: 
                        {
                            required: "Password Required",
                            minlength: "New Password length is at least 6 character"
                        },
                        new_password_confirm: 
                        {
                            required: "Confirm Password Required",
                            minlength: "Meta Keyword Required",
                            equalTo : "Confirm Password must be the same as New Password"
                            
                        }
                    },
                // the errorPlacement has to take the table layout into account
                errorPlacement: function(error, element) 
                {
                    error.prependTo( element.parent("div").next("span") );
                },
                // specifying a submitHandler prevents the default submit, good for the demo
                submitHandler: function() 
                {
                    $("#form_password").submit();
                },
                // set this class to error-labels to indicate valid fields
                success: function(label) {
                // set &nbsp; as text for IE
                label.html("&nbsp;").addClass("checked");
                }
                });

                
        }
    );
</script>