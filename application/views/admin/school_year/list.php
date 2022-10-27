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
                <table class="table" id="tb-school_year" data-form-url-datatable="<?php echo site_url('school_year/ajax_list')?>">
                    <thead>
                        <tr> 
                            <th>#</th>
                            <th>School Year</th>
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