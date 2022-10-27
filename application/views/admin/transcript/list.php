 <!-- Basic Tables start -->
 <section class="section">
    <div class="card">
        <?php
            $this->load->view('admin/main/message');
        ?>  
        <div class="card-body">
            <table class="table" id="tb-transcript" data-form-url-datatable="<?php echo site_url('transcript/ajax_list')?>">
                <thead>
                    <tr> 
                        <th>#</th>
                        <th>Classroom</th>
                        <th>School Year</th>
                        <th>Semester</th>
                        <th>Student</th>
                        <th>Total Score</th>
                        <th>Average Score</th>
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
