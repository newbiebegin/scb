<div id="auth">
        
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                 <?php
                 /*   <a href="index.html"><img src="<?= base_url('public/assets/images/logo/logo.svg')?>" alt="Logo"></a> */
                 ?>
                </div>
                <h1 class="auth-title"><?php echo $template['title'];?></h1>
                <?php
                    // start of content 
                    $this->load->view('admin/main/message');
                    // end of content
                    
                    // start of content
                    $this->load->view($template['content']);
                    // end of content
                ?>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
    
            </div>
        </div>
    </div>
        
</div>