<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Article extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('admin_ion_auth','easyphpthumbnail');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('article_model');


        $this->load->database();

        $this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));


        $this->load->view("vadmin_header");
        $this->load->view("vadmin_article");
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
        $data=$this->article_model->count_articles()->result();
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
            $this->session->set_userdata("article_limit",$start);
        }
        else
        {
            $this->session->set_userdata("article_limit",0);
        }
        if($limit)
        {
            $this->session->set_userdata("article_offset",$limit);
        }
        else
        {
            $this->session->set_userdata("article_offset",20);
        }
        if($like_index!="")
        {
            $this->session->set_userdata("article_like_index",$like_index);
        }
        else
        {
            $this->session->set_userdata("article_like_index",null);
        }
        if($like_value!="")
        {
            $this->session->set_userdata("article_like_value",$like_value);
        }
        else
        {
            $this->session->set_userdata("article_like_value",null);
        }
        if($where_index!="" && $where_value!="")
        {
            $this->session->set_userdata("article_where",array($where_index => $where_value));
        }
        else
        {
//        echo $where_index." x ".$where_value;
            $this->session->set_userdata("article_where",null);
        }
        if($sidx)
        {
            $this->session->set_userdata("article_order_by",$sidx);
        }
        else
        {
            $this->session->set_userdata("article_order_by","region_id");
        }
        if($sort)
        {
            $this->session->set_userdata("article_order",$sort);
        }
        else
        {
            $this->session->set_userdata("article_order","DESC");
        }
        $data=$this->article_model->articles($this->session->userdata("article_limit"),$this->session->userdata("article_offset"),$this->session->userdata("article_order_by"),$this->session->userdata("article_order"),$this->session->userdata("article_where"),$this->session->userdata("article_like_index"),$this->session->userdata("article_like_value"))->result();
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
                $str.= "<row id='". $each->article_id."'>";			
                $str.= "<cell>".$each->article_id."</cell>";
                $str.= "<cell><![CDATA[". $each->article_title."]]></cell>";
                $str.= "<cell><![CDATA[". $each->category_name."]]></cell>";
                $str.= "<cell><![CDATA[<a href='". site_url('admin/article/pic/'.$each->article_id)."'>&#10000; picture </a> | <a href='javascript:edit(". $each->article_id.");'>&#10000; edit </a> | <a href='javascript:deleting(". $each->article_id.");'>	&#10006; delete</a>]]></cell>";
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
                    array('field' => 'article_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_article['article_message'] = "Id Required";
                $data_article['article_status'] = 'error';
            } 
            else
            {
                $result=$this->article_model->delete($this->input->post('article_id'));
                $data_article['article_message'] = "Successful Deleting";
                $data_article['article_status'] = 'success';
            }
        }
        echo json_encode($data_article);
    }
    function details()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'article_id', 'label' => 'Id', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_article['article_message'] = "Id Required";
                $data_article['article_status'] = 'error';
            } 
            else
            {
                $where=array('article_id =\''.$this->input->post('article_id').'\'');
                $data=$this->article_model->articles(0,1,"article_id","DESC",$where ,"","")->result();
                if(count($data)>0)
                {
                    $data_article['article_id'] = $data[0]->article_id;
                    $data_article['article_title'] = $data[0]->article_title;
                    $data_article['article_meta_description'] = $data[0]->article_meta_description;
                    $data_article['article_meta_keyword'] = $data[0]->article_meta_keyword;
                    $data_article['article_description'] = $data[0]->article_description;
                    $data_article['category_id'] = $data[0]->category_id;
                    $data_article['category_name'] = $data[0]->category_name;
                    $data_article['article_message'] = "success";
                    $data_article['article_status'] = 'success';
                }
            }
        }
        echo json_encode($data_article);
    }
    function insert()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'article_title', 'label' => 'Article Title', 'rules' => 'required|xss_clean')
                    ,array('field' => 'article_meta_description', 'label' => 'Meta Description', 'rules' => 'required|xss_clean')
                    ,array('field' => 'article_meta_keyword', 'label' => 'Keyword', 'rules' => 'required|xss_clean')
                    ,array('field' => 'article_description', 'label' => 'Description', 'rules' => 'required|xss_clean')
                    ,array('field' => 'category_id', 'label' => 'Category ID', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_article['article_message'] = "Page Data Required";
                $data_article['article_status'] = 'error';
            } 
            else
            {
                $seo_url = str_replace(" ","-",  strtolower($this->input->post('article_title')));
                $seo_url = str_replace("?","~",  $seo_url);
                $seo_url = str_replace("&",".",  $seo_url);
                $result=$this->article_model->insert($this->input->post('article_title'),$seo_url,$this->input->post('article_meta_description'),$this->input->post('article_meta_keyword'),$this->input->post('article_description'),$this->input->post('category_id'));
                $data_article['article_message'] = "Successful Insert";
                $data_article['article_status'] = 'success';
            }
        }
        echo json_encode($data_article);
    }
    function update()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'article_title', 'label' => 'Article Title', 'rules' => 'required|xss_clean')
                    ,array('field' => 'article_meta_description', 'label' => 'Meta Description', 'rules' => 'required|xss_clean')
                    ,array('field' => 'article_meta_keyword', 'label' => 'Meta Keyword', 'rules' => 'required|xss_clean')
                    ,array('field' => 'article_description', 'label' => 'Description', 'rules' => 'required|xss_clean')
                    ,array('field' => 'category_id', 'label' => 'Category ID', 'rules' => 'required|xss_clean')
                    ,array('field' => 'article_id', 'label' => 'Article Id', 'rules' => 'required|xss_clean')
             );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_article['article_message'] = "City Data Required";
                $data_article['article_status'] = 'error';
            } 
            else
            {
                $seo_url = str_replace(" ","-",  strtolower($this->input->post('article_title')));
                $seo_url = str_replace("?","~",  $seo_url);
                $seo_url = str_replace("&",".",  $seo_url);
                $result=$this->article_model->update($this->input->post('article_title'),$seo_url,$this->input->post('article_meta_description'),$this->input->post('article_meta_keyword'),$this->input->post('article_description'),$this->input->post('category_id'),$this->input->post('article_id'));
                $data_article['article_message'] = "Successful Update";
                $data_article['article_status'] = 'success';
            }
        }
        echo json_encode($data_article);
    }
    function upload($article_id)
    {
//        if ($this->admin_ion_auth->logged_in() === FALSE)
//            redirect(site_url('admin'));

	$POST_MAX_SIZE = ini_get('post_max_size');
	$unit = strtoupper(substr($POST_MAX_SIZE, -1));
	$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

	if ((int)$this->input->server('CONTENT_LENGTH') > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
		header("HTTP/1.1 500 Internal Server Error"); // This will trigger an uploadError event in SWFUpload
		echo "POST exceeded maximum allowed size.";
		exit(0);
	}

// Settings
	$save_path = "upload/articles/".$article_id.'/';				// The path were we will save the file (getcwd() may not be reliable and should be tested in your environment)
	$upload_name = "Filedata";
	$max_file_size_in_bytes = 2147483647;				// 2GB in bytes
	$extension_whitelist = array("jpg", "gif", "png");	// Allowed file extensions
	$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				// Characters allowed in the file name (in a Regular Expression format)
	
// Other variables	
	$MAX_FILENAME_LENGTH = 260;
	$file_name = "";
	$file_extension = "";
	$uploadErrors = array(
        0=>"There is no error, the file uploaded with success",
        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3=>"The uploaded file was only partially uploaded",
        4=>"No file was uploaded",
        6=>"Missing a temporary folder"
	);


// Validate the upload
	if (!isset($_FILES[$upload_name])) {
		$this->HandleError("No upload found in \$_FILES for " . $upload_name);
		exit(0);
	} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
		$this->HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
		exit(0);
	} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
		$this->HandleError("Upload failed is_uploaded_file test.");
		exit(0);
	} else if (!isset($_FILES[$upload_name]['name'])) {
		$this->HandleError("File has no name.");
		exit(0);
	}
	
