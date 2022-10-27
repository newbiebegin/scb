<?php

$config = array(
    'classroom_detail/modal_form' => 
        array(
            array(
                'field' => 'form_modal_is_active',
                'label' => 'Active Status',
                'rules' => 'trim|required|max_length[1]|in_list[Y,N]',
            ),
        ),
       
    );