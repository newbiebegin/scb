<div id="app">
    <!-- start of sidebar-->
    <?php
        $this->load->view('admin/app/sidebar');
    ?>
    <!-- end of sidebar-->
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
    
        <div class="page-heading">
        <?php
            $this->load->view('admin/app/content_header');
            
            $this->load->view($template['content']);
        ?>
        </div>      
        <?php
            $this->load->view('admin/app/footer');
        ?>
    </div>
</div>