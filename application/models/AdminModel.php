<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class AdminModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function checkEmailAddress($userId, $uemail)
    {
        $this->db->where('uid !=', $userId);
        $this->db->where('uemail', $uemail);
        $query = $this->db->get('users');
        return $query->row();
    }

    function getProductListBySet($productId, $subjectId, $moduleId, $subjectTypeId, $timeAllowed)
    {
        $this->db->select("pb.Id as pid");
        $this->db->from("ts_problem pb");
        $this->db->join("ts_product pd", "pb.product_unique_ref = pd.product_unique_ref", "left");
        $this->db->where("pd.product_id", $productId);
        $this->db->where("pd.subject_id", $subjectId);
        $this->db->where("pd.module_id", $moduleId);
        $this->db->where("pd.subject_type_id", $subjectTypeId);
        $this->db->where("pd.test_duration", $timeAllowed);
        $this->db->where("pd.validity", 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function problemRowFetch($selectType, $selectCate, $selectSubj)
    {
        $this->db->where('type', $selectType);
        $this->db->where('category', $selectCate);
        $this->db->where('subject', $selectSubj);
        $query = $this->db->get('problem');
        return $query->result();
    }

    function updateAccountInfo($data, $id)
    {
        $this->db->where('uid', $id);
        $this->db->update('users', $data);
    }

    function getUserInfo($id)
    {
        $this->db->where('uid', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

    function updateUserPassword($data, $id)
    {
        $this->db->where('uid', $id);
        $this->db->update('users', $data);
    }

    function getAllUsers()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    function removeRowUsers($id)
    {
        $this->db->where('uid', $id);
        $this->db->delete('users');
    }

    function getAllProblem()
    {
        $query = $this->db->get("problem");
        return $query->result();
    }

    function saveQuestion($data)
    {
        $this->db->insert('problem', $data);
    }

    function saveImageInfo($data, $id)
    {
        $this->db->trans_start();
        $this->db->where('Id', $id);
        $this->db->update('problem', $data);
        $this->db->trans_complete();
    }

    function getEditProblemRow($id)
    {
        $this->db->where('Id', $id);
        $query = $this->db->get('problem');
        return $query->row();
    }

    function updateProblem($data, $id)
    {
        $this->db->where('Id', $id);
        $this->db->update('problem', $data);
    }

    function removeRowProblem($id)
    {
        $this->db->where('Id', $id);
        $this->db->delete('problem');
    }

    function getProduct()
    {
        $query = $this->db->get('product');
        return $query->result();
    }

    function saveNewProductInfo($data)
    {
        $this->db->insert('product', $data);
    }

    function getEditProductRow($id)
    {
        $this->db->where('Id', $id);
        $query = $this->db->get('product');
        return $query->row();
    }

    function updateProduct($data, $id)
    {
        $this->db->where('Id', $id);
        $this->db->update('product', $data);
    }

    function removeRowProduct($id)
    {
        $this->db->where('Id', $id);
        $this->db->delete('product');
    }

    function getSubjects()
    {
        $query = $this->db->get('subject');
        return $query->result();
    }

    function saveNewSubjectInfo($data)
    {
        $this->db->insert('subject', $data);
    }

    function getEditSubjectRow($id)
    {
        $this->db->where('Id', $id);
        $query = $this->db->get('subject');
        return $query->row();
    }

    function updateSubject($data, $id)
    {
        $this->db->where('Id', $id);
        $this->db->update('subject', $data);
    }

    function removeRowSubject($id)
    {
        $this->db->where('Id', $id);
        $this->db->delete('subject');
    }

    function getSubjectType()
    {
        $query = $this->db->get('subject_type');
        return $query->result();
    }

    function saveNewSubjectTypeInfo($data)
    {
        $this->db->insert('subject_type', $data);
    }

    function getEditSubjectTypeRow($id)
    {
        $this->db->where('Id', $id);
        $query = $this->db->get('subject_type');
        return $query->row();
    }

    function updateSubjectType($data, $id)
    {
        $this->db->where('Id', $id);
        $this->db->update('subject_type', $data);
    }

    function removeRowSubjectType($id)
    {
        $this->db->where('Id', $id);
        $this->db->delete('subject_type');
    }

    function getModules()
    {
        $query = $this->db->get('module');
        return $query->result();
    }

    function saveNewModuleInfo($data)
    {
        $this->db->insert('module', $data);
    }

    function getEditModuleRow($id)
    {
        $this->db->where('Id', $id);
        $query = $this->db->get('module');
        return $query->row();
    }

    function updateModule($data, $id)
    {
        $this->db->where('Id', $id);
        $this->db->update('module', $data);
    }

    function removeRowModule($id)
    {
        $this->db->where('Id', $id);
        $this->db->delete('module');
    }

    function getProductType()
    {
        $query = $this->db->get('product_type');
        return $query->result();
    }

    function saveProductTypeInfo($data)
    {
        $this->db->insert('product_type', $data);
    }

    function getProductTypeInfo($id)
    {
        $this->db->where('product_id', $id);
        $query = $this->db->get('product_type');
        return $query->row();
    }

    function updateProductType($data, $id)
    {
        $this->db->where('product_id', $id);
        $this->db->update('product_type', $data);
    }

    function removeProductType($id)
    {
        $this->db->where('product_id', $id);
        $this->db->delete('product_type');
    }

    function getPrice()
    {
        $query = $this->db->get('price');
        return $query->result();
    }

    function saveNewPriceInfo($data)
    {
        $this->db->insert('price', $data);
    }

    function getEditPriceRow($id)
    {
        $this->db->where('Id', $id);
        $query = $this->db->get('price');
        return $query->row();
    }

    function updatePrice($data, $id)
    {
        $this->db->where('Id', $id);
        $this->db->update('price', $data);
    }

    function removeRowPrice($id)
    {
        $this->db->where('Id', $id);
        $this->db->delete('price');
    }

    function getDuration()
    {
        $query = $this->db->get('duration');
        return $query->result();
    }

    function saveNewDurationInfo($data)
    {
        $this->db->insert('duration', $data);
    }

    function getEditDurationRow($id)
    {
        $this->db->where('Id', $id);
        $query = $this->db->get('duration');
        return $query->row();
    }

    function updateDuration($data, $id)
    {
        $this->db->where('Id', $id);
        $this->db->update('duration', $data);
    }

    function removeRowDuration($id)
    {
        $this->db->where('Id', $id);
        $this->db->delete('duration');
    }

    function getGenerate()
    {
        $query = $this->db->get('generate');
        return $query->result();
    }

    function saveGenerateInfo($data)
    {
        $this->db->db_debug = false;
        $res = $this->db->insert('generate', $data);
        if (!$res) {
            return false;
        } else
            return true;
    }

    function getEditGenerateRow($id)
    {
        $this->db->where('Id', $id);
        $query = $this->db->get('generate');
        return $query->row();
    }

    function updateGenerate($data, $id)
    {
        $this->db->where('Id', $id);
        $this->db->update('generate', $data);
    }

    function removeRowGenerate($id)
    {
        $this->db->where('Id', $id);
        $this->db->delete('generate');
    }

    function getConnect()
    {
        $query = $this->db->get('set');
        return $query->result();
    }

    function saveConnectInfo($data)
    {
        $this->db->insert('set', $data);
    }

    function getEditConnectRow($id)
    {
        $this->db->where('Id', $id);
        $query = $this->db->get('set');
        return $query->row();
    }

    function updateConnect($data, $id)
    {
        $this->db->where('Id', $id);
        $this->db->update('set', $data);
    }

    function removeRowConnect($id)
    {
        $this->db->where('Id', $id);
        $this->db->delete('set');
    }
}
