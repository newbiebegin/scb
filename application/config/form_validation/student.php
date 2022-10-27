<?php

$config = array(

    //   array(
    //         'field' => 'nis',
    //         'label' => 'NIS',
    //         'rules' => 'trim|required|max_length[50]|callback_is_unique_nis[tb_students.nis]',
    //     ),
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
            'field' => 'student_guardian',
            'label' => 'Student Guardian',
            'rules' => 'trim|required',
        ),
    );