 <!-- Basic Tables start -->
 <section class="section">
    <div class="card">
        <?php
            $this->load->view('admin/main/message');
        ?>  
        <div class="card-body">
        <form class="form" data-parsley-validate action="<?php echo $template['form']['action'];?>" method="post" id="frm_search" name="frm_search">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group <?php echo  form_error('name') ?'is-invalid' : '' ?>">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" placeholder="name" name="name" id="name" value="<?php set_value('name');?>" >
                            <?php 
                                echo form_error('name');
                            ?>  
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group <?php echo  form_error('nis') ?'is-invalid' : '' ?>">
                                <label for="nis" class="form-label">NIS</label>
                                <input type="text" class="form-control" placeholder="Nis" name="nis" id="nis" value="<?php set_value('nis');?>" >
                            <?php 
                                echo form_error('nis');
                            ?>  
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group <?php echo  form_error('classroom') ?'is-invalid' : '' ?>">
                                <label for="classroom" class="form-label">Classroom</label>
                                <input type="text" class="form-control" placeholder="Classroom" name="classroom" id="classroom" value="<?php set_value('classroom');?>" >
                            <?php 
                                echo form_error('classroom');
                            ?>  
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group <?php echo  form_error('semester') ?'is-invalid' : '' ?>">
                                <label for="semester" class="form-label">Semester</label>
                                <input type="text" class="form-control" placeholder="Semester" name="semester" id="semester" value="<?php set_value('semester');?>" >
                            <?php 
                                echo form_error('semester');
                            ?>  
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group <?php echo  form_error('school_year') ?'is-invalid' : '' ?>">
                                <label for="school_year" class="form-label">School Year</label>
                                <input type="text" class="form-control" placeholder="School Year" name="school_year" id="school_year" value="<?php set_value('school_year');?>" >
                            <?php 
                                echo form_error('school_year');
                            ?>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary me-1 mb-1" id="btn_search">Search</button>
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                            </div>
                        </div>
                    </div>
                    </form>
                    
            <div class="card-content">
                <div class="card-body">
               
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
            <table class="table" id="tb-transcript" data-form-url-datatable="<?php echo site_url('transcript/ajax_student_transcript')?>">
                <thead>
                    <tr> 
                        <th>#</th>
                        <th>Classroom</th>
                        <th>School Year</th>
                        <th>Semester</th>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Score</th>
                        <th>Active Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
        </div>
    </div>

</section>
<!-- Basic Tables end -->
