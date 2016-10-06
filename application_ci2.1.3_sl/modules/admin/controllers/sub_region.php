<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Sub_region extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('admin_ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('sub_region_model');


        $this->load->database();

        $this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $this->load->view("vadmin_header");
        $this->load->view("vadmin_sub_region");
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
        $data=$this->sub_region_model->count_sub_regions()->result();
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
            $this->session->set_userdata("sr_limit",$start);
        }
        else
        {
            $this->session->set_userdata("sr_limit",0);
        }
        if($limit)
        {
            $this->session->set_userdata("sr_offset",$limit);
        }
        else
        {
            $this->session->set_userdata("sr_offset",20);
        }
        if($like_index!="")
        {
            $this->session->set_userdata("sr_like_index",$like_index);
        }
        else
        {
            $this->session->set_userdata("sr_like_index",null);
        }
        if($like_value!="")
        {
            $this->session->set_userdata("sr_like_value",$like_value);
        }
        else
        {
            $this->session->set_userdata("sr_like_value",null);
        }
        if($where_index!="" && $where_value!="")
        {
            $this->session->set_userdata("sr_where",array($where_index => $where_value));
        }
        else
        {
//        echo $where_index." x ".$where_value;
            $this->session->set_userdata("sr_where",null);
        }
        if($sidx)
        {
            $this->session->set_userdata("sr_order_by",$sidx);
        }
        else
        {
            $this->session->set_userdata("sr_order_by","region_id");
        }
        if($sort)
        {
            $this->session->set_userdata("sr_order",$sort);
        }
        else
        {
            $this->session->set_userdata("sr_order","DESC");
        }
//        echo $this->session->userdata("region_limit")." x ".$this->session->userdata("region_offset");
        $data=$this->sub_region_model->sub_regions($this->session->userdata("sr_limit"),$this->session->userdata("sr_offset"),$this->session->userdata("sr_order_by"),$this->session->userdata("sr_order"),$this->session->userdata("sr_where"),$this->session->userdata("sr_like_index"),$this->session->userdata("sr_like_value"))->result();
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
                $str.= "<row id='". $each->sr_id."'>";			
                $str.= "<cell>".$each->sr_id."</cell>";
                $str.= "<cell><![CDATA[". $each->sr_code."]]></cell>";
                $str.= "<cell><![CDATA[". $each->sr_name."]]></cell>";
                $str.= "<cell><![CDATA[". $each->region_name."]]></cell>";
                $str.= "<cell><![CDATA[<a href='javascript:edit(". $each->sr_id.");'>&#10000; edit </a> | <a href='javascript:deleting(". $each->sr_id.");'>	&#10006; delete</a>]]></cell>";
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
                    array('field' => 'sr_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Id Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->sub_region_model->delete($this->input->post('sr_id'));
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
                    array('field' => 'sr_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Id Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $where=array('sr_id =\''.$this->input->post('sr_id').'\'');
                $data=$this->sub_region_model->sub_regions(0,1,"sr_id","DESC",$where ,"","")->result();
                if(count($data)>0)
                {
                    $data_region['sr_id'] = $data[0]->sr_id;
                    $data_region['sr_code'] = $data[0]->sr_code;
                    $data_region['sr_name'] = $data[0]->sr_name;
                    $data_region['region_id'] = $data[0]->region_id;
                    $data_region['region_name'] = $data[0]->region_name;
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
                    array('field' => 'sr_code', 'label' => 'Sub Region Code', 'rules' => 'required|xss_clean')
                    ,array('field' => 'sr_name', 'label' => 'Sub Region', 'rules' => 'required|xss_clean')
                    ,array('field' => 'region_id', 'label' => 'Region', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Region Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->sub_region_model->insert($this->input->post('sr_code'),$this->input->post('sr_name'),$this->input->post('region_id'));
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
                    array('field' => 'sr_code', 'label' => 'Sub Region Code', 'rules' => 'required|xss_clean')
                    ,array('field' => 'sr_name', 'label' => 'Sub Region', 'rules' => 'required|xss_clean')
                    ,array('field' => 'region_id', 'label' => 'Region', 'rules' => 'required|xss_clean')
                ,   array('field' => 'sr_id', 'label' => 'Sub Region ID', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Region Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->sub_region_model->update($this->input->post('sr_code'),$this->input->post('sr_name'),$this->input->post('region_id'),$this->input->post('sr_id'));
                $data_region['region_message'] = "Successful Insert";
                $data_region['region_status'] = 'success';
            }
        }
        echo json_encode($data_region);
    }
    function load_sub_region_select()
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

        $data=$this->sub_region_model->all()->result();
        if(count($data)>0)
        {
            $str="<select name='sr_id' id='".$select_id."'>";
            foreach($data as $each) 
            {
                $str.= "<option value='". $each->sr_id."' ".(($selected==$each->sr_id) ? " selected " : " ").">".$each->sr_name."</option>";
            }
            $str.="</select>";
        }
        echo $str;
    }
   
}
?>