<?php
?>
<div class="width962 center">
	<div class="float_left width468 center">
		<h1 class="form_title">Sign In to Your Account</h1>
		<div class="form_open"></div>
		<form action="<?php echo site_url("home/log");?>"
			id="form_login_student" method="post">
			<div class="error_message text_align_center padding20">
				<?php echo $error_message; ?>
			</div>
			<div class="form_label">
				<label for="user_name">User Name</label>
			</div>
			<div class="form_input">
				<div class="input_text">
					<input type="text" name="user_name" class="width250" />
				</div>
			</div>
			<div class="clear"></div>
			<div class="form_label">
				<label for="user_name" size="200">Password</label>
			</div>
			<div class="form_input">
				<div class="input_text">
					<input type="password" name="user_pass" class="width250" />
				</div>
			</div>
			<div class="clear"></div>
			<div class="form_label">&nbsp;</div>
			<div class="form_input font9">
				<input type="checkbox" name="remember_me" class="vertical_align_sub" />
				Remember User Name & Password on this computer
			</div>
			<div class="clear"></div>
			<div class="form_label">&nbsp;</div>
			<div class="form_input middle right">
				<button type="submit" class="button_loggin font18">Login</button>
			</div>
			<div class="clear"></div>
			<div class="form_label">&nbsp;</div>
			<div class="form_input middle right">
				<p>&nbsp;</p>
				<p class="font_bold" style="margin-left: 10px;">
					Forgot Your Password, <a class="color_green"
						href="<?php echo site_url('home/log/forgot_password');?>">Click Here</a>&nbsp;&nbsp;<img
						src="<?php echo site_url('images/forgot_password.jpg');?>" />
				</p>
			</div>
		</form>
	</div>
	<div class="space_bar_middle height350 center"></div>
	<div class="float_left width468 center">
		<h1 class="form_title">Not Yet a Member ?</h1>
		<div class="form_open"></div>
		<div id="facebook_login" class="font9">
			<a href="javascript:void(0)" onClick="fb_login();"
				id="register_with_facebook"> <img
				src="<?php echo site_url('images/facebook_logo.jpg'); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login
				With Facebook
			</a>
			<div id="fb-root"></div>
			
			
			<script>
    var FB;
      window.fbAsyncInit = function() {
        FB.init({
          appId: '<?php echo $idnya; ?>',
          cookie: true,
          xfbml: true,
          oauth: true
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
        });
      };
      
      function fb_login(){
    FB.login(function(response) {

        if (response.authResponse) {
            console.log('Welcome!  Fetching your information.... ');
            //console.log(response); // dump complete info
            access_token = response.authResponse.accessToken; //get access token
            user_id = response.authResponse.userID; //get FB UID

            FB.api('/me', function(response) {
                user_email = response.email; //get user email
          // you can store this data into your database             
            });

        } else {
            //user hit cancel button
            console.log('User cancelled login or did not fully authorize.');

        }
    }, {
        scope: 'publish_stream,email'
    });
}
(function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
}());
      
      
    </script>



			<p>&nbsp;</p>
			<input type="checkbox" name="tos" class="vertical_align_sub" /> I
			have read and agree to the <a class="color_green"
				href="<?php echo site_url("home/page/terms-of-service");?>">Terms of
				Service</a> and <a class="color_green"
				href="<?php echo site_url("home/page/privacy-statement");?>">Privacy
				Statement</a>.<br /> <input type="checkbox"
				name="remember_me_facebook" class="vertical_align_sub" /> Remember
			me on this computer
			<p>&nbsp;</p>
			<div class="margin_left160 font18 font_bold">or</div>
			<p>&nbsp;</p>
			<a href="<?php echo site_url('home/log/register');?>"
				id="register_new_account">Register Your Own Account</a>
			<p>&nbsp;</p>
		</div>
	</div>
	<div class="clear"></div>
</div>
