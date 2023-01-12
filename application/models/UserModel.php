<?php

class UserModel extends CI_Model
{
    public function getPartnerBook($where)
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

    public function getHospitalPartnerBook($where)
    {
        $get = $this->db->select("book_partner.* , hospital_service.service_name , hospital_sub_service.sub_service_name")
            ->from('book_partner')
            ->join('hospital_service', "book_partner.service_id = hospital_service.id", 'LEFT')
            ->join('hospital_sub_service', "book_partner.sub_service_id = hospital_sub_service.id", 'LEFT')
            ->where($where)
            ->order_by('id', 'DESC')
            ->get();
        if ($get->num_rows() > 0) {
            return $get->result_array();
        } else {
            return false;
        }
    }

    public function getBookedRentalItem($where)
    {
        $get = $this->db->select("rental_book_item.* , category.category_name , rental_product.product_name")
            ->from('rental_book_item')
            ->join('category', "rental_book_item.category_id = category.id", 'LEFT')
            ->join('rental_product', "rental_book_item.product_id = rental_product.id", 'LEFT')
            ->where($where)
            ->get();
        if ($get->num_rows() > 0) {
            return $get->result_array();
        } else {
            return false;
        }
    }
}
