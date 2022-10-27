<?php

$config = array(
    'classroom/form' => 
        array(
            array(
                'field' => 'grade',
                'label' => 'Grade',
                'rules' => 'trim|required|max_length[20]',
            ),
            array(
                'field' => 'is_active',
                'label' => 'Active Status',
                'rules' => 'trim|required|max_length[1]|in_list[Y,N]',
            ),
        ),      
    );