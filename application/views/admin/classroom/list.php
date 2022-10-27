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
            <table class="table" id="tb-classroom" data-form-url-datatable="<?php echo site_url('classroom/ajax_list')?>">
                <thead>
                    <tr> 
                        <th>#</th>
                        <th>Classroom</th>
                        <th>Grade</th>
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
