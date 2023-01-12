<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AdminHome extends CI_Controller
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

	public function dashboard()
	{
		error_reporting(0);
		$getRows['active_user'] = $this->CommonModel->getNumRows("users", "status = '1'");
		$getRows['inactive_user'] = $this->CommonModel->getNumRows("users", "status = '0'");
		$getRows['active_partner'] = $this->CommonModel->getNumRows("partners", "status = '1' AND verify_status = '1'");
		$getRows['partner_interview_new'] = $this->CommonModel->getNumRows("partners", "status = '0' AND verify_status = '0'");
		$getRows['partner_interview_reject'] = $this->CommonModel->getNumRows("partners", "status = '1' AND verify_status = '0'");
		$getRows['inactive_partner'] = $this->CommonModel->getNumRows("partners", "status = '0' AND verify_status = '1'");
		$getRows['verify_partner'] = $this->CommonModel->getNumRows("partners", "status = '1' AND verify_status = '0'");
		$getRows['verify_cancel_partner'] = $this->CommonModel->getNumRows("partners", "status = '1' AND verify_status = '2'");
		$getRows['service'] = $this->CommonModel->getNumRows("service", "is_delete = '1'");
		$getRows['sub_service'] = $this->CommonModel->getNumRows("sub_service", "is_delete = '1'");
		$getRows['new_elder_care'] = $this->CommonModel->getNumRows('book_partner', "booking_type = '1' AND transaction_status = '1' AND booking_status = '0'");
		$getRows['elder_care_assign'] = $this->CommonModel->getNumRows('book_partner', "booking_type = '1' AND transaction_status = '1' AND booking_status = '1'");
		$getRows['elder_care_complete'] = $this->CommonModel->getNumRows('book_partner', "booking_type = '1' AND transaction_status = '1' AND booking_status = '2'");
		$getRows['new_hospital_care'] = $this->CommonModel->getNumRows('book_partner', "booking_type = '2' AND transaction_status = '1' AND booking_status = '0'");
		$getRows['hospital_care_assign'] = $this->CommonModel->getNumRows('book_partner', "booking_type = '2' AND transaction_status = '1' AND booking_status = '1'");
		$getRows['hospital_care_complete'] = $this->CommonModel->getNumRows('book_partner', "booking_type = '2' AND transaction_status = '1' AND booking_status = '2'");
		$getRows['new_rental_book_product'] = $this->CommonModel->getNumRows('rental_book_product', "transaction_status = '1' AND booking_status = '0'");
		$getRows['assign_rental_book_product'] = $this->CommonModel->getNumRows('rental_book_product', "transaction_status = '1' AND booking_status = '1'");
		$getRows['care_recipient_request'] = $this->CommonModel->getNumRows('form', "status = '0'");
		$getRows['assign_care_recipient_request'] = $this->CommonModel->getNumRows('form', "status = '1'");
		$getRows['video_request'] = $this->CommonModel->getNumRows('video_call_request', "status = '0'");
		$getRows['accept_video_request'] = $this->CommonModel->getNumRows('video_call_request', "status = '1'");
		$getRows['reject_video_request'] = $this->CommonModel->getNumRows('video_call_request', "status = '2'");
		$getRows['title'] = "Home";
		$this->load->view('admin/index', $getRows);
	}

	public function banner()
	{
		extract($this->input->get());
		$id = $this->input->get('bID');
		$BdID = $this->input->get('BdID');
		$sId = decryptId($id);
		if (isset($id)) {
			$data['title'] = 'Banner Edit';
			$get = $this->CommonModel->getSingleRowById('banner', "id = '$sId'");
		} else {
			$get = false;
			$data['title'] = 'Banner add';
		}
		$data['image_path'] = set_value('image_path') == false ? @$get['image_path'] : set_value('image_path');
		$data['all_banner'] = $this->CommonModel->getAllRowsInOrder('banner', 'create_date', 'DESC');

		if (decryptId($BdID) != '') {
			$delete = $this->CommonModel->deleteRowById('banner', array('id' => decryptId($BdID)));
			unlink('upload/banner/' . $img);
			redirect('banner');
			exit;
		}

		if (count($_POST) > 0) {
			if (isset($id)) {
				$tempImage = $this->input->post('temp_image');
				if (!empty($_FILES['image_path']['name'])) {
					$p = fullImage('image_path', 'upload/banner');
					unlink('upload/banner/' . $tempImage);
					$post['image_path'] = $p;
				} else {
					$post['image_path'] = $tempImage;
				}

				$post['update_date'] = setDateTime();
				$update = $this->CommonModel->updateRowById('banner', 'id', $sId, $post);
				if ($update) {
					flashData('errors', 'Banner Update Successfully');
				} else {
					flashData('errors', 'Banner Not Update. please try again');
				}
			} else {
				$image = fullImage('image_path', 'upload/banner');
				if ($image) {
					$post['create_date'] = setDateTime();
					$post['image_path'] = $image;
					$insert = $this->CommonModel->insertRow('banner', $post);
					flashData('errors', 'Banner Add successfully.');
				} else {
					flashData('errors', 'Banner Not Add.Please try again.');
				}
			}
			redirect('banner');
		}
		$this->load->view('admin/banner', $data);
	}

	// Change Password 

	public function changePassword()
	{
		extract($this->input->post());
		$data['title'] = 'Change Password';
		if (count($_POST) > 0) {
			$this->form_validation->set_rules('current_password', 'current password', 'trim|required');
			$this->form_validation->set_rules('new_password', 'new password', 'trim|required');
			$this->form_validation->set_rules('cnf_password', 'confirm password', 'trim|required');
			$this->form_validation->set_error_delimiters('<div style="color: red;">', '</div>');
			if ($this->form_validation->run()) {
				$get = $this->CommonModel->getSingleRowById('admin_login', "id = '" . sessionId('admin_id') . "'");
				if (password_verify($current_password, $get['password'])) {
					$post['password'] = password_hash($cnf_password, PASSWORD_DEFAULT);
					$update = $this->CommonModel->updateRowById('admin_login', 'id', sessionId('admin_id'), $post);
					flashData('errors', 'Password change successfully');
					redirect('changePassword');
				} else {
					flashData('errors', 'Current Password Does Not Match');
				}
			}
		}
		$this->load->view('admin/change_password', $data);
	}

	// Service

	public function serviceAll()
	{
		$get['all_data'] = $this->CommonModel->getRowByIdInOrder('service', "is_delete = '1'", 'service_name', 'ASC');
		$get['title'] = 'All service';
		$this->load->view('admin/service_all', $get);
	}

	public function serviceAdd()
	{
		extract($this->input->post());
		$id = $this->input->get('id');
		$dID = $this->input->get('dID');
		$decrypt_id = decryptId($this->input->get('id'));
		$get = $this->CommonModel->getSingleRowById('service', "id = '$decrypt_id'");
		$data['service_name'] = set_value('service_name') == false ? @$get['service_name'] : set_value('service_name');
		$data['image'] = set_value('image') == false ? @$get['image'] : set_value('image');
		$data['description'] = set_value('description') == false ? @$get['description'] : set_value('description');
		if (isset($id)) {
			$data['title'] = 'Edit Service';
		} else {
			$data['title'] = 'Add Service';
		}

		if (isset($dID)) {
			$update = $this->CommonModel->updateRowById('service', 'id', decryptId($dID), array('is_delete' => '0'));
			redirect('serviceAll');
			exit;
		}

		if (count($_POST) > 0) {
			$this->form_validation->set_rules('service_name', 'service name', 'required');
			if ($this->form_validation->run()) {
				$post['service_name'] = trim($service_name);
				$post['description'] = $description;
				if (isset($id)) {
					if (empty($_FILES['image']['name'])) {
						$post['image'] = $temp_image;
					} else {
						$picture = imageUploadWithRatio('image', 'upload/service/', 600, 400);
						$post['image'] = $picture;
						unlink("upload/service/" . $temp_image);
					}
					$update = $this->CommonModel->updateRowById('service', 'id', $decrypt_id, $post);
					if ($update) {
						flashData('errors', 'service Update Successfully');
					} else {
						flashData('errors', 'service Not Add');
					}
				} else {
					$picture = imageUploadWithRatio('image', 'upload/service/', 600, 400);
					$post['image'] = $picture;
					$insert = $this->CommonModel->insertRow('service', $post);
					if ($insert) {
						flashData('errors', 'service Add Successfully');
					} else {
						flashData('errors', 'service Not Add');
					}
				}
				redirect('serviceAll');
			}
		}
		$this->load->view('admin/service_add', $data);
	}

	public function subServiceAll()
	{
		$data['all_data'] = $this->CommonModel->getRowByIdInOrder('sub_service', "is_delete = '1'", 'sub_service_name', 'ASC');
		$data['title'] = "All Sub Service";
		$this->load->view('admin/sub_service_all', $data);
	}

	public function subServiceAdd()
	{
		$dID = $this->input->get('dID');
		$id = $this->input->get('id');
		extract($this->input->post());
		$decrypt_id = decryptId($this->input->get('id'));

		$get = $this->CommonModel->getSingleRowById('sub_service', "id = '$decrypt_id'");
		$data['sub_service_name'] = set_value('sub_service_name') == false ? @$get['sub_service_name'] : set_value('sub_service_name');
		$data['service_id'] = set_value('service_id') == false ? @$get['service_id'] : set_value('service_id');
		$data['price'] = set_value('price') == false ? @$get['price'] : set_value('price');
		$data['description'] = set_value('description') == false ? @$get['description'] : set_value('description');

		if (isset($id)) {
			$data['title'] = 'Edit Sub service';
		} else {
			$data['title'] = 'Add Sub service';
		}

		if (isset($dID)) {
			$update = $this->CommonModel->updateRowById('sub_service', 'id', decryptId($dID), array('is_delete' => '0'));
			redirect('subServiceAll');
			exit;
		}

		if (count($_POST) > 0) {
			$this->form_validation->set_rules('sub_service_name', 'sub service name', 'trim|required');
			$this->form_validation->set_rules('service_id', 'service', 'required');
			if ($this->form_validation->run()) {

				$post['sub_service_name'] = $sub_service_name;
				$post['service_id'] = $service_id;
				$post['price'] = $price;
				$post['description'] = $description;
				if (isset($id)) {

					$update = $this->CommonModel->updateRowById('sub_service', 'id', $decrypt_id, $post);
					if ($update) {
						flashData('errors', 'Sub service Update Successfully');
					} else {
						flashData('errors', 'Sub service Not Add');
					}
				} else {
					$insert = $this->CommonModel->insertRow('sub_service', $post);
					if ($insert) {
						flashData('errors', 'Sub service Add Successfully');
					} else {
						flashData('errors', 'Sub service Not Add');
					}
				}
				redirect('subServiceAll');
			}
		}
		$this->load->view('admin/sub_service_add', $data);
	}

	// Form Fields

	public function formFieldTypeAll()
	{
		$get['all_data'] = $this->CommonModel->getRowByIdInOrder('form_field_type', "id != '0'", 'name', 'ASC');
		$get['title'] = 'All Form Field';
		$this->load->view('admin/form_field_all', $get);
	}

	public function formFieldTypeAdd()
	{
		extract($this->input->post());
		$id = $this->input->get('id');
		$dID = $this->input->get('dID');
		$decrypt_id = decryptId($this->input->get('id'));

		if (isset($id)) {
			$data['title'] = 'Edit Form Field';
			$get = $this->CommonModel->getSingleRowById('form_field_type', "id = '$decrypt_id'");
		} else {
			$data['title'] = 'Add Form Field';
			$get = false;
		}

		$data['name'] = set_value('name') == false ? @$get['name'] : set_value('name');

		if (isset($dID)) {
			$delete = $this->CommonModel->deleteRowById('form_field_type', "id = '" . decryptId($dID) . "'");
			redirect('formFieldTypeAll');
			exit;
		}

		if (count($_POST) > 0) {
			$this->form_validation->set_rules('name', 'service name', 'required');
			if ($this->form_validation->run()) {
				$post['name'] = trim($name);
				if (isset($id)) {

					$update = $this->CommonModel->updateRowById('form_field_type', 'id', $decrypt_id, $post);
					flashData('errors', 'Form Field Update Successfully');
				} else {
					$insert = $this->CommonModel->insertRow('form_field_type', $post);
					flashData('errors', 'Form Field Add Successfully');
				}
				redirect('formFieldTypeAll');
			}
		}
		$this->load->view('admin/form_field_add', $data);
	}

	public function formFieldAll()
	{
		$data['all_data'] = $this->CommonModel->getRowByIdInOrder('form_field', "id != '0'", 'name', 'ASC');
		$data['title'] = "All Form Field";
		$this->load->view('admin/form_fields_all', $data);
	}

	public function formFieldAdd()
	{
		$dID = $this->input->get('dID');
		$id = $this->input->get('id');
		extract($this->input->post());
		$decrypt_id = decryptId($this->input->get('id'));

		$get = $this->CommonModel->getSingleRowById('form_field', "id = '$decrypt_id'");
		$data['name'] = set_value('name') == false ? @$get['name'] : set_value('name');
		$data['field_type_id'] = set_value('field_type_id') == false ? @$get['field_type_id'] : set_value('field_type_id');

		if (isset($id)) {
			$data['title'] = 'Edit Form Field"';
		} else {
			$data['title'] = 'Add Form Field"';
		}

		if (isset($dID)) {
			$this->CommonModel->deleteRowById('form_field', "id = '" . decryptId($dID) . "'");
			redirect('formFieldAll');
			exit;
		}

		if (count($_POST) > 0) {
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			if ($this->form_validation->run()) {
				$post['name'] = $name;
				$post['field_type_id'] = $field_type_id;
				if (isset($id)) {
					$update = $this->CommonModel->updateRowById('form_field', 'id', $decrypt_id, $post);
					flashData('errors', 'Form Field Update Successfully');
				} else {
					$insert = $this->CommonModel->insertRow('form_field', $post);
					flashData('errors', 'Form Field Add Successfully');
				}
				redirect('formFieldAll');
			}
		}
		$this->load->view('admin/form_fields_add', $data);
	}

	// Hospital Service

	public function serviceHospitalAll()
	{
		$get['all_data'] = $this->CommonModel->getRowByIdInOrder('hospital_service', "is_delete = '1'", 'service_name', 'ASC');
		$get['title'] = 'All Hospital Service';
		$this->load->view('admin/hospital_service_all', $get);
	}

	public function serviceHospitalAdd()
	{
		extract($this->input->post());
		$id = $this->input->get('id');
		$dID = $this->input->get('dID');
		$decrypt_id = decryptId($this->input->get('id'));
		$get = $this->CommonModel->getSingleRowById('hospital_service', "id = '$decrypt_id'");
		$data['service_name'] = set_value('service_name') == false ? @$get['service_name'] : set_value('service_name');
		$data['image'] = set_value('image') == false ? @$get['image'] : set_value('image');
		$data['description'] = set_value('description') == false ? @$get['description'] : set_value('description');
		if (isset($id)) {
			$data['title'] = 'Edit Service Hospital';
		} else {
			$data['title'] = 'Add Service Hospital';
		}

		if (isset($dID)) {
			$update = $this->CommonModel->updateRowById('hospital_service', 'id', decryptId($dID), array('is_delete' => '0'));
			redirect('serviceHospitalAll');
			exit;
		}

		if (count($_POST) > 0) {
			$this->form_validation->set_rules('service_name', 'service name', 'required');
			if ($this->form_validation->run()) {
				$post['service_name'] = trim($service_name);
				$post['description'] = $description;
				if (isset($id)) {
					if (empty($_FILES['image']['name'])) {
						$post['image'] = $temp_image;
					} else {
						$picture = imageUploadWithRatio('image', 'upload/service/', 600, 400);
						$post['image'] = $picture;
						unlink("upload/service/" . $temp_image);
					}
					$update = $this->CommonModel->updateRowById('hospital_service', 'id', $decrypt_id, $post);
					if ($update) {
						flashData('errors', 'Service Update Successfully');
					} else {
						flashData('errors', 'Service Not Add');
					}
				} else {
					$picture = imageUploadWithRatio('image', 'upload/service/', 600, 400);
					$post['image'] = $picture;
					$insert = $this->CommonModel->insertRow('hospital_service', $post);
					if ($insert) {
						flashData('errors', 'Service Add Successfully');
					} else {
						flashData('errors', 'Service Not Add');
					}
				}
				redirect('serviceHospitalAll');
			}
		}
		$this->load->view('admin/hospital_service_add', $data);
	}

	public function subServiceHospitalAll()
	{
		$data['all_data'] = $this->CommonModel->getRowByIdInOrder('hospital_sub_service', "is_delete = '1'", 'sub_service_name', 'ASC');
		$data['title'] = "All Hospital Sub Service";
		$this->load->view('admin/hospital_sub_service_all', $data);
	}

	public function subServiceHospitalAdd()
	{
		$dID = $this->input->get('dID');
		$id = $this->input->get('id');
		extract($this->input->post());
		$decrypt_id = decryptId($this->input->get('id'));

		$get = $this->CommonModel->getSingleRowById('hospital_sub_service', "id = '$decrypt_id'");
		$data['sub_service_name'] = set_value('sub_service_name') == false ? @$get['sub_service_name'] : set_value('sub_service_name');
		$data['service_id'] = set_value('service_id') == false ? @$get['service_id'] : set_value('service_id');
		$data['price'] = set_value('price') == false ? @$get['price'] : set_value('price');
		$data['description'] = set_value('description') == false ? @$get['description'] : set_value('description');

		if (isset($id)) {
			$data['title'] = 'Edit Hospital Sub service';
		} else {
			$data['title'] = 'Add Hospital Sub service';
		}

		if (isset($dID)) {
			$update = $this->CommonModel->updateRowById('hospital_sub_service', 'id', decryptId($dID), array('is_delete' => '0'));
			redirect('subServiceAll');
			exit;
		}

		if (count($_POST) > 0) {
			$this->form_validation->set_rules('sub_service_name', 'sub service name', 'trim|required');
			$this->form_validation->set_rules('service_id', 'service', 'required');
			if ($this->form_validation->run()) {

				$post['sub_service_name'] = $sub_service_name;
				$post['service_id'] = $service_id;
				$post['price'] = $price;
				$post['description'] = $description;
				if (isset($id)) {

					$update = $this->CommonModel->updateRowById('hospital_sub_service', 'id', $decrypt_id, $post);
					flashData('errors', 'Hospital Sub service Update Successfully');
				} else {
					$insert = $this->CommonModel->insertRow('hospital_sub_service', $post);
					flashData('errors', 'Hospital Sub service Add Successfully');
				}
				redirect('subServiceHospitalAll');
			}
		}
		$this->load->view('admin/hospital_sub_service_add', $data);
	}

	// Form

	public function formData()
	{
		if (count($_POST) > 0) {
			extract($this->input->post());
			$post['message'] = $message;
			$post['status'] = '1';
			$update = $this->CommonModel->updateRowById('form', 'id', decryptId($id), $post);
			flashData('errors', 'Request Send Successfully');
			redirect('formData');
		}
		$data['all_data'] = $this->AdminModel->getFormData("form.id != '0'");
		$data['title'] = "Care Recipient Request";
		$this->load->view('admin/form_all', $data);
	}

	// Rental Product

	public function categoryAll()
	{
		$get['all_data'] = $this->CommonModel->getRowByIdInOrder('category', "is_delete = '1'", 'category_name', 'ASC');
		$get['title'] = 'All Category';
		$this->load->view('admin/category_all', $get);
	}

	public function categoryAdd()
	{
		extract($this->input->post());
		$id = $this->input->get('id');
		$dID = $this->input->get('dID');
		$decrypt_id = decryptId($this->input->get('id'));

		if (isset($id)) {
			$data['title'] = 'Edit Category';
			$get = $this->CommonModel->getSingleRowById('category', "id = '$decrypt_id'");
		} else {
			$data['title'] = 'Add Category';
			$get = false;
		}

		$data['category_name'] = set_value('category_name') == false ? @$get['category_name'] : set_value('category_name');
		$data['image'] = set_value('image') == false ? @$get['image'] : set_value('image');

		if (isset($dID)) {
			$update = $this->CommonModel->updateRowById('category', 'id', decryptId($dID), array('is_delete' => '0'));
			redirect('categoryAll');
			exit;
		}

		if (count($_POST) > 0) {
			$this->form_validation->set_rules('category_name', 'Category Name', 'required');
			if ($this->form_validation->run()) {
				$post['category_name'] = trim($category_name);

				if (!empty($_FILES['image']['name'])) {
					$picture = imageUploadWithRatio('image', 'upload/product/', 600, 400);
					$post['image'] = $picture;
					if ($data['image'] != "") {
						unlink("upload/product/" . $data['image']);
					}
				}

				if (isset($id)) {
					$update = $this->CommonModel->updateRowById('category', 'id', $decrypt_id, $post);
					flashData('errors', 'Category Update Successfully');
				} else {
					$insert = $this->CommonModel->insertRow('category', $post);
					flashData('errors', 'Category Add Successfully');
				}
				redirect('categoryAll');
			}
		}
		$this->load->view('admin/category_add', $data);
	}

	public function productAll()
	{
		$data['all_data'] = $this->CommonModel->getRowByIdInOrder('rental_product', "is_delete = '1'", 'product_name', 'ASC');
		$data['title'] = "All Product";
		$this->load->view('admin/product_all', $data);
	}

	public function productAdd()
	{
		$dID = $this->input->get('dID');
		$id = $this->input->get('id');
		extract($this->input->post());
		$decrypt_id = decryptId($this->input->get('id'));

		if (isset($id)) {
			$data['title'] = 'Edit Product';
			$get = $this->CommonModel->getSingleRowById('rental_product', "id = '$decrypt_id'");
		} else {
			$data['title'] = 'Add Product';
			$get = false;
		}

		$data['product_name'] = set_value('product_name') == false ? @$get['product_name'] : set_value('product_name');
		$data['category_id'] = set_value('category_id') == false ? @$get['category_id'] : set_value('category_id');
		$data['price'] = set_value('price') == false ? @$get['price'] : set_value('price');
		$data['description'] = set_value('description') == false ? @$get['description'] : set_value('description');
		$data['image'] = set_value('image') == false ? @$get['image'] : set_value('image');

		if (isset($dID)) {
			$update = $this->CommonModel->updateRowById('rental_product', 'id', decryptId($dID), array('is_delete' => '0'));
			redirect('productAll');
			exit;
		}

		if (count($_POST) > 0) {
			$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
			$this->form_validation->set_rules('category_id', 'service', 'required');
			if ($this->form_validation->run()) {

				$post['product_name'] = $product_name;
				$post['category_id'] = $category_id;
				$post['price'] = $price;
				$post['description'] = $description;

				if (!empty($_FILES['image']['name'])) {
					$picture = imageUploadWithRatio('image', 'upload/product/', 600, 400);
					$post['image'] = $picture;
					if ($data['image'] != "") {
						unlink("upload/product/" . $data['image']);
					}
				}

				if (isset($id)) {
					$update = $this->CommonModel->updateRowById('rental_product', 'id', $decrypt_id, $post);
					flashData('errors', 'Product Update Successfully');
				} else {
					$insert = $this->CommonModel->insertRow('rental_product', $post);
					flashData('errors', 'Product Add Successfully');
				}
				redirect('productAll');
			}
		}
		$this->load->view('admin/product_add', $data);
	}

	// Chat Bot  

	public function viewTree()
	{
		$id = $this->input->get('id');
		$level = $this->input->get('level');
		if (isset($id)) {
			$get['all_data'] = $this->CommonModel->getRowByIdInOrder('chatbot_qa', "id = '" . decryptId($id) . "' AND level = '$level'", "is_arrange", "ASC");
			$get['viewTree'] = $this->getTreeCategory(decryptId($id));
		} else {
			$get['all_data'] = $this->CommonModel->getRowByIdInOrder('chatbot_qa', "level = '0'", "is_arrange", "ASC");
		}

		$get['title'] = "Chat Bot";
		$this->load->view('admin/chatbot_view', $get);
	}

	public function getTreeCategory($flora_tree_id)
	{
		$get = $this->db->select()
			->where('tree_id', $flora_tree_id)
			->order_by('id', 'DESC')
			->get('chatbot_qa')
			->result_array();
		$category = '';
		if (count($get) > 0) {
			foreach ($get as $row) {
				$category .= $this->getTreeCategory($row['id']);
				$category .= "<span class='info'>" . $row['tree_title'] . "</span><span class='infoSpace'></span>";
			}
			return $category;
		} else {
			return false;
		}
	}

	public function addTree()
	{
		extract($this->input->post());
		$editId = $this->input->get('editId');
		$dId = $this->input->get('dId');
		$addId = $this->input->get('id');
		$level = $this->input->get('level');

		$get = $this->CommonModel->getSingleRowById("chatbot_qa", "tree_id = '" . decryptId($editId) . "'");
		$data['tree_title'] = set_value('tree_title') == false ? @$get['tree_title'] : set_value('tree_title');
		$data['is_category'] = set_value('is_category') == false ? @$get['is_category'] : set_value('is_category');
		$data['id'] = set_value('id') == false ? @$get['id'] : set_value('id');
		$data['description'] = set_value('description') == false ? @$get['description'] : set_value('description');
		$data['is_arrange'] = set_value('is_arrange') == false ? @$get['is_arrange'] : set_value('is_arrange');

		if (isset($editId)) {
			$title = 'Edit Tree Category';
		} else {
			$title = 'Add Tree Category';
		}

		if (isset($dId)) {
			$delete = $this->CommonModel->deleteRowById('chatbot_qa', "tree_id = '" . decryptId($dId) . "'");
			flashData('errors', 'Data Delete Successfully');
			redirect("viewTree?id=$addId&level=$level");
		}


		if (count($_POST) > 0) {
			$post['tree_title'] = trim($tree_title);
			$post['is_category'] = 1;
			$post['is_arrange'] = $is_arrange;
			$post['description'] = trim($description);

			if (isset($editId)) {
				$post['update_date'] = setDateTime();
				$update = $this->CommonModel->updateRowById('chatbot_qa', 'tree_id', decryptId($editId), $post);
				flashData('errors', 'Data update successfully');
				redirect("viewTree?id=$addId&level=$level");
			} else {
				isset($addId) ? $post['id'] = decryptId($addId) : 0;
				isset($level) ? $post['level'] = $level : 0;
				$post['create_date'] = setDateTime();
				$insert = $this->CommonModel->insertRow('chatbot_qa', $post);
				if ($insert) {
					flashData('errors', 'Data Add Successfully');
				} else {
					flashData('errors', 'Data Not Add');
				}
				if (isset($level)) {
					redirect("viewTree?id=$addId&level=$level");
				} else {
					redirect('viewTree');
				}
			}
		}
		$data['title'] = $title;
		$this->load->view('admin/chatbot_add', $data);
	}

	public function searchTreeDetails()
	{
		$search = $this->input->get('search');
		$get = $this->Admin->searchTreeDetails($search);
		if ($get) {
			foreach ($get as $row) {
				$searchKey = $row['tree_title'];
				$level = $row['level'];
				$flora_tree_id = encryptId($row['id']);
?>
				<li>
					<a href="<?= base_url("viewTree?search=$searchKey&id=$flora_tree_id&level=$level") ?>"><?= $row['tree_title'] ?></a>
				</li>
			<?php
			}
		} else { ?>
			<li style="margin: 5px">
				<span>Result not found.</span>
			</li>
<?php
		}
	}

	public function charBotQuery()
	{
		if (count($_POST) > 0) {
			extract($this->input->post());
			$post['admin_message'] = $message;
			$post['status'] = '1';
			$update = $this->CommonModel->updateRowById('chat_support', 'id', decryptId($id), $post);
			flashData('errors', 'Request Send Successfully');
			redirect('charBotQuery');
		}
		$data['all_data'] = $this->AdminModel->getChatBotData("chat_support.id != '0'");
		$data['title'] = "Chat Bot Query";
		$this->load->view('admin/chatbot_all', $data);
	}
}
