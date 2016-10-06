<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends MX_Controller {

	private $data_header = FALSE;

	public function __construct()
	{
		parent::__construct();
		//Do your magic here

		$this->load->model('page_m','pm');

		$site_title=$this->details('SITE_TITLE');
		$this->data_header['site_title']=$site_title['setting_desc'];

		$site_meta_keyword=$this->details('SITE_META_KEYWORD');
		$this->data_header['site_meta_keyword']=$site_meta_keyword['setting_desc'];

		$site_meta_description=$this->details('SITE_META_DESCRIPTION');
		$this->data_header['site_meta_description']=$site_meta_description['setting_desc'];

		$site_slogan=$this->details('SITE_SLOGAN');
		$this->data_header['site_slogan']=$site_slogan['setting_desc'];
	}

	public function get_page($slug)
	{
		if(!$data->page_content = $this->pm->get_by_slug($slug)) {
			redirect(base_url());
			exit;
		}

		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('vpage',$data);
   		$this->load->view("vhomepage_footer");
	}

	private function details($setting_name) {
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

/* End of file page.php */
/* Location: ./application_ci2.1.3_sl/modules/home/controllers/page.php */