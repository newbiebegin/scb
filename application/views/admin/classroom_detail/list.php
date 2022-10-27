<!-- Basic Tables start -->
 <section class="section">
        <div class="card">
            <!-- <div class="card-header">
                Jquery Datatable
            </div> -->
            <?php
                // $this->load->view('admin/main/message');
            ?>  
            <div class="card-body">
                
                <table class="table table-detail" id="tb-classroom_detail" data-form-url-datatable="<?php echo site_url('classroom_detail/ajax_list')?>" data-classroom = "<?php echo $data['classroom']->id;?>">
                    <thead>
                        <tr> 
                          <!--  <th><input type="checkbox" name="select_all" value="1" id="classroom_detail-select-all"></th>
                             <th></th> -->
                            <th>No</th>
                            <th>School Year</th>
                            <th>Homeroom Teacher</th>
                            <th>Head Class</th>
                            <th>Active Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
                 
                <!--edit form Modal -->
                <div class="modal fade" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                        
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">
                                    Form Edit Classroom Detail
                                </h4>
                                <button type="button" class="close" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                           <?php /* */?>
                           
                           
                                <div class="modal-body">
                                    <div id="form_message" name="form_message">
                                    </div>
                 
                                <form action="<?php echo $template['form']['classroom_detail']['add']['action'];?>" method="post" name="form_modal_classroom_detail" id="form_modal_classroom_detail" data-classroom = "<?php echo $data['classroom']->id;?>" data-url="<?php echo $template['form']['classroom_detail']['add']['action'];?>">
                                    <div class="form-group mandatory <?php echo  form_error('form_modal_classroom') ?'is-invalid' : '' ?>">
                                            
                                        <label for="form_modal_classroom" class="form-label">Classroom</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control form_modal_classroom-select" name="form_modal_classroom-select" id="form_modal_classroom-select" data-noresults-text="Nothing to see here." placeholder="Select classroom" autocomplete="off" disabled></select> 
                                            <input type="hidden" class="form-control" placeholder="Classroom" name="form_modal_classroom" id="form_modal_classroom" value="<?php echo $method == 'post' ? set_value('form_modal_classroom') : $data['classroom']->id;?>" data-form= "<?php echo $method == 'post' ? set_value('form_modal_classroom-select_text') : $data['classroom']->classroom;?>" data-form-autocomplete-url="<?php echo site_url('classroom/json_search')?>" required readonly="true">
                                            <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                            <button class="btn btn-primary" type="button" id="button-addon1">Add New</button> -->
                                        
                                        </div>
                                        <?php 
                                            echo form_error('form_modal_classroom');
                                        ?>   
                                    </div>
                                    <div class="form-group mandatory <?php echo  form_error('form_modal_school_year') ?'is-invalid' : '' ?>">
                                            
                                        <label for="form_modal_school_year" class="form-label">School Year</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control school_year-select" name="form_modal_school_year-select" id="form_modal_school_year-select" data-noresults-text="Nothing to see here." placeholder="Select school year" autocomplete="off" ></select> 
                                            <input type="hidden" class="form-control" placeholder="School Year" name="form_modal_school_year" id="form_modal_school_year" value="<?php echo $method == 'post' ? set_value('form_modal_school_year') : $data['classroom_detail']->school_year_id;?>" data-form= "<?php echo $method == 'post' ? set_value('form_modal_school_year-select_text') : $data['classroom_detail']->school_year;?>" data-form-autocomplete-url="<?php echo site_url('school_year/json_search')?>" required >
                                            <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                            <button class="btn btn-primary" type="button" id="button-addon1">Add New</button> -->
                                        </div>
                                        <?php 
                                            echo form_error('form_modal_school_year');
                                        ?>   
                                    </div>
                                    <div class="form-group mandatory <?php echo  form_error('form_modal_homeroom_teacher') ?'is-invalid' : '' ?>">
                                            
                                        <label for="form_modal_homeroom_teacher" class="form-label">Homeroom Teacher</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control form_modal_homeroom_teacher-select" name="form_modal_homeroom_teacher-select" id="form_modal_homeroom_teacher-select" data-noresults-text="Nothing to see here." placeholder="Select homeroom teacher" autocomplete="off" ></select> 
                                            <input type="hidden" class="form-control" placeholder="Homeroom Teacher" name="form_modal_homeroom_teacher" id="form_modal_homeroom_teacher" value="<?php echo $method == 'post' ? set_value('form_modal_homeroom_teacher') : $data['classroom_detail']->homeroom_teacher_id;?>" data-form= "<?php echo $method == 'post' ? set_value('homeroom_teacher-select_text') : $data['classroom_detail']->homeroom_teacher_name_nip;?>" data-form-autocomplete-url="<?php echo site_url('teacher/json_search')?>" required >
                                            <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                            <button class="btn btn-primary" type="button" id="button-addon1">Add New</button> -->
                                        
                                        </div>
                                        <?php 
                                            echo form_error('form_modal_homeroom_teacher');
                                        ?>   
                                    </div>
                                    <div class="form-group mandatory <?php echo  form_error('form_modal_head_class') ?'is-invalid' : '' ?>">
                                            
                                        <label for="form_modal_head_class" class="form-label">Head Class</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control head_class-select" name="form_modal_head_class-select" id="form_modal_head_class-select" data-noresults-text="Nothing to see here." placeholder="Select head class" autocomplete="off" ></select> 
                                            <input type="hidden" class="form-control" placeholder="Head Class" name="form_modal_head_class" id="form_modal_head_class" value="<?php echo $method == 'post' ? set_value('form_modal_head_class') : $data['classroom_detail']->head_class_id;?>" data-form= "<?php echo $method == 'post' ? set_value('form_modal_head_class-select_text') : $data['classroom_detail']->head_class_name_nis;?>" data-form-autocomplete-url="<?php echo site_url('student/json_search')?>" required >
                                            <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                            <button class="btn btn-primary" type="button" id="button-addon1">Add New</button> -->
                                        
                                        </div>
                                        <?php 
                                            echo form_error('form_modal_head_class');
                                        ?>   
                                    </div>
                                    <div class="form-group mandatory <?php echo  form_error('is_active') ?'is-invalid' : '' ?>">
                                        <label for="form_modal_is_active" class="form-label">Active Status</label>
                                    
                                        <select class="form-select" id="form_modal_is_active"  name="form_modal_is_active" placeholder="Active Status" data-parsley-required="true"  >
                                        <?php
                                            foreach($template['form']['dropdown_active_status'] as $key_dropdown_active_status => $val_dropdown_active_status ):
                                        ?>
                                                <option value='<?php echo $key_dropdown_active_status;?>' <?php echo $method == 'post' ? set_select('form_modal_is_active', $key_dropdown_active_status) : ($data['classroom_detail']->is_active == $key_dropdown_active_status ? 'selected' : ''); ?>>
                                                <?php
                                                    echo $val_dropdown_active_status;
                                                ?>
                                                </option>
                                                
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                    <?php 
                                        echo form_error('form_modal_is_active');
                                    ?> 
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="button" class="btn btn-primary ml-1"
                                         id="btn_save" name="btn_save">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Save</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                               
                    </div>
                </div>


                <!--warning theme Modal -->
                <div class="modal fade text-left" id="warning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel140" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                        role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-warning">
                                <h5 class="modal-title white" id="myModalLabel140">Warning
                                </h5>
                                <button type="button" class="close" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                            Are you sure to delete the data?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary"
                                    data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">No</span>
                                </button>

                                <button type="button" class="btn btn-warning ml-1" id="btn_confirm_delete" data-url="" data-classroom-detail="">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Yes</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of modal warning-->
            </div>
        </div>

    </section>
    <!-- Basic Tables end -->
<?php 
/*
<script type="text/html" id="Template1">
    <?php  echo $template['datatable']; ?>
</script>
*/?>