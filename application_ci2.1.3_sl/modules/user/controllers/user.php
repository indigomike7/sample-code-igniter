<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class User extends MX_Controller {
 
   public function index()
   {
      //$this->load->view('vuser');
       //if($)
   }

    function HandleError($message) 
    {
        echo $message;
    }
    public function user_setting()
    {
        $this->load->library('user/user_ion_auth');
        if ($this->user_ion_auth->logged_in() === FALSE)
            redirect(site_url(''));

        $this->load->model('user_model');
        $this->load->model('user_ion_auth_model');
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
        
        $data_setting['user_name_error']='';
        $data_setting['first_name_error']='';
        $data_setting['last_name_error']='';
        $data_setting['email_error']='';
        $data_setting['password_error']='';
        $data_setting['retype_password_error']='';
        $data_setting['bachelor_degree_error']='';
        $data_setting['university_bachelor_error']='';
        $data_setting['master_degree_error']='';
        $data_setting['university_master_error']='';
        $data_setting['tos_error']='';
        $data_setting['all_errors']='';
        $data_setting['success_message']='';
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
                $where=array('id =\''.$this->session->userdata('user_id').'\'');
                $data=$this->user_model->users(0,1,"id","DESC",$where ,"","")->result();
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
                $this->load->view("home/vhomepage_user_setting",$data_setting);
            } 
            else
            {
                $this->load->model('user/user_ion_auth_model');
//                die($this->input->post('email'));
                if($this->user_ion_auth_model->check_email_update($this->input->post('email'),$this->session->userdata('user_id')))
                {
                    $where=array('id =\''.$this->session->userdata('user_id').'\'');
                    $data=$this->user_model->users(0,1,"id","DESC",$where ,"","")->result();
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
//                    $this->load->view("home/vhomepage_user_setting",$data_setting);
                    $data_setting['email_error']='Email Has Been Used';
                    $this->load->view("home/vhomepage_user_setting",$data_setting);
                }
                else
                {
                    if($this->user_ion_auth_model->check_user_name_update($this->input->post('user_name'),$this->session->userdata('user_id')))
                    {
                    $where=array('id =\''.$this->session->userdata('user_id').'\'');
                    $data=$this->user_model->users(0,1,"id","DESC",$where ,"","")->result();
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
//                    $this->load->view("home/vhomepage_user_setting",$data_setting);
//                    $data_setting['email_error']='Email Has Been Used';
                        $data_setting['user_name_error']='User Name Has Been Used';
                        $this->load->view("home/vhomepage_user_setting",$data_setting);
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
                        $this->user_model->update($this->input->post('user_name'),$this->input->post('password'),$this->input->post('email'),$this->input->post('first_name'),$this->input->post('last_name'),$this->input->post('bachelor_degree'),$this->input->post('university_bachelor'),$this->input->post('master_degree'),$this->input->post('university_master'),$this->session->userdata('user_id'));
                        
                    $structure_thumb = 'upload/users/thumb';
                    $data=array();
                    if(!is_dir($structure_thumb))
                    {
                        if (!mkdir($structure_thumb, 0755, true)) {
                            $data['message_error']="failed to create folder thumb";
                        }
                    }

                    $POST_MAX_SIZE = ini_get('post_max_size');
                    $unit = strtoupper(substr($POST_MAX_SIZE, -1));
                    $multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

                    if ((int)$this->input->server('CONTENT_LENGTH') > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
                            header("HTTP/1.1 500 Internal Server Error"); // This will trigger an uploadError event in SWFUpload
                            echo "POST exceeded maximum allowed size.";
                            exit(0);
                    }

            // Settings
                    $save_path = "upload/users/".$this->session->userdata('user_id').'.jpg';				// The path were we will save the file (getcwd() may not be reliable and should be tested in your environment)
                    $upload_name = "files";
                    $max_file_size_in_bytes = 2147483647;				// 2GB in bytes
                    $extension_whitelist = array("jpg", "gif", "png");	// Allowed file extensions
                    $valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				// Characters allowed in the file name (in a Regular Expression format)

            // Other variables	
                    $MAX_FILENAME_LENGTH = 260;
                    $file_name = "";
                    $file_extension = "";
                    $uploadErrors = array(
                    0=>"There is no error, the file uploaded with success",
                    1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
                    2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
                    3=>"The uploaded file was only partially uploaded",
                    4=>"No file was uploaded",
                    6=>"Missing a temporary folder"
                    );


            // Validate the upload
                    if (!isset($_FILES[$upload_name])) {
                            $this->HandleError("No upload found in \$_FILES for " . $upload_name);
                            exit(0);
                    } else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
                            $this->HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
                            exit(0);
                    } else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
                            $this->HandleError("Upload failed is_uploaded_file test.");
                            exit(0);
                    } else if (!isset($_FILES[$upload_name]['name'])) {
                            $this->HandleError("File has no name.");
                            exit(0);
                    }

            // Validate the file size (Warning: the largest files supported by this code is 2GB)
                    $file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
                    if (!$file_size || $file_size > $max_file_size_in_bytes) {
                            $this->HandleError("File exceeds the maximum allowed size");
                            exit(0);
                    }

                    if ($file_size <= 0) {
                            $this->HandleError("File size outside allowed lower bound");
                            exit(0);
                    }


            // Validate file name (for our purposes we'll just remove invalid characters)
                    $file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
                    if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
                            $this->HandleError("Invalid file name");
                            exit(0);
                    }

                    $file_name='';

            // Validate that we won't over-write an existing file
                    if (file_exists($save_path . $file_name)) {
//                            $this->HandleError("File with this name already exists");
//                            exit(0);
                    }

            // Validate file extension
                    $path_info = pathinfo($_FILES[$upload_name]['name']);
                    $file_extension = $path_info["extension"];
                    $is_valid_extension = false;
                    foreach ($extension_whitelist as $extension) {
                            if (strcasecmp($file_extension, $extension) == 0) {
                                    $is_valid_extension = true;
                                    break;
                            }
                    }
                    if (!$is_valid_extension) {
                            $this->HandleError("Invalid file extension");
                            exit(0);
                    }

            // Validate file contents (extension and mime-type can't be trusted)
                    /*
                            Validating the file contents is OS and web server configuration dependant.  Also, it may not be reliable.
                            See the comments on this page: http://us2.php.net/fileinfo

                            Also see http://72.14.253.104/search?q=cache:3YGZfcnKDrYJ:www.scanit.be/uploads/php-file-upload.pdf+php+file+command&hl=en&ct=clnk&cd=8&gl=us&client=firefox-a
                            which describes how a PHP script can be embedded within a GIF image file.

                            Therefore, no sample code will be provided here.  Research the issue, decide how much security is
                            needed, and implement a solution that meets the needs.
                    */


            // Process the file
                    /*
                            At this point we are ready to process the valid file. This sample code shows how to save the file. Other tasks
                            could be done such as creating an entry in a database or generating a thumbnail.

                            Depending on your server OS and needs you may need to set the Security Permissions on the file after it has
                            been saved.
                    */
                    $file_name='';
                    if (!@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$file_name)) {
                            $this->HandleError("File could not be saved.");
                            exit(0);
                    }
