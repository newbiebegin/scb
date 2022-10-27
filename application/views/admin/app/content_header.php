<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?php echo $template['title'];?></h3>
        <?php 
            if($template['sub_title'] != NULL):
        ?>
            <p class="text-subtitle text-muted"><?php echo $template['sub_title'];?></p>
        <?php
            endif;
        ?>
        </div>
        <!-- start of breadcrumb -->
        <?php
            $this->load->view('admin/app/breadcrumb');
        ?>
        <!-- end of breadcrumb -->
    </div>
</div>