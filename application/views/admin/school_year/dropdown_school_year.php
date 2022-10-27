<?php
// var_dump($template['form']['dropdown_school_year']);
// exit();
?>
<select class="form-select school_year" id="<?php echo $template['form']['dropdown_school_year']['id'];?>"  name="<?php echo $template['form']['dropdown_school_year']['name'];?>"placeholder="School Year" data-parsley-required="<?php echo $template['form']['dropdown_school_year']['required'];?>"  >
<?php
    foreach($template['form']['dropdown_school_year']['data'] as $dropdown_school_year):
?>
        <option value='<?php echo $dropdown_school_year->id;?>' <?php echo $method == 'post' ? set_select($template['form']['dropdown_school_year']['name'], $dropdown_school_year->id) : ($data['field_school_year']->school_year_id == $dropdown_school_year->id ? 'selected' : ''); ?>>
        <?php
            echo $dropdown_school_year->school_year;
        ?>
        </option>
<?php
    endforeach;
?>
</select>
                                  
<?php /*
<select class="form-control student_guardian_occupation-select" name="student_guardian_occupation-select" id="student_guardian_occupation-select" data-noresults-text="Nothing to see here." placeholder="Select Student Guardian's Occupation" autocomplete="off" ></select> 
<input type="hidden" class="form-control" placeholder="Student Guardian's Occupation" name="student_guardian_occupation" id="student_guardian_occupation" value="<?php echo $method == 'post' ? set_value('student_guardian_occupation') : $data['student_guardian']->student_guardian_occupation_id;?>" data-form= "<?php echo $method == 'post' ? set_value('student_guardian_occupation-select_text') : $data['student_guardian']->student_guardian_occupation_name;?>" data-form-autocomplete-url="<?php echo site_url('occupation/json_search')?>" required >
 */?>