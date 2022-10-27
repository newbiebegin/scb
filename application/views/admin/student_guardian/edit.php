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
                        <form class="form" data-parsley-validate action="<?php echo $template['form']['action'];?>" enctype="multipart/form-data" method="post" id="frm_student_guardian" name="frm_student_guardian">
                            <ul class="nav nav-tabs" id="student-guardian-main-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="father-tab" data-bs-toggle="tab" data-bs-target="#father" type="button" role="tab" aria-controls="father" aria-selected="true">Father</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="mother-tab" data-bs-toggle="tab" data-bs-target="#mother" type="button" role="tab" aria-controls="mother" aria-selected="false">Mother</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="student-guardian-tab" data-bs-toggle="tab" data-bs-target="#student-guardian" type="button" role="tab" aria-controls="student-guardian" aria-selected="false">Student Guardian</button>
                                </li>
                            </ul>
                            <div>&nbsp;</div>
                            <div class="tab-content" id="student-guardian-content">
                                <div class="tab-pane fade show active" id="father" role="tabpanel" aria-labelledby="father-tab">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory <?php echo  form_error('father_name') ?'is-invalid' : '' ?>">
                                                <label for="father_name" class="form-label">Father's Name</label>
                                                <input type="text" class="form-control" placeholder="Father's Name" data-parsley-required="true" name="father_name" id="father_name" value="<?php echo $method == 'post' ? set_value('father_name') : $data['student_guardian']->father_name;?>" required>
                                            <?php 
                                                echo form_error('father_name');
                                            ?>  
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory <?php echo  form_error('father_occupation') ?'is-invalid' : '' ?>">
                                                
                                                <label for="father_occupation" class="form-label">Father's Occupation</label>
                                                <div class="input-group mb-3">
                                                    <select class="form-control father_occupation-select" name="father_occupation-select" id="father_occupation-select" data-noresults-text="Nothing to see here."                                         placeholder="Select Father's Occupation" autocomplete="off" ></select> 
                                                    <input type="hidden" class="form-control" placeholder="Father's Occupation" name="father_occupation" id="father_occupation" value="<?php echo $method == 'post' ? set_value('father_occupation') : $data['student_guardian']->father_occupation_id;?>" data-form= "<?php echo $method == 'post' ? set_value('father_occupation-select_text') : $data['student_guardian']->father_occupation_name;?>" data-form-autocomplete-url="<?php echo site_url('occupation/json_search')?>" required >
                                                    <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                                    <button class="btn btn-primary" type="button" id="button-addon1">Add New</button>
                                                </div>
                                                <?php 
                                                    echo form_error('father_occupation');
                                                ?>   
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                        
                                            <div class="form-group mandatory <?php echo  form_error('father_religion') ?'is-invalid' : '' ?>">
                                                <label for="father_religion-select" class="form-label">Father's Religion</label>
                                                
                                                <select class="form-control " name="father_religion-select" id="father_religion-select" data-noresults-text="Nothing to see here." 
                                                placeholder="Select father's religion" autocomplete="off" ></select> 
                                            
                                                <input type="hidden" class="form-control" placeholder="Father's religion" name="father_religion" id="father_religion" value="<?php echo $method == 'post' ? set_value('father_religion'): $data['student_guardian']->father_religion_id;?>" data-parsley-required="true" data-form="<?php echo $method == 'post' ? set_value('father_religion-select_text') : $data['student_guardian']->father_religion_name;?>" data-form-autocomplete-url="<?php echo site_url('religion/json_search')?>" required> 
                                            <?php 
                                                echo form_error('father_religion');
                                            ?> 
                                            </div>
                                        
                                        </div>
                                        <div class="col-md-6 col-12">
                                                <div class="form-group <?php echo  form_error('father_phone_number') ?'is-invalid' : '' ?>">
                                                    <label for="father_phone_number" class="form-label">Father's Phone Number</label>
                                                    <input type="text" class="form-control" placeholder="Father's Phone Number" name="father_phone_number" id="father_phone_number" value="<?php echo $method == 'post' ? set_value('father_phone_number') : $data['student_guardian']->father_phone_number;?>" >
                                                <?php 
                                                    echo form_error('father_phone_number');
                                                ?>    
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mandatory <?php echo  form_error('father_address') ?'is-invalid' : '' ?>">
                                                    <label for="father_address" class="form-label">Father's Address</label>
                                                    <textarea class="form-control" placeholder="Father's Address" data-parsley-required="true" id="father_address" name="father_address" style="height: 92px;" required><?php echo $method == 'post' ? set_value('father_address') : $data['student_guardian']->father_address;?></textarea>
                                                <?php 
                                                    echo form_error('father_address');
                                                ?> 
                                                </div>
                                            </div>
                                            
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="mother" role="tabpanel" aria-labelledby="mother-tab">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory <?php echo  form_error('mother_name') ?'is-invalid' : '' ?>">
                                                <label for="mother_name" class="form-label">Mother's Name</label>
                                                <input type="text" class="form-control" placeholder="Mother's Name" data-parsley-required="true" name="mother_name" id="mother_name" value="<?php echo $method == 'post' ? set_value('mother_name') : $data['student_guardian']->mother_name;?>" required>
                                            <?php 
                                                echo form_error('mother_name');
                                            ?>  
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory <?php echo  form_error('mother_occupation') ?'is-invalid' : '' ?>">
                                                
                                                <label for="mother_occupation" class="form-label">Mother's Occupation</label>
                                                <div class="input-group mb-3">
                                                    <select class="form-control mother_occupation-select" name="mother_occupation-select" id="mother_occupation-select" data-noresults-text="Nothing to see here."                                         placeholder="Select Mother's Occupation" autocomplete="off" ></select> 
                                                    <input type="hidden" class="form-control" placeholder="Mother's Occupation" name="mother_occupation" id="mother_occupation" value="<?php echo $method == 'post' ? set_value('mother_occupation') : $data['student_guardian']->mother_occupation_id;?>" data-form= "<?php echo $method == 'post' ? set_value('mother_occupation-select_text') : $data['student_guardian']->mother_occupation_name;?>" data-form-autocomplete-url="<?php echo site_url('occupation/json_search')?>" required >
                                                    <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                                    <button class="btn btn-primary" type="button" id="button-addon1">Add New</button>
                                                </div>
                                                <?php 
                                                    echo form_error('mother_occupation');
                                                ?>   
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6 col-12">
                                    
                                            <div class="form-group mandatory <?php echo  form_error('mother_religion') ?'is-invalid' : '' ?>">
                                                <label for="mother_religion-select" class="form-label">Mother's Religion</label>
                                                
                                                <select class="form-control " name="mother_religion-select" id="mother_religion-select" data-noresults-text="Nothing to see here." 
                                                placeholder="Select father's religion" autocomplete="off" ></select> 
                                            
                                                <input type="hidden" class="form-control" placeholder="Mother's religion" name="mother_religion" id="mother_religion" value="<?php echo $method == 'post' ? set_value('mother_religion'): $data['student_guardian']->mother_religion_id;?>" data-parsley-required="true" data-form="<?php echo $method == 'post' ? set_value('mother_religion-select_text') : $data['student_guardian']->mother_religion_name;?>" data-form-autocomplete-url="<?php echo site_url('religion/json_search')?>" required> 
                                            <?php 
                                                echo form_error('mother_religion');
                                            ?> 
                                            </div>
                                        
                                        </div>
                                        
                                        <div class="col-md-6 col-12">
                                            <div class="form-group <?php echo  form_error('mother_phone_number') ?'is-invalid' : '' ?>">
                                                <label for="mother_phone_number" class="form-label">Mother's Phone Number</label>
                                                <input type="text" class="form-control" placeholder="Mother's Phone Number" name="mother_phone_number" id="mother_phone_number" value="<?php echo $method == 'post' ? set_value('mother_phone_number') : $data['student_guardian']->mother_phone_number;?>" >
                                            <?php 
                                                echo form_error('mother_phone_number');
                                            ?>    
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory <?php echo  form_error('mother_address') ?'is-invalid' : '' ?>">
                                                <label for="mother_address" class="form-label">Mother's Address</label>
                                                <textarea class="form-control" placeholder="Mother's Address" data-parsley-required="true" id="mother_address" name="mother_address" style="height: 92px;" required><?php echo $method == 'post' ? set_value('mother_address') : $data['student_guardian']->mother_address;?></textarea>
                                            <?php 
                                                echo form_error('mother_address');
                                            ?> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="student-guardian" role="tabpanel" aria-labelledby="student-guardian-tab">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory <?php echo  form_error('code') ?'is-invalid' : '' ?>">
                                                <label for="code" class="form-label">Code</label>
                                                <input type="text" class="form-control" placeholder="Code" data-parsley-required="true" name="code" id="code" value="<?php echo $method == 'post' ? set_value('code') : $data['student_guardian']->code;?>" required>
                                            <?php 
                                                echo form_error('code');
                                            ?>  
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory <?php echo  form_error('student_guardian_name') ?'is-invalid' : '' ?>">
                                                <label for="student_guardian_name" class="form-label">Student Guardian's Name</label>
                                                <input type="text" class="form-control" placeholder="Student Guardian's Name" data-parsley-required="true" name="student_guardian_name" id="student_guardian_name" value="<?php echo $method == 'post' ? set_value('student_guardian_name') : $data['student_guardian']->student_guardian_name;?>" required>
                                            <?php 
                                                echo form_error('student_guardian_name');
                                            ?>  
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory <?php echo  form_error('student_guardian_occupation') ?'is-invalid' : '' ?>">
                                                
                                                <label for="student_guardian_occupation" class="form-label">Student Guardian's Occupation</label>
                                                <div class="input-group mb-3">
                                                    <select class="form-control student_guardian_occupation-select" name="student_guardian_occupation-select" id="student_guardian_occupation-select" data-noresults-text="Nothing to see here."                                         placeholder="Select Student Guardian's Occupation" autocomplete="off" ></select> 
                                                    <input type="hidden" class="form-control" placeholder="Student Guardian's Occupation" name="student_guardian_occupation" id="student_guardian_occupation" value="<?php echo $method == 'post' ? set_value('student_guardian_occupation') : $data['student_guardian']->student_guardian_occupation_id;?>" data-form= "<?php echo $method == 'post' ? set_value('student_guardian_occupation-select_text') : $data['student_guardian']->student_guardian_occupation_name;?>" data-form-autocomplete-url="<?php echo site_url('occupation/json_search')?>" required >
                                                    <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                                    <button class="btn btn-primary" type="button" id="button-addon1">Add New</button>
                                                </div>
                                                <?php 
                                                    echo form_error('student_guardian_occupation');
                                                ?>   
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6 col-12">
                                    
                                            <div class="form-group mandatory <?php echo  form_error('student_guardian_religion') ?'is-invalid' : '' ?>">
                                                <label for="student_guardian_religion-select" class="form-label">Student Guardian's Religion</label>
                                                
                                                <select class="form-control " name="student_guardian_religion-select" id="student_guardian_religion-select" data-noresults-text="Nothing to see here." 
                                                placeholder="Select student guardian's religion" autocomplete="off" ></select> 
                                            
                                                <input type="hidden" class="form-control" placeholder="Student Guardian's religion" name="student_guardian_religion" id="student_guardian_religion" value="<?php echo $method == 'post' ? set_value('student_guardian_religion'): $data['student_guardian']->student_guardian_religion_id;?>" data-parsley-required="true" data-form="<?php echo $method == 'post' ? set_value('student_guardian_religion-select_text') : $data['student_guardian']->student_guardian_religion_name;?>" data-form-autocomplete-url="<?php echo site_url('religion/json_search')?>" required> 
                                            <?php 
                                                echo form_error('student_guardian_religion');
                                            ?> 
                                            </div>
                                        
                                        </div>
                                        
                                        <div class="col-md-6 col-12">
                                            <div class="form-group <?php echo  form_error('student_guardian_phone_number') ?'is-invalid' : '' ?>">
                                                <label for="student_guardian_phone_number" class="form-label">Student Guardian's Phone Number</label>
                                                <input type="text" class="form-control" placeholder="Student Guardian's Phone Number" name="student_guardian_phone_number" id="student_guardian_phone_number" value="<?php echo $method == 'post' ? set_value('student_guardian_phone_number') : $data['student_guardian']->student_guardian_phone_number;?>" >
                                            <?php 
                                                echo form_error('student_guardian_phone_number');
                                            ?>    
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory <?php echo  form_error('student_guardian_address') ?'is-invalid' : '' ?>">
                                                <label for="student_guardian_address" class="form-label">Student Guardian's Address</label>
                                                <textarea class="form-control" placeholder="Student Guardian's Address" data-parsley-required="true" id="student_guardian_address" name="student_guardian_address" style="height: 92px;" required><?php echo $method == 'post' ? set_value('student_guardian_address') : $data['student_guardian']->student_guardian_address;?></textarea>
                                            <?php 
                                                echo form_error('student_guardian_address');
                                            ?> 
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group <?php echo  form_error('photo') ?'is-invalid' : '' ?>">
                                                <label for="photo" class="form-label">Student Guardian's Photo</label>
                                                <input type="file" class="form-control" placeholder="Student Guardian's Photo" name="photo" id="photo" value="<?php echo set_value('photo');?>" >
                                            <?php 
                                                echo form_error('photo');
                                            ?> 
                                            </div>
                                        </div>
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

 