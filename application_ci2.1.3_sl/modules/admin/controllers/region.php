<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Region extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('admin_ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('region_model');


        $this->load->database();

        $this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $this->load->view("vadmin_header");
        $this->load->view("vadmin_region");
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
        $data=$this->region_model->count_regions()->result();
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
            $this->session->set_userdata("region_limit",$start);
        }
        else
        {
            $this->session->set_userdata("region_limit",0);
        }
//        echo $limit."dsds";
        if($limit)
        {
            $this->session->set_userdata("region_offset",$limit);
        }
        else
        {
            $this->session->set_userdata("region_offset",20);
        }
        if($like_index!="")
        {
            $this->session->set_userdata("region_like_index",$like_index);
        }
        else
        {
            $this->session->set_userdata("region_like_index",null);
        }
        if($like_value!="")
        {
            $this->session->set_userdata("region_like_value",$like_value);
        }
        else
        {
            $this->session->set_userdata("region_like_value",null);
        }
        if($where_index!="" && $where_value!="")
        {
            $this->session->set_userdata("region_where", array(''.$where_index.' =\''.$where_value.'\''));

        }
        else
        {
//        echo $where_index." x ".$where_value;
            $this->session->set_userdata("region_where",null);
        }
        if($sidx)
        {
            $this->session->set_userdata("region_order_by",$sidx);
        }
        else
        {
            $this->session->set_userdata("region_order_by","region_id");
        }
        if($sort)
        {
            $this->session->set_userdata("region_order",$sort);
        }
        else
        {
            $this->session->set_userdata("region_order","DESC");
        }
//        echo $this->session->userdata("region_limit")." x ".$this->session->userdata("region_offset");
        $data=$this->region_model->regions($this->session->userdata("region_limit"),$this->session->userdata("region_offset"),$this->session->userdata("region_order_by"),$this->session->userdata("region_order"),$this->session->userdata("region_where"),$this->session->userdata("region_like_index"),$this->session->userdata("region_like_value"))->result();
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
                $str.= "<row id='". $each->region_id."'>";			
                $str.= "<cell>".$each->region_id."</cell>";
                $str.= "<cell><![CDATA[". $each->region_name."]]></cell>";
                $str.= "<cell><![CDATA[<a href='javascript:edit(". $each->region_id.");'>&#10000; edit </a> | <a href='javascript:deleting(". $each->region_id.");'>	&#10006; delete</a>]]></cell>";
                $str.= "</row>";
            }
        }
        $str.= "</rows>";	
        echo $str;
    }
    function load_region_select()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $selected = '';
        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'selected', 'label' => 'Id', 'rules' => 'xss_clean')
                    , array('field' => 'select_id', 'label' => 'Id', 'rules' => 'xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $selected == '';
                $select_id == '';
            } 
            else
            {
                $selected = $this->input->post("selected");
                $select_id = $this->input->post("select_id");
            }
        }

        $data=$this->region_model->all()->result();
        if(count($data)>0)
        {
            $str="<select name='region_id' id='".$select_id."'>";
            foreach($data as $each) 
            {
                $str.= "<option value='". $each->region_id."' ".(($selected==$each->region_id) ? " selected " : " ").">".$each->region_name."</option>";
            }
            $str.="</select>";
        }
        echo $str;
    }
    function deleting()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'region_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Id Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->region_model->delete($this->input->post('region_id'));
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
                    array('field' => 'region_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Id Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $where=array('region_id =\''.$this->input->post('region_id').'\'');
                $data=$this->region_model->regions(0,1,"region_id","DESC",$where ,"","")->result();
                if(count($data)>0)
                {
                    $data_region['region_id'] = $data[0]->region_id;
                    $data_region['region_name'] = $data[0]->region_name;
                    $data_region['region_message'] = "success";
                    $data_region['region_status'] = 'success';
                }
            }
        }
        echo json_encode($data_region);
    }
    function addnew()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $this->load->view("vadmin_header_fancybox");
        $this->load->view("vadmin_region_addnew");
        $this->load->view("vadmin_footer_fancybox");        
    }
    function insert()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'region_name', 'label' => 'Region', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Region Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->region_model->insert($this->input->post('region_name'));
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
                    array('field' => 'region_name', 'label' => 'Region', 'rules' => 'required|xss_clean')
                ,   array('field' => 'region_id', 'label' => 'Region ID', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Region Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->region_model->update($this->input->post('region_name'),$this->input->post('region_id'));
                $data_region['region_message'] = "Successful Insert";
                $data_region['region_status'] = 'success';
            }
        }
        echo json_encode($data_region);
    }
}
?>