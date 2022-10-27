<?php
    // if($this->input->method() == 'post')
    // {
    //     $nis = set_value('nis');
    // }

    $method = $this->input->method();
?>
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
                            <form class="form" data-parsley-validate action="<?php echo $template['form']['action'];?>" enctype="multipart/form-data" method="post" id="frm_student" name="frm_student">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory <?php echo  form_error('nis') ?'is-invalid' : '' ?>">
                                            <label for="nis" class="form-label">NIS</label>
                                            <input type="text" class="form-control" placeholder="NIS" data-parsley-required="true" name="nis" id="nis" value="<?php echo $method == 'post' ? set_value('nis') : $data['student']->nis;?>" required>
                                        <?php 
                                            echo form_error('nis');
                                        ?>    
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory <?php echo  form_error('name') ?'is-invalid' : '' ?>">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" placeholder="Name" data-parsley-required="true" name="name" id="name" value="<?php echo $method == 'post' ? set_value('name') : $data['student']->name;?>" required>
                                        <?php 
                                            echo form_error('name');
                                        ?>  
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory <?php echo  form_error('birthplace') ?'is-invalid' : '' ?>">
                                            
                                            <label for="birthplace" class="form-label">Birthplace</label>
                                            <div class="input-group mb-3">
                                                <select class="form-control birthplace-select" name="birthplace-select" id="birthplace-select" data-noresults-text="Nothing to see here."                                         placeholder="Select birthplace" autocomplete="off" ></select> 
                                                <input type="hidden" class="form-control" placeholder="Birthplace" name="birthplace" id="birthplace" value="<?php echo $method == 'post' ? set_value('birthplace') : $data['student']->birthplace_id;?>" data-form= "<?php echo $method == 'post' ? set_value('birthplace-select_text') : $data['student']->birthplace_name;?>" data-form-autocomplete-url="<?php echo site_url('city/json_search')?>" required >
                                                <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                                <button class="btn btn-primary" type="button" id="button-addon1">Add New</button>
                                          
                                            
                                            </div>
                                            <?php 
                                                echo form_error('birthplace');
                                            ?>   
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory <?php echo  form_error('birth_date') ?'is-invalid' : '' ?>">
                                            <label for="birth_date" class="form-label">Date of birth</label>
                                            <input type="text" class="form-control datepicker"  placeholder="Date of birth" data-parsley-required="true" name="birth_date" id="birth_date" value="<?php echo $method == 'post' ? set_value('birth_date') : $data['student']->birth_date;?>" required>
                                        <?php 
                                            echo form_error('birth_date');
                                        ?> 
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                  
                                        <div class="form-group mandatory <?php echo  form_error('religion') ?'is-invalid' : '' ?>">
                                            <label for="religion-select" class="form-label">Religion</label>
                                            
                                            <select class="form-control " name="religion-select" id="religion-select" data-noresults-text="Nothing to see here." 
                                            placeholder="Select religion" autocomplete="off" ></select> 
                                          
                                            <input type="hidden" class="form-control" placeholder="Religion" name="religion" id="religion" value="<?php echo $method == 'post' ? set_value('religion'): $data['student']->religion_id;?>" data-parsley-required="true" data-form="<?php echo $method == 'post' ? set_value('religion-select_text') : $data['student']->religion_name;?>" data-form-autocomplete-url="<?php echo site_url('religion/json_search')?>" required> 
                                        <?php 
                                            echo form_error('religion');
                                        ?> 
                                        </div>
                                       
                                    </div>
                                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory <?php echo  form_error('gender') ?'is-invalid' : '' ?>">
                                            <label for="gender" class="form-label">Gender</label>
                                           <?php
                                           /* <input type="text" class="form-control" placeholder="Gender" data-parsley-required="true" id="gender" name="gender" value="<?php echo set_value('gender');?>" required>
                                           */?>
                                            <select class="form-select" id="gender"  name="gender"placeholder="Gender" data-parsley-required="true"  >
                                            <option value=''></option>
                                            <option value='M' <?php echo $method == 'post' ? set_select('gender', 'M') : ($data['student']->gender == 'M' ? 'selected' : ''); ?>>Male</option>
                                            <option value='F' <?php echo  $method == 'post' ? set_select('gender', 'F') : ($data['student']->gender == 'F' ? 'selected' : ''); ?>>Female</option>
                                        </select>
                                        <?php 
                                            echo form_error('gender');
                                        ?> 
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory <?php echo  form_error('student_guardian') ?'is-invalid' : '' ?>">
                                            <label for="student_guardian" class="form-label">Student Guardian</label>
                                            <div class="input-group mb-3">
                                                <select class="form-control " name="student_guardian-select" id="student_guardian-select" data-noresults-text="Nothing to see here."                                         placeholder="Select student guardian" autocomplete="off" ></select> 

                                                <input type="hidden" class="form-control" placeholder="Student Guardian" data-parsley-required="true" name="student_guardian" id="student_guardian" value="<?php echo $method == 'post' ? set_value('student_guardian') : $data['student']->student_guardian_id;?>" data-form="<?php echo $method == 'post' ? set_value('student_guardian-select_text') : $data['student']->student_guardian_name;?>" data-form-autocomplete-url="<?php echo site_url('student_guardian/json_search')?>" required>

                                                <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                                <button class="btn btn-primary" type="button" id="button-addon1">Add New</button>
                                       
                                            </div>
                                        <?php 
                                            echo form_error('student_guardian');
                                        ?> 
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory <?php echo  form_error('address') ?'is-invalid' : '' ?>">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control" placeholder="Address" data-parsley-required="true" id="address" name="address" style="height: 92px;" required><?php echo $method == 'post' ? set_value('address') : $data['student']->address;?></textarea>
                                        <?php 
                                            echo form_error('address');
                                        ?> 
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group  <?php echo  form_error('photo') ?'is-invalid' : '' ?>">
                                            <label for="photo" class="form-label">Photo</label>
                                            <input type="file" class="form-control" placeholder="Photo Photo" name="photo" id="photo" value="<?php echo set_value('photo');?>" >
                                        <?php 
                                            echo form_error('photo');
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

 