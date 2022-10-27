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
                <table class="table" id="tb-teacher" data-form-url-datatable="<?php echo site_url('teacher/ajax_list')?>">
                    <thead>
                        <tr> 
                            <th>#</th>
                            <th>Name</th>
                            <th>NIP</th>
                            <th>Birthplace</th>
                            <th>Date of birth</th>
                            <th>Religion</th>
                            <th>Gender</th>
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