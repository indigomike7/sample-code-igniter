<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review extends MX_Controller {

	private $data_header = FALSE;

	public function __construct() {
		parent::__construct();

		$this->load->model('university_m','um');
		$this->load->model('program_m','pm');
		$this->load->model('review_m','rm');
		$this->load->model('course_m','cm');

		$this->load->helper('form');
		$this->load->library('form_validation');

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
		redirect(base_url());
		exit;
	}

	public function detail($item_id) {
		$data->detail = $this->rm->detail($item_id);

		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('vreview_detail',$data);
   		$this->load->view("vhomepage_footer");
	}

	public function add_university_review($univ_id) {
		$this->_is_logged_in();

		if(!$univ_id OR !is_numeric($univ_id)) {
			redirect(base_url());
			exit;
		}

		//Rate data
		$data->rate_data = array();
		for ($i=1;$i<=10;$i++) {
			$data->rate_data[$i] = $i;
		}
		
		//detail data
		$data->detail = $this->um->get_detail($univ_id);

		$data->breadcrumb = anchor(site_url('university/'.$data->detail->university_id),$data->detail->university_name);
		$data->breadcrumb .= ' > Add review';

		if($_POST) {
			$this->form_validation->set_rules('review','Review','required');
			$this->form_validation->set_rules('title','Title','required|max_length[60]');	

			if($this->form_validation->run()) {
				$input_data['item_id'] = $univ_id;
				$input_data['type'] = 'university';
				$input_data['user_id'] = $this->session->userdata('user_id');
				$input_data['title'] = $this->input->post('title');
				$input_data['review'] = $this->input->post('review');
				$input_data['rates'] = $this->input->post('rate');

				$this->rm->add_review($input_data);

				$this->_rerank($univ_id);

				redirect(site_url('university/'.$univ_id));

			} else {
				$data->title = set_value('title',$this->input->post('title'));
				$data->review = set_value('review',$this->input->post('review'));
				$data->rate = $this->input->post('rate');
			}	
		}

		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('vreview_form',$data);
   		$this->load->view("vhomepage_footer");
	}

	public function add_program_review($program_id) {
		$this->_is_logged_in();

		$program_id = $this->uri->segment(4);

		//Rate data
		$data->rate_data = array();
		for ($i=1;$i<=10;$i++) {
			$data->rate_data[$i] = $i;
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

		//detail data
		$data->detail = $this->um->get_detail($univ_id);
		$data->program = $program;

		$data->breadcrumb = anchor(site_url('university/'.$data->detail->university_id),$data->detail->university_name);
		$data->breadcrumb .= ' > '.anchor(site_url('university/'.$data->detail->university_id.'/program/'.$data->program->program_id),$data->program->program_name);
		$data->breadcrumb .= ' > Add review';

		if($_POST) {
			$this->form_validation->set_rules('review','Review','required');
			$this->form_validation->set_rules('title','Title','required|max_length[60]');	

			if($this->form_validation->run()) {
				$input_data['item_id'] = $program_id;
				$input_data['type'] = 'program';
				$input_data['user_id'] = $this->session->userdata('user_id');
				$input_data['title'] = $this->input->post('title');
				$input_data['review'] = $this->input->post('review');
				$input_data['rates'] = $this->input->post('rate');

				$this->rm->add_review($input_data);

				redirect(site_url('university/'.$univ_id.'/program/'.$program_id));

			} else {
				$data->title = set_value('title',$this->input->post('title'));
				$data->review = set_value('review',$this->input->post('review'));
				$data->rate = $this->input->post('rate');
			}
		}

		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('v_program_review_form',$data);
   		$this->load->view("vhomepage_footer");
	}

	public function add_course_review($course_id) {
		$this->_is_logged_in();

		//Rate data
		$data->rate_data = array();
		for ($i=1;$i<=10;$i++) {
			$data->rate_data[$i] = $i;
		}

		$course_id = $this->uri->segment(6);

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

		//detail data
		$data->detail = $this->um->get_detail($univ_id);
		$data->program = $program;
		$data->course = $course;
		//$data->review = $this->rm->get_review_by_univ($univ_id);

		$data->breadcrumb = anchor(site_url('university/'.$data->detail->university_id),$data->detail->university_name);
		$data->breadcrumb .= ' > '.anchor(site_url('university/'.$data->detail->university_id.'/program/'.$data->program->program_id),$data->program->program_name);
		$data->breadcrumb .= ' > '.anchor(site_url('university/'.$data->detail->university_id.'/program/'.$data->program->program_id.'/course/'.$data->course->course_id),$data->course->course_name);
		$data->breadcrumb .= ' > Add review';

		if($_POST) {
			$this->form_validation->set_rules('review','Review','required');
			$this->form_validation->set_rules('title','Title','required|max_length[60]');	

			if($this->form_validation->run()) {
				$input_data['item_id'] = $course_id;
				$input_data['type'] = 'course';
				$input_data['user_id'] = $this->session->userdata('user_id');
				$input_data['title'] = $this->input->post('title');
				$input_data['review'] = $this->input->post('review');
				$input_data['rates'] = $this->input->post('rate');

				$this->rm->add_review($input_data);

				redirect(site_url('university/'.$univ_id.'/program/'.$program_id.'/course/'.$course_id));

			} else {
				$data->title = set_value('title',$this->input->post('title'));
				$data->review = set_value('review',$this->input->post('review'));
				$data->rate = $this->input->post('rate');
			}
		}

		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('v_course_review_form',$data);
   		$this->load->view("vhomepage_footer");
	}

	public function all_university_review($univ_id) {
		if(!$univ_id OR !is_numeric($univ_id)) {
			redirect(base_url());
			exit;
		}

		//Rate data
		$data->rate_data = array();
		for ($i=1;$i<=10;$i++) {
			$data->rate_data[$i] = $i;
		}
		
		//detail data
		$data->detail = $this->um->get_detail($univ_id);

		$data->breadcrumb = anchor(site_url('university/'.$data->detail->university_id),$data->detail->university_name);
		$data->breadcrumb .= ' > All review';

		$data->review = $this->rm->get_review($univ_id,'university');

		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('v_all_review',$data);
   		$this->load->view("vhomepage_footer");
	}

	public function all_program_review($program_id) {
		$program_id = $this->uri->segment(4);

		//Rate data
		$data->rate_data = array();
		for ($i=1;$i<=10;$i++) {
			$data->rate_data[$i] = $i;
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

		//detail data
		$data->detail = $this->um->get_detail($univ_id);
		$data->program = $program;

		$data->breadcrumb = anchor(site_url('university/'.$data->detail->university_id),$data->detail->university_name);
		$data->breadcrumb .= ' > '.anchor(site_url('university/'.$data->detail->university_id.'/program/'.$data->program->program_id),$data->program->program_name);
		$data->breadcrumb .= ' > All review';

		$data->review = $this->rm->get_review($program_id,'program');

		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('v_all_program_review',$data);
   		$this->load->view("vhomepage_footer");
	}

	public function all_course_review($id) {
		//Rate data
		$data->rate_data = array();
		for ($i=1;$i<=10;$i++) {
			$data->rate_data[$i] = $i;
		}

		$course_id = $this->uri->segment(6);

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

		//detail data
		$data->detail = $this->um->get_detail($univ_id);
		$data->program = $program;
		$data->course = $course;
		//$data->review = $this->rm->get_review_by_univ($univ_id);

		$data->breadcrumb = anchor(site_url('university/'.$data->detail->university_id),$data->detail->university_name);
		$data->breadcrumb .= ' > '.anchor(site_url('university/'.$data->detail->university_id.'/program/'.$data->program->program_id),$data->program->program_name);
		$data->breadcrumb .= ' > '.anchor(site_url('university/'.$data->detail->university_id.'/program/'.$data->program->program_id.'/course/'.$data->course->course_id),$data->course->course_name);
		$data->breadcrumb .= ' > All review';

		$data->review = $this->rm->get_review($course_id,'course');

		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('v_all_course_review',$data);
   		$this->load->view("vhomepage_footer");
	}

	private function _is_logged_in() {
		if(!$this->session->userdata('user_id')) {
			redirect(site_url('home/log'));
			exit;
		}
	}

	private function _rerank($univ_id) {
		$new_rates = $this->rm->get_univ_rates($univ_id);
		$this->um->update_rank($univ_id,$new_rates);
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