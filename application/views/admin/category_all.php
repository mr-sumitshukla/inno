<?php $this->load->view('admin/template/header', $title); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h2 class="mb-sm-0 "><?= $title ?></h2>
                        <a href="<?= base_url("categoryAdd"); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add</a>
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
                                        <th>Sr no.</th>
                                        <th>Category Name</th>
                                        <th>Image</th>

                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($all_data) {
                                        $i = 0;
                                        foreach ($all_data as $all) {
                                            $id = encryptId($all['id']);

                                    ?>
                                            <tr>
                                                <td><?= ++$i; ?></td>
                                                <td><?= $all['category_name'] ?></td>
                                                <td>
                                                    <a href="<?= base_url("upload/product/") . $all['image']; ?>">
                                                        <img src="<?= base_url("upload/product/") . $all['image']; ?>" style="width: 60px; height: 50px">
                                                    </a>
                                                </td>

                                                <td>
                                                    <a href="<?= base_url("categoryAdd?id=$id"); ?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                                    <a onclick="return confirm('Are you want to sure ?')" href="<?= base_url("categoryAdd?dID=$id"); ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
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