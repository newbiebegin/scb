<?php
    $messages = NULL;
    $type_message = NULL;

    if(array_key_exists('errors', $data) &&  $data['errors'] != NULL):
        $messages = $data['errors'];
        $type_message = 'error_messages';
    endif;


    if(array_key_exists('messages', $data) &&  $data['messages'] != NULL):
        $messages = $data['messages']['content'];
        $type_message = $data['messages']['type'];
    endif;

    

    echo cr_show_messages($messages, $type_message);
?>
