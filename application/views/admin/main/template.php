<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

    <head>
    <!-- start of head -->
    <?php
        $this->load->view('admin/main/header');
    ?>
    <!-- start of head -->
    </head>

    <body>
        <?php
            $this->load->view($template['main_content']);
        ?>
        <!-- start of js -->
        <?php
            $this->load->view('admin/main/js');
        ?>
        <!-- end of js -->
    </body>

</html>
