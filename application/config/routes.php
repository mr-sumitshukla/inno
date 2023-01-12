<?php
defined('BASEPATH') or exit('No direct script access allowed');


$route['default_controller'] = 'admin/AdminAuth/admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/////////////////////     Admin     /////////////////

$route['admin'] = 'admin/AdminAuth/admin';
$route['adminLogout'] = 'admin/AdminAuth/adminLogout';

$route['dashboard'] = 'admin/AdminHome/dashboard';
$route['banner'] = 'admin/AdminHome/banner';
$route['changePassword'] = 'admin/AdminHome/changePassword';

//  => Add on Data

$route['serviceAll'] = 'admin/AdminHome/serviceAll';
$route['serviceAdd'] = 'admin/AdminHome/serviceAdd';
$route['subServiceAll'] = 'admin/AdminHome/subServiceAll';
$route['subServiceAdd'] = 'admin/AdminHome/subServiceAdd';

$route['formFieldTypeAll'] = 'admin/AdminHome/formFieldTypeAll';
$route['formFieldTypeAdd'] = 'admin/AdminHome/formFieldTypeAdd';
$route['formFieldAll'] = 'admin/AdminHome/formFieldAll';
$route['formFieldAdd'] = 'admin/AdminHome/formFieldAdd';

$route['serviceHospitalAll'] = 'admin/AdminHome/serviceHospitalAll';
$route['serviceHospitalAdd'] = 'admin/AdminHome/serviceHospitalAdd';
$route['subServiceHospitalAll'] = 'admin/AdminHome/subServiceHospitalAll';
$route['subServiceHospitalAdd'] = 'admin/AdminHome/subServiceHospitalAdd';

$route['categoryAll'] = 'admin/AdminHome/categoryAll';
$route['categoryAdd'] = 'admin/AdminHome/categoryAdd';
$route['productAll'] = 'admin/AdminHome/productAll';
$route['productAdd'] = 'admin/AdminHome/productAdd';

//  =>  User

$route['activeUser'] = 'admin/Users/activeUser';
$route['inactiveUser'] = 'admin/Users/inactiveUser';
$route['userStatus/(:any)/(:any)'] = 'admin/Users/userStatus/$1/$2';
$route['userDetails/(:any)'] = 'admin/Users/userDetails/$1';

//  =>  Partner

$route['activePartner'] = 'admin/Users/activePartner';
$route['inactivePartner'] = 'admin/Users/inactivePartner';
$route['interViewRequest'] = "admin/Users/interViewRequest";
$route['allInterViewRequest'] = "admin/Users/allInterViewRequest";
$route['verifyPartner'] = 'admin/Users/verifyPartner';
$route['verifyCancelPartner'] = 'admin/Users/verifyCancelPartner';
$route['partnerStatus/(:any)/(:any)'] = 'admin/Users/partnerStatus/$1/$2';
$route['partnerVerifyStatus'] = 'admin/Users/partnerVerifyStatus';
$route['partnerDetails/(:any)'] = 'admin/Users/partnerDetails/$1';
$route['partnerPayOut'] = 'admin/Users/partnerPayOut';
$route['partnerPayoutDetails'] = 'admin/Users/partnerPayoutDetails';
$route['payOutHistory'] = 'admin/Users/payOutHistory';

$route['partnerTraining'] = 'admin/Users/partnerTraining';
$route['partnerTrainingSend'] = 'admin/Users/partnerTrainingSend';

// Booking

$route['newPartnerBooking'] = "admin/Bookings/newPartnerBooking";
$route['getPartnerForAssign'] = "admin/Bookings/getPartnerForAssign";
$route['assignPartner'] = "admin/Bookings/assignPartner";

$route['newPartnerBookingForHospital'] = "admin/Bookings/newPartnerBookingForHospital";
$route['assignPartnerForHospital'] = "admin/Bookings/assignPartnerForHospital";
$route['addTask'] = "admin/Bookings/addTask";

$route['newProductBooking'] = "admin/Bookings/newProductBooking";
$route['getStoreForAssign'] = "admin/Bookings/getStoreForAssign";
$route['assignProductBooking'] = "admin/Bookings/assignProductBooking";

// Form 

$route['formData'] = "admin/AdminHome/formData";

