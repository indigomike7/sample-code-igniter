<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log extends MX_Controller {

	private $data_header= FALSE;
	private $data;
	private $thumb_marker = '_thumb';

	function __construct()
	{
		parent::__construct();
		//        $this->load->library('admin_ion_auth','easyphpthumbnail');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->library('user/user_ion_auth');
		//        $this->load->model('university_model');


		$this->load->database();

		$this->form_validation->set_error_delimiters("<p>", "</p>");

		$site_title=$this->details('SITE_TITLE');
		$this->data_header['site_title']=$site_title['setting_desc'];

		$site_meta_keyword=$this->details('SITE_META_KEYWORD');
		$this->data_header['site_meta_keyword']=$site_meta_keyword['setting_desc'];

		$site_meta_description=$this->details('SITE_META_DESCRIPTION');
		$this->data_header['site_meta_description']=$site_meta_description['setting_desc'];

		$site_slogan=$this->details('SITE_SLOGAN');
		$this->data_header['site_slogan']=$site_slogan['setting_desc'];

	}

	//redirect if needed, otherwise display the user list
	function index()
	{
		$this->load->helper( 'facebook' );
		$facebook = new Facebook(array(
				'appId'  => '302963539825363',
				'secret' => '39a8b87040de624d013128a71814b966',
		));

		$userFB = $facebook->getUser();
		$idFB="";
		try {
			$user_profile = $facebook->api('/me');
			$idFB=$user_profile['id'];
		} catch (FacebookApiException $e) {
		}



		$this->load->library('user/user_ion_auth');
		if ($this->user_ion_auth->logged_in() === TRUE)
			redirect(site_url());

		$data=array();
		$site_title=$this->details('SITE_TITLE');
		$data_header['site_title']=$site_title['setting_desc'];

		$site_meta_keyword=$this->details('SITE_META_KEYWORD');
		$data_header['site_meta_keyword']=$site_meta_keyword['setting_desc'];

		$site_meta_description=$this->details('SITE_META_DESCRIPTION');
		$data_header['site_meta_description']=$site_meta_description['setting_desc'];

		$site_slogan=$this->details('SITE_SLOGAN');
		$data_header['site_slogan']=$site_slogan['setting_desc'];

		$this->load->view("vhomepage_header",$data_header);
		$data_content['error_message']='';
		$data_content['idnya']=$facebook->getAppID();
		if ($this->input->post())
		{
			$config = array(
					array('field' => 'user_name', 'label' => 'User Name', 'rules' => 'required|xss_clean')
					,array('field' => 'user_pass', 'label' => 'First Name', 'rules' => 'required|xss_clean')
			);

			$this->form_validation->set_rules($config);

			if ($this->form_validation->run() == FALSE)
			{
				$data_content['error_message'] = "Invalid User Name or Password";
				$data_content['error_status'] = 'error';
				$this->load->view("vhomepage_signin",$data_content);
			}
			else
			{
				$username = $this->input->post('user_name');
				$password = $this->input->post('user_pass');
				if ($this->user_ion_auth->login($username, $password, $this->input->post('remember_me')) === FALSE)
				{
					$data_content['error_message'] = "Invalid User Name or Password";
					$data_content['error_status'] = 'error';
					$this->load->view("vhomepage_signin",$data_content);
				}
				else
					redirect(site_url());
			}
		}
		else
		{
			if (strlen($idFB)<1)
				$this->load->view("vhomepage_signin",$data_content);
			else {
				$this->load->model('user/user_ion_auth_model');
				$additional_data = array(
						'first_name'=>$user_profile['first_name']
						,'last_name'=>$user_profile['last_name']
						,'facebook_id'=>$user_profile['id']
						
				);
				$this->user_ion_auth_model->register($user_profile['username'] ,'','',$additional_data);
				
				$this->user_ion_auth->loginFB($user_profile['username'], $user_profile['id'], $this->input->post('remember_me'));
				redirect(site_url());
			}
		}
		$this->load->view("vhomepage_footer");
	}

	function register()
	{
		
		if ($this->user_ion_auth->logged_in() === TRUE)
			redirect(site_url());

		$data=array();
		$site_title=$this->details('SITE_TITLE');
		$data_header['site_title']=$site_title['setting_desc'];

		$site_meta_keyword=$this->details('SITE_META_KEYWORD');
		$data_header['site_meta_keyword']=$site_meta_keyword['setting_desc'];

		$site_meta_description=$this->details('SITE_META_DESCRIPTION');
		$data_header['site_meta_description']=$site_meta_description['setting_desc'];

		$site_slogan=$this->details('SITE_SLOGAN');
		$data_header['site_slogan']=$site_slogan['setting_desc'];

		$this->load->view("vhomepage_header",$data_header);

		$data_register['user_name_error']='';
		$data_register['first_name_error']='';
		$data_register['last_name_error']='';
		$data_register['email_error']='';
		$data_register['password_error']='';
		$data_register['retype_password_error']='';
		$data_register['bachelor_degree_error']='';
		$data_register['university_bachelor_error']='';
		$data_register['master_degree_error']='';
		$data_register['university_master_error']='';
		$data_register['tos_error']='';
		$data_register['all_errors']='';

		if ($this->input->post())
		{
			$config = array(
					array('field' => 'user_name', 'label' => 'User Name', 'rules' => 'required|min_length[6]|xss_clean')
					,array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'required|min_length[2]|xss_clean')
					,array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'required|min_length[2]|xss_clean')
					,array('field' => 'email', 'label' => 'Email', 'rules' => 'required|xss_clean|valid_email')
					,array('field' => 'password', 'label' => 'Password', 'rules' => 'required|min_length[6]|xss_clean')
					,array('field' => 'retype_password', 'label' => 'Retype Password', 'rules' => 'required|min_length[6]|xss_clean')
					,array('field' => 'bachelor_degree', 'label' => 'Bachelor Degree', 'rules' => 'min_length[2]|xss_clean')
					,array('field' => 'university_bachelor', 'label' => 'University Bachelor', 'rules' => 'min_length[2]|xss_clean')
					,array('field' => 'master_degree', 'label' => 'Master Degree', 'rules' => 'min_length[2]|xss_clean')
					,array('field' => 'university_master', 'label' => 'University Master', 'rules' => 'min_length[2]|xss_clean')
			);

			$this->form_validation->set_rules($config);

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view("vhomepage_register",$data_register);
			}
			else
			{
				$this->load->model('user/user_ion_auth_model');
				//                die($this->input->post('email'));
				if($this->user_ion_auth_model->email_check($this->input->post('email')))
				{
					$data_register['email_error']='Email Has Been Used';
					$this->load->view("vhomepage_register",$data_register);
				}
				else
				{
					if($this->user_ion_auth_model->username_check($this->input->post('user_name')))
					{
						$data_register['user_name_error']='User Name Has Been Used';
						$this->load->view("vhomepage_register",$data_register);
					}
					else
					{
						$additional_data = array(
								'first_name'=>$this->input->post('first_name')
								,'last_name'=>$this->input->post('last_name')
								,'bachelor_degree'=>$this->input->post('bachelor_degree')
								,'university_bachelor'=>$this->input->post('university_bachelor')
								,'master_degree'=>$this->input->post('master_degree')
								,'university_master'=>$this->input->post('university_master')
						);

						foreach ($_FILES as $f => $v) {
							if(!empty($v['name'])) {
								$upload = $this->_upload_picture('files');
								$additional_data['picture_url'] = $upload->picture_url;
								$additional_data['thumb_url'] = $upload->thumb_url;
								break;
							}	
						}

						$this->user_ion_auth_model->register($this->input->post('user_name'),$this->input->post('password'),$this->input->post('email'),$additional_data);

						$this->user_ion_auth_model->login($this->input->post('user_name'),$this->input->post('password'),$this->input->post('remember_me_register'));

						redirect(site_url());
					}
				}
			}
		}
		else
		{
			$this->load->view("vhomepage_register",$data_register);
		}
		$this->load->view("vhomepage_footer");
	}

	public function forgot_password() {

		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
			);

			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->load->view("vhomepage_header",$this->data_header);
			$this->load->view("vhomepage_password",$this->data);
			$this->load->view("vhomepage_footer");	
		}
		else
		{
			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->user_ion_auth->forgotten_password($this->input->post('email'));

			if ($forgotten)
			{ 
				//if there were no errors
				$this->session->set_flashdata('message', $this->user_ion_auth->messages());
				redirect("home/log/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->user_ion_auth->errors());
				redirect("home/log/forgot_password", 'refresh');
			}
		}
	}

	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->user_ion_auth->forgotten_password_check($code);

		if ($user)
		{  
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'user_ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'user_ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'user_ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				//render
				$this->load->view("vhomepage_header",$this->data_header);
				$this->load->view('vreset_pass', $this->data);
				$this->load->view("vhomepage_footer");
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) 
				{

					//something fishy might be up
					$this->user_ion_auth->clear_forgotten_password_code($code);

					show_error('This form post did not pass our security checks.');

				} 
				else 
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'user_ion_auth')};

					$change = $this->user_ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{ 
						//if the password was successfully changed
						$this->session->set_flashdata('message', $this->user_ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->user_ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{ 
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->user_ion_auth->errors());
			redirect("home/log/forgot_password", 'refresh');
		}
	}

	public function edit_user() {
        if ($this->user_ion_auth->logged_in() === FALSE)
            redirect(site_url(''));

        $this->load->model('user/user_model','user_m');
        $this->load->model('user/user_ion_auth_model','ion_m');

        //VALIDATION RULES
        $config = array(
                array('field' => 'user_name', 'label' => 'User Name', 'rules' => 'required|min_length[6]|xss_clean')
                ,array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'required|min_length[2]|xss_clean')
                ,array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'required|min_length[2]|xss_clean')
                ,array('field' => 'email', 'label' => 'Email', 'rules' => 'required|xss_clean|valid_email')
                ,array('field' => 'password', 'label' => 'Password', 'rules' => 'min_length[6]|xss_clean')
                ,array('field' => 'retype_password', 'label' => 'Retype Password', 'rules' => 'min_length[6]|xss_clean')
                ,array('field' => 'bachelor_degree', 'label' => 'Bachelor Degree', 'rules' => 'min_length[2]|xss_clean')
                ,array('field' => 'university_bachelor', 'label' => 'University Bachelor', 'rules' => 'min_length[2]|xss_clean')
                ,array('field' => 'master_degree', 'label' => 'Master Degree', 'rules' => 'min_length[2]|xss_clean')
                ,array('field' => 'university_master', 'label' => 'University Master', 'rules' => 'min_length[2]|xss_clean')
         );


		//GET OLD DATA
        $where=array('id =\''.$this->session->userdata('user_id').'\'');
        $data=$this->user_m->users(0,1,"id","DESC",$where ,"","")->result();
        $data_setting['thumb_url'] = $data[0]->thumb_url;
        
        if(!$_POST) {
        	if(count($data)>0)
	        {
	            $data_setting['user_id'] = $data[0]->id;
	            $data_setting['username'] = $data[0]->username;
	            $data_setting['first_name'] = $data[0]->first_name;
	            $data_setting['last_name'] = $data[0]->last_name;
	            $data_setting['email'] = $data[0]->email;
	            $data_setting['bachelor_degree'] = $data[0]->bachelor_degree;
	            $data_setting['university_bachelor'] = $data[0]->university_bachelor;
	            $data_setting['master_degree'] = $data[0]->master_degree;
	            $data_setting['university_master'] = $data[0]->university_master;
	            $data_setting['article_message'] = "success";
	            $data_setting['article_status'] = 'success';
	        }
        } else {

			$this->form_validation->set_rules($config);

			if($this->form_validation->run()) {

				$data = array(
					'username'=>$this->input->post('user_name'),
					'email'=>$this->input->post('email'),
					'password'=>$this->input->post('password'),
	                'first_name'=>$this->input->post('first_name'),
	                'last_name'=>$this->input->post('last_name'),
	                'bachelor_degree'=>$this->input->post('bachelor_degree'),
	                'university_bachelor'=>$this->input->post('university_bachelor'),
	                'master_degree'=>$this->input->post('master_degree'),
	                'university_master'=>$this->input->post('university_master')
	            );

	            foreach ($_FILES as $f => $v) {
					if(!empty($v['name'])) {
						$upload = $this->_upload_picture('files');
						$data['picture_url'] = $upload->picture_url;
						$data['thumb_url'] = $upload->thumb_url;
						break;
					}	
				}

	            $this->ion_m->update($this->session->userdata('user_id'),$data);
	            $this->session->set_flashdata('update_success','Data successfully updated');

	            redirect(site_url(uri_string()));
	            
	            exit;
			}

			$data_setting['user_id'] = $this->session->userdata('user_id');
            $data_setting['username'] = set_value('user_name',$this->input->post('user_name'));
            $data_setting['first_name'] = set_value('first_name',$this->input->post('first_name'));
            $data_setting['last_name'] = set_value('last_name',$this->input->post('last_name'));
            $data_setting['email'] = set_value('email',$this->input->post('email'));
            $data_setting['bachelor_degree'] = set_value('bachelor_degree',$this->input->post('bachelor_degree'));
            $data_setting['university_bachelor'] = set_value('university_bachelor',$this->input->post('university_bachelor'));
            $data_setting['master_degree'] = set_value('master_degree',$this->input->post('master_degree'));
            $data_setting['university_master'] = set_value('university_master',$this->input->post('university_master'));
            $data_setting['article_message'] = "success";
            $data_setting['article_status'] = 'success';

		}

        $this->load->view("vhomepage_header",$this->data_header);
        $this->load->view("vhomepage_user_setting",$data_setting);
        $this->load->view("vhomepage_footer");
	}
	
	function details($setting_name)
	{
		$this->load->model('home/home_site_setting_model');
		$where=array('setting_name =\''.$setting_name.'\'');
		$data=$this->home_site_setting_model->settings(0,1,"setting_id","DESC",$where ,"","")->result();
		if(count($data)>0)
		{
			$data_site_setting['setting_id'] = $data[0]->setting_id;
			$data_site_setting['setting_name'] = $data[0]->setting_name;
			$data_site_setting['setting_desc'] = $data[0]->setting_desc;
			$data_site_setting['article_message'] = "success";
			$data_site_setting['article_status'] = 'success';
		}
		return $data_site_setting;
	}

	private function _upload_picture($file) {

		$config['upload_path'] = './upload/users/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size']	= '1000';
		$config['max_width']  = '768';
		$config['max_height']  = '1366';
		$config['file_name'] = $this->session->userdata('user_id');
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);

		if($this->upload->do_upload($file)) {
			$data = $this->upload->data();
			$ret->picture_url = base_url('upload/users/'.$data['file_name']);
			$ret->thumb_url = $ret->picture_url;

			if($this->_manipulate_picture($data['file_name'])) {
				$ret->thumb_url = base_url('upload/users/thumb/'.$data['raw_name'].$this->thumb_marker.$data['file_ext']);
			}

			return $ret;
		} else {
			$this->session->set_flashdata('upload_error',$this->upload->display_errors('<p>', '</p>'));
		}

		return FALSE;
	}

	private function _manipulate_picture($file_name) {
		$config['image_library'] = 'gd2';
		$config['source_image']	= './upload/users/'.$file_name;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['new_image'] = './upload/users/thumb/'.$file_name;
		$config['thumb_marker'] = $this->thumb_marker;
		$config['width']	 = 155;
		$config['height']	= 155;

		$this->load->library('image_lib', $config); 

		if($this->image_lib->resize()) {
			return TRUE;
		}

		return FALSE;
	}
	 
}
?>