<?php
class Fblogin extends MX_Controller
{
    function __construct()
    {
        //parent::__construct();
//        $this->load->library('admin_ion_auth','easyphpthumbnail');
        $this->load->library('session');
        //$this->load->library('form_validation');
        //$this->load->helper('url');
//        $this->load->model('university_model');


        //$this->load->database();

        //$this->form_validation->set_error_delimiters("<p>", "</p>");
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        echo 'tes';
    }
}
?>
