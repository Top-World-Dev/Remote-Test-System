<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailModel extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }

    function sendMail($to, $subject, $message, $attach="", $from="info@module.com", $sender="Module System Support")
    {
        $this->email->set_crlf("\r\n");
        $this->email->from($from, $sender);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        if($attach) {
            $this->email->attach($attach);
        }
        if($this->email->send())
            return true;
        else
            return false;
    }

    function sendNewPassword($email, $pwd) {

    }

    function sendWCMessage($email, $pwd="") {
        $userCode = hash_hmac('sha1', $pwd, $email);
        $message = "";
        return $userCode;
    }
}
?>