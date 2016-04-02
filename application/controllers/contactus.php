<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contactus extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
           $arr['page'] ='contact';
        $this->load->view('vwContactus',$arr);

}
    public function submit()
 {
        //set validation rules
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|callback_alpha_space_only');
        $this->form_validation->set_rules('email', 'Emaid ID', 'trim|required|valid_email');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
        
        //run validation on post data
        if ($this->form_validation->run() == FALSE)
        {   //validation fails
            $this->load->view('vwContactus.php');
        }
        else
        {
            //insert the contact form data into database
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'message' => $this->input->post('message')
            );

            if ($this->db->insert('feedback', $data))
            {
                // success
                $this->session->set_flashdata('msg','<div class="alert alert-success text-center">We received your message! Will get back to you shortly!!!</div>');
                redirect('contactform/index');
            }
            else
            {
                // error
                $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Some Error.  Please try again later!!!</div>');
                redirect('contactform/index');
            }
        }
    }
    
    //custom callback to accept only alphabets and space input
    function alpha_space_only($str)
    {
        if (!preg_match("/^[a-zA-Z ]+$/",$str))
        {
            $this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */