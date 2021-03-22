<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('UserModel', 'ViewModel', 'EmailModel'));
        $this->load->helper(array('form', 'url', 'security'));
        $this->load->library(array('form_validation', 'session'));
        $this->load->config('stripe');
    }

    function index($page = "", $param = "")
    {
        if($page == "login")
        {
            $this->$page();
        }
        else if($page == "logout") 
        {
            $data = array('ts_login' => '', 'ts_uid' => '', 'ts_uname' => '', 'ts_userdata' => '');
            $this->session->unset_userdata($data);
            $this->session->sess_destroy();
            redirect("/");
        }
        else
        {
            $func_name = str_replace("-", "_", $page);
            if(method_exists($this, $func_name))
                $this->$func_name($param);
            else
                $this->ViewModel->page404();
        }
    }

    function login() 
    {
        if($this->session->userdata("ts_login"))
            redirect("/");
        $this->form_validation->set_rules('uemail', 'Email Address', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('upwd', 'Password', 'trim|required|xss_clean');

        if($this->form_validation->run() == false) 
        {
            $this->session->set_flashdata('lmsg','');
            $this->load->view('user/login');
        }
        else
        {
            $uemail = $this->input->post("uemail");
            $upwd = $this->input->post("upwd");
            if($userInfo = $this->UserModel->getUserInfo($uemail, $upwd))
            {
                if($userInfo->verification == 0)
                {
                    $this->session->set_flashdata('lmsg', 'Your account hasn\'t been verified.');
                    $this->load->view('user/login');
                }
                else if($userInfo->status)
                {
                    $this->session->set_flashdata('lmsg', 'Your account has been suspended.');
                    $this->load->view('user/login');
                }
                else
                {
                    $sess_data = array('ts_login' => true, 'ts_rank' => $userInfo->rank, 'ts_uid' => $userInfo->uid, 'ts_userdata' => $userInfo);
                    $this->session->set_userdata($sess_data);
                    if(isset($_GET['redirect']))
                    {
                        $redirect = $this->input->get('redirect');
                        redirect($redirect);
                    }
                    else
                        redirect("/");
                }
            }
            else
            {
                $this->session->set_flashdata('lmsg', 'Invalid Email Address or Password');
                $this->load->view('user/login');
            }
        }
    }

    function signup($status="")
    {
        if($this->session->userdata('ts_login'))
            redirect("/");
        if($status == 'confirm') 
        {
            $data['confirm'] = 1;
            $this->load->view('user/signup', $data);
        }
        else 
        {
            // set validation rules
            $this->form_validation->set_rules('uname', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('uemail', 'Email Address', 'trim|required|valid_email|is_unique[users.uemail]|xss_clean');
            $this->form_validation->set_rules('upwd', 'Password', 'trim|required|min_length[8]|max_length[20]|xss_clean');
            $this->form_validation->set_rules('urpwd', 'Confirm Password', 'trim|required|min_length[8]|max_length[20]|xss_clean|matches[upwd]');

            if($this->form_validation->run() == false) 
            {
                $this->session->set_flashdata('msg','');
                $this->load->view('user/signup');
            }
            else 
            {
                $uname = $this->input->post('uname');
                $uemail = $this->input->post('uemail');
                $upwd = $this->input->post('upwd');
                $ref = $this->input->post('ref');

                if($ucode = $this->EmailModel->sendWCMessage($uemail, $upwd))
                {
                    $time = time();
                    $newExpire = strtotime("+1 month");
                    $data = array(
                        'uname'         => $uname,
                        'uemail'        => $uemail,
                        'ucode'         => $ucode,
                        'upwd'          => sha1($upwd),
                        'uphoto'        => 'default-avatar.jpg',
                        'ureal'         => $upwd,
                        'rank'          => 0,
                        'membership'    => 1,
                        'expire'        => $newExpire,
                        'create_at'     => $time
                    );

                    $userId = $this->UserModel->saveUserInfo($data);
                    redirect("user/signup/confirm");
                }
                else
                {
                    $this->session->set_flashdata('msg', 'Oops! Sending Email Failure. Please try again later!!!');
                    $this->load->view('user/signup');
                }
            }
        }
    }
}
?>