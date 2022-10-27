<div class="col-12 col-md-6 order-md-2 order-first">
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url('administrator')?>">Dashboard</a></li>
            <!-- <li class="breadcrumb-item active" aria-current="page">Form Validation</li>
            <li class="breadcrumb-item active" aria-current="page">Parsley</li>  -->
            
<?php
    if($this->uri->segment(1) != 'Administrator' && $this->uri->segment(2) != ''):

        foreach ($this->uri->segments as $segment):
            
            $url = substr($this->uri->uri_string, 0, strpos($this->uri->uri_string, $segment)) . $segment;

            $is_active =  $url == $this->uri->uri_string;

            if($is_active):
?>
            <li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst($segment);?></li>
<?php
            else:
?>
            <li class="breadcrumb-item"><a href="<?php echo site_url($url);?>"><?php echo ucfirst($segment);?></a></li>
<?php
            endif;
        endforeach;
    endif;
?>
        </ol>
    </nav>
</div>
