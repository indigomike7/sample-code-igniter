<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class User_Home extends MX_Controller 
{
 
   public function index()
   {
        if ($this->user_ion_auth->logged_in() === FALSE)
            redirect(site_url());

        $this->load->view('vuser_header');
        $this->load->view('vuser');
        $this->load->view('vuser_footer');
   }
}
?>