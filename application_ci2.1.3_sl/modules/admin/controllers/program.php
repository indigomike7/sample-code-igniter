<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Program extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('admin_ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('program_model');


        $this->load->database();

        $this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        parse_str(substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'],'?')+1,strlen($_SERVER['REQUEST_URI'])-strpos($_SERVER['REQUEST_URI'],'?')),$_GET);                
        $this->load->model('university_model');
        $this->load->view("vadmin_header");
        if(isset($_GET['university']))
        {
            $university = $this->security->xss_clean($_GET['university']); 
            $result=$this->university_model->get_by_name($university)->result();
            if(count($result)>0)
            {
                $data["university_id"]=$result[0]->university_id;
                $data["university_name"]=$result[0]->university_name;
                $this->session->set_userdata("university_name",$result[0]->university_name);
            }
            else
            {
                $data["university_id"]="";
                $data["university_name"]="";
            }
        }
        else
        {
            $data["university_id"]="";
            $data["university_name"]="";
        }
        $this->load->view("vadmin_program",$data);        
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
        $data=$this->program_model->count_programs()->result();
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
            $this->session->set_userdata("program_limit",$start);
        }
        else
        {
            $this->session->set_userdata("program_limit",0);
        }
        if($limit)
        {
            $this->session->set_userdata("program_offset",$limit);
        }
        else
        {
            $this->session->set_userdata("program_offset",20);
        }
        if($like_index!="")
        {
            $this->session->set_userdata("program_like_index",$like_index);
        }
        else
        {
            $this->session->set_userdata("program_like_index",null);
        }
        if($like_value!="")
        {
            $this->session->set_userdata("program_like_value",$like_value);
        }
        else
        {
            $this->session->set_userdata("program_like_value",null);
        }
        if($where_index!="" && $where_value!="")
        {
            $this->session->set_userdata("program_where",array('programs.'.$where_index.'='.$where_value));
        }
        else
        {
//        echo $where_index." x ".$where_value;
            $this->session->set_userdata("program_where",null);
        }
        if($sidx)
        {
            $this->session->set_userdata("program_order_by",$sidx);
        }
        else
        {
            $this->session->set_userdata("program_order_by","region_id");
        }
        if($sort)
        {
            $this->session->set_userdata("program_order",$sort);
        }
        else
        {
            $this->session->set_userdata("program_order","DESC");
        }
//        echo $this->session->userdata("region_limit")." x ".$this->session->userdata("region_offset");
//        die($this->session->userdata("city_limit").$this->session->userdata("city_offset"));
//                die("xxx");
        $data=$this->program_model->programs($this->session->userdata("program_limit"),$this->session->userdata("program_offset"),$this->session->userdata("program_order_by"),$this->session->userdata("program_order"),$this->session->userdata("program_where"),$this->session->userdata("program_like_index"),$this->session->userdata("program_like_value"))->result();
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
                $str.= "<row id='". $each->program_id."'>";			
                $str.= "<cell>".$each->program_id."</cell>";
                $str.= "<cell><![CDATA[". $each->program_name."]]></cell>";
                $str.= "<cell><![CDATA[". $each->university_name."]]></cell>";
                $str.= "<cell><![CDATA[<a href='javascript:edit(". $each->program_id.");'>&#10000; edit </a> | <a href='javascript:deleting(". $each->program_id.");'>	&#10006; delete</a>]]></cell>";
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
                    array('field' => 'program_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_program['program_message'] = "Id Required";
                $data_program['program_status'] = 'error';
            } 
            else
            {
                $result=$this->program_model->delete($this->input->post('program_id'));
                $data_program['program_message'] = "Successful Deleting";
                $data_program['program_status'] = 'success';
            }
        }
        echo json_encode($data_program);
    }
    function details()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'program_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_program['program_message'] = "Id Required";
                $data_program['program_status'] = 'error';
            } 
            else
            {
                $where=array('program_id =\''.$this->input->post('program_id').'\'');
                $data=$this->program_model->programs(0,1,"program_id","DESC",$where ,"","")->result();
                if(count($data)>0)
                {
                    $data_program['program_id'] = $data[0]->program_id;
                    $data_program['program_name'] = $data[0]->program_name;
                    $data_program['category_id'] = $data[0]->category_id;
                    $data_program['program_description'] = $data[0]->program_description;
                    $data_program['university_id'] = $data[0]->university_id;
                    $data_program['university_message'] = "success";
                    $data_program['university_status'] = 'success';
                }
            }
        }
        echo json_encode($data_program);
    }
    function program_in_university()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'university_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_program['program_message'] = "Id Required";
                $data_program['program_status'] = 'error';
            } 
            else
            {
                $where=array('programs.university_id =\''.$this->input->post('university_id').'\'');
                $data=$this->program_model->programs(0,10000,"program_id","DESC",$where ,"","")->result();
                $str="";
                if(count($data)>0)
                {
            // be sure to put text data in CDATA
                    $str="<select name='program_in_university' id='program_in_university'>";
                    foreach($data as $each) 
                    {
                        $str.= "<option value='". $each->program_id."'>";			
                        $str.= "". $each->program_name."";
                        $str.= "</option>";
                    }
                    $str.="</select>";

                }
                $data_program["program_data"]=$str;
                $data_program['university_message'] = "success";
                $data_program['university_status'] = 'success';

            }
        }
        echo json_encode($data_program);
    }
    function program_in_course()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'course_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_program['program_message'] = "course Id Required";
                $data_program['program_status'] = 'error';
            } 
            else
            {
                $data=$this->program_model->program_in_course($this->input->post('course_id'))->result();
                $str="";
                if(count($data)>0)
                {
            // be sure to put text data in CDATA
                    $str="<table id='programs_in_course_data' style='border:1px; border-color:#999999;' align=\"center\" width=\"600px\">";
                    $str.="<tr style=\"background-color:#cccccc\"><th>Program ID</th><th>Program Name</th><th>Action</th></tr>";
                    foreach($data as $each) 
                    {
                        $str.="<tr>";
                        $str.= "<td>". $each->program_id."</td>";			
                        $str.= "<td>". $each->program_name."</td>";
                        $str.= "<td><a href=\"javascript:delete_cp(". $each->cp_id.");\">delete</a></td>";
                        $str.= "</tr>";
                    }
                    $str.="</table>";
                }
                $data_program["program_data"]=$str;
                $data_program['university_message'] = "success";
                $data_program['university_status'] = 'success';

            }
        }
        echo json_encode($data_program);
    }
    function insert()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'program_name', 'label' => 'Program Name', 'rules' => 'required|xss_clean')
                    ,array('field' => 'program_description', 'label' => 'Description', 'rules' => 'required|xss_clean')
                    ,array('field' => 'university_id', 'label' => 'University ID', 'rules' => 'required|xss_clean')
                    ,array('field' => 'category_id', 'label' => 'Category ID', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_program['program_message'] = "Program Data Required";
                $data_program['program_status'] = 'error';
            } 
            else
            {
                $result=$this->program_model->insert($this->input->post('program_name'),$this->input->post('program_description'),$this->input->post('university_id'),$this->input->post('category_id'));
                $data_program['program_message'] = "Successful Insert";
                $data_program['program_status'] = 'success';
            }
        }
        echo json_encode($data_program);
    }
    function update()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'program_name', 'label' => 'Program Name', 'rules' => 'required|xss_clean')
                    ,array('field' => 'program_description', 'label' => 'Description', 'rules' => 'required|xss_clean')
                    ,array('field' => 'university_id', 'label' => 'University ID', 'rules' => 'required|xss_clean')
                    ,array('field' => 'category_id', 'label' => 'Category ID', 'rules' => 'required|xss_clean')
                    ,array('field' => 'program_id', 'label' => 'Program ID', 'rules' => 'required|xss_clean')
             );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_program['program_message'] = "Program Data Required";
                $data_program['program_status'] = 'error';
            } 
            else
            {
                $result=$this->program_model->update($this->input->post('program_name'),$this->input->post('program_description'),$this->input->post('university_id'),$this->input->post('category_id'),$this->input->post('program_id'));
                $data_program['program_message'] = "Successful Update";
                $data_program['program_status'] = 'success';
            }
        }
        echo json_encode($data_program);
    }
    function insert_cp()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'course_id', 'label' => 'Course ID', 'rules' => 'required|xss_clean')
                    ,array('field' => 'program_id', 'label' => 'Program ID', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_program['program_message'] = "Program Data Required";
                $data_program['program_status'] = 'error';
            } 
            else
            {
                $result=$this->program_model->insert_cp($this->input->post('program_id'),$this->input->post('course_id'));
                $data_program['program_message'] = "Successful Insert";
                $data_program['program_status'] = 'success';
            }
        }
        echo json_encode($data_program);
    }
    function deleting_cp()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'cp_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_program['program_message'] = "Id Required";
                $data_program['program_status'] = 'error';
            } 
            else
            {
                $result=$this->program_model->delete_cp($this->input->post('cp_id'));
                $data_program['program_message'] = "Successful Deleting";
                $data_program['program_status'] = 'success';
            }
        }
        echo json_encode($data_program);
    }
    
}
?>