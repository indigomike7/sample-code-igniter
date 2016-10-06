<?php defined('BASEPATH') OR exit('No direct script access allowed');
class City extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('admin_ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('city_model');


        $this->load->database();

        $this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $this->load->view("vadmin_header");
        $this->load->view("vadmin_city");
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
        $data=$this->city_model->count_cities()->result();
//        die($data[0]->count);
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
            $this->session->set_userdata("city_limit",$start);
        }
        else
        {
            $this->session->set_userdata("city_limit",0);
        }
        if($limit)
        {
            $this->session->set_userdata("city_offset",$limit);
        }
        else
        {
            $this->session->set_userdata("city_offset",20);
        }
        if($like_index!="")
        {
            $this->session->set_userdata("city_like_index",$like_index);
        }
        else
        {
            $this->session->set_userdata("city_like_index",null);
        }
        if($like_value!="")
        {
            $this->session->set_userdata("city_like_value",$like_value);
        }
        else
        {
            $this->session->set_userdata("city_like_value",null);
        }
        if($where_index!="" && $where_value!="")
        {
            $this->session->set_userdata("city_where",array($where_index => $where_value));
        }
        else
        {
//        echo $where_index." x ".$where_value;
            $this->session->set_userdata("city_where",null);
        }
        if($sidx)
        {
            $this->session->set_userdata("city_order_by",$sidx);
        }
        else
        {
            $this->session->set_userdata("city_order_by","region_id");
        }
        if($sort)
        {
            $this->session->set_userdata("city_order",$sort);
        }
        else
        {
            $this->session->set_userdata("city_order","DESC");
        }
//        echo $this->session->userdata("region_limit")." x ".$this->session->userdata("region_offset");
//        die($this->session->userdata("city_limit").$this->session->userdata("city_offset"));
//                die("xxx");
        $data=$this->city_model->cities($this->session->userdata("city_limit"),$this->session->userdata("city_offset"),$this->session->userdata("city_order_by"),$this->session->userdata("city_order"),$this->session->userdata("city_where"),$this->session->userdata("city_like_index"),$this->session->userdata("city_like_value"))->result();
//        die(var_dump($data));
//        echo count($data);
        $str= "<rows>";
        $str.= "<page>".$page."</page>";
        $str.= "<total>".$total_pages."</total>";
        $str.= "<records>".$count."</records>";
//        echo count($data);
        if(count($data)>0)
        {
            // be sure to put text data in CDATA
            foreach($data as $each) 
            {
                $str.= "<row id='". $each->city_id."'>";			
                $str.= "<cell>".$each->city_id."</cell>";
                $str.= "<cell><![CDATA[". $each->city_name."]]></cell>";
                $str.= "<cell><![CDATA[". $each->country_name."]]></cell>";
                $str.= "<cell><![CDATA[<a href='javascript:edit(". $each->city_id.");'>&#10000; edit </a> | <a href='javascript:deleting(". $each->city_id.");'>	&#10006; delete</a>]]></cell>";
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
                    array('field' => 'city_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Id Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->city_model->delete($this->input->post('city_id'));
                $data_region['region_message'] = "Successful Deleting";
                $data_region['region_status'] = 'success';
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
                    array('field' => 'city_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Id Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $where=array('city_id =\''.$this->input->post('city_id').'\'');
                $data=$this->city_model->cities(0,1,"city_id","DESC",$where ,"","")->result();
                if(count($data)>0)
                {
                    $data_region['city_id'] = $data[0]->city_id;
                    $data_region['city_name'] = $data[0]->city_name;
                    $data_region['country_fips'] = $data[0]->country_fips;
                    $data_region['country_name'] = $data[0]->country_name;
                    $data_region['region_message'] = "success";
                    $data_region['region_status'] = 'success';
                }
            }
        }
        echo json_encode($data_region);
    }
    function insert()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'country_fips', 'label' => 'Country', 'rules' => 'required|xss_clean')
                    ,array('field' => 'city_name', 'label' => 'City', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "City Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->city_model->insert($this->input->post('city_name'),$this->input->post('country_fips'));
                $data_region['region_message'] = "Successful Insert";
                $data_region['region_status'] = 'success';
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
                    array('field' => 'country_fips', 'label' => 'Country', 'rules' => 'required|xss_clean')
                    ,array('field' => 'city_name', 'label' => 'City', 'rules' => 'required|xss_clean')
                    ,array('field' => 'city_id', 'label' => 'City ID', 'rules' => 'required|xss_clean')
             );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "City Data Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->city_model->update($this->input->post('city_name'),$this->input->post('country_fips'),$this->input->post('city_id'));
                $data_region['region_message'] = "Successful Update";
                $data_region['region_status'] = 'success';
            }
        }
        echo json_encode($data_region);
    }
}
?>