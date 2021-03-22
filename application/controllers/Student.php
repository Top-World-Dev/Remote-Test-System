<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('UserModel','ViewModel', 'StudentModel', 'AdminModel'));
        $this->load->helper(array('form','url','security'));
        $this->load->library(array('form_validation','session'));
    }

    function index($page="", $param="") {
		$func_name = str_replace("-", "_", $page);
		if (method_exists($this, $func_name)) 
			$this->$func_name($param);
		else 
			$this->ViewModel->page404();
    }
    
    function changeAccount() {
        if($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');
            $active = 1;

            $data = array(
                'title'     => "Account Overview",
                'uinfo'     => $userInfo,
                'active'    => $active,
                'styles'    => [

                ],
                'scripts'   => [
                    'js/jquery.validate.min.js',
                ],
            );

            $this->load->view('layouts/student/header', $data);
            $this->load->view('user/myaccount');
            $this->load->view('layouts/student/footer');
        }
    }

    function updateAccount() {
        if($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');

            $res['status'] = true;
            $params = $this->input->post('params');
            $userId = $params[0]['value'];
            $uemail = $params[2]['value'];

            if(!$this->AdminModel->checkEmailAddress($userId, $uemail)) {
                $data = array(
                    'uname' => $params[1]['value'],
                    'uemail' => $params[2]['value']
                );
                $this->AdminModel->updateAccountInfo($data, $userId);
                $userInfo = $this->AdminModel->getUserInfo($userId);
                $sess_data = array('ts_login' => true, 'ts_rank' => $userInfo->rank, 'ts_uid' => $userInfo->uid, 'ts_userdata' => $userInfo);
                $this->session->set_userdata($sess_data);
            }
            else {
                $res['status'] = false;
            }
            echo json_encode($res);
        }
    }

    function changePassword() {
        if($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');
            $active = 1;

            $data = array(
                'title' => "Change Password",
                'uinfo' => $userInfo,
                'active'    => $active,
                'styles'    => [

                ],
                'scripts'   => [
                    'js/jquery.validate.min.js',
                ],
            );

            $this->load->view('layouts/student/header', $data);
            $this->load->view('user/password');
            $this->load->view('layouts/student/footer');
        }
    }

    function updatePassword() {
        if($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');

            $res['status'] = true;
            $params = $this->input->post('params');
            $password = $params[0]['value'];
            $npassword = $params[1]['value'];
            $userCode = hash_hmac("sha1", $password, $userInfo->uemail);

            if($password == $npassword)
            {
                $data = array(
                    'ucode' => $userCode,
                    'upwd'  => sha1($password),
                    'ureal' => $password
                );
                $this->AdminModel->updateUserPassword($data, $userInfo->uid);
            }
            else {
                $res['status'] = false;
            }
            echo json_encode($res);
        }
    }

    function practice() {
        if($this->session->userdata('ts_login'))
        {
            $userInfo = $this->session->userdata('ts_userdata');
            $showproblem = $this->StudentModel->firstGetProblem();
            if(!$showproblem) return;
            $problems = $this->StudentModel->getProblemArray();
            $active = 1;

            $data = array(
                'uinfo'     => $userInfo,
                'showproblem'   => $showproblem,
                'active'    => $active,
                'problems'  => $problems,
                'styles'    => [
                    'admin/css/quill.css',
                    'vendors/quill/css/mathquill.css',  
                    'vendors/quill/css/katex.min.css',
                ],
                'scripts'   => [
                    "js/image-popup.js",
                    "js/remove-add-element.js",
                    "js/countdown.js",
                    "js/validate.js?v=1",
                ]
            );

            $this->load->view('layouts/student/header', $data);
            $this->load->view('student/practice');
            $this->load->view('layouts/student/footer');
        }
        else
        {
            redirect('/');
        }
    }

    function exam() {
        if($this->session->userdata('ts_login'))
        {
            $userInfo = $this->session->userdata('ts_userdata');
            $showproblem = $this->StudentModel->firstGetProblem();
            if(!$showproblem) return;
            $active = 0;

            $data = array(
                'uinfo'         => $userInfo,
                'showproblem'   => $showproblem,
                'active'        => $active,
                'styles'        => [
                    'admin/css/quill.css',
                    'vendors/quill/css/mathquill.css',  
                    'vendors/quill/css/katex.min.css',
                ],
                'scripts'       => [
                    "js/image-popup.js",
                    "js/remove-add-element.js",
                    "js/countdown.js",
                    "js/validateexam.js"
                ]
            );

            $this->load->view('layouts/student/header', $data);
            $this->load->view('student/exam');
            $this->load->view('layouts/student/footer');
        }
        else {
            redirect('/');
        }
    }

    function select($number) {
        if($this->session->userdata('ts_login')) {
            if(!$number) redirect('/');
            $userInfo = $this->session->userdata('ts_userdata');
            $showproblem = $this->StudentModel->getProblem($number);
            if(!$showproblem) redirect('/');
            $problems = $this->StudentModel->getProblemArray();
            $active = 1;

            $data = array(
                'showproblem'   => $showproblem,
                'problems'      => $problems,
                'number'        => $number,
                'uinfo'         => $userInfo,
                'active'        => $active,
                'styles'    => [

                ],
                'scripts'   => [
                    "js/image-popup.js",
                    "js/remove-add-element.js",
                    "js/countdown.js",
                    "js/validate.js",
                    "js/switch-question.js"
                ]
            );
    
            $this->load->view('layouts/student/header', $data);
            $this->load->view('student/practiceshow', $data);
            $this->load->view('layouts/student/footer');
        }
        else {
            redirect('/');
        }
    }

    function checkanswer() {
        if($this->session->userdata('ts_login')) {
            $selectAnswer = $this->input->post('selectAnswer');
            $problemId = $this->input->post('problemId');
            $res['status'] = true;
            $problem = $this->StudentModel->checkAnswer($problemId);

            if($selectAnswer == $problem->correct) {
                $res['solution'] = '<div class="form-group">';
                $res['solution'] .= '<div class="page-separator"><div class="page-separator__text">SOLUTION DETAILS</div></div>';
                $res['solution'] .= '<p class="solution">'.$problem->explanation.'</p></div>';
                $res['solution'] .= '<div class="discuss-sr-group"><div class="sr-group pb-2 text-center">';
                for($i = 1; $i <= 6; $i++) {
                    $srname = "SR$i";
                    if($problem->{$srname}) 
                        $res['solution'] .= '<a class="fancybox" rel="gallery1" href="'.base_url("assets/upload/".$problem->{$srname}).'" title="Solution Picture Reference '.$i.'"><div src="'.base_url("assets/upload/".$problem->{$srname}).'" class="sr-images">'.$srname.'</div></a>';
                }
                $res['solution'] .= '</div>';
                $res['solution'] .= '<div class="discuss-div text-right"><a class="discuss" href="#"><i class="material-icons list-icon">group</i> &nbsp;Discuss in Forum</a></div>';
                $res['solution'] .= '</div>';
            } else {
                $res['status'] = false;
            }
            echo json_encode($res);
        }
    }

    function problem() {
        if (isset($_POST['param'])) {
            $res['status'] = true;
            $problemId = $this->input->post('param');
            $problemInfo = $this->StudentModel->getProblem($problemId);
            if ($problemInfo) {
                $res['data']['pid'] = $problemInfo->Id;
                $res['data']['question'] = $problemInfo->question;
                $res['data']['explanation'] = $problemInfo->explanation;
                $res['data']['preference'] = "";
                for($i = 1; $i <= 10; $i++) {
                    $prname = "PR$i";
                    if($problemInfo->{$prname}) {
                        $res['data']['preference'] .= '<a class="fancybox" rel="gallery1" href="'.base_url("assets/upload/".$problemInfo->{$prname}).'"  title="Picture Reference '.$i.'">';
                        $res['data']['preference'] .= '<div src="'.base_url("assets/upload/".$problemInfo->{$prname}).'"  alt="" class="pr-images">'.$prname.'</div></a>';
                    }
                }
                $res['data']['answers'] = "";
                $answers = ['A','B','C','D','E','F','G','H','I','J'];
                foreach ($answers as $answer) {
                    if($problemInfo->{$answer}) {
                        $res['data']['answers'] .= '<div class="form-group"><div class="each-answer"><div>';
                        $res['data']['answers'] .= '<span class="select1" data-value="'.$answer.'" value="'.$answer.'">'.$answer.'</span>';
                        $res['data']['answers'] .= '<label class="answer-text select2" data-value="'.$answer.'">'.$problemInfo->{$answer}.'</label>';
                        $res['data']['answers'] .= '</div></div></div>';
                    }
                }
            }
            echo json_encode($res);
        }
    }
}
?>