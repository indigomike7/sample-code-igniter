<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Rating extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('admin_ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('rating_model');


        $this->load->database();

        $this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $this->load->view("vadmin_header");
        $this->load->view("vadmin_rating");
        $this->load->view("vadmin_footer");
    }
    function loadgrid()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        ob_clean();
        if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) 
        {
            header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
            header("Content-type: text/xml;charset=utf-8");
        }
        echo "<?xml version='1.0' encoding='utf-8'?>\n";
        parse_str(substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'],'?')+1,strlen($_SERVER['REQUEST_URI'])-strpos($_SERVER['REQUEST_URI'],'?')),$_GET);                
        $page = $this->security->xss_clean($_GET['page']);  // get the requested page
        $limit = $this->security->xss_clean($_GET['rows']); // get how many rows we want to have into the grid
        $sidx = $this->security->xss_clean($_GET['sidx']);  // get index row - i.e. user click to sort
        $sort = $this->security->xss_clean($_GET['sord']);  // get the direction
        $like_index = $this->security->xss_clean($_GET['like_index']);
        $like_value = $this->security->xss_clean($_GET['like_value']);
        $where_index = $this->security->xss_clean($_GET['where_index']);
        $where_value = $this->security->xss_clean($_GET['where_value']);
        if(!$sidx) $sidx =1;
        $data=$this->rating_model->count_ratings()->result();
        $count = $data[0]->count;
        if( $count >0 ) {
                $total_pages = ceil($count/$limit);
        } else {
                $total_pages = 0;
        }
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit; // do not put $limit*($page - 1)
        if($start)
        {
            $this->session->set_userdata("rating_limit",$start);
        }
        else
        {
            $this->session->set_userdata("rating_limit",0);
        }
//        echo $limit."dsds";
        if($limit)
        {
            $this->session->set_userdata("rating_offset",$limit);
        }
        else
        {
            $this->session->set_userdata("rating_offset",20);
        }
        if($like_index!="")
        {
            $this->session->set_userdata("rating_like_index",$like_index);
        }
        else
        {
            $this->session->set_userdata("rating_like_index",null);
        }
        if($like_value!="")
        {
            $this->session->set_userdata("rating_like_value",$like_value);
        }
        else
        {
            $this->session->set_userdata("rating_like_value",null);
        }
        if($where_index!="" && $where_value!="")
        {
            $this->session->set_userdata("rating_where", array(''.$where_index.' =\''.$where_value.'\''));

        }
        else
        {
//        echo $where_index." x ".$where_value;
            $this->session->set_userdata("rating_where",null);
        }
        if($sidx)
        {
            $this->session->set_userdata("rating_order_by",$sidx);
        }
        else
        {
            $this->session->set_userdata("rating_order_by","region_id");
        }
        if($sort)
        {
            $this->session->set_userdata("rating_order",$sort);
        }
        else
        {
            $this->session->set_userdata("rating_order","DESC");
        }
//        echo $this->session->userdata("region_limit")." x ".$this->session->userdata("region_offset");
        $data=$this->rating_model->ratings($this->session->userdata("rating_limit"),$this->session->userdata("rating_offset"),$this->session->userdata("rating_order_by"),$this->session->userdata("rating_order"),$this->session->userdata("rating_where"),$this->session->userdata("rating_like_index"),$this->session->userdata("rating_like_value"))->result();
//        var_dump($data);
//        echo count($data);
        $str= "<rows>";
        $str.= "<page>".$page."</page>";
        $str.= "<total>".$total_pages."</total>";
        $str.= "<records>".$count."</records>";
        if(count($data)>0)
        {
            // be sure to put text data in CDATA
            foreach($data as $each) 
            {
                $str.= "<row id='". $each->review_id."'>";			
                $str.= "<cell>".$each->review_id."</cell>";
                $str.= "<cell><![CDATA[". $each->title."]]></cell>";
                $str.= "<cell><![CDATA[<a href='javascript:edit(". $each->review_id.");'>&#10000; edit </a> | <a href='javascript:deleting(". $each->review_id.");'>	&#10006; delete</a>]]></cell>";
                $str.= "</row>";
            }
        }
        $str.= "</rows>";	
        echo $str;
    }
    function deleting()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'review_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['review_message'] = "Id Required";
                $data_region['review_status'] = 'error';
            } 
            else
            {
                $result=$this->rating_model->delete($this->input->post('review_id'));
                $data_region['review_message'] = "Successful Deleting";
                $data_region['review_status'] = 'success';
            }
        }
        echo json_encode($data_region);
    }
    function details()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'review_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['review_message'] = "Id Required";
                $data_region['review_status'] = 'error';
            } 
            else
            {
                $where=array('review_id =\''.$this->input->post('review_id').'\'');
                $data=$this->rating_model->ratings(0,1,"review_id","DESC",$where ,"","")->result();
                if(count($data)>0)
                {
                    $data_region['review_id'] = $data[0]->review_id;
                    $data_region['title'] = $data[0]->title;
                    $data_region['review'] = $data[0]->review;
                    $data_region['review_message'] = "success";
                    $data_region['review_status'] = 'success';
                }
            }
        }
        echo json_encode($data_region);
    }
    function update()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'title', 'label' => 'Title', 'rules' => 'required|xss_clean')
                ,   array('field' => 'review', 'label' => 'Title', 'rules' => 'required|xss_clean')
                ,   array('field' => 'review_id', 'label' => 'Review ID', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['review_message'] = "Region Required";
                $data_region['review_status'] = 'error';
            } 
            else
            {
                $result=$this->rating_model->update($this->input->post('title'),$this->input->post('review'),$this->input->post('review_id'));
                $data_region['review_message'] = "Successful Update";
                $data_region['review_status'] = 'success';
            }
        }
        echo json_encode($data_region);
    }
}
?>