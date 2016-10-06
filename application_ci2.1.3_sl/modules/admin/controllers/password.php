<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Password extends MX_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('admin_ion_auth','easyphpthumbnail');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('site_setting_model','admin_ion_auth_model');


        $this->load->database();

        $this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $this->load->view("vadmin_header");
        $data=array();
        $data['old_password_error']='';

        $data['new_password_error']='';
        
        $data['new_password_confirm_error']='';

        $data['warning_message']='';
        $data['error_message']='';
        $this->load->view("vadmin_password",$data);
        $this->load->view("vadmin_footer");
    }
    function change_password()
    {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $this->load->view("vadmin_header");
        $data=array();
        $data['old_password_error']='';

        $data['new_password_error']='';
        
        $data['new_password_confirm_error']='';

        $data['warning_message']='';
        $data['error_message']='';
        $this->form_validation->set_rules('old_password', 'Old password', 'required|min_length[6]|max_length[255]');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]|max_length[255]');
        $this->form_validation->set_rules('new_password_confirm', 'Confirm New Password', 'required|min_length[6]|max_length[255]');

        if (!$this->admin_ion_auth->logged_in())
        {
                redirect('admin', 'refresh');
        }

        $user = $this->admin_ion_auth->user()->row();
//        var_dump($user);
        if ($this->form_validation->run() == false)
        { 
            if(strlen($this->input->post('old_password'))<=6)
            {
                $data['old_password_error']='Password minimum 6 Character';
            }
            if(strlen($this->input->post('new_password'))<=6)
            {
                $data['new_password_error']='Password minimum 6 Character';
            }
            if(strlen($this->input->post('old_password'))==0)
            {
                $data['old_password_error']='Old Password Required';
            }
            if(strlen($this->input->post('new_password'))==0)
            {
                $data['new_password_error']='New Password Required';
            }
            if(strlen($this->input->post('new_password_confirm'))==0)
            {
                $data['new_password_confirm_error']='Confirm Password Required';
            }

                $this->load->view('vadmin_password', $data);
        }
        else
        {
//                $identity = $this->session->userdata($this->config->item('identity', 'admin_ion_auth'));
            if($this->input->post('new_password')!=$this->input->post('new_password_confirm'))
            {
                $data['new_password_confirm_error']='Confirm Password not the same as new password';
                $this->load->view('vadmin_password', $data);
            }
            else
            {
//                die($user->id. $this->input->post('old_password'). $this->input->post('new_password'));
                $change = $this->admin_ion_auth_model->change_password($user->username, $this->input->post('old_password'), $this->input->post('new_password'));

                if ($change)
                { 
                        //if the password was successfully changed
                        $this->session->set_flashdata('message', $this->admin_ion_auth_model->messages());
                        redirect('admin/logout');
                }
                else
                {
                        $this->session->set_flashdata('message', $this->admin_ion_auth_model->errors());
                        $data['error_message']=$this->admin_ion_auth_model->errors();
                        $this->load->view('vadmin_password', $data);

//                            redirect('auth/change_password', 'refresh');
                }
            }
        }
        $this->load->view("vadmin_footer");
    }
}
?>