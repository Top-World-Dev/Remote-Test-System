<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class StudentModel extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getDropboxInfo($id) {  //, $userId, $product_unique_ref, $associationId, $setId
        $this->db->where("Id", $id);
        $query = $this->db->get("dropbox");
        return $query->row();
    }

    function getDropboxInfoByIdentifier($identifier) {  //, $userId, $product_unique_ref, $associationId, $setId
        $this->db->where("identifier", $identifier);
        //$this->db->where("userid", $userId);
        //$this->db->where("product_unique_ref", $product_unique_ref);
        //$this->db->where("association_id", $associationId);
        //$this->db->where("set_id", $setId);
        $query = $this->db->get("dropbox");
        return $query->row_array();
    }

    function getDropboxListByAssociationId($associationId, $setId, $sorting=false) {
        $this->db->where("association_id", $associationId);
        $this->db->where("set_id", $setId);
        $this->db->where("active", 1);
        if ($sorting) {
            $this->db->order_by("score", "desc");
            $query = $this->db->get("dropbox");
            return $query->row();
        } else {
            $query = $this->db->get("dropbox");
            return $query->result_array();
        }
    } 

    function getProblem($id)
    {
        $this->db->where('Id', $id);
        $query = $this->db->get('problem');
        return $query->row();
    }

    function getProblemListByUniqueRef($product_unique_ref, $type)
    {
        $this->db->where('product_unique_ref', $product_unique_ref);
        $this->db->where('sub_type', $type);
        $query = $this->db->get('problem');
        return $query->result_array();
    }

    function getSetInfo($setId) {
        $this->db->where("set_id", $setId);
        $query = $this->db->get("generate");
        return $query->row();
    }

    function firstGetProblem()
    {
        $this->db->where('question_number', 4);
        $query = $this->db->get('problem');
        return $query->row();
    }

    function getProblemInfo()
    {
        $query = $this->db->get('problem');
        return $query->result();
    }

    function getProblemArray()
    {
        $query = $this->db->get('problem');
        return $query->result_array();
    }

    function checkAnswer($prId) {
        $this->db->where('Id', $prId);
        $query = $this->db->get('problem');
        return $query->row();
    }

    function saveDropboxInfo($data) {
        $this->db->trans_start();
        $this->db->insert("dropbox", $data);
        $insertId = $this->db->insert_id();
        $this->db->trans_complete();
        return $insertId;
    }

    function updateDropboxByAssociationId($associationId, $setId, $data) {
        $this->db->where("association_id", $associationId);
        $this->db->where("set_id", $setId);
        $this->db->where("active", 1);
        $this->db->update("dropbox", $data);
    }

    function updateDropboxInfo($id, $data) {
        $this->db->where("Id", $id);
        $this->db->update("dropbox", $data);
    }
}
?>