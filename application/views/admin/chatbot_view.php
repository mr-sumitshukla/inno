<?php $this->load->view('admin/template/header', $title); ?>
<?php
$id = $this->input->get('id');
$level = $this->input->get('level');
$search = $this->input->get('search');
?>
<style>
    .info {
        background-color: #d4d4d4;
        text-align: center;
        padding: 8px;
        border: 1px solid gray;
        border-radius: 50px;
        font-size: 18px;
    }

    .infoSpace {
        font-size: 20px;
        margin-left: 10px;
        margin-right: 10px
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <?php
                        $l = $level - 1;
                        $row = getSingleRowById('chatbot_qa', "tree_id = '" . decryptId($id) . "'");
                        if ($row) {
                            $fId = encryptId($row['id']);
                        ?>
                            <a href="<?= base_url("viewTree?id=$fId&level=$l") ?>" class="btn btn-primary" style="margin-bottom: 10px">
                                <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Go Back
                            </a>
                        <?php
                        }
                        ?>

                        <h2 class="mb-sm-0 "><?= $title ?></h2>
                        <?php
                        if (isset($id)) {
                        ?>
                            <a href="<?= base_url("addTree?id=$id&level=$level") ?>" class="btn btn-primary" style="float: right;margin-bottom: 10px">
                                <i class="fa fa-plus"></i> Add Category
                            </a>
                        <?php
                        } else {
                        ?>
                            <a href="<?= base_url('addTree') ?>" class="btn btn-primary" style="float: right;margin-bottom: 10px">
                                <i class="fa fa-plus"></i> Add Category
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div style="margin-top: 15px; margin-bottom: 15px; white-space: nowrap; overflow-x: scroll; padding-top: 12px;padding-bottom: 12px">
                        <?php
                        if (!empty($viewTree)) {
                            print_r($viewTree);
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="treeTable" class="table table-bordered nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($all_data) {
                                        $i = 0;
                                        foreach ($all_data as $all) {
                                            $flora_tree_id = encryptId($all['tree_id']);
                                            $id = encryptId($all['id']);
                                            $level = $all['level'] + 1;
                                            $currentLevel = $all['level'];
                                            $checkTree = $this->CommonModel->getNumRows('chatbot_qa', "id = '" . $all['tree_id'] . "'");
                                    ?>
                                            <tr>
                                                <td><?= ++$i; ?></td>
                                                <td><?= $all['tree_title'] ?></td>
                                                <td style="white-space:pre-wrap;"><?= $all['description'] ?></td>
                                                <td><?= $all['is_arrange'] ?></td>
                                                <td>
                                                    <?php
                                                    if ($all['is_category'] == '1') {
                                                    ?>
                                                        <a href="<?= base_url("viewTree?id=$flora_tree_id&level=$level"); ?>" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="<?= base_url("floraTreeDetailsAdd?fId=$flora_tree_id&id=$id&level=" . $all['level'] . "&flora_type=1"); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Details</a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <a href="<?= base_url("addTree?id=$id&level=$currentLevel&editId=$flora_tree_id"); ?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                                    <?php
                                                    if ($checkTree < 1) {
                                                    ?>
                                                        <a onclick="return confirm('Are you sure ?')" href="<?= base_url("addTree?id=$id&level=$currentLevel&dId=$flora_tree_id"); ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button disabled class="btn btn-danger"><i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    <?php
                                                    }


                                                    ?>

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

<script>
    $(function() {
        $('#treeTable').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': true
        });
    });


    $(".searchData").keyup(function() {
        let value = $(this).val();
        if (value !== "") {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('searchTreeDetails'); ?>",
                data: 'search=' + $(this).val(),
                success: function(data) {
                    $(".searchResult").show().html(data);
                }
            });
        }
    });

    $('body').click(function() {
        $('.searchResult').hide();
    });
</script>