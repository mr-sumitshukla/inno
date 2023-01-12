<script src="<?= base_url() ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/node-waves/waves.min.js"></script>

<script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="<?= base_url() ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js"></script>
<script src="<?= base_url() ?>/assets/js/pages/datatables.init.js"></script>
<script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/spectrum-colorpicker2/spectrum.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>

<script src="<?= base_url() ?>/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/%40chenfengyuan/datepicker/datepicker.min.js"></script>

<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<script src="<?= base_url() ?>/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/%40chenfengyuan/datepicker/datepicker.min.js"></script>

<script src="<?= base_url() ?>/assets/js/pages/form-advanced.init.js"></script>
<script src="<?= base_url() ?>/assets/js/app.js"></script>

<script src="<?= base_url() ?>/assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

<script src="<?= base_url() ?>/assets/js/pages/form-repeater.int.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        $('#snackbar').addClass('show');
        setTimeout(function() {
            $('#snackbar').removeClass('show');
        }, 3000);

        $('#datatable2').DataTable({
            "scrollX": true,
            // dom: 'Bfrtip',
            // buttons: [
            //     'excelHtml5',
            // ]
        });

        $("form[name='form_submit']").validate({
            errorClass: "error fail-alert",
            validClass: "valid success-alert",

            submitHandler: function(form) {
                $("#save").text("").html("Loading.. <i class='fa fa-spin fa-spinner'></i>").attr('disabled', true);
                form.submit();
            }
        });
    });
</script>