// Validate the file size (Warning: the largest files supported by this code is 2GB)
	$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
	if (!$file_size || $file_size > $max_file_size_in_bytes) {
		$this->HandleError("File exceeds the maximum allowed size");
		exit(0);
	}
	
	if ($file_size <= 0) {
		$this->HandleError("File size outside allowed lower bound");
		exit(0);
	}


// Validate file name (for our purposes we'll just remove invalid characters)
	$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
	if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
		$this->HandleError("Invalid file name");
		exit(0);
	}


// Validate that we won't over-write an existing file
	if (file_exists($save_path . $file_name)) {
		$this->HandleError("File with this name already exists");
		exit(0);
	}

// Validate file extension
	$path_info = pathinfo($_FILES[$upload_name]['name']);
	$file_extension = $path_info["extension"];
	$is_valid_extension = false;
	foreach ($extension_whitelist as $extension) {
		if (strcasecmp($file_extension, $extension) == 0) {
			$is_valid_extension = true;
			break;
		}
	}
	if (!$is_valid_extension) {
		$this->HandleError("Invalid file extension");
		exit(0);
	}

// Validate file contents (extension and mime-type can't be trusted)
	/*
		Validating the file contents is OS and web server configuration dependant.  Also, it may not be reliable.
		See the comments on this page: http://us2.php.net/fileinfo
		
		Also see http://72.14.253.104/search?q=cache:3YGZfcnKDrYJ:www.scanit.be/uploads/php-file-upload.pdf+php+file+command&hl=en&ct=clnk&cd=8&gl=us&client=firefox-a
		 which describes how a PHP script can be embedded within a GIF image file.
		
		Therefore, no sample code will be provided here.  Research the issue, decide how much security is
		 needed, and implement a solution that meets the needs.
	*/


