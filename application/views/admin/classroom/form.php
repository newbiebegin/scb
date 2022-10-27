<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div id="form_classroom_message" name="form_classroom_message">
                </div>
            <?php
                $this->load->view('admin/main/message');
                
                // $tab_content_header_active = "";
                
                $save_button_label = 'Save';
                $tab_button_header_active = " active";
                $tab_content_header_active = "show active";
                
                $tab_button_detail_active = "";
                $tab_content_detail_active = "";
                
                $form_name = $template['form']['name'];
                $show_list_classroom_details = TRUE;

                if($form_name == 'form_add')
                {
                    $tab_button_detail_active = " disabled";
                    $save_button_label = 'Save & Add New Detail';
                    $show_list_classroom_details = FALSE;
                }
                elseif($template['form']['redirect_tab_detail'])
                {
                    $tab_button_header_active = "";
                    $tab_content_header_active = "";
            
                    $tab_button_detail_active = " active";
                    $tab_content_detail_active = "show active";
                } 
            ?>            
                <div class="card-content">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="classroom-main-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?php echo $tab_button_header_active;?>" id="classroom-tab" data-bs-toggle="tab" data-bs-target="#classroom" type="button" role="tab" aria-controls="classroom" aria-selected="true">Classroom</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?php echo $tab_button_detail_active;?>" id="classroom_detail-tab" data-bs-toggle="tab" data-bs-target="#classroom_detail" type="button" role="tab" aria-controls="classroom_detail" aria-selected="false">Classroom Detail</button>
                                </li>
                            </ul>
                            <div>&nbsp;</div>
                            <div class="tab-content" id="classroom-content">
                                <div class="tab-pane fade <?php echo $tab_content_header_active;?>" id="classroom" role="tabpanel" aria-labelledby="classroom-tab">
                                    <form class="form" data-parsley-validate action="<?php echo $template['form']['action'];?>" method="post" id="frm_classroom" name="frm_classroom">
                   
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mandatory <?php echo  form_error('classroom') ?'is-invalid' : '' ?>">
                                                    <label for="classroom" class="form-label">Classroom</label>
                                                    <input type="text" class="form-control" placeholder="Classroom" data-parsley-required="true" name="classroom" id="classroom" value="<?php echo $method == 'post' ? set_value('classroom') : $data['classroom']->classroom;?>" required>
                                                <?php 
                                                    echo form_error('classroom');
                                                ?>  
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mandatory <?php echo  form_error('grade') ?'is-invalid' : '' ?>">
                                                    <label for="grade" class="form-label">Grade</label>
                                                    <input type="text" class="form-control" placeholder="Grade" data-parsley-required="true" name="grade" id="grade" value="<?php echo $method == 'post' ? set_value('grade') : $data['classroom']->grade;?>" required>
                                                <?php 
                                                    echo form_error('grade');
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
                                                            <option value='<?php echo $key_dropdown_active_status;?>' <?php echo $method == 'post' ? set_select('is_active', $key_dropdown_active_status) : ($data['classroom']->is_active == $key_dropdown_active_status ? 'selected' : ''); ?>>
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
                                                <button type="submit" class="btn btn-primary me-1 mb-1" id="btn_save_add_new_detail"><?php echo $save_button_label;?></button>
                                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                            </div>
                                        </div>
                                    </form> 
                                </div>  
                  
                               
                                <div class="tab-pane fade <?php echo $tab_content_detail_active;?>" id="classroom_detail" role="tabpanel" aria-labelledby="classroom_detail-tab">
                                    <div class="row">
                                        <div class="col-12">
                                        <?php
                                        if($show_list_classroom_details === TRUE)
                                        {
                                            $this->load->view('admin/classroom_detail/list', $data);
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div>   
                                <?php
                                /*   onclick="document.getElementById('frm_classroom').submit();"    */?>                                  
                            </div>
                           
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // Basic multiple Column Form section end -->

 