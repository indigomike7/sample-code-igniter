<?php
class Homepage extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
//        $this->load->library('admin_ion_auth','easyphpthumbnail');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
//        $this->load->model('university_model');

        $this->load->model('home/review_m');

        $this->load->database();

        $this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        $data=array();
        $site_title=$this->details('SITE_TITLE');
        $data_header['site_title']=$site_title['setting_desc'];

        $site_meta_keyword=$this->details('SITE_META_KEYWORD');
        $data_header['site_meta_keyword']=$site_meta_keyword['setting_desc'];
        
        $site_meta_description=$this->details('SITE_META_DESCRIPTION');
        $data_header['site_meta_description']=$site_meta_description['setting_desc'];

        $site_slogan=$this->details('SITE_SLOGAN');
        $data_header['site_slogan']=$site_slogan['setting_desc'];

        $this->load->model('home/review_m','rm');
        $review_data = new stdClass();
        $review_data->rotd = $this->review_m->get_rotd();
        $review_data->recent = $this->review_m->get_recent();
        $review_data->top = $this->review_m->get_top_reviewer();

        $this->load->view("vhomepage_header",$data_header);
        $this->load->view("vhomepage",$review_data);
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
}
?>
