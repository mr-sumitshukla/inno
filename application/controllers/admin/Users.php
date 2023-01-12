<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (sessionId('admin_id') == "") {
            redirect("admin");
        }
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('AdminModel');
    }

    // User

    public function activeUser()
    {
        $data['title'] = "All Active Users";
        $data['all_data'] = $this->CommonModel->getRowByIdInOrder('users', "status = '1'", 'create_date', 'desc');
        $this->load->view('admin/users/user_all', $data);
    }

    public function inactiveUser()
    {
        $data['title'] = "All Inactive Users";
        $data['all_data'] = $this->CommonModel->getRowByIdInOrder('users', "status = '0'", 'create_date', 'desc');
        $this->load->view('admin/users/user_all', $data);
    }

    public function userStatus($user_id, $status)
    {
        if ($status == 1) {
            $post = array('status' => '0');
            $msg = 'User inactive successfully';
        } else {
            $post = array('status' => '1');
            $msg = 'User active successfully';
        }
        $update = $this->CommonModel->updateRowById('users', 'id', decryptId($user_id), $post);
        if ($update) {
            flashData('errors', $msg);
        } else {
            flashData('errors', 'Something went wrong. Please try again');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function userDetails($id)
    {
        $data['title'] = "User Details";
        $data['all_data'] = $this->CommonModel->getSingleRowById('users', "id = '" . decryptId($id) . "'");
        $this->load->view('admin/users/user_details', $data);
    }

    // Partner

    public function activePartner()
    {
        $data['title'] = "All Active Partner";
        $data['all_data'] = $this->CommonModel->getRowByIdInOrder('partners', "status = '1' AND verify_status = '1'", 'create_date', 'desc');
        $this->load->view('admin/users/partner_all', $data);
    }

    public function inactivePartner()
    {
        $data['title'] = "All Inactive Partner";
        $data['all_data'] = $this->CommonModel->getRowByIdInOrder('partners', "status = '0' AND verify_status = '1'", 'create_date', 'desc');
        $this->load->view('admin/users/partner_all', $data);
    }

    public function interViewRequest()
    {
        extract($this->input->post());
        if (count($_POST) > 0) {
            if ($type == 1) {
                $post['interview_status'] = '2';
                $post['interview_link'] = $link;
                $post['interview_date'] = $date . ' ' . $time;
            } else {
                $post['interview_status'] = $type;
                $post['cancel_message'] = $cancel_message;
            }
            $update = $this->CommonModel->updateRowById('partners', 'id', decryptId($id), $post);
            flashData('errors', 'Request Update SUccessfully');
            redirect('allInterViewRequest');
        }

        $select_id = $this->input->get('select_id');
        if (isset($select_id)) {
            $update = $this->CommonModel->updateRowById('partners', 'id', decryptId($select_id), ['interview_status' => '4']);
            flashData('errors', 'Request Update SUccessfully');
            redirect('allInterViewRequest');
        }

        $data['all_data'] = $this->CommonModel->getRowByIdInOrder('partners', "status = '1' AND verify_status = '0' AND interview_status = '1'", 'create_date', 'desc');
        $data['title'] = 'New Interview Request';
        $data['id_pending'] = 0;
        $this->load->view('admin/users/interview_call', $data);
    }

    public function allInterViewRequest()
    {
        $data['all_data'] = $this->CommonModel->getRowByIdInOrder('partners', "status = '1' AND verify_status = '0' AND (interview_status = '2' || interview_status = '3' || interview_status = '5')", 'create_date', 'desc');
        $data['title'] = 'All Interview Request';
        $data['id_pending'] = 1;
        $this->load->view('admin/users/interview_call', $data);
    }

    public function verifyPartner()
    {
        $data['title'] = "All Verification Partner";
        $data['all_data'] = $this->CommonModel->getRowByIdInOrder('partners', "status = '1' AND verify_status = '0' AND interview_status = '4'", 'create_date', 'desc');
        $this->load->view('admin/users/partner_verify', $data);
    }

    public function verifyCancelPartner()
    {
        $data['title'] = "All Verification Cancel Partner";
        $data['all_data'] = $this->CommonModel->getRowByIdInOrder('partners', "status = '1' AND verify_status = '2' AND interview_status = '4'", 'create_date', 'desc');
        $this->load->view('admin/users/partner_verify', $data);
    }

    public function partnerStatus($user_id, $status)
    {
        if ($status == 1) {
            $post = array('status' => '0');
            $msg = 'Partner inactive successfully';
        } else {
            $post = array('status' => '1');
            $msg = 'Partner active successfully';
        }
        $update = $this->CommonModel->updateRowById('partners', 'id', decryptId($user_id), $post);
        if ($update) {
            flashData('errors', $msg);
        } else {
            flashData('errors', 'Something went wrong. Please try again');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function partnerVerifyStatus()
    {
        extract($this->input->post());
        if ($verify_status == 1) {
            $post = array('verify_status' => '1', 'pay_out' => $pay_out);
            $msg = 'Partner Verification successfully';
        } else {
            $post = array('verify_status' => '2', 'cancel_message' => $cancel_message);
            $msg = 'Partner Verification Cancel';
        }
        $update = $this->CommonModel->updateRowById('partners', 'id', decryptId($id), $post);
        if ($update) {
            flashData('errors', $msg);
        } else {
            flashData('errors', 'Something went wrong. Please try again');
        }
        redirect('verifyPartner');
    }

    public function partnerDetails($id)
    {
        $data['title'] = "Partner Details";
        $data['all_data'] = $this->CommonModel->getSingleRowById('partners', "id = '" . decryptId($id) . "'");
        $this->load->view('admin/users/partner_details', $data);
    }

    public function partnerTraining()
    {
        $id = $this->input->get('id');
        if (isset($id)) {
            $delete = $this->CommonModel->deleteRowById('partner_training', "id = '" . decryptId($id) . "'");
            flashData('errors', 'Data Delete Successfully');
            redirect('partnerTraining');
        }
        $data['title'] = "Partner Training Details";
        $data['all_data'] = $this->AdminModel->getPartnerTraining();
        $this->load->view('admin/users/partner_training', $data);
    }

    public function partnerTrainingSend()
    {
        if (count($_POST) > 0) {
            extract($this->input->post());
            $contact_list = json_decode($all_contact);
            if (!empty($contact_list)) {
                $post = [];
                foreach ($contact_list as $user_list) {
                    $post[] = [
                        'create_date' => setDateTime(),
                        'date' => date('d-m-Y h:i:s', strtotime($date . $time)),
                        'training_title' => $title,
                        'description' => $message,
                        'partner_id' => $user_list,
                        'link' => $link,
                    ];
                }
                $insertId = $this->CommonModel->insertRowInBatch('partner_training', $post);
            }
            flashData('errors', 'Training Details Send Successfully');
            redirect('partnerTrainingSend');
        }

        $data['title'] = "Training";
        $data['all_data'] = $this->CommonModel->getRowByIdInOrder('partners', "status = '1' AND verify_status = '1'", 'create_date', 'desc');
        $this->load->view('admin/users/partner_training_send', $data);
    }

    // Payment

    public function partnerPayOut()
    {
        $data['title'] = "Partner Payout";
        $getPartner = $this->CommonModel->getRowByMoreId('partners', "verify_status = '1'");
        $all_data = [];
        foreach ($getPartner as $partnerList) {
            $total = $this->AdminModel->getPartnerBookingSumInRow("partner_id = '" . $partnerList['id'] . "' AND booking_status = '2'");

            $all_data[] = array(
                'id' => $partnerList['id'],
                'partner_name' => $partnerList['name'],
                'total' => $total ? $total['total'] : 0,
            );
        }

        $total = array_column($all_data, 'total');
        array_multisort($total, SORT_DESC, $all_data);
        $data['all_data'] = $all_data;
        $this->load->view('admin/users/partner_payout', $data);
    }

    public function partnerPayoutDetails()
    {
        $id = $this->input->get('id');

        if (isset($id)) {
            $id = decryptId($id);
            if (count($_POST) > 0) {
                extract($this->input->post());
                $post['amount'] = $amount;
                $post['remark'] = $remark;
                $post['pay_type'] = $pay_type;
                $post['partner_id'] = $id;
                $post['date'] = setDateOnly();
                $insert = $this->CommonModel->insertRow('partner_pay_amount', $post);
                flashData('errors', 'Amount paid successfully');
                redirect($_SERVER['HTTP_REFERER']);
            }

            $total_pay_out = $this->AdminModel->getPartnerBookingSumInRow("partner_id = '" . $id . "' AND booking_status = '2'");
            $pay_amount = getSumInRow("partner_pay_amount", "partner_id = '{$id}'", "amount");
            $data['partner_details'] = $this->CommonModel->getSingleRowById('partners', "id = '{$id}'");


            $data['title'] = "Partner Payout";
            $data['total_amount'] = $total_pay_out ? $total_pay_out['total'] : 0;
            $data['total_pay'] = $pay_amount ? $pay_amount : 0;
            $this->load->view('admin/users/partner_payout_details', $data);
        } else {
            redirect('partnerPayOut');
        }
    }

    public function payOutHistory()
    {
        $data['title'] = 'Partner PAy Amount History';
        $id = $this->input->get('id');
        $id = decryptId($id);
        $data['all_data'] = $this->CommonModel->getRowByIdInOrder('partner_pay_amount', "partner_id = '$id'", "create_date", 'DESC');
        $this->load->view('admin/users/partner_payout_history', $data);
    }

    // Store

    public function storeAll()
    {
        $get['all_data'] = $this->CommonModel->getRowByIdInOrder('stores', "id != '0'", 'id', 'ASC');
        $get['title'] = 'All Store';
        $this->load->view('admin/store_all', $get);
    }

    public function storeAdd()
    {
        extract($this->input->post());
        $id = $this->input->get('id');
        $dID = $this->input->get('dID');
        $decrypt_id = decryptId($this->input->get('id'));

        if (isset($id)) {
            $data['title'] = 'Edit Store';
            $get = $this->CommonModel->getSingleRowById('stores', "id = '$decrypt_id'");
        } else {
            $data['title'] = 'Add Store';
            $get = false;
        }

        $data['name'] = set_value('name') == false ? @$get['name'] : set_value('name');
        $data['contact_no'] = set_value('contact_no') == false ? @$get['contact_no'] : set_value('contact_no');
        $data['store_name'] = set_value('store_name') == false ? @$get['store_name'] : set_value('store_name');
        $data['address'] = set_value('address') == false ? @$get['address'] : set_value('address');

        // if (isset($dID)) {
        //     $update = $this->CommonModel->updateRowById('stores', 'id', decryptId($dID), array('is_delete' => '0'));
        //     redirect('serviceAll');
        //     exit;
        // }

        if (count($_POST) > 0) {
            $this->form_validation->set_rules('name', 'Name', 'required');
            if ($this->form_validation->run()) {
                $post['name'] = trim($name);
                $post['contact_no'] = $contact_no;
                $post['store_name'] = $store_name;
                $post['address'] = $address;
                if (isset($id)) {
                    $update = $this->CommonModel->updateRowById('stores', 'id', $decrypt_id, $post);
                    flashData('errors', 'service Update Successfully');
                } else {
                    $insert = $this->CommonModel->insertRow('stores', $post);
                    flashData('errors', 'service Add Successfully');
                }
                redirect('storeAll');
            }
        }
        $this->load->view('admin/store_add', $data);
    }
}
