<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('UserModel', 'ViewModel', 'AdminModel', 'EmailModel'));
        $this->load->helper(array('form', 'url', 'security'));
        $this->load->library(array('form_validation', 'session'));
    }

    function index($page = "", $param = "")
    {
        if ($page == "login") {
            $this->$page();
        } else if ($page == "logout") {
            $data = array('ts_login' => '', 'ts_uid' => '', 'ts_uname' => '', 'ts_userdata' => '');
            $this->session->unset_userdata($data);
            $this->session->sess_destroy();
            redirect("admin/login");
        } else {
            $func_name = str_replace("-", "_", $page);
            if (method_exists($this, $func_name))
                $this->$func_name($param);
            else
                $this->ViewModel->page404();
        }
    }

    function login()
    {
        if ($this->session->userdata("ts_login"))
            redirect("/");
        $this->form_validation->set_rules('uemail', 'Email Address', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('upwd', 'Password', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('lmsg', '');
            $this->load->view('user/login');
        } else {
            $uemail = $this->input->post("uemail");
            $upwd = $this->input->post("upwd");
            if ($userInfo = $this->UserModel->getUserInfo($uemail, $upwd)) {
                if ($userInfo->verification == 0) {
                    $this->session->set_flashdata('lmsg', 'Your account hasn\'t been verified.');
                    $this->load->view('user/login');
                } else if ($userInfo->status) {
                    $this->session->set_flashdata('lmsg', 'Your account has been suspended.');
                    $this->load->view('user/login');
                } else {
                    $sess_data = array('ts_login' => true, 'ts_rank' => $userInfo->rank, 'ts_uid' => $userInfo->uid, 'ts_userdata' => $userInfo);
                    $this->session->set_userdata($sess_data);
                    if (isset($_GET['redirect'])) {
                        $redirect = $this->input->get('redirect');
                        redirect($redirect);
                    } else
                        redirect("/");
                }
            } else {
                $this->session->set_flashdata('lmsg', 'Invalid Email Address or Password');
                $this->load->view('user/login');
            }
        }
    }

    function changeAccount()
    {
        if ($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');

            if ($userInfo->rank != 2) redirect('/');

            $data = array(
                'title' => "Account Overview",
                'page'  => 'Users',
                'menu'  => 'Users',
                'uinfo' => $userInfo,
                'styles'    => [],
                'scripts'   => [
                    'js/jquery.validate.min.js',
                ],
            );

            $this->load->view('layouts/admin/header', $data);
            $this->load->view('manager/myaccount');
            $this->load->view('layouts/admin/footer');
        }
    }

    function updateAccount()
    {
        if ($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');

            if ($userInfo->rank != 2) redirect('/');

            $res['status'] = true;
            $params = $this->input->post('params');
            $userId = $params[0]['value'];
            $uemail = $params[2]['value'];

            if (!$this->AdminModel->checkEmailAddress($userId, $uemail)) {
                $data = array(
                    'uname' => $params[1]['value'],
                    'uemail' => $params[2]['value']
                );
                $this->AdminModel->updateAccountInfo($data, $userId);
                $userInfo = $this->AdminModel->getUserInfo($userId);
                $sess_data = array('ts_login' => true, 'ts_rank' => $userInfo->rank, 'ts_uid' => $userInfo->uid, 'ts_userdata' => $userInfo);
                $this->session->set_userdata($sess_data);
            } else {
                $res['status'] = false;
            }
            echo json_encode($res);
        }
    }

    function changePassword()
    {
        if ($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');

            if ($userInfo->rank != 2) redirect('/');

            $data = array(
                'title' => "Change Password",
                'page'  => 'Users',
                'menu'  => 'Users',
                'uinfo' => $userInfo,
                'styles'    => [],
                'scripts'   => [
                    'js/jquery.validate.min.js',
                ],
            );

            $this->load->view('layouts/admin/header', $data);
            $this->load->view('manager/password');
            $this->load->view('layouts/admin/footer');
        }
    }

    function updatePassword()
    {
        if ($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');
            if ($userInfo->rank != 2) redirect('/');

            $res['status'] = true;
            $params = $this->input->post('params');
            $password = $params[0]['value'];
            $npassword = $params[1]['value'];
            $userCode = hash_hmac("sha1", $password, $userInfo->uemail);

            if ($password == $npassword) {
                $data = array(
                    'ucode' => $userCode,
                    'upwd'  => sha1($password),
                    'ureal' => $password
                );
                $this->AdminModel->updateUserPassword($data, $userInfo->uid);
            } else {
                $res['status'] = false;
            }
            echo json_encode($res);
        }
    }

    function users()
    {
        if ($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');

            if ($userInfo->rank != 2) redirect('admin/login');

            $users = $this->AdminModel->getAllUsers();

            $data = array(
                'title' => "All Users",
                'page'  => 'Users',
                'menu'  => 'Users',
                'users' => $users,
                'uinfo' => $userInfo,
                'styles'    => [
                    'vendors/dataTable/css/jquery.dataTables.min.css'
                ],
                'scripts'   => [
                    'admin/js/toggle-check-all.js',
                    'admin/js/check-selected-row.js',
                    'vendors/dataTable/js/jquery.dataTables.min.js',
                    'vendors/dataTable/js/dataTable-script.js'
                ]
            );

            $this->load->view('layouts/admin/header', $data);
            $this->load->view('manager/users');
            $this->load->view('layouts/admin/footer');
        } else {
            redirect('admin/login');
        }
    }

    function removeRowUsers()
    {
        if ($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');
            if ($userInfo->rank != 2) return;
            $params = $this->input->post('params');;
            $this->AdminModel->removeRowUsers($params[0]);
        }
    }

    function problem()
    {
        if ($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');

            if ($userInfo->rank != 2) redirect('admin/login');
            $problems = $this->AdminModel->getAllProblem();
            $PrTypes = $this->AdminModel->getProductType();
            $Refs  = $this->AdminModel->getProduct();
            $records = $this->AdminModel->getSubjects();
            $modules = $this->AdminModel->getModules();
            $data = array(
                'title' => 'Problem Managment',
                'page'  => 'Managment',
                'menu'  => 'Managment',
                'PrTypes'  => $PrTypes,
                'Refs'     => $Refs,
                'records'  => $records,
                'modules'  => $modules,
                'problems' => $problems,
                'uinfo'    => $userInfo,
                'styles'   => [
                    'vendors/dataTable/css/jquery.dataTables.min.css'
                ],
                'scripts'  => [
                    'admin/js/toggle-check-all.js',
                    'admin/js/check-selected-row.js',
                    'vendors/dataTable/js/jquery.dataTables.min.js',
                    'vendors/dataTable/js/dataTable-script.js'
                ]
            );

            $this->load->view('layouts/admin/header', $data);
            $this->load->view('manager/problem');
            $this->load->view('layouts/admin/footer');
        } else {
            redirect('admin/login');
        }
    }

    function problemRowFetch()
    {
        if ($this->session->userdata('ts_login')) {
            $userInfo = $this->session->userdata('ts_userdata');
            if ($userInfo->rank != 2) return;

            $selectType = $this->input->post('selectType');
            $selectCate = $this->input->post('selectCate');
            $selectSubj = $this->input->post('selectSubj');

            if ($selectType == '0' || $selectCate == '0' || $selectSubj == '0') {
                $problems = $this->AdminModel->getAllProblem();
            } else {
                $problems = $this->AdminModel->problemRowFetch($selectType, $selectCate, $selectSubj);
            }

            if (!empty($problems)) {
                $i = 1;
                foreach ($problems as $problem) { ?>

                    <tr data-id="<?= $problem->Id ?>" style="text-align: center;">
                        <td><?= $problem->Id ?></td>
                        <td><?= $problem->type ?></td>
                        <td id="appadd"><?= htmlentities($problem->question) ?></td>
                        <td><?= $problem->sub_type ?></td>
                        <td><?= $problem->category ?></td>
                        <td><?= $problem->subject ?></td>
                        <td><?= $problem->module ?></td>
                        <td>
                            <a href="<?= site_url("admin/edit-picture/{$problem->Id}") ?>" class="btn btn-primary btn-circle btn-sm mr-2"><i class="material-icons list-icon">add_a_photo</i></a>
                        </td>
                        <td>
                            <a href="<?= site_url("admin/edit-problem/{$problem->Id}") ?>" class="btn btn-dark btn-circle btn-sm mr-2"><i class="material-icons list-icon">edit</i></a>
                            <button type="button" class="btn btn-danger btn-circle btn-sm remove"><i class="material-icons list-icon">delete</i></button>
                        </td>
                    </tr>
                <?php
                    $i++;
                }
                ?> <?php
                } else {
                    ?>
                <tr>
                    <td align="right">No Data</td>
                </tr>
<?php
                }
            } else {
                redirect('admin/login');
            }
        }

        function addproblem()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');

                if ($userInfo->rank != 2) redirect('admin/login');
                $PrTypes = $this->AdminModel->getProductType();
                $Refs  = $this->AdminModel->getProduct();
                $subjects = $this->AdminModel->getSubjects();
                $modules = $this->AdminModel->getModules();
                $data = array(
                    'title' => 'Add Problem',
                    'page'  => 'Managment',
                    'menu'  => 'Managment',
                    'PrTypes'   => $PrTypes,
                    'Refs'      => $Refs,
                    'subjects'  => $subjects,
                    'modules'   => $modules,
                    'uinfo'     => $userInfo,
                    'styles'    => [
                        'vendors/quill/css/mathquill4quill.css',
                        'vendors/quill/css/mathquill.css',
                        'vendors/quill/css/katex.min.css',
                        'admin/css/quill.css'
                    ],
                    'scripts'   => [
                        'vendors/quill/js/mathquill4quill.js',
                        'vendors/quill/js/mathquill.min.js',
                        'vendors/quill/js/katex.min.js',
                        'vendors/quill/js/quill.min.js',
                        'js/jquery.validate.min.js'
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/add_problem');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }


        function edit_problem($id)
        {
            if ($this->session->userdata('ts_login')) {
                if (!$id) redirect('admin/problem');
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');

                $PrTypes = $this->AdminModel->getProductType();
                $Refs  = $this->AdminModel->getProduct();
                $subjects = $this->AdminModel->getSubjects();
                $modules = $this->AdminModel->getModules();

                $record = $this->AdminModel->getEditProblemRow($id);
                if (!$record) redirect('/');

                $data = array(
                    'page'      => 'Managment',
                    'menu'      => 'Managment',
                    'title'     => 'Update Problem',
                    'PrTypes'   => $PrTypes,
                    'Refs'      => $Refs,
                    'subjects'  => $subjects,
                    'modules'   => $modules,
                    'uinfo'     => $userInfo,
                    'record'    => $record,
                    'styles'    => [
                        'vendors/quill/css/mathquill4quill.css',
                        'vendors/quill/css/mathquill.css',
                        'vendors/quill/css/katex.min.css',
                        'admin/css/quill.css'
                    ],
                    'scripts'   => [
                        'vendors/quill/js/mathquill4quill.js',
                        'vendors/quill/js/mathquill.min.js',
                        'vendors/quill/js/katex.min.js',
                        'vendors/quill/js/quill.min.js',
                        'js/jquery.validate.min.js',
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/edit_problem');
                $this->load->view('layouts/admin/footer');
            }
        }

        function uploadPRFile_1($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->PR1) {
                    unlink(FCPATH . "assets/upload/{$record->PR1}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'PR1'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadPRFile_2($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->PR2) {
                    unlink(FCPATH . "assets/upload/{$record->PR2}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'PR2'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadPRFile_3($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->PR3) {
                    unlink(FCPATH . "assets/upload/{$record->PR3}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'PR3'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadPRFile_4($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->PR4) {
                    unlink(FCPATH . "assets/upload/{$record->PR4}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'PR4'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadPRFile_5($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->PR5) {
                    unlink(FCPATH . "assets/upload/{$record->PR5}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'PR5'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadPRFile_6($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->PR6) {
                    unlink(FCPATH . "assets/upload/{$record->PR6}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'PR6'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadPRFile_7($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->PR7) {
                    unlink(FCPATH . "assets/upload/{$record->PR7}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'PR7'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadPRFile_8($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->PR8) {
                    unlink(FCPATH . "assets/upload/{$record->PR8}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'PR8'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadPRFile_9($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->PR9) {
                    unlink(FCPATH . "assets/upload/{$record->PR9}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'PR9'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadPRFile_10($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->PR10) {
                    unlink(FCPATH . "assets/upload/{$record->PR10}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'PR10'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadSRFile_1($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->SR1) {
                    unlink(FCPATH . "assets/upload/{$record->SR1}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'SR1'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadSRFile_2($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->SR2) {
                    unlink(FCPATH . "assets/upload/{$record->SR2}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'SR2'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadSRFile_3($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->SR3) {
                    unlink(FCPATH . "assets/upload/{$record->SR3}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'SR3'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadSRFile_4($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->SR4) {
                    unlink(FCPATH . "assets/upload/{$record->SR4}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'SR4'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadSRFile_5($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->SR5) {
                    unlink(FCPATH . "assets/upload/{$record->SR5}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'SR5'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function uploadSRFile_6($id)
        {
            if (!empty($_FILES['file']['name'])) {

                $record = $this->AdminModel->getEditProblemRow($id);
                if ($record->SR6) {
                    unlink(FCPATH . "assets/upload/{$record->SR6}");
                }

                $config['upload_path'] = './assets/upload/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 1024 * 2;
                $config['file_name'] = $_FILES['file']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();

                    $data = array(
                        'SR6'   => $uploadData['file_name']
                    );

                    $this->AdminModel->saveImageInfo($data, $id);
                }
            }
        }

        function createproblem()
        {
            if ($this->session->userdata('ts_login')) {
                if ($this->session->userdata("ts_rank") != 2) return;
                $params = $this->input->post('params');

                if ($params[2]['value'] == 'Yes') {
                    $params[2]['value'] = 'Y';
                } else {
                    $params[2]['value'] = 'N';
                }

                $data = array(
                    'type'                  => $params[0]['value'],
                    'product_unique_ref'    => $params[1]['value'],
                    'sq'                    => $params[2]['value'],
                    'sub_type'              => $params[3]['value'],
                    'category'              => $params[4]['value'],
                    'subject'               => $params[5]['value'],
                    'module'                => $params[6]['value'],
                    'correct'               => $params[7]['value'],
                    'question_number'       => $params[8]['value'],
                    'question'              => $params[9]['value'],
                    'explanation'           => $params[10]['value'],
                    'A'                     => $params[11]['value'],
                    'B'                     => $params[12]['value'],
                    'C'                     => $params[13]['value'],
                    'D'                     => $params[14]['value'],
                    'E'                     => $params[15]['value'],
                    'F'                     => $params[16]['value'],
                    'G'                     => $params[17]['value'],
                    'H'                     => $params[18]['value'],
                    'I'                     => $params[19]['value'],
                    'J'                     => $params[20]['value']
                );
                $this->AdminModel->saveQuestion($data);
            }
        }

        function edit_picture($id)
        {
            if ($this->session->userdata('ts_login')) {
                if (!$id) redirect('admin/problem');
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');

                $data = array(
                    'page'      => 'Managment',
                    'menu'      => 'Managment',
                    'title'     => 'Link Reference Pictures',
                    'uinfo'     => $userInfo,
                    'prnumber'  => $id,
                    'styles'    => [
                        'vendors/dropzone/dropzone.css'  // me
                    ],
                    'scripts'   => [
                        'vendors/dropzone/dropzone.js',   // me
                        'js/jquery.validate.min.js'
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/link_picture');
                $this->load->view('layouts/admin/footer');
            }
        }

        function updateproblem()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');
                $params = $this->input->post('params');

                $rowId = $params[0]['value'];

                if ($params[3]['value'] == 'Yes') {
                    $params[3]['value'] = 'Y';
                } else {
                    $params[3]['value'] = 'N';
                }

                $data = array(
                    'type'                  => $params[1]['value'],
                    'product_unique_ref'    => $params[2]['value'],
                    'sq'                    => $params[3]['value'],
                    'sub_type'              => $params[4]['value'],
                    'category'              => $params[5]['value'],
                    'subject'               => $params[6]['value'],
                    'module'                => $params[7]['value'],
                    'correct'               => $params[8]['value'],
                    'question'              => $params[9]['value'],
                    'explanation'           => $params[10]['value'],
                    'A'                     => $params[11]['value'],
                    'B'                     => $params[12]['value'],
                    'C'                     => $params[13]['value'],
                    'D'                     => $params[14]['value'],
                    'E'                     => $params[15]['value'],
                    'F'                     => $params[16]['value'],
                    'G'                     => $params[17]['value'],
                    'H'                     => $params[18]['value'],
                    'I'                     => $params[19]['value'],
                    'J'                     => $params[20]['value']
                );

                $this->AdminModel->updateProblem($data, $rowId);
            }
        }

        function removeRowProblem()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) return;
                $params = $this->input->post('params');

                $record = $this->AdminModel->getEditProblemRow($params[0]);
                if ($record) {
                    unlink(FCPATH . "assets/upload/{$record->PR1}");
                    unlink(FCPATH . "assets/upload/{$record->PR2}");
                    unlink(FCPATH . "assets/upload/{$record->PR3}");
                    unlink(FCPATH . "assets/upload/{$record->PR4}");
                    unlink(FCPATH . "assets/upload/{$record->PR5}");
                    unlink(FCPATH . "assets/upload/{$record->PR6}");
                    unlink(FCPATH . "assets/upload/{$record->PR7}");
                    unlink(FCPATH . "assets/upload/{$record->PR8}");
                    unlink(FCPATH . "assets/upload/{$record->PR9}");
                    unlink(FCPATH . "assets/upload/{$record->PR10}");
                    unlink(FCPATH . "assets/upload/{$record->SR1}");
                    unlink(FCPATH . "assets/upload/{$record->SR2}");
                    unlink(FCPATH . "assets/upload/{$record->SR3}");
                    unlink(FCPATH . "assets/upload/{$record->SR4}");
                    unlink(FCPATH . "assets/upload/{$record->SR5}");
                    unlink(FCPATH . "assets/upload/{$record->SR6}");
                }

                $this->AdminModel->removeRowProblem($params[0]);
            }
        }

        function product()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');

                if ($userInfo->rank != 2) redirect('admin/login');
                $records = $this->AdminModel->getProduct();
                $data = array(
                    'page'          => 'Product',
                    'menu'          => 'Change Setting',
                    'title'         => 'Product',
                    'records'       => $records,
                    'uinfo'         => $userInfo,
                    'styles'    => [
                        'vendors/dataTable/css/jquery.dataTables.min.css'
                    ],
                    'scripts'   => [
                        'admin/js/toggle-check-all.js',
                        'admin/js/check-selected-row.js',
                        'vendors/dataTable/js/jquery.dataTables.min.js',
                        'vendors/dataTable/js/dataTable-script.js'
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/product');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function newproduct()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('admin/login');

                $products = $this->AdminModel->getProductType();
                $subjects = $this->AdminModel->getSubjects();
                $subjecttypes = $this->AdminModel->getSubjectType();
                $modules = $this->AdminModel->getModules();
                $prices = $this->AdminModel->getPrice();
                $timeAllows = $this->AdminModel->getDuration();
                $data = array(
                    'page'          => 'Product',
                    'menu'          => 'Change Setting',
                    'title'         => 'Add Product',
                    'products'      => $products,
                    'subjects'      => $subjects,
                    'subjecttypes'  => $subjecttypes,
                    'modules'       => $modules,
                    'prices'        => $prices,
                    'timeAllows'    => $timeAllows,
                    'uinfo'         => $userInfo,
                    'styles'        => [],
                    'scripts'       => [
                        'js/jquery.validate.min.js',
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/add_product');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function createproduct()
        {
            if ($this->session->userdata('ts_login')) {
                if ($this->session->userdata("ts_rank") != 2) return;
                $params = $this->input->post('params');

                $data = array(
                    'product'               => $params[0]['value'],
                    'product_id'            => intval($params[1]['value']),
                    'subject'               => $params[2]['value'],
                    'subject_id'            => intval($params[3]['value']),
                    'subject_type'          => $params[4]['value'],
                    'subject_type_id'       => intval($params[5]['value']),
                    'module'                => $params[6]['value'],
                    'module_id'             => intval($params[7]['value']),
                    'price_usd'             => intval($params[8]['value']),
                    'price_id'              => intval($params[9]['value']),
                    'test_duration'         => $params[10]['value'],
                    'number_of_question'    => $params[11]['value'],
                    'test_date'             => date($params[12]['value']),
                    'test_time_gmt'         => date($params[13]['value']),
                    'product_unique_ref'    => date($params[14]['value']),
                    'validity'              => intval($params[15]['value'])
                );
                $this->AdminModel->saveNewProductInfo($data);
            }
        }

        function edit_product($id)
        {
            if ($this->session->userdata('ts_login')) {
                if (!$id) redirect('admin/product');
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');

                $products = $this->AdminModel->getProductType();
                $subjects = $this->AdminModel->getSubjects();
                $subjecttypes = $this->AdminModel->getSubjectType();
                $modules = $this->AdminModel->getModules();
                $prices = $this->AdminModel->getPrice();
                $timeAllows = $this->AdminModel->getDuration();

                $record = $this->AdminModel->getEditProductRow($id);
                if (!$record) redirect('/');

                $data = array(
                    'page'      => 'Product',
                    'menu'      => 'Change Setting',
                    'title'     => 'Update Product',
                    'products'      => $products,
                    'subjects'      => $subjects,
                    'subjecttypes'  => $subjecttypes,
                    'modules'       => $modules,
                    'prices'        => $prices,
                    'timeAllows'    => $timeAllows,
                    'uinfo'         => $userInfo,
                    'record'    => $record,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/edit_product');
                $this->load->view('layouts/admin/footer');
            }
        }

        function updateproduct()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');
                $params = $this->input->post('params');

                $rowId = $params[0]['value'];
                $data = array(
                    'product'               => $params[1]['value'],
                    'product_id'            => intval($params[2]['value']),
                    'subject'               => $params[3]['value'],
                    'subject_id'            => intval($params[4]['value']),
                    'subject_type'          => $params[5]['value'],
                    'subject_type_id'       => intval($params[6]['value']),
                    'module'                => $params[7]['value'],
                    'module_id'             => intval($params[8]['value']),
                    'price_usd'             => intval($params[9]['value']),
                    'price_id'              => intval($params[10]['value']),
                    'test_duration'         => $params[11]['value'],
                    'number_of_question'    => $params[12]['value'],
                    'test_date'             => date($params[13]['value']),
                    'test_time_gmt'         => date($params[14]['value']),
                    'product_unique_ref'    => date($params[15]['value']),
                    'validity'              => intval($params[16]['value'])
                );

                $this->AdminModel->updateProduct($data, $rowId);
            }
        }

        function removeRowProduct()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) return;
                $params = $this->input->post('params');
                $this->AdminModel->removeRowProduct($params[0]);
            }
        }

        function subject()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');

                if ($userInfo->rank != 2) redirect('admin/login');

                $records = $this->AdminModel->getSubjects();
                $data = array(
                    'page'      => 'Subject',
                    'menu'      => 'Change Setting',
                    'title'     => 'Subject',
                    'uinfo'     => $userInfo,
                    'records'   => $records,
                    'styles'    => [
                        'vendors/dataTable/css/jquery.dataTables.min.css'
                    ],
                    'scripts'   => [
                        'admin/js/toggle-check-all.js',
                        'admin/js/check-selected-row.js',
                        'vendors/dataTable/js/jquery.dataTables.min.js',
                        'vendors/dataTable/js/dataTable-script.js'
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/subject');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function newsubject()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('admin/login');
                $data = array(
                    'page'      => 'Subject',
                    'menu'      => 'Change Setting',
                    'title'     => 'Add Subject',
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/add_subject');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function createsubject()
        {
            if ($this->session->userdata('ts_login')) {
                if ($this->session->userdata("ts_rank") != 2) return;
                $params = $this->input->post('params');

                $data = array(
                    'subject'       => $params[0]['value'],
                    'subject_id'    => $params[1]['value'],
                    'validity'      => intval($params[2]['value'])
                );
                $this->AdminModel->saveNewSubjectInfo($data);
            }
        }

        function edit_subject($id)
        {
            if ($this->session->userdata('ts_login')) {
                if (!$id) redirect('admin/subject');
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');

                $record = $this->AdminModel->getEditSubjectRow($id);
                if (!$record) redirect('/');

                $data = array(
                    'page'      => 'Subject',
                    'menu'      => 'Change Setting',
                    'title'     => 'Update Subject',
                    'record'    => $record,
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/edit_subject');
                $this->load->view('layouts/admin/footer');
            }
        }

        function updatesubject()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');
                $params = $this->input->post('params');

                $rowId = $params[0]['value'];
                $data = array(
                    'subject'       => $params[1]['value'],
                    'subject_id'    => $params[2]['value'],
                    'validity'      => intval($params[3]['value'])
                );

                $this->AdminModel->updateSubject($data, $rowId);
            }
        }

        function removeRowSubject()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) return;
                $params = $this->input->post('params');
                $this->AdminModel->removeRowSubject($params[0]);
            }
        }

        function subjecttype()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');

                if ($userInfo->rank != 2) redirect('admin/login');

                $records = $this->AdminModel->getSubjectType();
                $data = array(
                    'page'      => 'Subject Type',
                    'menu'      => 'Change Setting',
                    'title'     => 'Subject Type',
                    'uinfo'     => $userInfo,
                    'records'   => $records,
                    'styles'    => [
                        'vendors/dataTable/css/jquery.dataTables.min.css'
                    ],
                    'scripts'   => [
                        'admin/js/toggle-check-all.js',
                        'admin/js/check-selected-row.js',
                        'vendors/dataTable/js/jquery.dataTables.min.js',
                        'vendors/dataTable/js/dataTable-script.js'
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/subjecttype');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function newsubjecttype()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('admin/login');
                $data = array(
                    'page'      => 'Subject Type',
                    'menu'      => 'Change Setting',
                    'title'     => 'New Subject Type',
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/add_subjecttype');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function createsubjecttype()
        {
            if ($this->session->userdata('ts_login')) {
                if ($this->session->userdata("ts_rank") != 2) return;
                $params = $this->input->post('params');

                $data = array(
                    'subject_type'   => $params[0]['value'],
                    'type_id'        => $params[1]['value'],
                    'validity'       => intval($params[2]['value'])
                );
                $this->AdminModel->saveNewSubjectTypeInfo($data);
            }
        }

        function edit_subjecttype($id)
        {
            if ($this->session->userdata('ts_login')) {
                if (!$id) redirect('admin/producttype');
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');

                $record = $this->AdminModel->getEditSubjectTypeRow($id);
                if (!$record) redirect('/');

                $data = array(
                    'page'      => 'Subject Type',
                    'menu'      => 'Change Setting',
                    'title'     => 'Update Subject Type',
                    'record'    => $record,
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/edit_subjecttype');
                $this->load->view('layouts/admin/footer');
            }
        }

        function updatesubjecttype()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');
                $params = $this->input->post('params');

                $rowId = $params[0]['value'];
                $data = array(
                    'subject_type'   => $params[1]['value'],
                    'type_id'        => $params[2]['value'],
                    'validity'       => intval($params[3]['value'])
                );

                $this->AdminModel->updateSubjectType($data, $rowId);
            }
        }

        function removeRowsubjecttype()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) return;
                $params = $this->input->post('params');
                $this->AdminModel->removeRowSubjectType($params[0]);
            }
        }

        function module()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');

                if ($userInfo->rank != 2) redirect('admin/login');

                $records = $this->AdminModel->getModules();
                $data = array(
                    'page'      => 'Module',
                    'menu'      => 'Change Setting',
                    'title'     => 'Module',
                    'uinfo'     => $userInfo,
                    'records'   => $records,
                    'styles'    => [
                        'vendors/dataTable/css/jquery.dataTables.min.css'
                    ],
                    'scripts'   => [
                        'admin/js/toggle-check-all.js',
                        'admin/js/check-selected-row.js',
                        'vendors/dataTable/js/jquery.dataTables.min.js',
                        'vendors/dataTable/js/dataTable-script.js'
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/module');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function newmodule()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('admin/login');
                $data = array(
                    'page'      => 'Module',
                    'menu'      => 'Change Setting',
                    'title'     => 'Add Module',
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/add_module');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function createmodule()
        {
            if ($this->session->userdata('ts_login')) {
                if ($this->session->userdata("ts_rank") != 2) return;
                $params = $this->input->post('params');

                $data = array(
                    'module'        => $params[0]['value'],
                    'module_id'     => $params[1]['value'],
                    'validity'      => intval($params[2]['value'])
                );
                $this->AdminModel->saveNewModuleInfo($data);
            }
        }

        function edit_module($id)
        {
            if ($this->session->userdata('ts_login')) {
                if (!$id) redirect('admin/producttype');
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');

                $record = $this->AdminModel->getEditModuleRow($id);
                if (!$record) redirect('/');

                $data = array(
                    'page'      => 'Module',
                    'menu'      => 'Change Setting',
                    'title'     => 'Update Module',
                    'record'    => $record,
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/edit_module');
                $this->load->view('layouts/admin/footer');
            }
        }

        function updatemodule()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');
                $params = $this->input->post('params');

                $rowId = $params[0]['value'];
                $data = array(
                    'module'        => $params[1]['value'],
                    'module_id'     => $params[2]['value'],
                    'validity'      => intval($params[3]['value'])
                );

                $this->AdminModel->updateModule($data, $rowId);
            }
        }

        function removeRowModule()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) return;
                $params = $this->input->post('params');
                $this->AdminModel->removeRowModule($params[0]);
            }
        }

        function producttype()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('admin/login');

                $data = array(
                    'page'      => 'Product Type',
                    'menu'      => 'Change Setting',
                    'title'     => 'Product Type',
                    'uinfo'     => $userInfo,
                    'styles'    => [
                        'vendors/dataTable/css/jquery.dataTables.min.css'
                    ],
                    'scripts'   => [
                        'vendors/dataTable/js/jquery.dataTables.min.js',
                        'js/jquery.validate.min.js'
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/producttype');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function productTypeList()
        {
            $res = array(
                "draw" => intval($this->input->post('draw')),
                'data' => array(),
                'expired' =>  false,
            );
            if ($this->session->userdata('ts_login')) {
                $records = $this->AdminModel->getProductType();
                $status = array(
                    '<span class="badge bg-danger">Inactive</span>',
                    '<span class="badge bg-success">Active</span>'
                );
                foreach ($records as $key => $record) {
                    $row = array();
                    $row['index'] = $key + 1;
                    $row['pid'] = $record->product_id;
                    $row['type'] = $record->product_type;
                    $row['status'] = $status[$record->validity];
                    $row['action'] = '<a href="' . site_url("admin/edit-producttype/{$record->product_id}") . '" class="btn btn-dark btn-circle btn-sm mr-2">
                                    <i class="material-icons list-icon">edit</i>
                                </a>
                                <button type="button" class="btn btn-danger btn-circle btn-sm remove-type" data-id="' . $record->product_id . '">
                                    <i class="material-icons list-icon">delete</i>
                                </button>';
                    $res['data'][] = $row;
                }
            } else {
                $res['expired'] = true;
                $res['url'] = site_url("login");
            }
            echo json_encode($res);
        }

        function newproducttype()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('admin/login');
                $data = array(
                    'page'      => 'Product Type',
                    'menu'      => 'Change Setting',
                    'title'     => 'Add Product Type',
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/add_producttype');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function createproducttype()
        {
            $res['required'] = false;
            if ($this->session->userdata('ts_login')) {
                $params = $this->input->post('params');
                $data = array(
                    'product_type' => $params[0]['value'],
                );
                $this->AdminModel->saveProductTypeInfo($data);
            } else {
                $res['expired'] = true;
                $res['message'] = "Your session has timed out. Please sign in again.";
                $res['url'] = site_url("login");
            }
            echo json_encode($res);
        }

        function edit_producttype($id)
        {
            if ($this->session->userdata('ts_login')) {
                if (!$id) redirect('admin/producttype');
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');

                $record = $this->AdminModel->getProductTypeInfo($id);
                if (!$record) redirect('/');

                $data = array(
                    'page'      => 'Product Type',
                    'menu'      => 'Change Setting',
                    'title'     => 'Update Product Type',
                    'record'    => $record,
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/edit_producttype');
                $this->load->view('layouts/admin/footer');
            }
        }

        function updateproducttype()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');
                $params = $this->input->post('params');

                $rowId = $params[0]['value'];
                $data = array(
                    'product_type' => $params[1]['value'],
                    'validity'     => $params[2]['value']
                );
                $this->AdminModel->updateProductType($data, $rowId);
            }
        }

        function removeProductType()
        {
            if ($this->session->userdata('ts_login')) {
                $param = $this->input->post('param');
                $this->AdminModel->removeProductType($param);
            }
        }

        function price()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');

                if ($userInfo->rank != 2) redirect('admin/login');

                $records = $this->AdminModel->getPrice();
                $data = array(
                    'page'      => 'Price',
                    'menu'      => 'Change Setting',
                    'title'     => 'Price',
                    'uinfo'     => $userInfo,
                    'records'   => $records,
                    'styles'    => [
                        'vendors/dataTable/css/jquery.dataTables.min.css'
                    ],
                    'scripts'   => [
                        'admin/js/toggle-check-all.js',
                        'admin/js/check-selected-row.js',
                        'vendors/dataTable/js/jquery.dataTables.min.js',
                        'vendors/dataTable/js/dataTable-script.js'
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/price');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function newprice()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('admin/login');
                $data = array(
                    'page'      => 'Price',
                    'menu'      => 'Change Setting',
                    'title'     => 'Add Price',
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/add_price');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function createprice()
        {
            if ($this->session->userdata('ts_login')) {
                if ($this->session->userdata("ts_rank") != 2) return;
                $params = $this->input->post('params');

                $data = array(
                    'price_usd'   => $params[0]['value'],
                    'price_id'    => $params[1]['value'],
                    'validity'    => intval($params[2]['value'])
                );
                $this->AdminModel->saveNewPriceInfo($data);
            }
        }

        function edit_price($id)
        {
            if ($this->session->userdata('ts_login')) {
                if (!$id) redirect('admin/price');
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');

                $record = $this->AdminModel->getEditPriceRow($id);
                if (!$record) redirect('/');

                $data = array(
                    'page'      => 'Price',
                    'menu'      => 'Change Setting',
                    'title'     => 'Update Price',
                    'record'    => $record,
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/edit_price');
                $this->load->view('layouts/admin/footer');
            }
        }

        function updateprice()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');
                $params = $this->input->post('params');

                $rowId = $params[0]['value'];
                $data = array(
                    'price_usd'   => $params[1]['value'],
                    'price_id'    => $params[2]['value'],
                    'validity'    => intval($params[3]['value'])
                );

                $this->AdminModel->updatePrice($data, $rowId);
            }
        }

        function removeRowPrice()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) return;
                $params = $this->input->post('params');
                $this->AdminModel->removeRowPrice($params[0]);
            }
        }

        function duration()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');

                if ($userInfo->rank != 2) redirect('admin/login');

                $records = $this->AdminModel->getDuration();
                $data = array(
                    'page'      => 'Duration',
                    'menu'      => 'Change Setting',
                    'title'     => 'Duration',
                    'uinfo'     => $userInfo,
                    'records'   => $records,
                    'styles'    => [
                        'vendors/dataTable/css/jquery.dataTables.min.css'
                    ],
                    'scripts'   => [
                        'admin/js/toggle-check-all.js',
                        'admin/js/check-selected-row.js',
                        'vendors/dataTable/js/jquery.dataTables.min.js',
                        'vendors/dataTable/js/dataTable-script.js'
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/duration');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function newduration()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('admin/login');
                $data = array(
                    'page'      => 'Duration',
                    'menu'      => 'Change Setting',
                    'title'     => 'Add Duration',
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/add_duration');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function createduration()
        {
            if ($this->session->userdata('ts_login')) {
                if ($this->session->userdata("ts_rank") != 2) return;
                $params = $this->input->post('params');

                $data = array(
                    'test_duration'   => intval($params[0]['value']),
                    'unit'            => $params[1]['value'],
                    'validity'        => intval($params[2]['value'])
                );
                $this->AdminModel->saveNewDurationInfo($data);
            }
        }

        function edit_duration($id)
        {
            if ($this->session->userdata('ts_login')) {
                if (!$id) redirect('admin/duration');
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');

                $record = $this->AdminModel->getEditDurationRow($id);
                if (!$record) redirect('/');

                $data = array(
                    'page'      => 'Duration',
                    'menu'      => 'Change Setting',
                    'title'     => 'Update Duration',
                    'record'    => $record,
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/edit_duration');
                $this->load->view('layouts/admin/footer');
            }
        }

        function updateduration()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');
                $params = $this->input->post('params');

                $rowId = $params[0]['value'];
                $data = array(
                    'test_duration'   => intval($params[1]['value']),
                    'unit'            => $params[2]['value'],
                    'validity'        => intval($params[3]['value'])
                );

                $this->AdminModel->updateDuration($data, $rowId);
            }
        }

        function removeRowDuration()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) return;
                $params = $this->input->post('params');
                $this->AdminModel->removeRowDuration($params[0]);
            }
        }

        function generate()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');

                if ($userInfo->rank != 2)  redirect('admin/login');

                $records = $this->AdminModel->getGenerate();
                $data = array(
                    'page'      => 'Generate',
                    'menu'      => 'Change Setting',
                    'title'     => 'Generate',
                    'uinfo'     => $userInfo,
                    'records'   => $records,
                    'styles'    => [
                        'vendors/dataTable/css/jquery.dataTables.min.css'
                    ],
                    'scripts'   => [
                        'admin/js/toggle-check-all.js',
                        'admin/js/check-selected-row.js',
                        'vendors/dataTable/js/jquery.dataTables.min.js',
                        'vendors/dataTable/js/dataTable-script.js'
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/generate');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function newgenerate()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('admin/login');

                $products = $this->AdminModel->getProductType();
                $subjects = $this->AdminModel->getSubjects();
                $modules = $this->AdminModel->getModules();
                $subjecttypes = $this->AdminModel->getSubjectType();
                $timeAllows = $this->AdminModel->getDuration();

                $data = array(
                    'page'          => 'Generate',
                    'menu'          => 'Change Setting',
                    'title'         => 'Generate a New Set',
                    'products'      => $products,
                    'subjects'      => $subjects,
                    'modules'       => $modules,
                    'uinfo'         => $userInfo,
                    'subjecttypes'  => $subjecttypes,
                    'timeAllows'    => $timeAllows,
                    'styles'        => [],
                    'scripts'       => [
                        'js/jquery.validate.min.js',
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/add_generate');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function saveGenerate()
        {
            $res['expired'] = false;
            if ($this->session->userdata('ts_login')) {
                $res['status'] = true;
                $params = $this->input->post('params');

                $problems = $this->AdminModel->getProductListBySet($params[1]['value'], $params[2]['value'], $params[3]['value'], $params[4]['value'], $params[5]['value']);
                if ($problems) {
                    $problemIds = array_column($problems, "pid");
                    $problemIds = implode(",", $problemIds);
                    $data = array(
                        'set_id'             => $params[0]['value'],
                        'product_id'         => $params[1]['value'],
                        'subject_id'         => $params[2]['value'],
                        'module_id'          => $params[3]['value'],
                        'subject_type_id'    => $params[4]['value'],
                        'time_allowed'       => $params[5]['value'],
                        'assigned_questions' => $problemIds,
                    );

                    if ($this->AdminModel->saveGenerateInfo($data)) {
                        $res['data'] = $problemIds;
                        $res['message'] = "Questions has been assigned successfully to the set.";
                    } else {
                        $res['status'] = false;
                        $res['message'] = "The Set ID already exist. Please enter a unique ID.";
                    }
                } else {
                    $res['status'] = false;
                    $res['message'] = "There are not products that match the options.";
                }
            } else {
                $res['expired'] = true;
                $res['url'] = site_url("login");
            }
            echo json_encode($res);
        }

        function edit_generate($id)
        {
            if ($this->session->userdata('ts_login')) {
                if (!$id) redirect('admin/generate');
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');

                $products = $this->AdminModel->getProductType();
                $subjects = $this->AdminModel->getSubjects();
                $modules = $this->AdminModel->getModules();
                $subjecttypes = $this->AdminModel->getSubjectType();
                $timeAllows = $this->AdminModel->getDuration();

                $record = $this->AdminModel->getEditGenerateRow($id);
                if (!$record) redirect('/');

                $data = array(
                    'page'      => 'Generate',
                    'menu'      => 'Change Setting',
                    'title'     => 'Update Generate GUI',
                    'products'      => $products,
                    'subjects'      => $subjects,
                    'modules'       => $modules,
                    'subjecttypes'  => $subjecttypes,
                    'timeAllows'    => $timeAllows,
                    'record'        => $record,
                    'uinfo'         => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/edit_generate');
                $this->load->view('layouts/admin/footer');
            }
        }

        function updategenerate()
        {
            $res['expired'] = false;
            if ($this->session->userdata('ts_login')) {
                $res['status'] = true;
                $params = $this->input->post('params');

                $problems = $this->AdminModel->getProductListBySet($params[2]['value'], $params[3]['value'], $params[4]['value'], $params[5]['value'], $params[6]['value']);
                if ($problems) {
                    $problemIds = array_column($problems, "pid");
                    $problemIds = implode(",", $problemIds);
                    $rowId = $params[0]['value'];
                    $data = array(
                        'product_id'            => $params[2]['value'],
                        'subject_id'            => $params[3]['value'],
                        'module_id'             => $params[4]['value'],
                        'subject_type_id'       => $params[5]['value'],
                        'time_allowed'          => $params[6]['value'],
                        'assigned_questions'    => $problemIds,
                        'validity'              => $params[8]['value']
                    );
                    $this->AdminModel->updateGenerate($data, $rowId);
                    $res['data'] = $problemIds;
                    $res['message'] = "The Set has been updated successfully.";
                } else {
                    $res['status'] = false;
                    $res['message'] = "There are not products that match the options.";
                }
            } else {
                $res['expired'] = true;
                $res['url'] = site_url("login");
            }
            echo json_encode($res);
        }

        function removeRowGenerate()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) return;
                $params = $this->input->post('params');
                $this->AdminModel->removeRowGenerate($params[0]);
            }
        }

        function connect()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');

                if ($userInfo->rank != 2) redirect('admin/login');

                $records = $this->AdminModel->getConnect();
                $data = array(
                    'page'      => 'Connect',
                    'menu'      => 'Change Setting',
                    'title'     => 'Connect',
                    'uinfo'     => $userInfo,
                    'records'   => $records,
                    'styles'    => [
                        'vendors/dataTable/css/jquery.dataTables.min.css'
                    ],
                    'scripts'   => [
                        'admin/js/toggle-check-all.js',
                        'admin/js/check-selected-row.js',
                        'vendors/dataTable/js/jquery.dataTables.min.js',
                        'vendors/dataTable/js/dataTable-script.js'
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/connect');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function newconnect()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('admin/login');
                $generates = $this->AdminModel->getGenerate();
                $data = array(
                    'page'      => 'Connect',
                    'menu'      => 'Change Setting',
                    'title'     => 'New Connection',
                    'generates'  => $generates,
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );
                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/add_connect');
                $this->load->view('layouts/admin/footer');
            } else {
                redirect('admin/login');
            }
        }

        function connectsetid()
        {
            if ($this->session->userdata('ts_login')) {
                if ($this->session->userdata("ts_rank") != 2) return;
                $params = $this->input->post('params');

                $data = array(
                    'association_id'        => $params[0]['value'],
                    'set_id'                => $params[1]['value'],
                    'validity'              => intval($params[2]['value'])
                );
                $this->AdminModel->saveConnectInfo($data);
            }
        }

        function edit_connect($id)
        {
            if ($this->session->userdata('ts_login')) {
                if (!$id) redirect('admin/connect');
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');
                $record = $this->AdminModel->getEditConnectRow($id);
                if (!$record) redirect('/');
                $generates = $this->AdminModel->getGenerate();

                $data = array(
                    'page'      => 'Connect',
                    'menu'      => 'Change Setting',
                    'title'     => 'Update Connection',
                    'record'    => $record,
                    'generates' => $generates,
                    'uinfo'     => $userInfo,
                    'styles'    => [],
                    'scripts'   => [
                        'js/jquery.validate.min.js',
                    ]
                );

                $this->load->view('layouts/admin/header', $data);
                $this->load->view('manager/edit_connect');
                $this->load->view('layouts/admin/footer');
            }
        }

        function updateconnect()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) redirect('/');
                $params = $this->input->post('params');

                $rowId = $params[0]['value'];
                $data = array(
                    'association_id'        => $params[1]['value'],
                    'set_id'                => $params[2]['value'],
                    'validity'              => intval($params[3]['value'])
                );

                $this->AdminModel->updateConnect($data, $rowId);
            }
        }

        function removeRowConnect()
        {
            if ($this->session->userdata('ts_login')) {
                $userInfo = $this->session->userdata('ts_userdata');
                if ($userInfo->rank != 2) return;
                $params = $this->input->post('params');
                $this->AdminModel->removeRowConnect($params[0]);
            }
        }
    }