// Video Call Request 

$route['videoCallRequest'] = "admin/Bookings/videoCallRequest";
$route['allVideoCallRequest'] = "admin/Bookings/allVideoCallRequest";


// Store 

$route['storeAll'] = "admin/Users/storeAll";
$route['storeAdd'] = "admin/Users/storeAdd";

// Chat Bot

$route['viewTree'] = "admin/AdminHome/viewTree";
$route['addTree'] = "admin/AdminHome/addTree";
$route['charBotQuery'] = "admin/AdminHome/charBotQuery";

/////////////////////  Partner API    ///////////////////////

$route['api/stateApi'] = 'api/CommonApi/stateApi';
$route['api/cityApi/(:any)'] = 'api/CommonApi/cityApi/$1';
$route['api/serviceApi'] = 'api/CommonApi/serviceApi';
$route['api/subServiceApi/(:any)'] = 'api/CommonApi/subServiceApi/$1';
$route['api/getFormField'] = 'api/CommonApi/getFormField';
$route['api/hospitalServiceApi'] = 'api/CommonApi/hospitalServiceApi';
$route['api/hospitalSubServiceApi/(:any)'] = 'api/CommonApi/hospitalSubServiceApi/$1';
$route['api/categoryApi'] = 'api/CommonApi/categoryApi';
$route['api/productApi/(:any)'] = 'api/CommonApi/productApi/$1';


$route['api/partnerCheck'] = 'api/PartnerApi/partnerCheck';
$route['api/partnerRegistration'] = 'api/PartnerApi/partnerRegistration';
$route['api/partnerProfile'] = 'api/PartnerApi/partnerProfile';

$route['api/sendOTPForLogin'] = 'api/PartnerApi/sendOTPForLogin';
$route['api/partnerLogin'] = 'api/PartnerApi/partnerLogin';

$route['api/partnerDashboard'] = 'api/PartnerApi/partnerDashboard';
$route['api/getTraining'] = 'api/PartnerApi/getTraining';
$route['api/getBookPartner/(:any)'] = 'api/PartnerApi/getBookPartner/$1';
$route['api/getHospitalBookPartner/(:any)'] = 'api/PartnerApi/getHospitalBookPartner/$1';
$route['api/partnerWorkCheckIn'] = 'api/PartnerApi/partnerWorkCheckIn';
$route['api/partnerWorkComplete'] = 'api/PartnerApi/partnerWorkComplete';
$route['api/gymTransaction'] = 'api/PartnerApi/gymTransaction';
$route['api/getTaskPartner/(:any)'] = 'api/PartnerApi/getTaskPartner/$1';
$route['api/taskStatus'] = 'api/PartnerApi/taskStatus';

$route['api/interViewRequest'] = 'api/PartnerApi/interViewRequest';


/////////////////////  User API    ///////////////////////

$route['api/userCheck'] = 'api/UserApi/userCheck';
$route['api/userRegistration'] = 'api/UserApi/userRegistration';
$route['api/userProfile'] = 'api/UserApi/userProfile';

$route['api/sendOTPForLoginUser'] = 'api/UserApi/sendOTPForLoginUser';
$route['api/userLogin'] = 'api/UserApi/userLogin';

$route['api/userDashboard'] = 'api/UserApi/userDashboard';

$route['api/bookPartner'] = 'api/UserApi/bookPartner';
$route['api/bookPartnerPaymentConfirm'] = 'api/UserApi/bookPartnerPaymentConfirm';
$route['api/bookPartnerHospital'] = 'api/UserApi/bookPartnerHospital';
$route['api/getTaskUser/(:any)'] = 'api/UserApi/getTaskUser/$1';

$route['api/formSave'] = 'api/UserApi/formSave';

$route['api/requestVideoCall'] = 'api/UserApi/requestVideoCall';

$route['api/bookRentalProduct'] = 'api/UserApi/bookRentalProduct';
$route['api/rentalProductPaymentConfirm'] = 'api/UserApi/rentalProductPaymentConfirm';

$route['api/chatBotList'] = 'api/UserApi/chatBotList';
$route['api/chatBotQuery'] = 'api/UserApi/chatBotQuery';

$route['api/feedbackForm'] = 'api/UserApi/feedbackForm';
