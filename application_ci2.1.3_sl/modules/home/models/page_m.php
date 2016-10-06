<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_m extends CI_Model {
	private static $page = 'page';
	private static $category = 'page_categories';

	public function __construct()
	{
		parent::__construct();
	}

	public function get_detail($page_id) {
		$this->db->join(self::$category,self::$category.'.category_id = '.self::$page.'.category_id');
		$this->db->where('page_id',$page_id);

		if($query = $this->db->get(self::$page)) {
			return $query->row();
		}

		return FALSE;
	}

	public function get_by_slug($slug) {
		$this->db->join(self::$category,self::$category.'.category_id = '.self::$page.'.category_id');
		$this->db->where('page_seo_title',$slug);

		if($query = $this->db->get(self::$page)) {
			return $query->row();
		}

		return FALSE;
	}
}

/* End of file page_m.php */
/* Location: ./application_ci2.1.3_sl/modules/home/models/page_m.php */