<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Admin extends MX_Controller {
 
   public function index()
   {
        $this->load->view('vadmin_header');
        if ($this->admin_ion_auth->logged_in() === TRUE)
        {
            $this->load->view('vadmin');
        }
        else
        {
            $this->load->view('vadmin_login');
        }
        $this->load->view('vadmin_footer');
   }
   public function login()
   {
            // is user logged in ???
            if ($this->admin_ion_auth->logged_in() === TRUE)
                    redirect('admin/admin_home');

            $data_admin['error_admin'] = FALSE;

            if ($this->input->post())
            {
                    $config = array(
                            array('field' => 'user_name', 'label' => 'Username', 'rules' => 'required|xss_clean'),
                            array('field' => 'user_pass', 'label' => 'Password', 'rules' => 'required|xss_clean')
                    );

                    $this->form_validation->set_rules($config);
                    if ($this->form_validation->run() == FALSE)
                    {
                        //echo "sss";
                            $data_admin['admin_message'] = "Invalid Username or Password";
                            $data_admin['admin_status'] = 'error';
                    } else
                    {
                        //echo "xxx";
                            $username = $this->input->post('user_name');
                            $password = $this->input->post('user_pass');
                            if ($this->admin_ion_auth->login($username, $password,$this->input->post("remember_me")) === FALSE)
                            {
                                    $data_admin['admin_message'] = "Invalid Username or Password";
                                    $data_admin['admin_status'] = 'error';
                            }
                            else
                                    redirect('admin/admin_home');
                    }
            }
            $this->load->view("vadmin_header");
            $this->load->view("vadmin_login",$data_admin);
            $this->load->view("vadmin_footer");
//            $this->template->set_layout(FALSE)->build('login', $this->_data);
    }

    public function logout()
    {
            $this->admin_ion_auth->logout();
            redirect(site_url("admin")."");
    }
}
?>