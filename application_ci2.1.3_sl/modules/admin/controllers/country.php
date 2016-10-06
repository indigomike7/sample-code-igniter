<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Country extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('admin_ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('country_model');


        $this->load->database();

        $this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $this->load->view("vadmin_header");
        $this->load->view("vadmin_country");
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
        $data=$this->country_model->count_countries()->result();
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
            $this->session->set_userdata("country_limit",$start);
        }
        else
        {
            $this->session->set_userdata("country_limit",0);
        }
        if($limit)
        {
            $this->session->set_userdata("country_offset",$limit);
        }
        else
        {
            $this->session->set_userdata("country_offset",20);
        }
        if($like_index!="")
        {
            $this->session->set_userdata("country_like_index",$like_index);
        }
        else
        {
            $this->session->set_userdata("country_like_index",null);
        }
        if($like_value!="")
        {
            $this->session->set_userdata("country_like_value",$like_value);
        }
        else
        {
            $this->session->set_userdata("country_like_value",null);
        }
        if($where_index!="" && $where_value!="")
        {
            $this->session->set_userdata("country_where",array($where_index => $where_value));
        }
        else
        {
//        echo $where_index." x ".$where_value;
            $this->session->set_userdata("country_where",null);
        }
        if($sidx)
        {
            $this->session->set_userdata("country_order_by",$sidx);
        }
        else
        {
            $this->session->set_userdata("country_order_by","region_id");
        }
        if($sort)
        {
            $this->session->set_userdata("country_order",$sort);
        }
        else
        {
            $this->session->set_userdata("country_order","DESC");
        }
//        echo $this->session->userdata("region_limit")." x ".$this->session->userdata("region_offset");
        $data=$this->country_model->countries($this->session->userdata("country_limit"),$this->session->userdata("country_offset"),$this->session->userdata("country_order_by"),$this->session->userdata("country_order"),$this->session->userdata("country_where"),$this->session->userdata("country_like_index"),$this->session->userdata("country_like_value"))->result();
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
                $str.= "<row id='". $each->country_id."'>";			
                $str.= "<cell>".$each->country_id."</cell>";
                $str.= "<cell><![CDATA[". $each->country_fips."]]></cell>";
                $str.= "<cell><![CDATA[". $each->country_iso."]]></cell>";
                $str.= "<cell><![CDATA[". $each->country_tld."]]></cell>";
                $str.= "<cell><![CDATA[". $each->country_name."]]></cell>";
                $str.= "<cell><![CDATA[". $each->sr_name."]]></cell>";
                $str.= "<cell><![CDATA[<a href='javascript:edit(". $each->country_id.");'>&#10000; edit </a> | <a href='javascript:deleting(". $each->country_id.");'>	&#10006; delete</a>]]></cell>";
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
                    array('field' => 'country_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Id Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->country_model->delete($this->input->post('country_id'));
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
                    array('field' => 'country_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Id Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $where=array('country_id =\''.$this->input->post('country_id').'\'');
                $data=$this->country_model->countries(0,1,"country_id","DESC",$where ,"","")->result();
                if(count($data)>0)
                {
                    $data_region['country_id'] = $data[0]->country_id;
                    $data_region['country_fips'] = $data[0]->country_fips;
                    $data_region['country_iso'] = $data[0]->country_iso;
                    $data_region['country_tld'] = $data[0]->country_tld;
                    $data_region['country_name'] = $data[0]->country_name;
                    $data_region['sr_id'] = $data[0]->sr_id;
                    $data_region['sr_name'] = $data[0]->sr_name;
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
                    array('field' => 'country_fips', 'label' => 'Country FIPS', 'rules' => 'required|xss_clean')
                    ,array('field' => 'country_iso', 'label' => 'Country ISO', 'rules' => 'required|xss_clean')
                    ,array('field' => 'country_tld', 'label' => 'Country TLD', 'rules' => 'required|xss_clean')
                    ,array('field' => 'country_name', 'label' => 'Country', 'rules' => 'required|xss_clean')
                    ,array('field' => 'sr_id', 'label' => 'Sub Region', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Country Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->country_model->insert($this->input->post('country_fips'),$this->input->post('country_iso'),$this->input->post('country_tld'),$this->input->post('country_name'),$this->input->post('sr_id'));
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
                    array('field' => 'country_fips', 'label' => 'Country FIPS', 'rules' => 'required|xss_clean')
                    ,array('field' => 'country_iso', 'label' => 'Country ISO', 'rules' => 'required|xss_clean')
                    ,array('field' => 'country_tld', 'label' => 'Country TLD', 'rules' => 'required|xss_clean')
                    ,array('field' => 'country_name', 'label' => 'Country', 'rules' => 'required|xss_clean')
                    ,array('field' => 'sr_id', 'label' => 'Sub Region', 'rules' => 'required|xss_clean')
                    ,array('field' => 'country_id', 'label' => 'Country ID', 'rules' => 'required|xss_clean')
             );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['region_message'] = "Region Required";
                $data_region['region_status'] = 'error';
            } 
            else
            {
                $result=$this->country_model->update($this->input->post('country_fips'),$this->input->post('country_iso'),$this->input->post('country_tld'),$this->input->post('country_name'),$this->input->post('sr_id'),$this->input->post('country_id'));
                $data_region['region_message'] = "Successful Insert";
                $data_region['region_status'] = 'success';
            }
        }
        echo json_encode($data_region);
    }
    function load_country_select()
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

        $data=$this->country_model->all()->result();
        if(count($data)>0)
        {
            $str="<select name='country_fips' id='".$select_id."'>";
            foreach($data as $each) 
            {
                $str.= "<option value='". $each->country_fips."' ".(($selected==$each->country_fips) ? " selected " : " ").">".$each->country_name."</option>";
            }
            $str.="</select>";
        }
        echo $str;
    }
   
}
?>