<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class University_m extends CI_Model {

	private static $univ = 'universities';
	private static $course = 'courses';
	private static $program = 'programs';
	private static $review = 'review';
	private static $countries = 'countries';
	private static $location = 'universities_location';
	private static $category = 'universities_categories';
	private static $cp = 'courses_program';


	public function __construct() {
		parent::__construct();
	}

	public function search($type,$keyword,$limit,$offset) {
		switch ($type) {
			case 'university':
				return $this->search_university($keyword,$limit,$offset);
				break;

			case 'program':
				return $this->search_program($keyword,$limit,$offset);
				break;

			case 'course':
				return $this->search_course($keyword,$limit,$offset);
				break;
			
			default:
				return $this->search_university($keyword,$limit,$offset);
				break;
		}
	}

	private function search_university($keyword,$limit,$offset) {
		if($limit) {
			$this->db->limit($limit,$offset);
		}

		if (is_array($keyword)) {
			$first = true;
			foreach ($keyword as $k) {
				if($first) {
					$this->db->like('university_name',$k);
				} else {
					$this->db->or_like('university_name',$k);
				}
				$firs = false;
			}
		} else {
			$this->db->like('university_name',$keyword);
		}

		if ($q = $this->db->get(self::$univ)) {
			$i = 0;
			$ret = array();

			foreach ($q->result() as $r) {
				$ret[$i] = $this->_improve_search($r,'university');
				$i++;
			}

			return $ret;
		}

		return FALSE;
	}

	private function search_program($keyword,$limit,$offset) {
		if($limit) {
			$this->db->limit($limit,$offset);
		}

		if (is_array($keyword)) {
			$first = true;
			foreach ($keyword as $k) {
				if($first) {
					$this->db->like('program_name',$k);
				} else {
					$this->db->or_like('program_name',$k);
				}
				$firs = false;
			}
		} else {
			$this->db->like('program_name',$keyword);
		}

		if ($q = $this->db->get(self::$program)) {
			$i = 0;
			$ret = array();

			foreach ($q->result() as $r) {
				$ret[$i] = $this->_improve_search($r,'program');
				$i++;
			}

			return $ret;
		}

		return FALSE;
	}

	private function search_course($keyword,$limit,$offset) {
		if($limit) {
			$this->db->limit($limit,$offset);
		}

		if (is_array($keyword)) {
			$first = true;
			foreach ($keyword as $k) {
				if($first) {
					$this->db->like('course_name',$k);
				} else {
					$this->db->or_like('course_name',$k);
				}
				$firs = false;
			}
		} else {
			$this->db->like('course_name',$keyword);
		}

		$this->db->join(self::$cp,self::$cp.'.course_id = '.self::$course.'.course_id');
		$this->db->order_by(self::$course.'.course_id');
		//$this->db->join(self::$program,self::$program.'.program_id = '.self::$cp.'.program_id','left');

		if ($q = $this->db->get(self::$course)) {
			$i = 0;
			$ret = array();

			$oldId = null;

			foreach ($q->result() as $r) {
				if($oldId == $r->course_id) {
					continue;
				}

				$oldId = $r->course_id;

				$ret[$i] = $this->_improve_search($r,'course');
				$i++;
			}

			return $ret;
		}

		return FALSE;
	}

	public function new_search($keyword,$limit,$offset) {
		if($limit) {
			$this->db->limit($limit,$offset);
		}

		$this->db->select(self::$univ.'.*,'.self::$program.'.*');
		if (is_array($keyword)) {
			$first = true;
			foreach ($keyword as $k) {
				if($first) {
					$this->db->like('university_name',$k);
				} else {
					$this->db->or_like('university_name',$k);
				}
				$this->db->or_like('program_name',$k);
				$first = false;
			}
		} else {
			$this->db->like('university_name',$keyword);
			$this->db->or_like('program_name',$keyword);
		}

		//$this->db->group_by('university_id');

		$this->db->from(self::$program);
		if ($q = $this->db->get(self::$univ)) {
			$i = 0;
			$ret = array();

			foreach ($q->result() as $r) {
				$ret[$i] = $this->_improve_result($r);
				$i++;
			}

			return $ret;
		}

		return FALSE;
	}

	public function get_all() {
		if($query = $this->db->get(self::$univ)) {
			return $query->result();
		}

		return FALSE;
	}

	public function count_all() {
		if($query = $this->db->get(self::$univ)) {
			return $query->num_rows();
		}

		return FALSE;	
	}

	public function get_by_filter ($country_id,$short,$limit,$offset) {
		$this->db->join(self::$location,self::$location.'.university_id = '.self::$univ.'.university_id','left');
		//$this->db->join(self::$category,self::$category.'.category_id = '.self::$univ.'.category_id','right');
		$this->db->group_by(self::$univ.'.university_id');

		if($country_id != FALSE && $country_id != 'all' ) {
			$this->db->where(self::$location.'.country_id',$country_id);
		}

		if($short != FALSE && $short != 'none') {
			if($short == 'rank') {
				$this->db->order_by($short,'DESC');
			} else {
				$this->db->where(self::$univ.'.category_id',$short);		
			}
		}

		if($limit) {
			$this->db->limit($limit,$offset);
		}

		if ($query = $this->db->get(self::$univ)) {
			//return $query->result();
			$ret = array();
			$i = 0;
			foreach ($query->result() as $r) {
				$ret[$i] = $this->_improve_result($r);
				$i++;
			}

			return $ret;
		}

		return FALSE;
	}

	public function get_detail($id) {
		$this->db->where('university_id',$id);
		$this->db->limit('1');

		if( $query = $this->db->get(self::$univ) ) {
			$result = $this->_improve_result($query->row(),TRUE);
			return $result;
		}

		return FALSE;
	}

	public function update_rank($univ_id,$rank) {
		$this->db->where('university_id',$univ_id);
		$this->db->update(self::$univ,array('rank'=>$rank));
	}

	public function get_categories($array=FALSE) {
		if($query = $this->db->get(self::$category)) {
			if($array) {
				return $query->result_array();
			} else {
				return $query->result();
			}
		}

		return FALSE;
	}

	private function _get_course($univ_id) {
		$this->db->get_where('university_id',$univ_id);

		if( $query = $this->db->get(self::$course)) {
			return $query->result();
		}

		return FALSE;
	}

	private function _get_program($univ_id) {
		$this->db->where('university_id',$univ_id);

		if( $query = $this->db->get(self::$program)) {
			return $query->result();
		}

		return FALSE;
	}

	private function _review($univ_id) {
		$query = $this->db->query('SELECT *, AVG(rates) as avg_rates, COUNT(rates) as review  FROM '.self::$review.' WHERE item_id = '.$univ_id.' AND type = "university"' );

		$ret->rates = 0;
		$ret->review = 0;

		if($result = $query->row()) {
			$ret->rates = floor($result->avg_rates);
			$ret->review = $result->review;
		}

		return $ret;
	}

	private function _review_search($id, $type) {
		$query = $this->db->query('SELECT *, AVG(rates) as avg_rates, COUNT(rates) as review  FROM '.self::$review.' WHERE item_id = '.$id.' AND type = "'.$type.'"' );

		$ret->rates = 0;
		$ret->review = 0;

		if($result = $query->row()) {
			$ret->rates = floor($result->avg_rates);
			$ret->review = $result->review;
		}

		return $ret;
	}

	private function _improve_result($r,$program = FALSE) {
		$ret = $r;

		$review = $this->_review($r->university_id);

		$ret->rates = $review->rates;
		$ret->review = $review->review;
		$ret->star = floor($review->rates/2);
		$ret->image_url = $this->_get_image_url($r->university_id);

		if($program) {
			$ret->program = $this->_get_program($r->university_id);
		}

		return $ret;
	}

	private function _improve_search($r,$type) {
		$ret = $r;

		switch ($type) {
			case 'university':
				$ret->name = $r->university_name;
				$ret->description = $r->university_description;
				$ret->item_id = $r->university_id;
				$ret->link = $this->_build_link('university',$r->university_id);
				break;

			case 'program':
				$ret->name = $r->program_name;
				$ret->description = $r->program_description;
				$ret->item_id = $r->program_id;
				$ret->link = $this->_build_link('program',$r->program_id);
				break;

			case 'course':
				$ret->name = $r->course_name;
				$ret->description = $r->course_description;
				$ret->item_id = $r->course_id;
				$ret->link = $this->_build_link('course',$r->course_id);
				break;
			
			default:
				$ret->name = $r->university_name;
				$ret->description = $r->university_description;
				$ret->item_id = $r->university_id;
				//$ret->link = $this->_build_link('university',$r->university_id);
				break;
		}

		$review = $this->_review_search($ret->item_id,$type);

		$ret->rates = $review->rates;
		$ret->review = $review->review;
		$ret->star = floor($review->rates/2);
		$ret->image_url = $this->_get_image_url($r->university_id);

		return $ret;
	}

	private function _build_link($type,$id) {
		
		$this->db->limit(1);

		switch($type) {
			case 'university':
				$this->db->where('university_id',$id);
				$query = $this->db->get(self::$univ);
				break;

			case 'program':
				$this->db->join(self::$univ,self::$univ.'.university_id = '.self::$program.'.university_id');
				$this->db->where(array('program_id'=>$id));
				$query = $this->db->get(self::$program);
				break;

			case 'course':
				$this->db->join(self::$cp,self::$cp.'.course_id = '.self::$course.'.course_id','left');
				$this->db->join(self::$program,self::$program.'.program_id = '.self::$cp.'.program_id','left');
				$this->db->join(self::$univ,self::$univ.'.university_id = '.self::$course.'.university_id');
				$this->db->where(self::$course.'.course_id',$id);
				$query = $this->db->get(self::$course);
				break;
			
			default:
				$this->db->where('university_id',$id);
				$query = $this->db->get(self::$univ);
				break;
		}

		

		if($query) {
			$r = $query->row();

			switch ($type) {
				case 'course':
					$link = anchor(site_url('university/'.$r->university_id.'/program/'.$r->program_id.'/course/'.$r->course_id),$r->course_name);
					break;

				case 'program':
					$link = anchor(site_url('university/'.$r->university_id.'/program/'.$r->program_id),$r->program_name);
					break;

				case 'university':
					$link = anchor(site_url('university/'.$r->university_id),$r->university_name);
					break;

				default:
					$link = anchor(site_url('university/'.$r->university_id),$r->university_name);
					break;
			}

			return $link;
		}

		return '-';
	}

	private function _get_image_url($univ_id) {
		$structure = 'upload/universities/'.$univ_id.'/';
		$ret = site_url('upload/dummy/large.jpg');

		if (is_dir($structure)) {
			if ($handle = opendir($structure)) {
				while (false !== ($entry = readdir($handle))) {
					if($entry!="." && $entry!='..' && $entry!='thumb') {
						$ret = site_url($structure.$entry);
					}
				}
			}
		}

		return $ret;
	}

}