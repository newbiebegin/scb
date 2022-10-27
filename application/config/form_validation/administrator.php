<?php

$config = array(
		array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required|max_length[100]',
        ),
        array(
            'field' => 'birthplace',
            'label' => 'Birthplace',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'birth_date',
            'label' => 'Date of birth',
            'rules' => 'trim|required|max_length[15]',
        ),
        array(
            'field' => 'religion',
            'label' => 'Religion',
            'rules' => 'trim|required|max_length[11]',
        ),
        array(
            'field' => 'gender',
            'label' => 'Gender',
            'rules' => 'trim|required|max_length[1]|in_list[M,F]',
        ),
        array(
            'field' => 'address',
            'label' => 'Address',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'phone_number',
            'label' => 'Phone Number',
            'rules' => 'trim|max_length[20]',
        ),
    );