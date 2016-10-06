<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Course extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('admin_ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('course_model');


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
        $this->load->view("vadmin_course",$data);        
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
        if($where_index!="" && $where_value!="")
        {
            $this->session->set_userdata("course_where",array('courses.'.$where_index.'='.$where_value));
        }
        else
        {
//        echo $where_index." x ".$where_value;
            $this->session->set_userdata("course_where",null);
        }
        
        $data=$this->course_model->count_courses($this->session->userdata("course_where"))->result();
//        die($data[0]->count);
        $count = $data[0]->count;
        if( $count >0 ) {
                $total_pages = ceil($count/$limit);
        } else {
                $total_pages = 0;
        }
        if ($page > $total_pages) $page=$total_pages;
//        echo $limit." ".$page." ".$limit;
        if($page==0)
            $start = 0;
        else            
            $start = $limit*$page - $limit; // do not put $limit*($page - 1)
        if($start)
        {
            $this->session->set_userdata("course_limit",$start);
        }
        else
        {
            $this->session->set_userdata("course_limit",0);
        }
        if($limit)
        {
            $this->session->set_userdata("course_offset",$limit);
        }
        else
        {
            $this->session->set_userdata("course_offset",20);
        }
        if($like_index!="")
        {
            $this->session->set_userdata("course_like_index",$like_index);
        }
        else
        {
            $this->session->set_userdata("course_like_index",null);
        }
        if($like_value!="")
        {
            $this->session->set_userdata("course_like_value",$like_value);
        }
        else
        {
            $this->session->set_userdata("course_like_value",null);
        }
        if($sidx)
        {
            $this->session->set_userdata("course_order_by",$sidx);
        }
        else
        {
            $this->session->set_userdata("course_order_by","region_id");
        }
        if($sort)
        {
            $this->session->set_userdata("course_order",$sort);
        }
        else
        {
            $this->session->set_userdata("course_order","DESC");
        }
//        echo $this->session->userdata("region_limit")." x ".$this->session->userdata("region_offset");
//        die($this->session->userdata("city_limit").$this->session->userdata("city_offset"));
//                die("xxx");
        $data=$this->course_model->courses($this->session->userdata("course_limit"),$this->session->userdata("course_offset"),$this->session->userdata("course_order_by"),$this->session->userdata("course_order"),$this->session->userdata("course_where"),$this->session->userdata("course_like_index"),$this->session->userdata("course_like_value"))->result();
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
                $str.= "<row id='". $each->course_id."'>";			
                $str.= "<cell>".$each->course_id."</cell>";
                $str.= "<cell><![CDATA[". $each->course_name."]]></cell>";
                $str.= "<cell><![CDATA[". $each->university_name."]]></cell>";
                $str.= "<cell><![CDATA[<a href='javascript:program(". $each->course_id.");'>&#10000; program </a> |<a href='javascript:lecturer(". $each->course_id.");'>&#10000; lecturer </a> |<a href='javascript:edit(". $each->course_id.");'>&#10000; edit </a>|<a href='javascript:deleting(". $each->course_id.");'>	&#10006; delete</a>]]></cell>";
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
                    array('field' => 'course_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_course['course_message'] = "Id Required";
                $data_course['course_status'] = 'error';
            } 
            else
            {
                $result=$this->course_model->delete($this->input->post('course_id'));
                $data_course['course_message'] = "Successful Deleting";
                $data_course['course_status'] = 'success';
            }
        }
        echo json_encode($data_course);
    }
    function details()
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
                $data_course['course_message'] = "Id Required";
                $data_course['course_status'] = 'error';
            } 
            else
            {
                $where=array('course_id =\''.$this->input->post('course_id').'\'');
                $data=$this->course_model->courses(0,1,"course_id","DESC",$where ,"","")->result();
                if(count($data)>0)
                {
                    $data_course['course_id'] = $data[0]->course_id;
                    $data_course['course_name'] = $data[0]->course_name;
                    $data_course['course_description'] = $data[0]->course_description;
                    $data_course['university_id'] = $data[0]->university_id;
                    $data_course['university_message'] = "success";
                    $data_course['university_status'] = 'success';
                }
            }
        }
        echo json_encode($data_course);
    }
    function insert()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'course_name', 'label' => 'Course Name', 'rules' => 'required|xss_clean')
                    ,array('field' => 'course_description', 'label' => 'Description', 'rules' => 'required|xss_clean')
                    ,array('field' => 'university_id', 'label' => 'University ID', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_course['course_message'] = "Course Data Required";
                $data_course['course_status'] = 'error';
            } 
            else
            {
                $result=$this->course_model->insert($this->input->post('course_name'),$this->input->post('course_description'),$this->input->post('university_id'));
                $data_course['course_message'] = "Successful Insert";
                $data_course['course_status'] = 'success';
            }
        }
        echo json_encode($data_course);
    }
    function update()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'course_name', 'label' => 'Course Name', 'rules' => 'required|xss_clean')
                    ,array('field' => 'course_description', 'label' => 'Description', 'rules' => 'required|xss_clean')
                    ,array('field' => 'university_id', 'label' => 'University ID', 'rules' => 'required|xss_clean')
                    ,array('field' => 'course_id', 'label' => 'Course ID', 'rules' => 'required|xss_clean')
             );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_course['course_message'] = "Course Data Required";
                $data_course['course_status'] = 'error';
            } 
            else
            {
                $result=$this->course_model->update($this->input->post('course_name'),$this->input->post('course_description'),$this->input->post('university_id'),$this->input->post('course_id'));
                $data_course['course_message'] = "Successful Update";
                $data_course['course_status'] = 'success';
            }
        }
        echo json_encode($data_course);
    }
    function lecturer_in_course()
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
                $data_course['course_message'] = "course Id Required";
                $data_course['course_status'] = 'error';
            } 
            else
            {
                $data=$this->course_model->lecturer_in_course($this->input->post('course_id'))->result();
                $str="";
                if(count($data)>0)
                {
            // be sure to put text data in CDATA
                    $str="<table id='programs_in_course_data' style='border:1px; border-color:#999999;' align=\"center\" width=\"600px\">";
                    $str.="<tr style=\"background-color:#cccccc\"><th>Program ID</th><th>Program Name</th><th>Action</th></tr>";
                    foreach($data as $each) 
                    {
                        $str.="<tr>";
                        $str.= "<td>". $each->cl_id."</td>";			
                        $str.= "<td>". $each->lecturer_name."</td>";
                        $str.= "<td><a href=\"javascript:delete_cl(". $each->cl_id.");\">delete</a></td>";
                        $str.= "</tr>";
                    }
                    $str.="</table>";
                }
                $data_course["course_data"]=$str;
                $data_course['course_message'] = "success";
                $data_course['course_status'] = 'success';

            }
        }
        echo json_encode($data_course);
    }
    function insert_cl()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'course_id', 'label' => 'Course ID', 'rules' => 'required|xss_clean')
                    ,array('field' => 'lecturer_name', 'label' => 'Lecturer Name', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_course['course_message'] = "Program Data Required";
                $data_course['course_status'] = 'error';
            } 
            else
            {
                $result=$this->course_model->insert_cl($this->input->post('lecturer_name'),$this->input->post('course_id'));
                $data_course['course_message'] = "Successful Insert";
                $data_course['course_status'] = 'success';
            }
        }
        echo json_encode($data_course);
    }
    function deleting_cl()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'cl_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_course['course_message'] = "Id Required";
                $data_course['course_status'] = 'error';
            } 
            else
            {
                $result=$this->course_model->delete_cl($this->input->post('cl_id'));
                $data_course['course_message'] = "Successful Deleting";
                $data_course['course_status'] = 'success';
            }
        }
        echo json_encode($data_course);
    }
    
}
?>