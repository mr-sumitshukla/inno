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
                <div class="col-8 offset-2">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data" name="form_submit">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <label for="example-text-input" class="col-md-3 col-form-label">Sub Service Name</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="sub_service_name" required value="<?= $sub_service_name ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Service</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" name="service_id" required>
                                                    <option value="">Select Service</option>
                                                    <?php
                                                    $c = getRowsByMoreIdWithOrder('hospital_service', "is_delete = '1'", "service_name", 'ASC');
                                                    foreach ($c as $cate) {
                                                    ?>
                                                        <option value="<?= $cate['id'] ?>" <?php if ($service_id == $cate['id']) {
                                                                                                echo 'selected';
                                                                                            } ?>><?= ucwords($cate['service_name']) ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <label for="example-text-input" class="col-md-3 col-form-label">Service Price</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="price" required value="<?= $price ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <label for="example-text-input" class="col-md-3 col-form-label">Service Description</label>
                                            <div class="col-md-9">
                                                <textarea name="description" class="form-control" rows="5"><?= $description ?></textarea>
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

</script>