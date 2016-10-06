<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review_m extends CI_Model {
	private static $review = 'review';
	private static $users = 'users';
	private static $course = 'courses';
	private static $program = 'programs';
	private static $university = 'universities';
	private static $cp = 'courses_program';

	public function __construct() {
		parent::__construct();
	}

	public function add_review($data) {
		$this->db->insert(self::$review,$data);
	}

	public function get_review_by_univ($univ_id) {
		$this->db->where(array('item_id'=>$univ_id,'type'=>'university'));

		if($query = $this->db->get(self::$review)) {
			$final =array();
			$i = 0;

			foreach ($query->result() as $r) {
				$final[$i] = $r;
				$final[$i]->star = $this->count_star($r->rates);
				$final[$i]->my_review = $this->count_user_review($r->user_id);	
				$i++;
			}

			return $final;
		}

		return FALSE;
	}

	public function detail($item_id) {
		$this->db->join(self::$users,self::$users.'.id = '.self::$review.'.user_id','left');
		$this->db->where('review_id',$item_id);
		$this->db->limit(1);

		if($query = $this->db->get(self::$review)) {
			$r = $query->row();
			$r->link = $this->_build_link($r->type,$item_id);
			$r->star = floor($r->rates/2);

			return $r;
		}

		return FALSE;
	}

	public function get_review_by_user($user_id) {
		$this->db->where(array('user_id'=>$user_id));

		if($query = $this->db->get(self::$review)) {
			$final =array();
			$i = 0;

			foreach ($query->result() as $r) {
				$final[$i] = $r;
				$final[$i]->star = $this->count_star($r->rates);
				$final[$i]->link = $this->_build_link($r->type,$r->review_id);
				$i++;
			}

			return $final;
		}

		return FALSE;
	}

	public function get_review($item_id,$type,$limit = FALSE,$offset = FALSE) {
		$this->db->join(self::$users,self::$users.'.id = '.self::$review.'.user_id');
		$this->db->where(array('item_id'=>$item_id,'type'=>$type));
		$this->db->order_by('review_id','DESC');

		if ($limit !== FALSE && $offset !== FALSE) {
			$this->db->limit($limit,$offset);
		}

		if($query = $this->db->get(self::$review)) {
			$final =array();
			$i = 0;

			foreach ($query->result() as $r) {
				$final[$i] = $r;
				$final[$i]->star = $this->count_star($r->rates);
				$final[$i]->my_review = $this->count_user_review($r->user_id);
				$i++;
			}

			return $final;
		}

		return FALSE;
	}

	public function get_rotd() {
		$this->db->join(self::$users,self::$users.'.id = '.self::$review.'.user_id');
		$this->db->limit(1);
		$this->db->order_by('review_id','random');

		if($query = $this->db->get(self::$review)) {
			$ret = $query->row();
			$ret->star =  $this->count_star($ret->rates);
			$ret->my_review = $this->count_user_review($ret->user_id);
			$ret->link = $this->_build_link($ret->type,$ret->review_id);
			
			return $ret;
		}

		return FALSE;
	}

	public function get_recent() {
		$this->db->join(self::$users,self::$users.'.id = '.self::$review.'.user_id');
		$this->db->limit(3);
		$this->db->order_by('review_id','desc');

		if($query = $this->db->get(self::$review)) {
			$i=0;
			$ret = array();
			foreach ($query->result() as $data) {
				$ret[$i] = $data;
				$ret[$i]->link = $this->_build_link($data->type,$data->review_id);
				$i++;
			}

			return $ret;
		}

		return FALSE;
	}

	public function get_top_reviewer() {
		$this->db->select('*, COUNT(*) as review_numb');
		$this->db->join(self::$users,self::$users.'.id = '.self::$review.'.user_id');
		$this->db->group_by('user_id');
		$this->db->order_by('review_numb','desc');
		$this->db->limit(15);

		if($query = $this->db->get(self::$review)) {
			return $query->result();
		}

		return FALSE;
	}

	public function get_univ_rates($univ_id) {
		$query = $this->db->query('SELECT *, AVG(rates) as avg_rates FROM '.self::$review.' WHERE item_id = '.$univ_id.' AND type = "university"' );

		$ret = 0;

		if($result = $query->row()) {
			$ret = floor($result->avg_rates);
		}

		return $ret;
	}

	private function count_user_review($user_id) {
		$this->db->where('user_id',$user_id);
		if($count = $this->db->get(self::$review)) {
			return count($count->result());
		}

		return '0';
	}

	private function count_star($rate) {
		return ceil(($rate/2));
	}

	private function _build_link($type,$id) {
		switch($type) {
			case 'course':
				$this->db->join(self::$cp,self::$cp.'.course_id = '.self::$review.'.item_id');
				$this->db->join(self::$course,self::$course.'.course_id = '.self::$review.'.item_id');
				$this->db->join(self::$program,self::$program.'.program_id = '.self::$cp.'.program_id');
				$this->db->join(self::$university,self::$university.'.university_id = '.self::$program.'.university_id');
				break;
			case 'program':
				$this->db->join(self::$program,self::$program.'.program_id = '.self::$review.'.item_id');
				$this->db->join(self::$university,self::$university.'.university_id = '.self::$program.'.university_id');
				break;
			case 'university':
				$this->db->join(self::$university,self::$university.'.university_id = '.self::$review.'.item_id');
				break;
			default:
				$this->db->join(self::$university,self::$university.'.university_id = '.self::$review.'.item_id');
				break;
		}

		$this->db->where(array('review_id'=>$id));
		$this->db->limit(1);

		if($query = $this->db->get(self::$review)) {
			$r = $query->row();

			switch ($type) {
				case 'course':
					$clink = anchor(site_url('university/'.$r->university_id.'/program/'.$r->program_id.'/course/'.$r->course_id),$r->course_name);
					$ulink = anchor(site_url('university/'.$r->university_id),$r->university_name);
					$plink = anchor(site_url('university/'.$r->university_id.'/program/'.$r->program_id),$r->program_name);
					$link = $clink.' of '.$plink.' programs on '.$ulink;
					break;

				case 'program':
					$ulink = anchor(site_url('university/'.$r->university_id),$r->university_name);
					$plink = anchor(site_url('university/'.$r->university_id.'/program/'.$r->program_id),$r->program_name);
					$link = $plink.' programs on '.$ulink;
					break;

				case 'university':
					$link = anchor(site_url('university/'.$r->university_id),$r->university_name);
					break;

				default:
					# code...
					break;
			}

			return $link;
		}

		return '-';
	}
}