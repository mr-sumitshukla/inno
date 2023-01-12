<?php $this->load->view('admin/template/header', $title); ?>
<?php $id = $this->input->get('id'); ?>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h2 class="mb-sm-0 "><?= $title ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 offset-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" name="form_submit2" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <label for="example-text-input" class="col-md-3 col-form-label">Old Password</label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control current_password" name="current_password" value="<?= set_value('current_password') ?>">
                                                <span style="color: red" id="current_password"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <label for="example-text-input" class="col-md-3 col-form-label">New Password</label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control new_password" name="new_password" value="<?= set_value('new_password') ?>">
                                                <span style="color: red" id="new_password"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <label for="example-text-input" class="col-md-3 col-form-label">Confirm Password</label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control cnf_password" name="cnf_password" value="<?= set_value('cnf_password') ?>">
                                                <span style="color: red" id="cnf_password"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="text-center">
                                    <button type="submit" id="save" class="btn btn-primary w-md">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/template/footer'); ?>
<script>
    $(document).on('click', '#save', function() {
        let current_password = $('.current_password').val();
        let new_password = $('.new_password').val();
        let cnf_password = $('.cnf_password').val();

        if (current_password.trim() === "" || new_password.trim() === "" || cnf_password === "") {
            current_password.trim() === "" ? $('#current_password').text('Enter Current Password') : $('#current_password').text('');
            new_password.trim() === "" ? $('#new_password').text('Enter New Password') : $('#new_password').text('');
            cnf_password.trim() === "" ? $('#cnf_password').text('Enter Confirm Password') : $('#cnf_password').text('');
            return false;
        } else if (new_password.trim() !== cnf_password.trim()) {
            $('#cnf_password').text('Password Does Not Match');
            return false;
        } else {
            $("#save").text("").html("Loading.. <i class='fa fa-spin fa-spinner'></i>").attr('disabled', true);
            $("form[name='form_submit2']").submit();
        }
    });
</script>