<!-- Basic Tables start -->
<section class="section">
    <div class="card">
        <div class="card-body">
            <table class="table table-detail" id="tb-transcript_detail" data-form-url-datatable="<?php echo site_url('transcript_detail/ajax_list')?>" data-transcript = "<?php echo $data['transcript']->id;?>">
                <thead>
                    <tr> 
                        <th>No</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>NIP</th>
                        <th>Score</th>
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
                                Form Edit Transcript Detail
                            </h4>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="form_message" name="form_message">
                            </div>
                 
                            <form action="<?php echo $template['form']['transcript_detail']['add']['action'];?>" method="post" name="form_modal_transcript_detail" id="form_modal_transcript_detail" data-transcript = "<?php echo $data['transcript']->id;?>" data-url="<?php echo $template['form']['transcript_detail']['add']['action'];?>">
                                <div class="form-group mandatory <?php echo  form_error('form_modal_subject_teacher') ?'is-invalid' : '' ?>">
                                            
                                    <label for="form_modal_subject_teacher" class="form-label">Subject</label>
                                    <!-- <div class="input-group mb-3"> -->
                                    <select class="form-control subject_teacher-select" name="form_modal_subject_teacher-select" id="form_modal_subject_teacher-select" data-noresults-text="Nothing to see here." placeholder="Select subject" autocomplete="off" ></select> 
                                    <input type="hidden" class="form-control" placeholder="Subject" name="form_modal_subject_teacher" id="form_modal_subject_teacher" value="<?php echo $method == 'post' ? set_value('form_modal_subject_teacher') : $data['transcript_detail']->subject_teacher_id;?>" data-form= "<?php echo $method == 'post' ? set_value('form_modal_subject_teacher-select_text') : $data['transcript_detail']->subject_teacher_name;?>" data-form-autocomplete-url="<?php echo site_url('subject_teacher/json_search')?>" required >
                                    <!-- <button class="btn btn-primary" type="button" id="button-addon1">Search</button>&nbsp;
                                    <button class="btn btn-primary" type="button" id="button-addon1">Add New</button> -->
                                <!-- </div> -->
                                    <?php 
                                        echo form_error('form_modal_subject_teacher');
                                    ?>   
                                </div>
                                <div class="form-group mandatory <?php echo  form_error('form_modal_score') ?'is-invalid' : '' ?>">
                                    <label for="form_modal_score" class="form-label">Score</label>
                                    <input type="text" class="form-control" placeholder="Score" data-parsley-required="true" name="form_modal_score" id="form_modal_score" value="<?php echo $method == 'post' ? set_value('form_modal_score') : $data['transcript_detail']->score;?>" required>
                                <?php 
                                    echo form_error('form_modal_score');
                                ?>  
                                </div>
                                <div class="form-group mandatory <?php echo  form_error('is_active') ?'is-invalid' : '' ?>">
                                    <label for="form_modal_is_active" class="form-label">Active Status</label>
                                    
                                    <select class="form-select" id="form_modal_is_active"  name="form_modal_is_active" placeholder="Active Status" data-parsley-required="true"  >
                                    <?php
                                        foreach($template['form']['dropdown_active_status'] as $key_dropdown_active_status => $val_dropdown_active_status ):
                                    ?>
                                            <option value='<?php echo $key_dropdown_active_status;?>' <?php echo $method == 'post' ? set_select('form_modal_is_active', $key_dropdown_active_status) : ($data['transcript_detail']->is_active == $key_dropdown_active_status ? 'selected' : ''); ?>>
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