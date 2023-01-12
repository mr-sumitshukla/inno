<?php

class Bookings extends CI_Controller
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

    public function newPartnerBooking()
    {
        $date = $this->input->get('date');
        if (count($_POST) > 0) {
            extract($this->input->post());
            $get = $this->CommonModel->getSingleRowById('partners', "id = '$partner_id'");
            $post = [
                'partner_id' => $partner_id,
                'booking_status' => '1',
                'partner_charges' => $get['pay_out'],
                'check_in_time' => date('h:i A', strtotime($check_in_time)),
                'check_out_time' => date('h:i A', strtotime($check_out_time)),
            ];
            $update = $this->CommonModel->updateRowById('book_partner', 'id', decryptId($booking_id), $post);
            flashData('errors', 'Partner assign Successfully');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($date != "") {
            $data['all_data'] = $this->AdminModel->getNewPartnerBook("booking_type = '1' AND booking_status = '0' AND booking_date = '" . date('d-m-Y', strtotime($date)) . "'");
        } else {
            $data['all_data'] = $this->AdminModel->getNewPartnerBook("booking_type = '1' AND booking_status = '0'");
        }
        $data['all_partner'] = $this->CommonModel->getRowByMoreId('partners', "verify_status = '1' AND status = '1'");
        $data['title'] = 'New Booking for Home Care';
        $this->load->view('admin/new_booking', $data);
    }

    public function getPartnerForAssign()
    {
        $id = $this->input->get('id');
        extract($this->input->post());
        if (count($_POST) > 0) {
            $get = $this->CommonModel->getSingleRowById('partners', "id = '" . decryptId($partner_id) . "'");
            $booking_id = $this->input->get('booking_id');
            $update = $this->CommonModel->updateRowById('book_partner', 'id', decryptId($booking_id), ['partner_id' => decryptId($partner_id), 'booking_status' => '1', 'partner_charges' => $get['pay_out']]);
            redirect($_SERVER['HTTP_REFERER']);
        }
        $data['booking_id'] = $id;
        $data['all_data'] = $this->CommonModel->getRowByMoreId('partners', "verify_status = '1' AND status = '1'");
        $this->load->view('admin/assign_partner', $data);
    }

    public function assignPartner()
    {
        $date = $this->input->get('date');
        if ($date != "") {
            $data['all_data'] = $this->AdminModel->getPartnerBook("booking_type = '1' AND booking_status != '0' AND booking_date = '" . date('d-m-Y', strtotime($date)) . "'");
        } else {
            $data['all_data'] = $this->AdminModel->getPartnerBook("booking_type = '1' AND booking_status != '0'");
        }
        $data['title'] = 'Assign Partner Booking';
        $this->load->view('admin/all_booking', $data);
    }

    // Partner For Hospital

    public function newPartnerBookingForHospital()
    {
        $date = $this->input->get('date');
        if (count($_POST) > 0) {
            extract($this->input->post());
            $get = $this->CommonModel->getSingleRowById('partners', "id = '$partner_id'");
            $post = [
                'partner_id' => $partner_id,
                'booking_status' => '1',
                'partner_charges' => $get['pay_out'],
                'check_in_time' => date('h:i A', strtotime($check_in_time)),
                'check_out_time' => date('h:i A', strtotime($check_out_time)),
            ];
            $update = $this->CommonModel->updateRowById('book_partner', 'id', decryptId($booking_id), $post);
            flashData('errors', 'Partner assign Successfully');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($date != "") {
            $data['all_data'] = $this->AdminModel->getNewPartnerBook("booking_type = '2' AND booking_status = '0' AND booking_date = '" . date('d-m-Y', strtotime($date)) . "'");
        } else {
            $data['all_data'] = $this->AdminModel->getNewPartnerBook("booking_type = '2' AND booking_status = '0'");
        }
        $data['all_partner'] = $this->CommonModel->getRowByMoreId('partners', "verify_status = '1' AND status = '1'");
        $data['title'] = 'New Booking for Hospital';
        $this->load->view('admin/new_booking_for_hospital', $data);
    }

    public function assignPartnerForHospital()
    {
        $date = $this->input->get('date');
        if ($date != "") {
            $data['all_data'] = $this->AdminModel->getPartnerBook("booking_type = '2' AND booking_status != '0' AND booking_date = '" . date('d-m-Y', strtotime($date)) . "'");
        } else {
            $data['all_data'] = $this->AdminModel->getPartnerBook("booking_type = '2' AND booking_status != '0'");
        }
        $data['title'] = 'Assign Partners For Hospital';
        $this->load->view('admin/all_booking_for_hospital', $data);
    }

    public function addTask()
    {
        extract($this->input->post());
        $booking_id = $this->input->get('booking_id');
        $id = $this->input->get('id');
        $dID = $this->input->get('dID');
        $decrypt_id = decryptId($this->input->get('id'));

        if (isset($dID)) {
            $delete = $this->CommonModel->deleteRowById('task', "id = '" . decryptId($dID) . "'");
            flashData('errors', 'Data Delete Successfully');
            redirect("addTask?booking_id=$booking_id");
            exit;
        }

        if (isset($id)) {
            $data['title'] = 'Edit Task';
            $get = $this->CommonModel->getSingleRowById('task', "id = '$decrypt_id'");
        } else {
            $data['title'] = 'Add Task';
            $get = false;
        }

        $data['task_date'] = set_value('task_date') == false ? @$get['task_date'] : set_value('task_date');
        $data['task_title'] = set_value('task_title') == false ? @$get['task_title'] : set_value('task_title');
        $data['task_description'] = set_value('task_description') == false ? @$get['task_description'] : set_value('task_description');

        if (count($_POST) > 0) {
            $this->form_validation->set_rules('task_date', 'Date', 'required');
            if ($this->form_validation->run()) {
                $post['task_date'] = $task_date;
                $post['task_title'] = $task_title;
                $post['task_description'] = $task_description;
                if (isset($id)) {
                    $update = $this->CommonModel->updateRowById('task', 'id', $decrypt_id, $post);
                    flashData('errors', 'Task Update Successfully');
                } else {
                    $post['booking_id'] = decryptId($booking_id);
                    $insert = $this->CommonModel->insertRow('task', $post);
                    flashData('errors', 'Task Add Successfully');
                }
                redirect("addTask?booking_id=$booking_id");
            }
        }

        $data['all_data'] = $this->CommonModel->getRowByMoreId('task', "booking_id = '" . decryptId($booking_id) . "'");
        $this->load->view('admin/add_task', $data);
    }
    // Video Call

    public function videoCallRequest()
    {
        extract($this->input->post());
        if (count($_POST) > 0) {
            if ($type == 1) {
                $post['status'] = '1';
                $post['video_url'] = $link;
                $post['date'] = $date . ' ' . $time;
            } else {
                $post['status'] = '2';
                $post['message'] = $cancel_message;
                $post['date'] = date('d-M-Y h:i A');
            }
            $update = $this->CommonModel->updateRowById('video_call_request', 'id', decryptId($id), $post);
            flashData('errors', 'Request Update SUccessfully');
        }

        $data['all_data'] = $this->AdminModel->getVideoCallRequest("video_call_request.status = '0'");
        $data['id_pending'] = '1';
        $data['title'] = 'New Video Call Request';
        $this->load->view('admin/video_call', $data);
    }

    public function allVideoCallRequest()
    {
        $data['all_data'] = $this->AdminModel->getVideoCallRequest("video_call_request.status != '0'");
        $data['id_pending'] = '0';
        $data['title'] = 'All Video Call Request';
        $this->load->view('admin/video_call', $data);
    }

    // Rental Product

    public function newProductBooking()
    {
        $date = $this->input->get('date');
        if ($date != "") {
            $data['all_data'] = $this->CommonModel->getRowByIdInOrder('rental_book_product', "booking_status = '0' AND booking_date = '" . date('d-m-Y', strtotime($date)) . "' AND transaction_status = '1'", "id", 'DESC');
        } else {
            $data['all_data'] = $this->CommonModel->getRowByIdInOrder('rental_book_product', "booking_status = '0' AND transaction_status = '1' AND transaction_status = '1'", "id", 'DESC');
        }
        $data['is_assign'] = 0;
        $data['title'] = 'New Request for Rental Product';
        $this->load->view('admin/new_rental_product_booking', $data);
    }

    public function getStoreForAssign()
    {
        $id = $this->input->get('id');
        $partner_id = $this->input->get('partner_id');
        if (isset($partner_id)) {
            $booking_id = $this->input->get('booking_id');
            $update = $this->CommonModel->updateRowById('rental_book_product', 'id', decryptId($booking_id), ['rental_store_id' => decryptId($partner_id), 'booking_status' => '1']);
            redirect($_SERVER['HTTP_REFERER']);
        }
        $data['booking_id'] = $id;
        $data['all_data'] = $this->CommonModel->getAllRowsInOrder('stores', 'name', 'ASC');
        $this->load->view('admin/assign_store', $data);
    }

    public function assignProductBooking()
    {
        $date = $this->input->get('date');
        if ($date != "") {
            $data['all_data'] = $this->CommonModel->getRowByIdInOrder('rental_book_product', "booking_status != '0' AND booking_date = '" . date('Y-m-d', strtotime($date)) . "' AND transaction_status = '1'", "id", 'DESC');
        } else {
            $data['all_data'] = $this->CommonModel->getRowByIdInOrder('rental_book_product', "booking_status != '0' AND transaction_status = '1' AND transaction_status = '1'", "id", 'DESC');
        }
        $data['is_assign'] = 1;
        $data['title'] = 'New Request for Rental Product';
        $this->load->view('admin/new_rental_product_booking', $data);
    }
}
