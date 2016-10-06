<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Site_setting extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('admin_ion_auth','easyphpthumbnail');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('site_setting_model');


        $this->load->database();

        $this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $this->load->view("vadmin_header");
        $data=array();
        $site_title=$this->details('SITE_TITLE');
        $data['site_title']=$site_title['setting_desc'];
        $data['site_title_error']='';

        $site_meta_keyword=$this->details('SITE_META_KEYWORD');
        $data['site_meta_keyword']=$site_meta_keyword['setting_desc'];
        $data['site_meta_keyword_error']='';
        
        $site_meta_description=$this->details('SITE_META_DESCRIPTION');
        $data['site_meta_description']=$site_meta_description['setting_desc'];
        $data['site_meta_description_error']='';

        $site_admin_email=$this->details('SITE_ADMIN_EMAIL');
        $data['site_admin_email']=$site_admin_email['setting_desc'];
        $data['site_admin_email_error']='';

        $site_date_format=$this->details('SITE_DATE_FORMAT');
        $data['site_date_format']=$site_date_format['setting_desc'];
        $data['site_date_format_error']='';

        $site_require_activation=$this->details('SITE_REQUIRE_ACTIVATION');
        $data['site_require_activation']=$site_require_activation['setting_desc'];
        $data['site_require_activation_error']='';

        $site_slogan=$this->details('SITE_SLOGAN');
        $data['site_slogan']=$site_slogan['setting_desc'];
        $data['site_slogan_error']='';

        $data['warning_message']='';
        $this->load->view("vadmin_site_setting",$data);
        $this->load->view("vadmin_footer");
    }
    function details($setting_name)
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $where=array('setting_name =\''.$setting_name.'\'');
        $data=$this->site_setting_model->settings(0,1,"setting_id","DESC",$where ,"","")->result();
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
    function update($setting_name, $setting_desc)
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $result=$this->site_setting_model->update($setting_name,$setting_desc);
    }
    function update_settings()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $data=array();
        $data['site_title_error']='';
        $data['site_meta_keyword_error']='';
        $data['site_meta_description_error']='';
        $data['site_admin_email_error']='';
        $data['site_date_format_error']='';
        $data['site_require_activation_error']='';
        $data['site_slogan_error']='';
        $data['warning_message']='';
        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'site_title', 'label' => 'Site Title', 'rules' => 'required|xss_clean')
                    ,array('field' => 'site_meta_description', 'label' => 'Meta Description', 'rules' => 'required|xss_clean')
                    ,array('field' => 'site_meta_keyword', 'label' => 'Meta Keyword', 'rules' => 'required|xss_clean')
                    ,array('field' => 'site_admin_email', 'label' => 'Admin Email', 'rules' => 'required|xss_clean')
                    ,array('field' => 'site_date_format', 'label' => 'Date Format', 'rules' => 'required|xss_clean')
                    ,array('field' => 'site_require_activation', 'label' => 'Require Activation', 'rules' => 'required|xss_clean')
                    ,array('field' => 'site_slogan', 'label' => 'Site Slogan', 'rules' => 'required|xss_clean')
             );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                if(strlen($this->input->post('site_title'))==0)
                {
                    $data['site_title_error']='Title Required';
                }
                if(strlen($this->input->post('site_meta_description'))==0)
                {
                    $data['site_meta_description_error']='Meta Description Required';
                }
                if(strlen($this->input->post('site_meta_keyword'))==0)
                {
                    $data['site_meta_keyword_error']='Meta Keyword';
                }
                if(strlen($this->input->post('site_admin_email'))==0)
                {
                    $data['site_admin_email_error']='Admin Email Required';
                }
                if(strlen($this->input->post('site_date_format'))==0)
                {
                    $data['site_date_format_error']='Date Format Required';
                }
                if(strlen($this->input->post('site_require_activation'))==0)
                {
                    $data['site_require_activation_error']='Require Activation Required';
                }
                if(strlen($this->input->post('site_slogan'))==0)
                {
                    $data['site_slogan']='Site Slogan Required';
                }
            } 
            else
            {
                $this->update('SITE_TITLE',$this->input->post('site_title'));
                $this->update('SITE_META_DESCRIPTION',$this->input->post('site_meta_description'));
                $this->update('SITE_META_KEYWORD',$this->input->post('site_meta_keyword'));
                $this->update('SITE_ADMIN_EMAIL',$this->input->post('site_admin_email'));
                $this->update('SITE_DATE_FORMAT',$this->input->post('site_date_format'));
                $this->update('SITE_REQUIRE_ACTIVATION',$this->input->post('site_require_activation'));
                $this->update('SITE_SLOGAN',$this->input->post('site_slogan'));
                $data["warning_message"]='Settings Updated';
            }
        }
        $this->load->view("vadmin_header");
        $site_title=$this->details('SITE_TITLE');
        $data['site_title']=$site_title['setting_desc'];

        $site_meta_keyword=$this->details('SITE_META_KEYWORD');
        $data['site_meta_keyword']=$site_meta_keyword['setting_desc'];
        
        $site_meta_description=$this->details('SITE_META_DESCRIPTION');
        $data['site_meta_description']=$site_meta_description['setting_desc'];

        $site_admin_email=$this->details('SITE_ADMIN_EMAIL');
        $data['site_admin_email']=$site_admin_email['setting_desc'];

        $site_date_format=$this->details('SITE_DATE_FORMAT');
        $data['site_date_format']=$site_date_format['setting_desc'];

        $site_require_activation=$this->details('SITE_REQUIRE_ACTIVATION');
        $data['site_require_activation']=$site_require_activation['setting_desc'];

        $site_slogan=$this->details('SITE_SLOGAN');
        $data['site_slogan']=$site_slogan['setting_desc'];

        $this->load->view("vadmin_site_setting",$data);
        $this->load->view("vadmin_footer");
        
    }
}
?>