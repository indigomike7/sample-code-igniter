<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Program_m extends CI_Model {

	private static $program = 'programs';
	private static $cp = 'courses_program';
	private static $univ = 'universities';
	private static $course = 'courses';
	private static $lecture = 'courses_lecturer';
	private static $review = 'review';

	public function __construct() {
		parent::__construct();
	}

	public function detail($univ_id,$program_id) {
		$this->db->where(array('university_id'=>$univ_id,'program_id'=>$program_id));

		if($query = $this->db->get(self::$program)) {
			$ret = $query->row();
			$ret->course = $this->get_course($program_id);
			$ret->p_review = $this->_review($program_id);
			$ret->star = floor($ret->p_review->rates/2);

			return $ret;
		}

		return FALSE;
	}

	public function top_five() {
		$this->_short();
		$this->db->order_by('rates','DESC');
		return $this->db->get(self::$program)->result();
	}

	public function bottom_five() {
		$this->_short();
		$this->db->order_by('rates','ASC');
		return $this->db->get(self::$program)->result();
	}

	private function _short() {
		$this->db->select('universities.*,programs.*, (SELECT AVG(rates) FROM review WHERE item_id = programs.program_id AND type = "program") as "rates", (SELECT COUNT(rates) FROM review WHERE item_id = programs.program_id AND type = "program") as reviews ');
		$this->db->join(self::$univ,self::$univ.'.university_id = '.self::$program.'.university_id ');	
		$this->db->limit(5);
	}

	private function get_course($program_id) {
		$this->db->where('program_id',$program_id);
		$this->db->join(self::$course, self::$course.'.course_id = '.self::$cp.'.course_id');
		$this->db->join(self::$lecture, self::$lecture.'.course_id = '.self::$cp.'.course_id');

		if( $query = $this->db->get(self::$cp)) {
			return $query->result();
		}

		return FALSE;
	}

	private function _review($program_id) {
		$query = $this->db->query('SELECT AVG(rates) as avg_rates, COUNT(rates) as review  FROM '.self::$review.' WHERE item_id = '.$program_id.' AND type = "program"' );

		$ret->rates = 0;
		$ret->review = 0;

		if($result = $query->row()) {
			$ret->rates = floor($result->avg_rates);
			$ret->review = $result->review;
		}

		return $ret;
	}

}