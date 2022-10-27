 <!-- Basic Tables start -->
 <section class="section">
    <div class="card">
        <?php
            $this->load->view('admin/main/message');
        ?>  
        <div class="card-body">
            <table class="table" id="tb-classroom_subject" data-form-url-datatable="<?php echo site_url('classroom_subject/ajax_list')?>">
                <thead>
                    <tr> 
                        <th>#</th>
                        <th>School Year</th>
                        <th>Semester</th>
                        <th>Classroom</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>NIP</th>
                        <th>Active Status</th>
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
