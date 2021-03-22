<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Rest extends REST_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('UserModel','ViewModel', 'StudentModel', 'AdminModel'));
        $this->load->helper(array('form','url','security'));
        $this->load->library(array('form_validation','session'));
    }

    function index_post($page="", $param="") {
		$func_name = str_replace("-", "_", $page);
		if (method_exists($this, $func_name))
			$this->$func_name($param);
		else 
			$this->ViewModel->page404();
    }

    private function loadTestPage($data, $type) {
        $setId = $data->setId; 
        $userId = $data->userId; 
        $product_unique_ref = $data->product_unique_ref; 
        $associationId = $data->associationId; 
        $identifier = $data->identifier;
        $res['status'] = true;
        $problems = $this->StudentModel->getProblemListByUniqueRef($product_unique_ref, $type);
        if ($problems) {
            $setInfo = $this->StudentModel->getSetInfo($setId);
            // save candidate info
            $dropbox = $this->StudentModel->getDropboxInfoByIdentifier($identifier);
            if (!$dropbox) {
                $testDate = gmdate("Y-m-d");
                $testTime = gmdate("H:i:s");
                $dropbox = array(
                    'identifier'         => $identifier,
                    'userid'             => $userId,
                    'product_unique_ref' => $product_unique_ref,
                    'association_id'     => $associationId,
                    'test_date'          => $testDate,
                    'test_time_gmt'      => $testTime,
                    'set_id'             => $setId,
                    'time_allowed'       => $setInfo->time_allowed,
                );
                $dropbox['Id'] = $this->StudentModel->saveDropboxInfo($dropbox);
            } else {
                $dropboxInfo = array(
                    'score' => 0,
                    'special_question_correct' => 0,
                    'time_spent'               => 0,
                    'winner_indication'        => 0
                );
                $this->StudentModel->updateDropboxInfo($dropbox['Id'], $dropboxInfo);
            }
            
            $candidates = $this->StudentModel->getDropboxListByAssociationId($associationId, $setId);

            $allowed = $this->ViewModel->getFormattedTimeAllowed($setInfo->time_allowed);
            
            $valid_logins = $this->config->item('rest_valid_logins');
            $authToken = implode("", array_keys($valid_logins)).":".implode("", array_values($valid_logins));
            $authToken = base64_encode($authToken);

            $res['data'] = array(
                'type'      => $type,
                'dropbox'   => $dropbox,
                'problem'   => $problems[0],
                'problems'  => $problems,
                'allowed'   => $allowed,
                'authToken' => $authToken,
                'apikey'    => $this->rest->key, 
                'position'  => count($candidates),
                'styles'    => [
                    'admin/css/quill.css',
                    'vendors/quill/css/mathquill.css',  
                    'vendors/quill/css/katex.min.css',
                ],
                'scripts'   => [
                    "js/countdown.js",
                    "js/rest.js",
                ]
            );
        } else {
            $res['status'] = false;
        }
        return $res;
    }

    function exam() {
        $content = file_get_contents('php://input');
        $json = json_decode(trim($content));
        if (!empty($json)) {
            $res = $this->loadTestPage($json, "Practicing");
            if ($res['status']) {
                $this->load->view('rest/header', $res['data']);
                $this->load->view('rest/practice');
                $this->load->view('rest/footer');
            } else {
                $res = array(
                    'error'   => false,
                    'message' => "There are no problems that match the requests."
                );
                $this->response($res);
            }
        }
    }

    function switchMode() {
        $params = $this->input->post('params');
        $dropbox = $this->StudentModel->getDropboxInfo($params[1]);
        $object = new stdClass();
        $object->setId = $dropbox->set_id; 
        $object->userId = $dropbox->userid; 
        $object->product_unique_ref = $dropbox->product_unique_ref; 
        $object->associationId = $dropbox->association_id; 
        $object->identifier = $dropbox->identifier;
        $res = $this->loadTestPage($object, $params[0]);
        if ($res['status']) {
            $this->load->view('rest/practice', $res['data']);
        } else {
            echo "There are no problems that match the requests.";
        }
    }

    function checkanswer() {
        $params = $this->input->post('params');
        $res['status'] = true;
        $problem = $this->StudentModel->getProblem($params[0]);
        // update dropbox data
        $dropbox = $this->StudentModel->getDropboxInfo($params[2]);
        $data = array(
            'score' => $dropbox->score,
            'time_spent' => $params[5]
        );
        $producType = strtolower($params[3]);
        if ($producType == "ps" || $producType == "gc") {
            $winner = false;
            $topBox = $this->StudentModel->getDropboxListByAssociationId($dropbox->association_id, $dropbox->set_id, true);
            if ($dropbox->Id != $topBox->Id) {
                if ($data['score'] > $topBox->score) {
                    $winner = true;
                } else if ($data['score'] > $topBox->score) {
                    if ($data['time_spent'] < $topBox->time_spent) {
                        $winner = true;
                    }
                }
            }
            if ($winner) {
                $data['winner_indication'] = 1;
                $this->StudentModel->updateDropboxByAssociationId($dropbox->association_id, $dropbox->set_id, array('winner_indication' => 0));
            }
        }
        if($params[1] == $problem->correct) {
            if ($params[6] == 'true')
                $data['score'] = $dropbox->score + 1;
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
        $this->StudentModel->updateDropboxInfo($dropbox->Id, $data);
        $res['summary'] = array(
            'module' => $problem->module,
            'time_spent' => $data['time_spent'],
            'time_allowed' => $dropbox->time_allowed,
            'corrects' => $data['score']
        );
        $this->response($res);
    }

    function problem() {
        if (isset($_POST['params'])) {
            $res = array(
                $this->config->item('rest_status_field_name')  => true,
            );
            $params = $this->input->post('params');
            $problemInfo = $this->StudentModel->getProblem($params[0]);
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
            } else {
                $res = array(
                    $this->config->item('rest_status_field_name')  => FALSE,
                    $this->config->item('rest_message_field_name') => "There is not a problem that match the Id"
                );
            }
            $this->response($res);
        } else {
            //$this->ViewModel->page404();
            $this->response([
                $this->config->item('rest_status_field_name') => FALSE,
                $this->config->item('rest_message_field_name') => $this->lang->line('text_rest_unknown_method')
            ], self::HTTP_METHOD_NOT_ALLOWED);
        }
    }
}
?>