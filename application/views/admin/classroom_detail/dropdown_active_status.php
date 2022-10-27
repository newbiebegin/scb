
<select class="form-select active_status" id="is_active"  name="is_active"placeholder="Active Status" data-parsley-required="true"  >
<?php
        foreach($template['form']['dropdown_active_status'] as $key_dropdown_active_status => $val_dropdown_active_status ):
?>
        <option value="<?php echo $key_dropdown_active_status;?>" <?php echo $method == 'post' ? set_select('is_active', $key_dropdown_active_status) : ($data['field_is_active']->is_active == $key_dropdown_active_status ? "selected" : ""); ?>>
        <?php
            echo $val_dropdown_active_status;
        ?>
        </option>
        
<?php
    endforeach;
?>
</select>

<?php
/*
<select size='1' name='row-1-office' disabled style='border: none; appearance:none;'>
            <option value='Edinburgh'>Edinburgh</option>
            <option value='London' selected='selected'>London</option>
            <option value='New York'>New York</option>
            <option value='San Francisco'>San Francisco</option>
            <option value='Tokyo'>Tokyo</option>
         </select>
        
<select size='1' name='row-1-office' class='active_status'>
            <option value='1Edinburgh'>Edinburgh</option>
            <option value='2London' selected='selected'>London</option>
            <option value='3New York'>New York</option>
            <option value='4San Francisco'>San Francisco</option>
            <option value='5Tokyo'>Tokyo</option>
         </select> */?>