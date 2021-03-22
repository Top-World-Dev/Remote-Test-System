<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getUserInfo($email, $pwd)
    {
        $this->db->where("uemail", $email);
        $this->db->where("upwd", sha1($pwd));
        $query = $this->db->get("users");
        return $query->row();
    }

    function saveUserInfo($data) {
        $this->db->trans_start();
        $this->db->insert('users', $data);
        $insertId = $this->db->insert_id();
        $this->db->trans_complete();
        return $insertId;
    }

    function getActiveNews($status=1)
    {
        $this->db->where("status", $status);
        $query = $this->db->get("news");
        return $query->result();
    }

    function getTagsByStatus($userId, $status) {
        $this->db->where("user_id", $userId);
        $this->db->where("status", $status);
        $query = $this->db->get("tags");
        return $query->result();
    }

    function getContactCountByTag($userId, $tag) {
        $this->db->select("COUNT(Id) as count");
        $this->db->where("user_id", $userId);
        $this->db->where("tags like '%\"$tag\"%'");
        $query = $this->db->get("contacts");
        return $query->row()->count;
    }

    function getUserId()
    {
        return $this->session->userdata("ts_uid");
    }

    function updateUserInfo($data, $id)
    {
        $this->db->where("uid", $id);
        $this->db->update("users", $data);
    }

    function getActiveCountries()
    {
        $this->db->where("status", 1);
        $query = $this->db->get("countries");
        return $query->result();
    }
}
?>