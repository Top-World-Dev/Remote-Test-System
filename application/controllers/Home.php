<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

    function index() 
    {
        if($this->session->userdata('ts_login'))
        {
            $uinfo = $this->session->userdata('ts_userdata');
            if($uinfo->rank == 2)
                redirect("admin/problem");
            else
                redirect("student/practice");
        }
        else
        {
            redirect("login");
        }
    }
}
?>