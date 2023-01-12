<?php $this->load->view('admin/template/header', $title); ?>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable2" class="table table-bordered nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Contact Number</th>
                                        <th>Title</th>
                                        <th>Link</th>
                                        <th>Description</th>
                                        <th>Action</th>
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
                                                <td><?= date('d-M-Y h:i A', strtotime($all['date'])) ?></td>
                                                <td><?= ucwords($all['name']) ?></td>
                                                <td><?= $all['contact_no'] ?></td>
                                                <td><?= $all['training_title'] ?></td>
                                                <td><?= $all['link'] ?></td>
                                                <td><?= $all['description'] ?></td>
                                                <td>
                                                    <a class="btn btn-danger" href="<?= base_url("partnerTraining?id=$id") ?>">
                                                        Delete
                                                    </a>
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