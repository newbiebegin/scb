 <!-- Basic Tables start -->
 <section class="section">
        <div class="card">
            <!-- <div class="card-header">
                Jquery Datatable
            </div> -->
            <?php
                $this->load->view('admin/main/message');
            ?>  
            <div class="card-body">
                <table class="table" id="tb-student_guardian" data-form-url-datatable="<?php echo site_url('student_guardian/ajax_list')?>">
                    <thead>
                        <tr> 
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <!-- <th>Occupation</th> -->
                            <th>Religion</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    <!-- Basic Tables end -->