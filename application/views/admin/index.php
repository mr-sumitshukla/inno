<?php $this->load->view('admin/template/header', $title); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-cl-12">
                    <div class="row">
                        <h4>Users</h4>
                        <div class="col-md-3">
                            <a href="<?= base_url('activeUser') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Active User</p>
                                                <h4 class="mb-0"><?= $active_user ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('inactiveUser') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Inactive User</p>
                                                <h4 class="mb-0"><?= $inactive_user ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Partner</h4>
                        <div class="col-md-3">
                            <a href="<?= base_url('activePartner') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Active Partner</p>
                                                <h4 class="mb-0"><?= $active_partner ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('inactivePartner') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Inactive Partner</p>
                                                <h4 class="mb-0"><?= $inactive_partner ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('verifyPartner') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">New Verify Partner</p>
                                                <h4 class="mb-0"><?= $verify_partner ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('verifyCancelPartner') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Verification Cancel Partner</p>
                                                <h4 class="mb-0"><?= $verify_cancel_partner ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('interViewRequest') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Partner Interview Request</p>
                                                <h4 class="mb-0"><?= $partner_interview_new ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('allInterViewRequest') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Partner Interview Reject</p>
                                                <h4 class="mb-0"><?= $partner_interview_reject ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Service</h4>
                        <div class="col-md-3">
                            <a href="<?= base_url('serviceAll') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Total Service</p>
                                                <h4 class="mb-0"><?= $service ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('subServiceAll') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Total Sub Service</p>
                                                <h4 class="mb-0"><?= $sub_service ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Booking - Elder Care at Home </h4>
                        <div class="col-md-3">
                            <a href="<?= base_url('newPartnerBooking') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">New Booking</p>
                                                <h4 class="mb-0"><?= $new_elder_care ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('assignPartner') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Assign Booking</p>
                                                <h4 class="mb-0"><?= $elder_care_assign ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('assignPartner') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Complete Booking</p>
                                                <h4 class="mb-0"><?= $elder_care_complete ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Booking - Elder Care at Hospital</h4>
                        <div class="col-md-3">
                            <a href="<?= base_url('newPartnerBookingForHospital') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">New Booking</p>
                                                <h4 class="mb-0"><?= $new_hospital_care ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('assignPartnerForHospital') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Assign Booking</p>
                                                <h4 class="mb-0"><?= $hospital_care_assign ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('assignPartnerForHospital') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Complete Booking</p>
                                                <h4 class="mb-0"><?= $hospital_care_complete ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Booking - Rental Product</h4>
                        <div class="col-md-3">
                            <a href="<?= base_url('newProductBooking') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">New Booking</p>
                                                <h4 class="mb-0"><?= $new_rental_book_product ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('assignProductBooking') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Assign Booking</p>
                                                <h4 class="mb-0"><?= $assign_rental_book_product ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Care Recipient Request</h4>
                        <div class="col-md-3">
                            <a href="<?= base_url('formData') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">New Request</p>
                                                <h4 class="mb-0"><?= $care_recipient_request ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('formData') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">All Request</p>
                                                <h4 class="mb-0"><?= $assign_care_recipient_request ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Video Call Request</h4>
                        <div class="col-md-3">
                            <a href="<?= base_url('videoCallRequest') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">New Request</p>
                                                <h4 class="mb-0"><?= $video_request ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('allVideoCallRequest') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Accept Request</p>
                                                <h4 class="mb-0"><?= $accept_video_request ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('allVideoCallRequest') ?>">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Reject Request</p>
                                                <h4 class="mb-0"><?= $reject_video_request ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/template/footer'); ?>