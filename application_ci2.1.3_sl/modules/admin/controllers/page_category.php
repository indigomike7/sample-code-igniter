<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Page_category extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('admin_ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('page_category_model');


        $this->load->database();

        $this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $this->load->view("vadmin_header");
        $this->load->view("vadmin_page_category");
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
        $data=$this->page_category_model->count_categories()->result();
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
            $this->session->set_userdata("page_category_limit",$start);
        }
        else
        {
            $this->session->set_userdata("page_category_limit",0);
        }
//        echo $limit."dsds";
        if($limit)
        {
            $this->session->set_userdata("page_category_offset",$limit);
        }
        else
        {
            $this->session->set_userdata("page_category_offset",20);
        }
        if($like_index!="")
        {
            $this->session->set_userdata("page_category_like_index",$like_index);
        }
        else
        {
            $this->session->set_userdata("page_category_like_index",null);
        }
        if($like_value!="")
        {
            $this->session->set_userdata("page_category_like_value",$like_value);
        }
        else
        {
            $this->session->set_userdata("page_category_like_value",null);
        }
        if($where_index!="" && $where_value!="")
        {
            $this->session->set_userdata("page_category_where", array(''.$where_index.' =\''.$where_value.'\''));

        }
        else
        {
//        echo $where_index." x ".$where_value;
            $this->session->set_userdata("page_category_where",null);
        }
        if($sidx)
        {
            $this->session->set_userdata("page_category_order_by",$sidx);
        }
        else
        {
            $this->session->set_userdata("page_category_order_by","category_id");
        }
        if($sort)
        {
            $this->session->set_userdata("page_category_order",$sort);
        }
        else
        {
            $this->session->set_userdata("page_category_order","DESC");
        }
//        echo $this->session->userdata("region_limit")." x ".$this->session->userdata("region_offset");
        $data=$this->page_category_model->categories($this->session->userdata("page_category_limit"),$this->session->userdata("page_category_offset"),$this->session->userdata("page_category_order_by"),$this->session->userdata("page_category_order"),$this->session->userdata("page_category_where"),$this->session->userdata("page_category_like_index"),$this->session->userdata("page_category_like_value"))->result();
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
                $str.= "<row id='". $each->category_id."'>";			
                $str.= "<cell>".$each->category_id."</cell>";
                $str.= "<cell><![CDATA[". $each->category_name."]]></cell>";
                $str.= "<cell><![CDATA[<a href='javascript:edit(". $each->category_id.");'>&#10000; edit </a> | <a href='javascript:deleting(". $each->category_id.");'>	&#10006; delete</a>]]></cell>";
                $str.= "</row>";
            }
        }
        $str.= "</rows>";	
        echo $str;
    }
    function load_category_select()
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

        $data=$this->page_category_model->all()->result();
        if(count($data)>0)
        {
            $str="<select name='category_id' id='".$select_id."'>";
            foreach($data as $each) 
            {
                $str.= "<option value='". $each->category_id."' ".(($selected==$each->category_id) ? " selected " : " ").">".$each->category_name."</option>";
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
                    array('field' => 'category_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_category['page_category_message'] = "Id Required";
                $data_category['page_category_status'] = 'error';
            } 
            else
            {
                $result=$this->page_category_model->delete($this->input->post('category_id'));
                $data_category['page_category_message'] = "Successful Deleting";
                $data_category['page_category_status'] = 'success';
            }
        }
        echo json_encode($data_category);
    }
    function details()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'category_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_region['page_category_message'] = "Id Required";
                $data_region['page_category_status'] = 'error';
            } 
            else
            {
                $where=array('category_id =\''.$this->input->post('category_id').'\'');
                $data=$this->page_category_model->categories(0,1,"category_id","DESC",$where ,"","")->result();
                if(count($data)>0)
                {
                    $data_category['category_id'] = $data[0]->category_id;
                    $data_category['category_name'] = $data[0]->category_name;
                    $data_category['page_category_message'] = "success";
                    $data_category['page_category_status'] = 'success';
                }
            }
        }
        echo json_encode($data_category);
    }
    function insert()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'category_name', 'label' => 'Category', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_category['page_category_message'] = "Category Required";
                $data_category['page_category_status'] = 'error';
            } 
            else
            {
                $result=$this->page_category_model->insert($this->input->post('category_name'));
                $data_category['page_category_message'] = "Successful Insert";
                $data_category['page_category_status'] = 'success';
            }
        }
        echo json_encode($data_category);
    }
    function update()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'category_name', 'label' => 'Category', 'rules' => 'required|xss_clean')
                ,   array('field' => 'category_id', 'label' => 'Category ID', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_category['page_category_message'] = "Region Required";
                $data_category['page_category_status'] = 'error';
            } 
            else
            {
                $result=$this->page_category_model->update($this->input->post('category_name'),$this->input->post('category_id'));
                $data_category['page_category_message'] = "Successful Insert";
                $data_category['page_category_status'] = 'success';
            }
        }
        echo json_encode($data_category);
    }
}
?>