<?php

use innomitra\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class UserApi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('UserModel');
    }

    public function sendOTPForLoginUser_POST()
    {
        extract($this->input->post());
        $this->form_validation->set_rules('contact_no', 'contact number', 'trim|required');
        if ($this->form_validation->run()) {
            // $otp = rand(9999, 99999);
            $otp = 12345;
            $get = $this->CommonModel->getSingleRowById('users', "contact_no = '$contact_no'");
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

    public function userLogin_POST()
    {
        extract($this->input->post());
        $this->form_validation->set_rules('contact_no', 'contact number', 'trim|required');
        $this->form_validation->set_rules('otp', 'otp', 'trim|required');
        $this->form_validation->set_rules('fcm_token', 'fcm_token', 'trim');
        if ($this->form_validation->run()) {
            $getOtp = $this->CommonModel->getSingleRowByIdInOrder('temp_otp', "contact_no = '$contact_no'", 'id', 'DESC');
            if ($getOtp && ($getOtp['otp'] == $otp)) {
                $getUser = $this->CommonModel->getSingleRowById('users', "contact_no = '$contact_no'");
                $hash = date('dm') . round(microtime(true) * 1000);
                if ($getUser) {
                    $this->CommonModel->updateRowById('users', 'id', $getUser['id'], array('unique_hash' => $hash, 'fcm_token' => @$fcm_token));
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
                    $getUser['profile_image'] =  $getUser['profile_image'] == "" ? null : USER_IMAGE . $getUser['profile_image'];
                    $getUser['token'] = $token;
                    $this->response(array('status' => 200, 'message' => 'User login successfully.', 'data' => $getUser));
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

    public function userCheck_POST()
    {
        extract($this->input->post());
        $this->form_validation->set_rules('email_id', 'Email Id', 'trim|is_unique[users.email_id]', ['is_unique' => 'Email Id already exist.']);
        $this->form_validation->set_rules('contact_no', 'Email Id', 'trim|is_unique[users.contact_no]', ['is_unique' => 'Contact Number already exist.']);
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

    public function userRegistration_POST()
    {
        extract($this->input->post());
        $this->form_validation->set_rules('name', 'name', 'trim|required', ['required' => 'Name is required.']);
        $this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|is_unique[users.email_id]', ['is_unique' => 'Email Id already exist.']);
        $this->form_validation->set_rules('contact_no', 'Email Id', 'trim|required|is_unique[users.contact_no]', ['is_unique' => 'Contact Number already exist.']);
        $this->form_validation->set_rules('otp', 'otp', 'trim|required');
        $this->form_validation->set_error_delimiters('', ' ');
        if ($this->form_validation->run()) {
            $getOtp = $this->CommonModel->getSingleRowByIdInOrder('temp_otp', "contact_no = '$contact_no'", 'id', 'DESC');
            if ($getOtp && ($getOtp['otp'] == $otp)) {
                $hash = date('dm') . round(microtime(true) * 1000);

                $post['name'] = $name;
                $email_id == "" ? null : $post['email_id'] = $email_id;
                $post['contact_no'] = $contact_no;
                $post['unique_hash'] = $hash;

                $insert = $this->CommonModel->insertRowReturnId('users', $post);
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
                    $getPartner = $this->CommonModel->getSingleRowById('users', "id = '$insert'");
                    $getPartner['profile_image'] =  $getPartner['profile_image'] == "" ? null : PARTNER_IMAGE . $getPartner['profile_image'];
                    $getPartner['token'] = $token;
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

    public function userProfile_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $get = $this->CommonModel->getSingleRowById('users', "id = '$tokenId'");
                $this->response(array('status' => 200, 'message' => 'View User Profile', 'data' => $get));
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function userProfile_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $get = $this->CommonModel->getSingleRowById('users', "id = '{$tokenId}'");
                $this->form_validation->set_rules('name', 'name', 'trim|required', ['required' => 'Name is required.']);
                if ($this->form_validation->run()) {

                    $post['name'] = $name;
                    $post['address'] = $address;
                    $post['area'] = $area;
                    $post['postal_code'] = $postal_code;
                    $post['state'] = $state;
                    $post['city'] = $city;

                    if (!empty($_FILES['profile_image']['name'])) {
                        $profile_image = imageUpload('profile_image', USER_IMAGE);
                        $post['profile_image'] = $profile_image;
                        if (isset($profile_image_temp) && $profile_image_temp != "") {
                            unlink(USER_IMAGE . $profile_image_temp);
                        }
                    }

                    $update = $this->CommonModel->updateRowById('users', 'id', $tokenId, $post);
                    $get = $this->CommonModel->getSingleRowById('users', "id = '{$tokenId}'");
                    $get['profile_image'] =  $get['profile_image'] == "" ? null : PARTNER_IMAGE . $get['profile_image'];
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

    public function userDashboard_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $data['new_request'] = 0;
                $data['help_line_no'] = '9522122133';
                $this->response(array('status' => 200, 'message' => 'Show partner dashboard', 'data' => $data));
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function bookPartner_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $this->form_validation->set_rules('name', 'Name', 'trim|required');
                $this->form_validation->set_rules('contact_no', 'Contact Number', 'trim|required');
                $this->form_validation->set_rules('address', 'Address', 'trim|required');
                $this->form_validation->set_rules('area', 'Area', 'trim|required');
                $this->form_validation->set_rules('postal_code', 'Postal Code', 'trim|required');
                $this->form_validation->set_rules('state', 'State', 'trim|required');
                $this->form_validation->set_rules('city', 'City', 'trim|required');
                $this->form_validation->set_rules('hospital_name', 'Hospital Name', 'trim|required');
                $this->form_validation->set_rules('hospital_address', 'Hospital Address', 'trim|required');
                $this->form_validation->set_rules('booking_date', 'Booking Date', 'trim|required');
                $this->form_validation->set_rules('booking_time', 'Booking Time', 'trim|required');
                $this->form_validation->set_rules('no_of_days', 'Number of Days', 'trim|required');
                $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
                $this->form_validation->set_rules('final_amount', 'Final Amount', 'trim|required');
                $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'trim|required');
                $this->form_validation->set_rules('service_id', 'Service Id', 'trim|required');
                $this->form_validation->set_rules('sub_service_id', 'Sub Service Id', 'trim|required');
                $this->form_validation->set_rules('booking_type', 'Booking Type', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run()) {
                    $post['name'] = $name;
                    $post['contact_no'] = $contact_no;
                    $post['address'] = $address;
                    $post['area'] = $area;
                    $post['postal_code'] = $postal_code;
                    $post['state'] = $state;
                    $post['city'] = $city;
                    $post['booking_date'] = date('d-m-Y', strtotime($booking_date));
                    $post['booking_time'] = $booking_time;
                    $post['no_of_days'] = $no_of_days;
                    $post['amount'] = $amount;
                    $post['final_amount'] = $final_amount;
                    $post['payment_mode'] = $payment_mode;
                    $post['service_id'] = $service_id;
                    $post['sub_service_id'] = $sub_service_id;
                    $post['booking_type'] = $booking_type;
                    $post['otp'] = rand(9999, 99999);
                    $txn_id = $post['transaction_id'] = orderIdGenerateUser();
                    $post['user_id'] = $tokenId;
                    if ($booking_type == 2) {
                        $post['hospital_name'] = $hospital_name;
                        $post['hospital_address'] = $hospital_address;
                    }
                    $insert = $this->CommonModel->insertRow('book_partner', $post);
                    $this->response(array('status' => 200, 'message' => 'Partner Book Successfully', 'data' => ['transaction_id' => $txn_id]));
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

    public function bookPartnerPaymentConfirm_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $this->form_validation->set_rules('transaction_id', 'Transaction Id', 'trim|required');
                $this->form_validation->set_rules('transaction_status', 'Transaction Status', 'trim|required');
                $this->form_validation->set_rules('payment_id', 'Payment Id', 'trim');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run()) {
                    $post['transaction_status'] = $transaction_status;
                    if ($transaction_status == '1') {
                        $post['payment_id'] = $payment_id;
                        $message = "Payment Successful";
                    } else {
                        $message = "Payment Failed";
                    }
                    $update = $this->CommonModel->updateRowById('book_partner', 'transaction_id', $transaction_id, $post);
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

    public function bookPartner_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $getBooking = $this->UserModel->getPartnerBook("user_id = '$tokenId' AND booking_type = '1'");
                if ($getBooking) {
                    $all_data = [];
                    foreach ($getBooking as $bookingList) {
                        if ($bookingList['booking_status'] != '0') {
                            $getPartner = $this->CommonModel->getSingleRowById('partners', "id = '{$bookingList['partner_id']}'");
                            $bookingList['partner_name'] = $getPartner['name'];
                            $bookingList['partner_contact_no'] = $getPartner['contact_no'];
                        }
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

    public function bookPartnerHospital_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $getBooking = $this->UserModel->getHospitalPartnerBook("user_id = '$tokenId' AND booking_type = '2'");
                if ($getBooking) {
                    $all_data = [];
                    foreach ($getBooking as $bookingList) {
                        if ($bookingList['booking_status'] != '0') {
                            $getPartner = $this->CommonModel->getSingleRowById('partners', "id = '{$bookingList['partner_id']}'");
                            $bookingList['partner_name'] = $getPartner['name'];
                            $bookingList['partner_contact_no'] = $getPartner['contact_no'];
                        }
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

    public function getTaskUser_GET($id)
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
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

    // Form Data

    public function formSave_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $this->form_validation->set_rules('name', 'name', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run()) {
                    $post['name'] = $name;
                    $post['relationship'] = $relationship;
                    $post['gender'] = $gender;
                    $post['language'] = $language;
                    $post['medical_condition'] = $medical_condition;
                    $post['additional_requirement'] = $additional_requirement;
                    $post['level_of_mobility'] = $level_of_mobility;
                    $post['level_of_dependency'] = $level_of_dependency;
                    $post['age'] = $age;
                    $post['height'] = $height;
                    $post['weight'] = $weight;
                    $post['user_id'] = $tokenId;
                    $post['date'] = setDateOnly();
                    if (!empty($_FILES['image']['name'])) {
                        $pic = imageUpload('image', FORM_IMAGE);
                        $post['image'] = $pic;
                    }
                    $insert = $this->CommonModel->insertRow('form', $post);
                    $this->response(array('status' => 200, 'message' => 'Form Submit Successfully', 'data' => null));
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

    public function formSave_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $get = $this->CommonModel->getRowByIdInOrder('form', "user_id = '{$tokenId}'", 'create_date', 'DESC');
                if ($get) {
                    $this->response(array('status' => 200, 'message' => 'Show all data', 'data' => $get));
                } else {
                    $this->response(array('status' => 400, 'message' => 'NO Data Found', 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    // Request For Video Call

    public function requestVideoCall_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $post['user_id'] = $tokenId;
                $insert = $this->CommonModel->insertRow('video_call_request', $post);
                $this->response(array('status' => 200, 'message' => 'Request send successfully', 'data' => null));
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function requestVideoCall_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $get = $this->CommonModel->getRowByIdInOrder('video_call_request', "user_id = '$tokenId'", 'create_date', 'DESC');
                if ($get) {
                    $this->response(array('status' => 200, 'message' => 'Show all request', 'data' => $get));
                } else {
                    $this->response(array('status' => 200, 'message' => 'No data found', 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    // Book Rental Product

    public function bookRentalProduct_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $this->form_validation->set_rules('name', 'Name', 'trim|required');
                $this->form_validation->set_rules('item_data', 'Item Data', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run()) {
                    $post['name'] = $name;
                    $post['contact_no'] = $contact_no;
                    $post['address'] = $address;
                    $post['area'] = $area;
                    $post['postal_code'] = $postal_code;
                    $post['state'] = $state;
                    $post['city'] = $city;
                    $post['booking_date'] = date('Y-m-d', strtotime($booking_date));
                    $post['no_of_days'] = $no_of_days;
                    $post['amount'] = $amount;
                    $post['final_amount'] = $final_amount;
                    $post['otp'] = rand(999, 9999);
                    $post['payment_mode'] = $payment_mode;

                    $txn_id = $post['transaction_id'] = orderIdGenerateUser2();
                    $post['user_id'] = $tokenId;
                    $insertId = $this->CommonModel->insertRowReturnId('rental_book_product', $post);
                    if (!empty($item_data)) {
                        $item_list = json_decode($item_data, true);
                        foreach ($item_list as $list) {
                            $post_item[] = array(
                                'book_product_id' => $insertId,
                                'create_date' => setDateTime(),
                                'category_id' => $list['category_id'],
                                'product_id' => $list['product_id'],
                                'no_of_items' => $list['no_of_items'],
                                'amount' => $list['amount'],
                                'final_amount' => $list['final_amount']
                            );
                        }
                        $insert = $this->CommonModel->insertRowInBatch('rental_book_item', $post_item);
                    }
                    $this->response(array('status' => 200, 'message' => 'Transaction Initiate Successfully', 'data' => ['transaction_id' => $txn_id]));
                } else {
                    $this->response(array('status' => 400, 'message' => str_replace('n', '', validation_errors()), 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function rentalProductPaymentConfirm_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $this->form_validation->set_rules('transaction_id', 'Transaction Id', 'trim|required');
                $this->form_validation->set_rules('transaction_status', 'Transaction Status', 'trim|required');
                $this->form_validation->set_rules('payment_id', 'Payment Id', 'trim');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run()) {
                    $post['transaction_status'] = $transaction_status;
                    if ($transaction_status == '1') {
                        $post['payment_id'] = $payment_id;
                        $message = "Payment Successful";
                    } else {
                        $message = "Payment Failed";
                    }
                    $update = $this->CommonModel->updateRowById('rental_book_product', 'transaction_id', $transaction_id, $post);
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

    public function bookRentalProduct_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $getBooking = $this->CommonModel->getRowByIdInOrder('rental_book_product', "user_id = '$tokenId'", 'id', 'DESC');
                if ($getBooking) {
                    $all_data = [];
                    foreach ($getBooking as $bookingList) {
                        $bookingList['items'] = $this->UserModel->getBookedRentalItem("book_product_id = '{$bookingList['id']}'");
                        $all_data[] = $bookingList;
                    }
                    $this->response(array('status' => 200, 'message' => 'All Rental Product Book', 'data' => $all_data));
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

    // Chat Bot

    public function getTreeCategory($flora_tree_id)
    {
        $get = $this->db->select("tree_title,tree_id,id,level")
            ->where('tree_id', $flora_tree_id)
            ->order_by('id', 'DESC')
            ->get('chatbot_qa')
            ->result_array();
        if (count($get) > 0) {
            $allCategory = "";
            foreach ($get as $row) {
                $allCategory .= $this->getTreeCategory($row['id']);
                $allCategory .= ucwords($row['tree_title']) . '|||' . $row['tree_id'] . '|||' . $row['level'] . '<=||=>';
            }
            return $allCategory;
        } else {
            return false;
        }
    }

    public function chatBotList_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $id = $this->input->get('id');
                $level = $this->input->get('level');
                $grid = array();
                if (isset($id)) {
                    $getTree = $this->CommonModel->getRowByIdInOrder('chatbot_qa', "id = '$id' AND level = '$level'", "is_arrange", "ASC");
                    $getGrid = $this->getTreeCategory($id);
                    if ($getGrid) {
                        $lastDataRemove = lastReplace("<=||=>", "", $getGrid);
                        $gridData = explode("<=||=>", $lastDataRemove);
                        foreach ($gridData as $gd) {
                            $finalData = explode("|||", $gd);
                            $grid[] = array(
                                'id' => $finalData[1],
                                'grid_title' => $finalData[0],
                                'level' => $finalData[2] + 1,
                            );
                        }
                    } else {
                        $grid = null;
                    }
                } else {
                    $getTree = $this->CommonModel->getRowByIdInOrder('chatbot_qa', "level = '0'", "is_arrange", "ASC");
                    $grid = null;
                }

                if ($getTree) {
                    $allList = array();
                    foreach ($getTree as $treeList) {
                        $allList[] = array(
                            'id' => $treeList['tree_id'],
                            'tree_title' => $treeList['tree_title'],
                            'is_category' => $treeList['is_category'],
                            'description' => str_replace("@", "", $treeList['description']),
                            'level' => $treeList['level'] + 1,
                        );
                    }
                    $this->response(array('status' => 200, 'message' => 'Show all data', 'data' => $allList, 'grid' => $grid), REST_Controller::HTTP_OK);
                } else {
                    $this->response(array('status' => 400, 'message' => 'No Data Found', 'data' => null), REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function chatBotQuery_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $this->form_validation->set_rules('title', 'title', 'trim|required');
                $this->form_validation->set_rules('message', 'message', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run()) {
                    $post['title'] = $title;
                    $post['message'] = $message;
                    $post['user_id'] = $tokenId;
                    $insert = $this->CommonModel->insertRow('chat_support', $post);
                    $this->response(array('status' => 200, 'message' => 'Message send Successfully', 'data' => null));
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

    public function chatBotQuery_GET()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $get = $this->CommonModel->getRowByIdInOrder('chat_support', "user_id = '{$tokenId}'", 'create_date', 'DESC');
                if ($get) {
                    $this->response(array('status' => 200, 'message' => 'Show all data', 'data' => $get));
                } else {
                    $this->response(array('status' => 400, 'message' => 'N Data Found', 'data' => null));
                }
            } else {
                $this->response(array('status' => 401, 'message' => 'Unauthorized user', 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(array('status' => 401, 'message' => $token['message'], 'data' => null), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function feedbackForm_POST()
    {
        $token = $this->authorization_token->validateToken();
        if (!empty($token) and $token['status'] != 0) {
            extract($this->input->post());
            if (getUserId($token)) {
                $tokenId = $token['data']->id;
                $this->form_validation->set_rules('message', 'message', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run()) {
                    $post['message'] = $message;
                    $post['user_id'] = $tokenId;
                    $insert = $this->CommonModel->insertRow('feedback', $post);
                    $this->response(array('status' => 200, 'message' => 'Message send Successfully', 'data' => null));
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
}
