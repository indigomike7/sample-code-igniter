<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_m extends CI_Model {
	private static $course = 'courses';
	private static $program = 'programs';
	private static $univ = 'universities';
	private static $lecture = 'courses_lecturer';
	private static $cp = 'courses_program';
	private static $review = 'review';

	public function __construct()
	{
		parent::__construct();
	}
	
	public function detail($univ_id, $course_id) {
		$this->db->where(array('university_id'=>$univ_id, self::$course.'.course_id'=>$course_id));
		$this->db->join(self::$lecture,self::$lecture.'.course_id = '.self::$course.'.course_id');

		if ($query = $this->db->get(self::$course)) {
			$ret = $query->row();

			$ret->c_review = $this->_review($course_id);
			$ret->star = floor($ret->c_review->rates/2);

			return $ret;
		}

		return FALSE;
	}

	public function top_five() {
		$this->_short();
		$this->db->order_by('rates','DESC');
		return $this->db->get(self::$course)->result();
	}

	public function bottom_five() {
		$this->_short();
		$this->db->order_by('rates','ASC');
		return $this->db->get(self::$course)->result();
	}

	private function _short() {
		$this->db->join(self::$cp,self::$cp.'.course_id = '.self::$course.'.course_id');
		$this->db->join(self::$program,self::$program.'.program_id = '.self::$cp.'.program_id');
		$this->db->join(self::$univ,self::$univ.'.university_id = '.self::$course.'.university_id');
		$this->db->select(self::$univ.'.*,'.self::$program.'.*,'.self::$cp.'.*, courses.*, (SELECT AVG(rates) FROM review WHERE item_id = courses.course_id AND type = "course") as "rates", (SELECT COUNT(rates) FROM review WHERE item_id = courses.course_id AND type = "course") as reviews ');
		$this->db->limit(5);
	}

	private function _review($course_id) {
		$query = $this->db->query('SELECT AVG(rates) as avg_rates, COUNT(rates) as review  FROM '.self::$review.' WHERE item_id = '.$course_id.' AND type = "course"' );

		$ret->rates = 0;
		$ret->review = 0;

		if($result = $query->row()) {
			$ret->rates = floor($result->avg_rates);
			$ret->review = $result->review;
		}

		return $ret;
	}
}