<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SCB - <?php echo $template['title'];?></title>
<!--start of datepicker-->
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> -->
<!-- <link id="bsdp-css" href="<?//= base_url('public/assets/extensions/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet"> -->

<!--end of datepicker-->

<link rel="stylesheet" href="<?= base_url('public/assets/css/main/app.css')?>">
<?php 
    if(array_key_exists('css', $template) && !empty($template['css'])):

        foreach ($template['css'] as $css):
         
?>
<link rel="stylesheet" href="<?= base_url('public/assets/'.$css)?>">
<?php
            
        endforeach;
    else:
?>
<link rel="stylesheet" href="<?= base_url('public/assets/css/main/app-dark.css')?>">
<?php
    endif;
?>
<link rel="shortcut icon" href="<?= base_url('public/assets/images/logo/favicon.svg')?>" type="image/x-icon">
<link rel="shortcut icon" href="<?= base_url('public/assets/images/logo/favicon.png')?>" type="image/png">

<link rel="stylesheet" href="<?= base_url('public/assets/css/shared/iconly.css')?>">

<!-- start of datatables -->
<link rel="stylesheet" href="<?= base_url('public/assets/css/pages/fontawesome.css')?>">
<!-- <link rel="stylesheet" href="<? //= base_url('public/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css')?>"> -->
<!-- <link rel="stylesheet" href="<?//= base_url('public/assets/css/pages/datatables.css')?>"> -->
<!-- end of datatables -->

<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

<!-- <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> -->
		

<!-- <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" /> -->

<!-- <link href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css" rel="stylesheet" type="text/css" /> -->
