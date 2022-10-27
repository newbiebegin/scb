<?php

$config = array(
    'transcript/form' => 
        array(
            array(
                'field' => 'semester',
                'label' => 'Semester',
                'rules' => 'trim|required|max_length[2]',
            ),
            array(
                'field' => 'is_active',
                'label' => 'Active Status',
                'rules' => 'trim|required|max_length[1]|in_list[Y,N]',
            ),
        ),      
    );