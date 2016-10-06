<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Admin_Home extends MX_Controller 
{
 
   public function index(  )
   {
        if ($this->admin_ion_auth->logged_in() === FALSE)
            redirect(site_url('admin'));

        $this->load->view('vadmin_header');
        $this->load->view('vadmin');
        $this->load->view('vadmin_footer');
   }
}
?>