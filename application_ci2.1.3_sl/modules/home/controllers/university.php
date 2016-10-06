<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class University extends MX_Controller {

	private $data_header = FALSE;

	public function __construct() {
		parent::__construct();

		$this->load->model('university_m','um');
		$this->load->model('program_m','pm');
		$this->load->model('review_m','rm');
		$this->load->model('course_m','cm');

		$site_title=$this->details('SITE_TITLE');
		$this->data_header['site_title']=$site_title['setting_desc'];

		$site_meta_keyword=$this->details('SITE_META_KEYWORD');
		$this->data_header['site_meta_keyword']=$site_meta_keyword['setting_desc'];

		$site_meta_description=$this->details('SITE_META_DESCRIPTION');
		$this->data_header['site_meta_description']=$site_meta_description['setting_desc'];

		$site_slogan=$this->details('SITE_SLOGAN');
		$this->data_header['site_slogan']=$site_slogan['setting_desc'];
	}

	public function index() {
		redirect (base_url());
		exit;
	}

	public function detail($univ_id) {
		if(!$univ_id OR !is_numeric($univ_id)) {
			redirect(site_url());
			exit;
		}

		$all = count($data->review = $this->rm->get_review($univ_id,'university'));
		$limit = 5;
        $uri_offset = 4;
        $offset = $this->uri->segment($uri_offset) ? $this->uri->segment($uri_offset) : 0 ; 

		$this->load->library('pagination');
		$config['base_url'] = site_url('university/'.$univ_id.'/offset');
		$config['total_rows'] = $all;
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_offset;

		$this->pagination->initialize($config);

		$data->detail = $this->um->get_detail($univ_id);
		$data->review = $this->rm->get_review($univ_id,'university',$limit,$offset);

		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('vuniversity',$data);
   		$this->load->view("vhomepage_footer");
	}

	public function program($program_id) {
		if(!$program_id OR !is_numeric($program_id)) {
			redirect(site_url());
			exit;
		}

		$univ_id = $this->uri->segment(2);
		
		if(!$univ_id OR !is_numeric($univ_id)) {
			redirect(site_url());
			exit;
		}

		if(!$program = $this->pm->detail($univ_id,$program_id)) {
			redirect(site_url());
			exit;
		}

		$all = count($this->rm->get_review($program_id,'program'));
		$limit = 5;
        $uri_offset = 6;
        $offset = $this->uri->segment($uri_offset) ? $this->uri->segment($uri_offset) : 0 ; 

		$this->load->library('pagination');
		$config['base_url'] = site_url('university/'.$univ_id.'/program/'.$program_id.'/offset');
		$config['total_rows'] = $all;
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_offset;

		$this->pagination->initialize($config);

		$data->detail = $this->um->get_detail($univ_id);
		$data->program = $program;
		$data->review = $this->rm->get_review($program_id,'program',$limit,$offset);

		$data->breadcrumb = anchor(site_url('university/'.$data->detail->university_id),$data->detail->university_name);
		$data->breadcrumb .= ' > '.$data->program->program_name;

		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('vprogram',$data);
   		$this->load->view("vhomepage_footer");
	}

	public function course($course_id) {
		if(!$course_id OR !is_numeric($course_id)) {
			redirect(site_url());
			exit;
		}

		$univ_id = $this->uri->segment(2);
		$program_id = $this->uri->segment(4);
		
		if(!$univ_id OR !is_numeric($univ_id)) {
			redirect(site_url());
			exit;
		}

		if(!$program_id OR !is_numeric($program_id)) {
			redirect(site_url());
			exit;
		}


		if(!$program = $this->pm->detail($univ_id,$program_id)) {
			redirect(site_url());
			exit;
		}

		if(!$course = $this->cm->detail($univ_id,$course_id)) {
			redirect(site_url());
			exit;
		}

		$all = count($this->rm->get_review($course_id,'course'));
		$limit = 5;
        $uri_offset = 8;
        $offset = $this->uri->segment($uri_offset) ? $this->uri->segment($uri_offset) : 0 ; 

		$this->load->library('pagination');
		$config['base_url'] = site_url('university/'.$univ_id.'/program/'.$program_id.'/course/'.$course_id.'/offset');
		$config['total_rows'] = $all;
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_offset;

		$this->pagination->initialize($config);

		$data->detail = $this->um->get_detail($univ_id);
		$data->program = $program;
		$data->course = $course;
		$data->review = $this->rm->get_review($course_id,'course',$limit,$offset);

		$data->breadcrumb = anchor(site_url('university/'.$data->detail->university_id),$data->detail->university_name);
		$data->breadcrumb .= ' > '.anchor(site_url('university/'.$data->detail->university_id.'/program/'.$data->program->program_id),$data->program->program_name);
		$data->breadcrumb .= ' > '.$data->course->course_name;

		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('vcourse',$data);
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