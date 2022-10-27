<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div id="form_classroom_subject_message" name="form_classroom_subject_message">
                </div>
            <?php
                $this->load->view('admin/main/message');
            ?>            
                <div class="card-content">
                    <div class="card-body">
                        
                        <form class="form" data-parsley-validate action="<?php echo $template['form']['action'];?>" method="post" id="frm_classroom_subject" name="frm_classroom_subject">
        
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory <?php echo  form_error('classroom') ?'is-invalid' : '' ?>">
                                        <label for="classroom" class="form-label">Classroom</label>
                                        <!-- <div class="input-group mb-3"> -->
                                            <select class="form-control classroom-select" name="classroom-select" id="classroom-select" data-noresults-text="Nothing to see here." placeholder="Select classroom" autocomplete="off" ></select> 
                                            <input type="hidden" class="form-control" placeholder="Teacher" name="classroom" id="classroom" value="<?php echo $method == 'post' ? set_value('classroom') : $data['classroom_subject']->classroom_id;?>" data-form= "<?php echo $method == 'post' ? set_value('classroom-select_text') : $data['classroom_subject']->classroom_name;?>" data-form-autocomplete-url="<?php echo site_url('classroom/json_search')?>" required>
                                            <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                            <button class="btn btn-primary" type="button" id="button-addon1">Add New</button> -->
                                        
                                        <!-- </div> -->
                                        <?php 
                                            echo form_error('classroom');
                                        ?>   
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory <?php echo  form_error('school_year') ?'is-invalid' : '' ?>">
                                    
                                        <label for="school_year" class="form-label">School Year</label>
                                        <!-- <div class="input-group mb-3"> -->
                                            <select class="form-control school_year-select" name="school_year-select" id="school_year-select" data-noresults-text="Nothing to see here." placeholder="Select school year" autocomplete="off" data-parsley-required="true" ></select> 
                                            <input type="hidden" class="form-control" placeholder="School Year" name="school_year" id="school_year" value="<?php echo $method == 'post' ? set_value('school_year') : $data['classroom_subject']->school_year_id;?>" data-form= "<?php echo $method == 'post' ? set_value('school_year-select_text') : $data['classroom_subject']->school_year;?>" data-form-autocomplete-url="<?php echo site_url('school_year/json_search')?>" required >
                                            <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                            <button class="btn btn-primary" type="button" id="button-addon1">Add New</button> -->
                                        <!-- </div> -->
                                        <?php 
                                            echo form_error('school_year');
                                        ?>   
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory <?php echo  form_error('semester') ?'is-invalid' : '' ?>">
                                        <label for="semester" class="form-label">Semester</label>
                                        <input type="text" class="form-control" placeholder="Semester" data-parsley-required="true" name="semester" id="semester" value="<?php echo $method == 'post' ? set_value('semester') : $data['classroom_subject']->semester;?>" required>
                                    <?php 
                                        echo form_error('semester');
                                    ?>  
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory <?php echo  form_error('subject_teacher') ?'is-invalid' : '' ?>">
                                    
                                        <label for="subject_teacher" class="form-label">Subject</label>
                                        <!-- <div class="input-group mb-3"> -->
                                            <select class="form-control subject_teacher-select" name="subject_teacher-select" id="subject_teacher-select" data-noresults-text="Nothing to see here." placeholder="Select subject" autocomplete="off" ></select> 
                                            <input type="hidden" class="form-control" placeholder="Subject" name="subject_teacher" id="subject_teacher" value="<?php echo $method == 'post' ? set_value('subject_teacher') : $data['classroom_subject']->subject_teacher_id;?>" data-form= "<?php echo $method == 'post' ? set_value('subject_teacher-select_text') : $data['classroom_subject']->subject_teacher_name;?>" data-form-autocomplete-url="<?php echo site_url('subject_teacher/json_search')?>" required >
                                            <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                            <button class="btn btn-primary" type="button" id="button-addon1">Add New</button> -->
                                        <!-- </div> -->
                                        <?php 
                                            echo form_error('subject_teacher');
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
                                                <option value='<?php echo $key_dropdown_active_status;?>' <?php echo $method == 'post' ? set_select('is_active', $key_dropdown_active_status) : ($data['classroom_subject']->is_active == $key_dropdown_active_status ? 'selected' : ''); ?>>
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

 