// Process the file
	/*
		At this point we are ready to process the valid file. This sample code shows how to save the file. Other tasks
		 could be done such as creating an entry in a database or generating a thumbnail.
		 
		Depending on your server OS and needs you may need to set the Security Permissions on the file after it has
		been saved.
	*/
	if (!@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$file_name)) {
		$this->HandleError("File could not be saved.");
		exit(0);
	}
        echo "before creating...";
        require_once("upload/easyphpthumbnail.php");
        $thumb = new easyphpthumbnail();

        $thumb->Thumbsize = 300;
        $thumb -> Thumblocation = $save_path.'thumb/';
        $thumb -> Thumbprefix = '';
        $thumb -> Thumbsaveas = 'png';
        $thumb -> Thumbfilename = $file_name;
        $thumb->Createthumb($save_path.$file_name,'file');

        echo "after creating...";
	exit(0);


    }
    function HandleError($message) 
    {
        echo $message;
    }
    function pic($article_id)
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $structure = 'upload/articles/'.$article_id.'/';
        $data=array();
        if(!is_dir($structure))
        {
            if (!mkdir($structure, 0755, true)) {
                $data['message_error']="failed to create folder";
            }
        }
        
        $structure_thumb = 'upload/articles/'.$article_id.'/thumb';
        $data=array();
        if(!is_dir($structure_thumb))
        {
            if (!mkdir($structure_thumb, 0755, true)) {
                $data['message_error']="failed to create folder";
            }
        }

        $data['article_id']=$article_id;
        $this->load->view("vadmin_header");
        $this->load->view("vadmin_article_pic",$data);
        $this->load->view("vadmin_footer");

    }
    function uploadform()
    {
        echo '
            <form action="'.site_url("admin/article/upload/5").'" method="post" enctype="multipart/form-data">
                <input type="file" name="Filedata">
                <input type ="submit">
            </form>
            ';
    }
    function readdir($article_id)
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $structure = 'upload/articles/'.$article_id.'/';
        $str = "";
        if ($handle = opendir($structure)) 
        {
//            $str.= "Directory handle: $handle\n";
//            $str.= "Entries:\n";

            /* This is the correct way to loop over the directory. */
            $str.= "<table>";
            $str.="<tr><th>Image</th><th>Thumbnail</th><th>Action</th></tr>";
            while (false !== ($entry = readdir($handle))) 
            {
                if($entry!="." && $entry!='..' && $entry!='thumb')
                {
                    $str.= "<tr>
                        <td style='width:300px;'>
                        <img src='".site_url($structure.$entry)."' width='200px'/><br/>
                        <span style='background-color:#ccc;'>".site_url($structure.$entry)."</span>
                        </td>
                        <td style='width:300px;'>
                        <img src='".site_url($structure.'thumb/'.$entry)."' width='150px'/><br/>
                        <span style='background-color:#ccc;'>".site_url($structure.'thumb/'.$entry)."</span></td>
                        <td><a href='javascript:delete_pic(\"".$entry."\");'>delete pic</a></td>
                            </tr>";
                }
            }
            $str.="</table>";

            closedir($handle);
        }
        $data['pic_data'] = $str;
        echo json_encode($data);
    }
    function delete_pic($article_id)
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        
        $structure = 'upload/articles/'.$article_id.'/';
        if ($this->input->post())
        {
            $config = array(
                    array('field' => 'pic_name', 'label' => 'Picture Name', 'rules' => 'required|xss_clean')
            );

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE)
            {
                $data_article['article_message'] = "Id Required";
                $data_article['article_status'] = 'error';
            } 
            else
            {
                if(file_exists($structure.$this->input->post('pic_name')))
                {
                    unlink($structure.$this->input->post('pic_name'));
                }
                if(file_exists($structure.'thumb/'.$this->input->post('pic_name')))
                {
                    unlink($structure.'thumb/'.$this->input->post('pic_name'));
                }
                
                $data_article['article_message'] = "Successful Deleting";
                $data_article['article_status'] = 'success';
            }
        }
        echo json_encode($data_article);
    }
}
?>