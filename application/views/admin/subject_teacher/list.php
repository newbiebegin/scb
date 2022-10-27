 <!-- Basic Tables start -->
 <section class="section">
    <div class="card">
        <?php
            $this->load->view('admin/main/message');
        ?>  
        <div class="card-body">
            <table class="table" id="tb-subject_teacher" data-form-url-datatable="<?php echo site_url('subject_teacher/ajax_list')?>">
                <thead>
                    <tr> 
                        <th>#</th>
                        <th>Teacher</th>
                        <th>NIP</th>
                        <th>Subject</th>
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
