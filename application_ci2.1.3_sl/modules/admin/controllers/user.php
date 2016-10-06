<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class User extends MX_Controller {
 
   public function index()
   {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url());

        $this->load->view('vadmin_header');
        $this->load->view('vadmin_user');
        $this->load->view('vadmin_footer');
   }
   public function import()
   {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url());

        $config['upload_path'] = './upload_xls/';
        $config['allowed_types'] = 'xls|csv';
        $config['max_size']	= '100';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';

        $this->load->view('vadmin_header');
        $this->load->library('upload', $config);
        
        if(!$this->upload->do_upload("myfile")&&($this->input->post('myfile')))
        {
            $data = array('error' => $this->upload->display_errors());
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
        }
        $this->load->view('vadmin_user_import', $data);
        $this->load->view('vadmin_footer');
   }
   public function deleting($file)
   {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url());

        $file_to_delete ='../sl/upload_xls/'.$file; 
       if(file_exists($file_to_delete))
       {
           unlink($file_to_delete);
       }
        redirect(site_url("admin/user/import"));
   }
   public function importing($file)
   {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url());

        require_once("classes/PHPExcel/IOFactory.php");
        $inputFileName = '../sl/upload_xls/'.$file;

        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        //var_dump($sheetData);
        $data=null;
        //echo array_shift(array_keys($sheetData))." xx";
        for($i=array_shift(array_keys($sheetData));$i<count($sheetData);$i++)
        {
            if(is_array($sheetData[$i]))
            {
                //echo "array";
                //echo $sheetData[$i]["A"];
                if(trim($sheetData[$i]["A"])=="ID" 
                        && trim($sheetData[$i]["B"])=="DOB" 
                        && trim($sheetData[$i]["C"])=="GROUP"
                        && trim($sheetData[$i]["D"])=="LASTN"
                        && trim($sheetData[$i]["E"])=="FIRSTN"
                        && $sheetData[$i]["F"]==NULL
                        )
                {
                    //do nothing, title here
                    //echo "title";
                }
                else
                {
//                    echo $i."<br/>";
                    //echo $sheetData[$i]["A"].$sheetData[$i]["B"].$sheetData[$i]["C"].$sheetData[$i]["D"].$sheetData[$i]["E"]."<br/>";
//                    if(trim($sheetData[$i]["A"])=="")
//                        echo "kosong";
//                    else
//                        echo "berisi";
                    if(($sheetData[$i]["A"]==null && trim($sheetData[$i]["A"])=="") 
                            && ($sheetData[$i]["B"]==null && trim($sheetData[$i]["B"])=="")
                            && ($sheetData[$i]["C"]==null && trim($sheetData[$i]["C"])=="")
                            && ($sheetData[$i]["D"]==null && trim($sheetData[$i]["D"])=="")
                            && ($sheetData[$i]["E"]==null && trim($sheetData[$i]["E"])=="")
                            && ($sheetData[$i]["F"]==null && trim($sheetData[$i]["F"])=="")
                            )
                    {
                        //echo $i;
                        //do nothing, blank row
                    }
                    else
                    {
//                        echo "insert";
                        $array=array("id"=>$sheetData[$i]["A"]
                            ,"dob"=>$sheetData[$i]["B"]
                            ,"group"=>$sheetData[$i]["C"]
                            ,"last_name"=>$sheetData[$i]["D"]
                            ,"first_name"=>$sheetData[$i]["E"]
                            );
                        $data[]=$array;
//                        $data[]["id"]=$sheetData[$i]["A"];
//                        $data[]["dob"]=$sheetData[$i]["B"];
//                        $data[]["group"]=$sheetData[$i]["C"];
//                        $data[]["last_name"]=$sheetData[$i]["D"];
//                        $data[]["first_name"]=$sheetData[$i]["E"];
//                        echo var_dump($data[2]);
                        
                    }
                    
                }
                
            }
        }
        //var_dump($data);
//        for($i=1;$i<count($data);$i++)
//        {
//            echo var_dump($data[$i])."<br/>";
//        }
        $data_group=null;
        $exist=false;
        /*
         * EXTRACT DATA GROUP
         * indigomike7
         */
        //echo array_shift(array_keys($data));
        for($i=array_shift(array_keys($data));$i<count($data);$i++)
        {
            //echo $data[$i]["group"]." ".$i."<br/>";
            if(($i==1 || $i == 0) && $data[$i]["group"]!="" && $data[$i]["group"]!=null)
            {
                $data_group[]["group"]=$data[$i]["group"];
//                echo $data_group[0]["group"];
            }
            else
            {
                $exist = false;
                for($j=0;$j<count($data_group);$j++)
                {
                    if($data_group[$j]["group"]==$data[$i]["group"])
                    {
                        $exist =true;
                    }
                }
                if($exist != true)
                {
                    //add new group to group
                    $data_group[]["group"]=$data[$i]["group"];
                }
            }
        }
        $this->db->empty_table('groups');  
        $this->db->empty_table('users');
        $this->db->empty_table('users_groups');
        $this->load->library("user/user_ion_auth");
        for($i=array_shift(array_keys($data_group));$i<count($data_group);$i++)
        {
            //$this->load->library("admin_ion_auth");
//            echo $data_group[$i]["group"]."<br/>";
            Modules::run("user");
            //$this->libraries
            //echo "xx";
            $this->user_ion_auth->create_group($data_group[$i]["group"],'');
            
//            echo "insert<br/>";
        }
        
        for($i=array_shift(array_keys($data));$i<count($data);$i++)
        {
            $group_id = $this->user_ion_auth->group_id_from_name($data[$i]["group"])->row()->id;
            $group = array($group_id);
            $this->user_ion_auth->register($data[$i]["id"], $data[$i]["dob"], $data[$i]["id"].$this->config->item('user_ion_auth_domain', 'user_ion_auth'), $additional_data = array(), $group);

        }
   }
}
?>