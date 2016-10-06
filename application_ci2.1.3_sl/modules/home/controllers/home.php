<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Home extends MX_Controller {

	private $data_header = FALSE;
	private $data;

	public function __construct() {
		parent::__construct();

		$this->load->model('university_m','um');
		$this->load->model('program_m','pm');
		$this->load->model('course_m','cm');
		$this->load->helper('inflector');
    $this->load->helper('form');

		$site_title=$this->details('SITE_TITLE');
		$this->data_header['site_title']=$site_title['setting_desc'];

		$site_meta_keyword=$this->details('SITE_META_KEYWORD');
		$this->data_header['site_meta_keyword']=$site_meta_keyword['setting_desc'];

		$site_meta_description=$this->details('SITE_META_DESCRIPTION');
		$this->data_header['site_meta_description']=$site_meta_description['setting_desc'];

		$site_slogan=$this->details('SITE_SLOGAN');
		$this->data_header['site_slogan']=$site_slogan['setting_desc'];
	}
 
   	public function index()
   	{
    	$this->load->view('vhome');
   	}

   	public function categories() {

   		$base_url = site_url('home/categories');
   		$uri_segment = 3;
   		$limit = 6;
   		$offset = 0;
   		$country_id = FALSE;
   		$short = FALSE;

   		$data->countries=$this->countries();
      $data->categories = array();

      $data->categories['none'] = 'None';
      $data->categories['rank'] = 'Rank';

      if($categories = $this->um->get_categories()) {
        foreach ($categories as $cat) {
            $data->categories[$cat->category_id] = $cat->category_name; 
        }
      }
      
        $data->top_five_p = $this->pm->top_five();
        $data->bottom_five_p = $this->pm->bottom_five();
        $data->top_five_c = $this->cm->top_five();
        $data->bottom_five_c = $this->cm->bottom_five();

        $data->all = $this->um->count_all();        

        $u_total = $this->uri->total_segments();

       	if($u_total >= 6) {
       		$country_id = $this->uri->segment(4);
     			$short = $this->uri->segment(6);
     			$base_url = site_url('home/categories/countries/'.$country_id.'/short/'.$short.'/offset');
     			$uri_segment = 8;
     			//$offset = $this->uri->segment($uri_segment);
     			$data->all = count($this->um->get_by_filter($country_id,$short,FALSE,FALSE)); 
       	}

        $offset = $this->uri->segment($uri_segment);

       	$data->universities = $this->um->get_by_filter($country_id,$short,$limit,$offset);
       	$data->current_country = $country_id;
       	$data->current_short = $short;

        $this->load->library('pagination');
        $config['base_url'] = $base_url;
        $config['total_rows'] = $data->all;
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri_segment;

        $this->pagination->initialize($config);


        $this->load->view("vhomepage_header",$this->data_header);
        $this->load->view('vhomepage_categories',$data);
        $this->load->view("vhomepage_footer");
   	}

   	function countries()
    {
        $this->load->model('admin/country_model');
        $where=array();
        $data=$this->country_model->all(0,1,"country_id","DESC",$where ,"","")->result();
        if(count($data)>0)
        {
            for($i=0;$i<count($data);$i++)
            {
                $data_countries[] = $data[$i];
            }
        }
        return $data_countries;        
    }

   	public function search() {

   		/*
   		if($this->input->post('query') == '' || $this->input->post('query') == NULL ) {
   			redirect (base_url());
   			exit;
   		}*/
   		if(isset($_POST['query'])) {
   			if($this->input->post('query') == '' || $this->input->post('query') == NULL ) {
	   			redirect (base_url());
	   			exit;
	   		} else {
				$query = $this->input->post('query');

				$clear = preg_replace('/[^a-zA-Z0-9\s\x20]/', '_', strip_tags(html_entity_decode($query)));;

				$clear = underscore($clear);

        if(isset($_POST['filter'])) {
          redirect(site_url('home/search/'.$clear.'/filter/'.$this->input->post('filter').'/offset'));  
        } else {
          redirect(site_url('home/search/'.$clear.'/filter/university/offset'));
        }
				
	   		}	
   		}

      $limit = 5;
      $uri_offset = 7;
      $offset = $this->uri->segment($uri_offset); 
      $type = $this->uri->segment(5);

      switch ($this->uri->segment(5)) {
        case 'program':
          $type = 'program';
          break;

        case 'course':
          $type = 'course';
          break;
        
        case 'university':
          $type = 'university';
          break;

        default:
          $type = 'university';
          break;
      }

   		$uri = $this->uri->segment(3);
   		$this->data->phrase = preg_replace('/[^a-zA-Z0-9\s\x20]/', ' ', strip_tags(html_entity_decode($uri)));;

   		$keyword = explode(' ',$this->data->phrase);

   		$all = count($this->um->search($type,$keyword,FALSE,FALSE));

      $this->load->library('pagination');
      $config['base_url'] = site_url('home/search/'.$uri.'/offset');
      $config['total_rows'] = $all;
      $config['per_page'] = $limit;
      $config['uri_segment'] = $uri_offset;

      $this->pagination->initialize($config);

   		$this->data->search = $this->um->search($type,$keyword,$limit,$offset);

   		$this->load->view("vhomepage_header",$this->data_header);
   		$this->load->view('vsearch',$this->data);
   		$this->load->view("vhomepage_footer");	
   	}

    public function top_reviewer() {
      $this->load->model('review_m','rm');

      $this->data->top_reviewer = $this->rm->get_top_reviewer();

      $this->load->view("vhomepage_header",$this->data_header);
      $this->load->view('vtop_reviewer',$this->data);
      $this->load->view("vhomepage_footer");
    }

    public function contributor($user_id) {
      $this->load->model('user/user_ion_auth_model','ion_m');
      $this->load->model('review_m','rm');

      $this->data->user_data = $this->ion_m->user($user_id)->result();
      $this->data->user_reviews = $this->rm->get_review_by_user($user_id);
      //print_r($this->data->r);

      $this->load->view("vhomepage_header",$this->data_header);
      $this->load->view('vcontributor',$this->data);
      $this->load->view("vhomepage_footer");
    }

  public function details($setting_name)
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
