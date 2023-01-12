<?php

use innomitra\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class PartnerApi extends  REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('UserModel');
        $this->load->model('AdminModel');
    }

    public function sendOTPForLogin_POST()
    {
        extract($this->input->post());
        $this->form_validation->set_rules('contact_no', 'contact number', 'trim|required');
        if ($this->form_validation->run()) {
            // $otp = rand(9999, 99999);
            $otp = 12345;
            $get = $this->CommonModel->getSingleRowById('partners', "contact_no = '$contact_no'");
            // $message_content = "<#> Dear customer, your Kotty OTP is " . $otp . " " . $hash_key . " Regards RISHI ENTERPRISES";
            if ($get) {
                if ($get['status'] == '1') {
                    $this->CommonModel->insertRow('temp_otp', ['contact_no' => $contact_no, 'otp' => $otp]);
                    // sendOTP($contact_no, $message_content);
                    $this->response(array('status' => 200, 'message' => 'OTP send successfully.', 'data' => null));
                } else {
                    $this->response(array('status' => 400, 'message' => 'Your account has been blocked. Please contact tech support.', 'data' => null));
                }
            } else {
                $this->response(array('status' => 400, 'message' => 'Please Enter Registered Contact Number', 'data' => null));
            }
        } else {
            $this->response(array('status' => 400, 'message' => $this->form_validation->error_array(), 'data' => null));
        }
    }

    public function partnerLogin_POST()
    {
        extract($this->input->post());
        $this->form_validation->set_rules('contact_no', 'contact number', 'trim|required');
        $this->form_validation->set_rules('otp', 'otp', 'trim|required');
        $this->form_validation->set_rules('fcm_token', 'fcm_token', 'trim');
        if ($this->form_validation->run()) {
            $getOtp = $this->CommonModel->getSingleRowByIdInOrder('temp_otp', "contact_no = '$contact_no'", 'id', 'DESC');
            if ($getOtp && ($getOtp['otp'] == $otp)) {
                $getUser = $this->CommonModel->getSingleRowById('partners', "contact_no = '$contact_no'");
                $hash = date('dm') . round(microtime(true) * 1000);
                if ($getUser) {
                    $this->CommonModel->updateRowById('partners', 'id', $getUser['id'], array('unique_hash' => $hash, 'fcm_token' => $fcm_token));
                    $token_data = array(
                        'id' => $getUser['id'],
                        'name' => $getUser['name'],
                        'contact_no' => $getUser['contact_no'],
                        'unique_hash' => $hash,
                        'time' => time()
                    );
                    $token = $this->authorization_token->generateToken($token_data);
                    $this->CommonModel->deleteRowById('temp_otp', "contact_no = '$contact_no'");
                    $token = $this->authorization_token->generateToken($token_data);
                    $getUser['profile_image'] =  $getUser['profile_image'] == "" ? null : PARTNER_IMAGE . $getUser['profile_image'];
                    $getUser['document_image'] = $getUser['document_image'] == "" ? null : PARTNER_IMAGE . $getUser['document_image'];
                    $getUser['token'] = $token;
                    $getUser['is_profile_complete_1'] = $getUser['address'] == "" ? 0 : 1;
                    $getUser['is_profile_complete_2'] = $getUser['interview_status'] != 4 ? 0 : 1;
                    $getUser['is_profile_complete_3'] = $getUser['document_no'] == "" ? 0 : 1;
                    $this->response(array('status' => 200, 'message' => 'Partner login successfully.', 'data' => $getUser));
                } else {
                    $this->response(array('status' => 200, 'message' => 'Contact number not registered', 'data' => $data));
                }
            } else {
                $this->response(array('status' => 400, 'message' => 'Enter valid OTP', 'data' => null));
            }
        } else {
            $this->response(array('status' => 400, 'message' => str_replace("\n", '', validation_errors()), 'data' => null));
        }
    }

    public function partnerCheck_POST()
    {
        extract($this->input->post());
        $this->form_validation->set_rules('email_id', 'Email Id', 'trim|is_unique[partners.email_id]', ['is_unique' => 'Email Id already exist.']);
        $this->form_validation->set_rules('contact_no', 'Email Id', 'trim|is_unique[partners.contact_no]', ['is_unique' => 'Contact Number already exist.']);
        $this->form_validation->set_error_delimiters('', ' ');
        if ($this->form_validation->run()) {
            // $otp = rand(9999, 99999);
            $otp = 12345;
            $this->CommonModel->insertRow('temp_otp', ['contact_no' => $contact_no, 'otp' => $otp]);
            // sendOTP($contact_no, $message_content);
            $this->response(array('status' => 200, 'message' => 'OTP send successfully.', 'data' => null));
        } else {
            $this->response(array('status' => 400, 'message' => str_replace("\n", '', validation_errors()), 'data' => null));
        }
    }

    public function partnerRegistration_POST()
    {
        extract($this->input->post());
        $this->form_validation->set_rules('name', 'name', 'trim|required', ['required' => 'Name is required.']);
        $this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|is_unique[partners.email_id]', ['is_unique' => 'Email Id already exist.']);
        $this->form_validation->set_rules('contact_no', 'Email Id', 'trim|required|is_unique[partners.contact_no]', ['is_unique' => 'Contact Number already exist.']);
        $this->form_validation->set_rules('service_id', 'Service Id', 'trim|required');
        $this->form_validation->set_rules('otp', 'otp', 'trim|required');
        $this->form_validation->set_error_delimiters('', ' ');
        if ($this->form_validation->run()) {
            $getOtp = $this->CommonModel->getSingleRowByIdInOrder('temp_otp', "contact_no = '$contact_no'", 'id', 'DESC');
            if ($getOtp && ($getOtp['otp'] == $otp)) {
                $hash = date('dm') . round(microtime(true) * 1000);

                $post['name'] = $name;
                $email_id == "" ? null : $post['email_id'] = $email_id;
                $post['contact_no'] = $contact_no;
                $post['service_id'] = $service_id;
                $post['unique_hash'] = $hash;

                $insert = $this->CommonModel->insertRowReturnId('partners', $post);
                if ($insert) {
                    $token_data = array(
                        'id' => $insert,
                        'name' => $name,
                        'contact_no' => $contact_no,
                        'unique_hash' => $hash,
                        'time' => time()
                    );

                    $this->CommonModel->deleteRowById('temp_otp', "contact_no = '$contact_no'");
                    $token = $this->authorization_token->generateToken($token_data);
                    $getPartner = $this->CommonModel->getSingleRowById('partners', "id = '$insert'");
                    $getPartner['profile_image'] =  $getPartner['profile_image'] == "" ? null : PARTNER_IMAGE . $getPartner['profile_image'];
                    $getPartner['document_image'] = $getPartner['document_image'] == "" ? null : PARTNER_IMAGE . $getPartner['document_image'];
                    $getPartner['token'] = $token;
                    $getPartner['is_profile_complete_1'] = 0;
                    $getPartner['is_profile_complete_2'] = 0;
                    $getPartner['is_profile_complete_3'] = 0;
                    $this->response(array('status' => 200, 'message' => 'Profile update successfully.', 'data' => $getPartner));
                } else {
                    $this->response(array('status' => 400, 'message' => 'Something went wrong. Please try again', 'data' => null));
                }
            } else {
                $this->response(array('status' => 400, 'message' => 'Enter valid OTP', 'data' => null));
            }
        } else {
            $this->response(array('status' => 400, 'message' => str_replace("\n", '', validation_errors()), 'data' => null));
        }
    }

    public function partnerProfile_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $get = $this->CommonModel->getSingleRowById('partners', "id = '$tokenId'");
                $this->response(array('status' => 200, 'message' => 'View Partner Profile', 'data' => $get));
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function partnerProfile_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $get = $this->CommonModel->getSingleRowById('partners', "id = '{$tokenId}'");
                $this->form_validation->set_rules('name', 'name', 'trim|required', ['required' => 'Name is required.']);
                if ($get['document_no'] != $document_no) {
                    $this->form_validation->set_rules('document_no', 'Document Number', 'trim|required|is_unique[partners.document_no]', ['is_unique' => 'Document number already exist.']);
                }
                $this->form_validation->set_rules('service_id', 'Service Id', 'trim|required');
                if ($this->form_validation->run()) {

                    $post['address'] = $address;
                    $post['area'] = $area;
                    $post['postal_code'] = $postal_code;
                    $post['state'] = $state;
                    $post['city'] = $city;
                    $post['document_type'] = $document_type;
                    if ($document_no != "") {
                        $post['document_no'] = $document_no;
                    }
                    $post['account_holder_name'] = $account_holder_name;
                    $post['account_number'] = $account_number;
                    $post['ifsc_code'] = $ifsc_code;
                    $post['bank_name'] = $bank_name;

                    if (!empty($_FILES['profile_image']['name'])) {
                        $profile_image = imageUpload('profile_image', PARTNER_IMAGE);
                        $post['profile_image'] = $profile_image;
                        if ($get['profile_image'] != "") {
                            unlink(PARTNER_IMAGE . $profile_image_temp);
                        }
                    }
                    if (!empty($_FILES['document_image']['name'])) {
                        $document_image = imageUpload('document_image', PARTNER_IMAGE);
                        $post['document_image'] = $document_image;
                        if ($get['document_image'] != "") {
                            unlink(PARTNER_IMAGE . $document_image_temp);
                        }
                    }

                    if (!empty($_FILES['police_verify_document']['name'])) {
                        $police_verify_document = documentUpload('police_verify_document', PARTNER_IMAGE);
                        $post['police_verify_document'] = $police_verify_document;
                        if ($get['police_verify_document'] != "") {
                            unlink(PARTNER_IMAGE . $police_verify_document);
                        }
                    }

                    if ($get['verify_status'] == '2') {
                        $post['verify_status'] = '0';
                    }

                    $update = $this->CommonModel->updateRowById('partners', 'id', $tokenId, $post);
                    $get = $this->CommonModel->getSingleRowById('partners', "id = '{$tokenId}'");
                    $get['profile_image'] =  $get['profile_image'] == "" ? null : PARTNER_IMAGE . $get['profile_image'];
                    $get['document_image'] = $get['document_image'] == "" ? null : PARTNER_IMAGE . $get['document_image'];
                    $get['police_verify_document'] = $get['police_verify_document'] == "" ? null : PARTNER_IMAGE . $get['police_verify_document'];
                    $this->response(array('status' => 200, 'message' => 'Profile update successfully', 'data' => $get));
                } else {
                    $this->response(array('status' => 400, 'message' => str_replace("\n", '', validation_errors()), 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function interViewRequest_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $update = $this->CommonModel->updateRowById('partners', 'id', $tokenId, ['interview_status' => '1']);
                $this->response(array('status' => 200, 'message' => 'Interview Request Send Successfully', 'data' => null));
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function partnerDashboard_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $get = $this->CommonModel->getSingleRowById('partners', "id = '$tokenId'");
                $data['verify_status'] = $get['verify_status'];
                $data['cancel_message'] = $get['cancel_message'];
                $this->response(array('status' => 200, 'message' => 'Show partner dashboard', 'data' => $data));
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function getBookPartner_GET($status)
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $getBooking = $this->UserModel->getPartnerBook("booking_status = '$status' AND book_partner.partner_id = '$tokenId' AND booking_type = '1' AND (payment_mode = '1' AND transaction_status = '1' OR payment_mode = '2')");
                if ($getBooking) {
                    $all_data = [];
                    foreach ($getBooking as $bookingList) {
                        $getWork = $this->CommonModel->getRowByMoreId('book_partner_work', "book_partner_id = '{$bookingList['id']}'");
                        $bookingList['work_details'] = $getWork ? $getWork : null;
                        $all_data[] = $bookingList;
                    }
                    $this->response(array('status' => 200, 'message' => 'All Booking Partner', 'data' => $all_data));
                } else {
                    $this->response(array('status' => 400, 'message' => 'No data found', 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function getHospitalBookPartner_GET($status)
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $getBooking = $this->UserModel->getHospitalPartnerBook("booking_status = '$status' AND book_partner.partner_id = '$tokenId' AND booking_type = '2' AND (payment_mode = '1' AND transaction_status = '1' OR payment_mode = '2')");
                if ($getBooking) {
                    $all_data = [];
                    foreach ($getBooking as $bookingList) {
                        $getWork = $this->CommonModel->getRowByMoreId('book_partner_work', "book_partner_id = '{$bookingList['id']}'");
                        $bookingList['work_details'] = $getWork ? $getWork : null;
                        $all_data[] = $bookingList;
                    }
                    $this->response(array('status' => 200, 'message' => 'All Booking Partner', 'data' => $all_data));
                } else {
                    $this->response(array('status' => 400, 'message' => 'No data found', 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function partnerWorkCheckIn_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $book_partner_id = $this->input->get('book_partner_id');
                if ($book_partner_id != "") {
                    $get = $this->CommonModel->getRowByMoreId('book_partner_work', "book_partner_id = '$book_partner_id'");
                    $this->response(array('status' => 200, 'message' => 'Show check in check ou', 'data' => $get ? $get : null), REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $this->response(array('status' => 400, 'message' => 'Book Partner Id is required', 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function partnerWorkCheckIn_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $this->form_validation->set_rules('book_partner_id', 'Book Partner Id', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run()) {
                    $get = $this->CommonModel->getSingleRowById('book_partner_work', "book_partner_id = '$book_partner_id' AND partner_id = '$tokenId' AND date = '" . date('d-m-Y') . "'");
                    if ($get) {
                        if ($get['check_out'] == "") {
                            $post['check_out'] = date('h:i A');
                            $post['check_out_lat'] = $check_out_lat;
                            $post['check_out_long'] = $check_out_long;
                            $update = $this->CommonModel->updateRowByMoreId('book_partner_work', "book_partner_id = '$book_partner_id' AND partner_id = '$tokenId' AND date = '" . date('d-m-Y') . "'", $post);
                            $message = "Partner Check Out";
                        } else {
                            $message = "Already Check Out";
                        }
                    } else {
                        $post['book_partner_id'] = $book_partner_id;
                        $post['partner_id'] = $tokenId;
                        $post['date'] = date('d-m-Y');
                        $post['check_in'] = date('h:i A');
                        $post['check_in_lat'] = $check_in_lat;
                        $post['check_in_long'] = $check_in_long;
                        $insert = $this->CommonModel->insertRow('book_partner_work', $post);
                        $message = "Partner Check In";
                    }
                    $this->response(array('status' => 200, 'message' => $message, 'data' => null));
                } else {
                    $this->response(array('status' => 400, 'message' => str_replace("\n", '', validation_errors()), 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function partnerWorkComplete_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $this->form_validation->set_rules('book_partner_id', 'Book Partner Id', 'trim|required');
                $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run()) {
                    $get = $this->CommonModel->getSingleRowById('book_partner', "id = '{$book_partner_id}'");
                    if ($get['otp'] == 'otp') {
                        $update = $this->CommonModel->updateRowById('book_partner', 'id', $book_partner_id, ['work_complete_date' => setDateTime(), 'booking_status' => '2']);
                        $this->response(array('status' => 200, 'message' => 'Work Completed Successfully', 'data' => $book_partner_id));
                    } else {
                        $this->response(array('status' => 400, 'message' => 'Enter Valid OTP', 'data' => null));
                    }
                } else {
                    $this->response(array('status' => 400, 'message' => str_replace("\n", '', validation_errors()), 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function getTaskPartner_GET($id)
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $get = $this->CommonModel->getRowByIdInOrder('task', "booking_id = '$id'", 'task_date', 'DESC');
                if ($get) {
                    $this->response(array('status' => 200, 'message' => 'Show all task', 'data' => $get));
                } else {
                    $this->response(array('status' => 400, 'message' => 'No Task', 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function taskStatus_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $this->form_validation->set_rules('id', 'id', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run()) {
                    $post['task_status'] = '1';
                    $post['task_complete_date'] = date('d-M-Y h:i A');
                    $update = $this->CommonModel->updateRowById('task', 'id', $id, $post);
                    $this->response(array('status' => 200, 'message' => 'Task status update successfully', 'data' => null));
                } else {
                    $this->response(array('status' => 400, 'message' => str_replace("\n", '', validation_errors()), 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function gymTransaction_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $total_pay_out = $this->AdminModel->getPartnerBookingSumInRow("partner_id = '" . $tokenId . "' AND booking_status = '2'");
                $pay_amount = getSumInRow("partner_pay_amount", "partner_id = '{$tokenId}'", "amount");
                $data['membership'] = $total_pay_out ? $total_pay_out['total'] : 0;
                $data['pay'] = $pay_amount ? $pay_amount : 0;
                $data['remaining_amount'] = $data['membership'] - $data['pay'];
                $getTxn = $this->CommonModel->getRowByIdInOrder('partner_pay_amount', "partner_id = '{$tokenId}'", "create_date", 'DESC');
                $data['all_transaction'] = $getTxn ? $getTxn : null;
                $this->response(array('status' => 200, 'message' => 'Show all transaction', 'data' => $data));
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function getTraining_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getPartnerId($token)) {
                $tokenId = $token['data']->id;
                $get = $this->CommonModel->getRowByIdInOrder('partner_training', "partner_id = '$tokenId'", 'id', 'DESC');
                if ($get) {
                    $this->response(array('status' => 200, 'message' => 'Show all training', 'data' => null));
                } else {
                    $this->response(array('status' => 400, 'message' => 'No data found', 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}
