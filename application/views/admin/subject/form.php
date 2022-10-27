<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                
            <?php
                $this->load->view('admin/main/message');
            ?>            
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" data-parsley-validate action="<?php echo $template['form']['action'];?>" method="post" id="frm_subject" name="frm_subject">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory <?php echo  form_error('name') ?'is-invalid' : '' ?>">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" placeholder="Name" data-parsley-required="true" name="name" id="name" value="<?php echo $method == 'post' ? set_value('name') : $data['subject']->name;?>" required>
                                    <?php 
                                        echo form_error('name');
                                    ?>  
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory <?php echo  form_error('is_active') ?'is-invalid' : '' ?>">
                                        <label for="is_active" class="form-label">Active Status</label>
                                       
                                        <select class="form-select" id="is_active"  name="is_active"placeholder="Active Status" data-parsley-required="true"  >
                                        <?php
                                        // var_dump($template['form']['dropdown_active_status']);
                                        // exit();
                                             foreach($template['form']['dropdown_active_status'] as $key_dropdown_active_status => $val_dropdown_active_status ):
                                        ?>
                                                <option value='<?php echo $key_dropdown_active_status;?>' <?php echo $method == 'post' ? set_select('is_active', $key_dropdown_active_status) : ($data['subject']->is_active == $key_dropdown_active_status ? 'selected' : ''); ?>>
                                                <?php
                                                    echo $val_dropdown_active_status;
                                                ?>
                                                </option>
                                                
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                    <?php 
                                        echo form_error('is_active');
                                    ?> 
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // Basic multiple Column Form section end -->

 