//                    echo "before creating...";
                    require_once("upload/easyphpthumbnail.php");
                    $thumb = new easyphpthumbnail();

                    $thumb->Thumbsize = 300;
                    $thumb -> Thumblocation = 'upload/users/thumb/';
                    $thumb -> Thumbprefix = '';
                    $thumb -> Thumbsaveas = 'png';
                    $thumb -> Thumbfilename = $this->session->userdata('user_id').'.jpg';
                    $thumb->Createthumb('upload/users/'.$this->session->userdata('user_id').'.jpg','file');

                    $data_setting['success_message']='Data Updated';
//                    echo "after creating...";
//                    exit(0);

//                        $this->user_ion_auth_model->login($this->input->post('user_name'),$this->input->post('password'),$this->input->post('remember_me_register'));
                        
//                        redirect(site_url("user"));
                        $where=array('id =\''.$this->session->userdata('user_id').'\'');
                        $data=$this->user_model->users(0,1,"id","DESC",$where ,"","")->result();
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
//                    $this->load->view("home/vhomepage_user_setting",$data_setting);
//                    $data_setting['email_error']='Email Has Been Used';
//                        $data_setting['user_name_error']='User Name Has Been Used';
                        $this->load->view("home/vhomepage_user_setting",$data_setting);
                    }
                }
            }
        }
        else
        {
            $where=array('id =\''.$this->session->userdata('user_id').'\'');
            $data=$this->user_model->users(0,1,"id","DESC",$where ,"","")->result();
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
            $this->load->view("home/vhomepage_user_setting",$data_setting);
        }
        $this->load->view("vhomepage_footer");
        
    }
    public function logout()
    {
        $this->user_ion_auth->logout();
        redirect(site_url());
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
    function check_user_name_register()
    {
        if($this->user_ion_auth_model->username_check($this->input->post('user_name')))
        {
            $data_setting['user_exist']='true';
        }
        else
        {
            $data_setting['user_exist']='false';
        }
        echo json_encode($data_setting);
    }
    function check_email_register()
    {
        if($this->user_ion_auth_model->email_check($this->input->post('email')))
        {
            $data_setting['email_exist']='true';
        }
        else
        {
            $data_setting['email_exist']='false';
        }
        echo json_encode($data_setting);
    }
    function check_user_name_update()
    {
        if(count($this->user_ion_auth_model->check_user_name_update($this->input->post('user_name'),$this->session->userdata('user_id'))->result())>0)
        {
            $data_setting['user_exist']='true';
        }
        else
        {
            $data_setting['user_exist']='false';
        }
        echo json_encode($data_setting);
    }
    function check_email_update()
    {
        if(count($this->user_ion_auth_model->check_email_update($this->input->post('user_name'),$this->session->userdata('user_id'))->result())>0)
        {
            $data_setting['email_exist']='true';
        }
        else
        {
            $data_setting['email_exist']='false';
        }
        echo json_encode($data_setting);
    }
    

}
