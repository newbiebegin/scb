<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div id="form_student_classroom_message" name="form_student_classroom_message">
                </div>
            <?php
                $this->load->view('admin/main/message');
            ?>            
                <div class="card-content">
                    <div class="card-body">
                        
                        <form class="form" data-parsley-validate action="<?php echo $template['form']['action'];?>" method="post" id="frm_student_classroom" name="frm_student_classroom">
        
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory <?php echo  form_error('classroom') ?'is-invalid' : '' ?>">
                                        <label for="classroom" class="form-label">Classroom</label>
                                        <!-- <div class="input-group mb-3"> -->
                                            <select class="form-control classroom-select" name="classroom-select" id="classroom-select" data-noresults-text="Nothing to see here." placeholder="Select classroom" autocomplete="off" data-parsley-required="true"></select> 
                                            <input type="hidden" class="form-control" placeholder="Classroom" name="classroom" id="classroom" value="<?php echo $method == 'post' ? set_value('classroom') : $data['student_classroom']->classroom_id;?>" data-form= "<?php echo $method == 'post' ? set_value('classroom-select_text') : $data['student_classroom']->classroom_name;?>" data-form-autocomplete-url="<?php echo site_url('classroom/json_search')?>" required>
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
                                            <input type="hidden" class="form-control" placeholder="School Year" name="school_year" id="school_year" value="<?php echo $method == 'post' ? set_value('school_year') : $data['student_classroom']->school_year_id;?>" data-form= "<?php echo $method == 'post' ? set_value('school_year-select_text') : $data['student_classroom']->school_year;?>" data-form-autocomplete-url="<?php echo site_url('school_year/json_search')?>" required >
                                            <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                            <button class="btn btn-primary" type="button" id="button-addon1">Add New</button> -->
                                        <!-- </div> -->
                                        <?php 
                                            echo form_error('form_modal_school_year');
                                        ?>   
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory <?php echo  form_error('student') ?'is-invalid' : '' ?>">
                                        <label for="student" class="form-label">Student</label>
                                        <!-- <div class="input-group mb-3"> -->
                                            <select class="form-control " name="student-select" id="student-select" data-noresults-text="Nothing to see here."                                         placeholder="Select student" autocomplete="off" ></select> 

                                            <input type="hidden" class="form-control" placeholder="Student" data-parsley-required="true" name="student" id="student" value="<?php echo $method == 'post' ? set_value('student') : $data['student_classroom']->student_id;?>" data-form="<?php echo $method == 'post' ? set_value('student-select_text') : $data['student_classroom']->student_name_nis;?>" data-form-autocomplete-url="<?php echo site_url('student/json_search')?>" required>

                                            <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                            <button class="btn btn-primary" type="button" id="button-addon1">Add New</button>
                                
                                        </div> -->
                                    <?php 
                                        echo form_error('student');
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
                                                <option value='<?php echo $key_dropdown_active_status;?>' <?php echo $method == 'post' ? set_select('is_active', $key_dropdown_active_status) : ($data['student_classroom']->is_active == $key_dropdown_active_status ? 'selected' : ''); ?>>
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

 