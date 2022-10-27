<?php

$config = array(
    'student_classroom/form' => 
        array(
            array(
                'field' => 'is_active',
                'label' => 'Active Status',
                'rules' => 'trim|required|max_length[1]|in_list[Y,N]',
            ),
        ),      
    );