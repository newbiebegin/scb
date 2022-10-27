<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div id="form_subject_teacher_message" name="form_subject_teacher_message">
                </div>
            <?php
                $this->load->view('admin/main/message');
            ?>            
                <div class="card-content">
                    <div class="card-body">
                        
                        <form class="form" data-parsley-validate action="<?php echo $template['form']['action'];?>" method="post" id="frm_subject_teacher" name="frm_subject_teacher">
        
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory <?php echo  form_error('teacher') ?'is-invalid' : '' ?>">
                                        <label for="teacher" class="form-label">Teacher</label>
                                        <!-- <div class="input-group mb-3"> -->
                                            <select class="form-control teacher-select" name="teacher-select" id="teacher-select" data-noresults-text="Nothing to see here." placeholder="Select teacher" autocomplete="off" ></select> 
                                            <input type="hidden" class="form-control" placeholder="Teacher" name="teacher" id="teacher" value="<?php echo $method == 'post' ? set_value('teacher') : $data['subject_teacher']->teacher_id;?>" data-form= "<?php echo $method == 'post' ? set_value('teacher-select_text') : $data['subject_teacher']->teacher_name_nip;?>" data-form-autocomplete-url="<?php echo site_url('teacher/json_search')?>" required>
                                            <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                            <button class="btn btn-primary" type="button" id="button-addon1">Add New</button> -->
                                        
                                        <!-- </div> -->
                                        <?php 
                                            echo form_error('teacher');
                                        ?>   
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory <?php echo  form_error('subject') ?'is-invalid' : '' ?>">
                                    
                                        <label for="subject" class="form-label">Subject</label>
                                        <!-- <div class="input-group mb-3"> -->
                                            <select class="form-control subject-select" name="subject-select" id="subject-select" data-noresults-text="Nothing to see here." placeholder="Select subject" autocomplete="off" ></select> 
                                            <input type="hidden" class="form-control" placeholder="Subject" name="subject" id="subject" value="<?php echo $method == 'post' ? set_value('subject') : $data['subject_teacher']->subject_id;?>" data-form= "<?php echo $method == 'post' ? set_value('subject-select_text') : $data['subject_teacher']->subject_name;?>" data-form-autocomplete-url="<?php echo site_url('subject/json_search')?>" required >
                                            <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                            <button class="btn btn-primary" type="button" id="button-addon1">Add New</button> -->
                                        <!-- </div> -->
                                        <?php 
                                            echo form_error('subject');
                                        ?>   
                                    </div>
                                </div>
                               
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory <?php echo  form_error('is_active') ?'is-invalid' : '' ?>">
                                        <label for="is_active" class="form-label">Active Status</label>
                                    
                                        <select class="form-select" id="is_active"  name="is_active"placeholder="Active Status" data-parsley-required="true"  >
                                        <?php
                                            foreach($template['form']['dropdown_active_status'] as $key_dropdown_active_status => $val_dropdown_active_status ):
                                        ?>
                                                <option value='<?php echo $key_dropdown_active_status;?>' <?php echo $method == 'post' ? set_select('is_active', $key_dropdown_active_status) : ($data['subject_teacher']->is_active == $key_dropdown_active_status ? 'selected' : ''); ?>>
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
                                    <button type="submit" class="btn btn-primary me-1 mb-1" id="btn_save_add_new_detail">Save</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </form> 
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // Basic multiple Column Form section end -->

 