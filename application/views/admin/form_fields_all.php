<?php $this->load->view('admin/template/header', $title); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h2 class="mb-sm-0 "><?= $title ?></h2>
                        <a href="<?= base_url("formFieldAdd"); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable2" class="table table-bordered nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Form Field Type</th>
                                        <th>Field Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($all_data) {
                                        $i = 0;
                                        foreach ($all_data as $item) {
                                            $i = $i + 1;
                                            $id = encryptId($item['id']);
                                            $service = getSingleRowById('form_field_type', "id = '" . $item['field_type_id'] . "'");
                                    ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= ucwords($service['name']) ?></td>
                                                <td><?= ucwords($item['name']) ?> </td>
                                                <td>
                                                    <a href="<?php echo base_url(); ?>formFieldAdd?id=<?php echo $id; ?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                                    <a onclick="return confirm('Are you want to sure ?')" href="<?= base_url("formFieldAdd?dID=$id"); ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/template/footer'); ?>