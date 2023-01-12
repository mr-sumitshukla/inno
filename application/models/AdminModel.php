<?php

class AdminModel extends CI_Model
{
    public function getNewPartnerBook($where)
    {
        $get = $this->db->select("book_partner.* , service.service_name , sub_service.sub_service_name")
            ->from('book_partner')
            ->join('service', "book_partner.service_id = service.id", 'LEFT')
            ->join('sub_service', "book_partner.sub_service_id = sub_service.id", 'LEFT')
            ->where($where)
            ->order_by('id', 'DESC')
            ->get();
        if ($get->num_rows() > 0) {
            return $get->result_array();
        } else {
            return false;
        }
    }

    public function getPartnerBook($where)
    {
        $get = $this->db->select("book_partner.* , service.service_name , sub_service.sub_service_name, partners.name as partner_name , partners.contact_no as partner_contact_no")
            ->from('book_partner')
            ->join('service', "book_partner.service_id = service.id", 'LEFT')
            ->join('sub_service', "book_partner.sub_service_id = sub_service.id", 'LEFT')
            ->join('partners', "partners.id = book_partner.partner_id", 'LEFT')
            ->where($where)
            ->order_by('id', 'DESC')
            ->get();
        if ($get->num_rows() > 0) {
            return $get->result_array();
        } else {
            return false;
        }
    }

    public function getFormData($where)
    {
        $get = $this->db->select("form.* , users.name as username, users.contact_no as user_contact_no")
            ->from('form')
            ->join('users', "form.user_id = users.id", 'LEFT')
            ->where($where)
            ->order_by('id', 'DESC')
            ->get();
        if ($get->num_rows() > 0) {
            return $get->result_array();
        } else {
            return false;
        }
    }

    public function getPartnerBookingSumInRow($where)
    {
        $ci = &get_instance();
        $get = $ci->db->query("SELECT SUM(partner_charges*no_of_days) AS total FROM `tbl_book_partner` WHERE $where");
        if ($get->num_rows() > 0) {
            return $get->row_array();
        } else {
            return false;
        }
    }

    public function getVideoCallRequest($where)
    {
        $get = $this->db->select("video_call_request.*, users.name, users.contact_no")
            ->from('video_call_request')
            ->join('users', "video_call_request.user_id = users.id", 'LEFT')
            ->where($where)
            ->order_by('video_call_request.id', 'DESC')
            ->get();
        if ($get->num_rows() > 0) {
            return $get->result_array();
        } else {
            return false;
        }
    }

    public function getPartnerInterview($where)
    {
        $get = $this->db->select("partner_interview.* , partners.name as username, partners.contact_no as user_contact_no")
            ->from('partner_interview')
            ->join('partners', "partner_interview.partner_id = partners.id", 'LEFT')
            ->where($where)
            ->order_by('id', 'DESC')
            ->get();
        if ($get->num_rows() > 0) {
            return $get->result_array();
        } else {
            return false;
        }
    }

    public function getChatBotData($where)
    {
        $get = $this->db->select("chat_support.* , users.name as username, users.contact_no as user_contact_no")
            ->from('chat_support')
            ->join('users', "chat_support.user_id = users.id", 'LEFT')
            ->where($where)
            ->order_by('id', 'DESC')
            ->get();
        if ($get->num_rows() > 0) {
            return $get->result_array();
        } else {
            return false;
        }
    }

    public function getPartnerTraining()
    {
        $get = $this->db->select("partners.name, partners.contact_no, partner_training.*")
            ->from('partner_training')
            ->join('partners', "partner_training.partner_id = partners.id", 'LEFT')
            ->order_by('id', 'DESC')
            ->get();
        if ($get->num_rows() > 0) {
            return $get->result_array();
        } else {
            return false;
        }
    }
}
