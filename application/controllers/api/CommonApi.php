<?php

use innomitra\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class CommonApi extends  REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
    }

    public function stateApi_GET()
    {
        $get = $this->CommonModel->getAllRowsInOrder('state', 'state_name', 'ASC');
        if ($get) {
            foreach ($get as $list) {
                $all[] = array(
                    'state_id' => $list['state_id'],
                    'state_name' => $list['state_name']
                );
            }
            $this->response(array('status' => 200, 'message' => 'Show all state', 'data' => $all));
        } else {
            $this->response(array('status' => 400, 'message' => 'No Data Found', 'data' => null));
        }
    }

    public function cityApi_GET($state_id)
    {
        $get = $this->CommonModel->getRowByIdInOrder('city', "state_id = '$state_id'", 'city_name', 'ASC');
        if ($get) {
            foreach ($get as $cityList) {
                $all[] = array(
                    'city_id' => $cityList['city_id'],
                    'city_name' => $cityList['city_name'],
                );
            }
            $this->response(array('status' => 200, 'message' => 'Show all city', 'data' => $all));
        } else {
            $this->response(array('status' => 400, 'message' => 'Something went wrong. Please try again', 'data' => null));
        }
    }

    public function serviceApi_GET()
    {
        $get = $this->CommonModel->getRowByIdInOrder('service', "is_delete = '1'", 'service_name', 'ASC');
        if ($get) {
            foreach ($get as $list) {
                $all[] = array(
                    'id' => $list['id'],
                    'service_name' => $list['service_name'],
                    'image' => $list['image'] == "" ? null : SERVICE_IMAGE . $list['image'],
                );
            }
            $this->response(array('status' => 200, 'message' => 'Show all Service', 'data' => $all));
        } else {
            $this->response(array('status' => 400, 'message' => 'No Data Found', 'data' => null));
        }
    }

    public function subServiceApi_GET($service_id)
    {
        $get = $this->CommonModel->getRowByIdInOrder('sub_service', "service_id = '$service_id'", 'sub_service_name', 'ASC');
        if ($get) {
            foreach ($get as $cityList) {
                $all[] = array(
                    'id' => $cityList['id'],
                    'sub_service_name' => $cityList['sub_service_name'],
                    'service_id' => $cityList['service_id'],
                    'price' => $cityList['price'],
                    'description' => $cityList['description'],
                );
            }
            $this->response(array('status' => 200, 'message' => 'Show all Sub Service', 'data' => $all));
        } else {
            $this->response(array('status' => 400, 'message' => 'Something went wrong. Please try again', 'data' => null));
        }
    }

    public function getFormField_GET()
    {
        $get = $this->CommonModel->getAllRows('form_field_type');
        $all_data = [];
        if ($get) {
            foreach ($get as $label_list) {
                $all_label = [];
                $getLabel = $this->CommonModel->getRowByMoreId('form_field', "field_type_id = '{$label_list['id']}'");
                if ($getLabel) {
                    $all_label[] = $getLabel;
                }
                $all_data[] = [
                    'label_name' => $label_list['name'],
                    'all_label' => $all_label
                ];
            }
            $this->response(array('status' => 200, 'message' => 'Show all Data', 'data' => $all_data));
        } else {
            $this->response(array('status' => 400, 'message' => 'No Data Found', 'data' => null));
        }
    }

    public function hospitalServiceApi_GET()
    {
        $get = $this->CommonModel->getRowByIdInOrder('hospital_service', "is_delete = '1'", 'service_name', 'ASC');
        if ($get) {
            foreach ($get as $list) {
                $all[] = array(
                    'id' => $list['id'],
                    'service_name' => $list['service_name'],
                    'image' => $list['image'] == "" ? null : SERVICE_IMAGE . $list['image'],
                );
            }
            $this->response(array('status' => 200, 'message' => 'Show all Service', 'data' => $all));
        } else {
            $this->response(array('status' => 400, 'message' => 'No Data Found', 'data' => null));
        }
    }

    public function hospitalSubServiceApi_GET($service_id)
    {
        $get = $this->CommonModel->getRowByIdInOrder('hospital_sub_service', "service_id = '$service_id'", 'sub_service_name', 'ASC');
        if ($get) {
            foreach ($get as $cityList) {
                $all[] = array(
                    'id' => $cityList['id'],
                    'sub_service_name' => $cityList['sub_service_name'],
                    'service_id' => $cityList['service_id'],
                    'price' => $cityList['price'],
                    'description' => $cityList['description'],
                );
            }
            $this->response(array('status' => 200, 'message' => 'Show all Sub Service', 'data' => $all));
        } else {
            $this->response(array('status' => 400, 'message' => 'Something went wrong. Please try again', 'data' => null));
        }
    }

    public function categoryApi_GET()
    {
        $get = $this->CommonModel->getRowByIdInOrder('category', "is_delete = '1'", 'category_name', 'ASC');
        if ($get) {
            foreach ($get as $list) {
                $all[] = array(
                    'id' => $list['id'],
                    'category_name' => $list['category_name'],
                    'image' => $list['image'] == "" ? null : PRODUCT_IMAGE . $list['image'],
                );
            }
            $this->response(array('status' => 200, 'message' => 'Show all Category', 'data' => $all));
        } else {
            $this->response(array('status' => 400, 'message' => 'No Data Found', 'data' => null));
        }
    }

    public function productApi_GET($category_id)
    {
        $get = $this->CommonModel->getRowByIdInOrder('rental_product', "category_id = '$category_id'", 'product_name', 'ASC');
        if ($get) {
            foreach ($get as $cityList) {
                $all[] = array(
                    'id' => $cityList['id'],
                    'product_name' => $cityList['product_name'],
                    'category_id' => $cityList['category_id'],
                    'price' => $cityList['price'],
                    'description' => $cityList['description'],
                    'image' => $cityList['image'] == "" ? null : PRODUCT_IMAGE . $cityList['image'],
                );
            }
            $this->response(array('status' => 200, 'message' => 'Show all Sub Service', 'data' => $all));
        } else {
            $this->response(array('status' => 400, 'message' => 'Something went wrong. Please try again', 'data' => null));
        }
    }
}
