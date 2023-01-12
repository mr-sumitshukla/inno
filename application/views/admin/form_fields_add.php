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
                                            <label for="example-text-input" class="col-md-3 col-form-label">Name</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="name" required value="<?= $name ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Form Field Type</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" name="field_type_id" required>
                                                    <option value="">Select Service</option>
                                                    <?php
                                                    $c = getRowsByMoreIdWithOrder('form_field_type', "id != '0'", "name", 'ASC');
                                                    foreach ($c as $cate) {
                                                    ?>
                                                        <option value="<?= $cate['id'] ?>" <?php if ($field_type_id == $cate['id']) {
                                                                                                echo 'selected';
                                                                                            } ?>><?= ucwords($cate['name']) ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
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