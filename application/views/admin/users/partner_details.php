<?php $this->load->view('admin/template/header', $title); ?>
<style>
    .details label {
        font-size: 16px;
    }

    .details span {
        font-size: 16px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center">
                        <h2 class="mb-sm-0 "><?= $title ?></h2>
                        <?php
                        if ($all_data['verify_status'] != '1' && $all_data['interview_status'] == '4') {
                        ?>
                            <button type="button" class="btn btn-primary waves-effect waves-light" style="margin-left: 20px; margin-right: 20px;" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable">Verify</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" style="margin-right: 20px;" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable1">Cancel</button>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 details">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Name : </label>
                                            <span><?= ucwords($all_data['name']) ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Email Id : </label>
                                            <span><?= $all_data['email_id'] ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Contact Number : </label>
                                            <span><?= $all_data['email_id'] ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Profile Image : </label>
                                            <?php
                                            if ($all_data['profile_image'] != "") {
                                            ?>
                                                <img src="<?= base_url() . PARTNER_IMAGE . $all_data['profile_image'] ?>" style="width: 200px; height: 200px;">
                                            <?php
                                            } else {
                                                echo "----";
                                            }
                                            ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Service : </label>
                                            <?php
                                            $getService = getSingleRowById('service', "id = '{$all_data['service_id']}'");
                                            ?>
                                            <span><?= $getService['service_name'] ?></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-2">
                                        <div class="col-lg-12">
                                            <label>Address : </label>
                                            <span><?= $all_data['address'] ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Area : </label>
                                            <span><?= $all_data['area'] ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Postal Code : </label>
                                            <span><?= $all_data['postal_code'] ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>State : </label>
                                            <span><?= $all_data['state'] ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>City : </label>
                                            <span><?= $all_data['city'] ?></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label>Document Type : </label>
                                            <span><?= $all_data['document_type'] ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Document No : </label>
                                            <span><?= $all_data['document_no'] ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Document Type : </label>
                                            <?php
                                            if ($all_data['document_image'] != "") {
                                            ?>
                                                <img src="<?= base_url() . PARTNER_IMAGE . $all_data['document_image'] ?>" style="width: 200px; height: 200px;">
                                            <?php
                                            } else {
                                                echo "----";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label>Police Verify Document : </label>
                                            <?php
                                            if ($all_data['police_verify_document'] != "") {
                                            ?>
                                                <img src="<?= base_url() . PARTNER_IMAGE . $all_data['police_verify_document'] ?>" style="width: 200px; height: 200px;">
                                            <?php
                                            } else {
                                                echo "Not Upload";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <label>Account Holder Name : </label>
                                            <span><?= $all_data['account_holder_name'] ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Account Number : </label>
                                            <span><?= $all_data['account_number'] ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>IFSC Code : </label>
                                            <span><?= $all_data['ifsc_code'] ?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Bank Name : </label>
                                            <span><?= $all_data['bank_name'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= base_url('partnerVerifyStatus') ?>" name="form_submit3">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Verify Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Payout</label>
                                <input type="hidden" name="verify_status" value="1">
                                <input type="hidden" name="id" value="<?= encryptId($all_data['id']) ?>">
                                <input type="number" class="form-control" required name="pay_out" placeholder="Pay Out">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalScrollable1" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= base_url('partnerVerifyStatus') ?>" name="form_submit2">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle1">Verification Cancel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3" id="datepicker1">
                                <label>Message</label>
                                <textarea name="cancel_message" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="verify_status" value="2">
                        <input type="hidden" name="id" value="<?= encryptId($all_data['id']) ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('admin/template/footer'); ?>

<script>
    $("form[name='form_submit3']").validate({
        errorClass: "error fail-alert",
        validClass: "valid success-alert",
        submitHandler: function(form) {
            $(".save").text("").html("Loading.. <i class='fa fa-spin fa-spinner'></i>").attr('disabled', true);
            form.submit();
        }
    });
    $("form[name='form_submit2']").validate({
        errorClass: "error fail-alert",
        validClass: "valid success-alert",
        submitHandler: function(form) {
            $(".save").text("").html("Loading.. <i class='fa fa-spin fa-spinner'></i>").attr('disabled', true);
            form.submit();
        }
    });
</script>