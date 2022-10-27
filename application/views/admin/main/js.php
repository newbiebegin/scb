<script src="<?= base_url('public/assets/extensions/jquery/jquery.min.js') ?>"></script> 
<script src="<?= base_url('public/assets/js/bootstrap.js')?>"></script>

<script src="<?= base_url('public/assets/js/app.js')?>"></script>

<!-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script> -->

<!-- <script src="<?//= base_url('public/assets/js/bootstrap.min.js')?>"></script> 
 -->
 <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
<!-- Need: Apexcharts -->
<?php /*
<script src="<?= base_url('public/assets/extensions/apexcharts/apexcharts.min.js')?>"></script>
<script src="<?= base_url('public/assets/js/pages/dashboard.js') ?>"></script>
*/?>
<!--form-->

<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" ></script> -->



<!--start of datepicker-->
<!-- <script src="<?//= base_url('public/assets/extensions/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script> -->

<!--end of datepicker-->
<!--form-->

<!-- start of datatables -->
<!-- <script src="<?//= base_url('public/assets/js/extensions/datatables.min.js') ?>"></script> -->
<!-- <script src="<?//= base_url('public/assets/js/pages/datatables.js') ?>"></script> -->
<!-- end of datatables -->

<!-- start of autocomplete -->
<!-- <script src="<?//= base_url('public/assets/js/pages/bootstrap-autocomplete.js')?>"></script> -->
<!-- end of autocomplete -->

<script src="<?= base_url('public/assets/extensions/parsleyjs/parsley.min.js') ?>"></script>
<script src="<?= base_url('public/assets/js/pages/parsley.js') ?>"></script>
<?php 
    if(array_key_exists('js', $template) && !empty($template['js'])):

        foreach ($template['js'] as $js):
         
?>
            <script src="<?= base_url('public/assets/'.$js) ?>"></script>
<?php
        endforeach;
    endif;
?>

<?php
/*

<script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<!-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->

<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
*/
?>
<!-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> -->
