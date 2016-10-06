<?php
?>
                <div id="form_login_admin" class="height480">
                    <h1 class="form_title">Sign In to Admin</h1>
                    <div class="form_open"></div>
                    <div class="ui-widget error_student center width468 height50">
                        <?php
                        if(isset($admin_status))
                        {
                            if($admin_status =="error")
                            {
                                echo md5("password");
                                ?>
                                <div style="padding: 0 .7em;" class="ui-state-error ui-corner-all font10">
                                <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p>
                                <?php echo $admin_message; ?>&nbsp;
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="space_bar_middle_start height250">&nbsp;</div>
                    <div class="width468 float_left">
                    <form action="<?php echo site_url("admin/admin/login");?>" id="form_login_student" method="post">
                        <div class="form_label">
                            <label for="user_name">User Name</label>
                        </div>
                        <div class="form_input">
                            <div class="input_text">
                                <input type="text" name="user_name" class="width250"/>
                            </div>
                        </div>
                        <div class="form_label">
                            <label for="user_name" size="200">Password</label>
                        </div>
                        <div class="form_input">
                            <div class="input_text">
                                <input type="password" name="user_pass" class="width250"/>
                            </div>
                        </div>
                        <div class="form_label">
                            &nbsp;
                        </div>
                        <div class="form_input middle">
                            <input type="checkbox" name="remember_me" class="vertical_align_sub"/><label for="checkbox" class="font_normal"> Remember me on this computer</label>
                        </div>
                        <div class="form_label">
                            &nbsp;
                        </div>
                        <div class="form_input middle right">
                            <button type="submit" class="button_loggin font18">Login</button>
                        </div>
                        </form>
                    </div>
                    <div class="space_bar_middle_end height250"></div>
                </div>
                <div class="hr center width468">&nbsp;</div>
                <div class="height100">&nbsp;</div>
