<?php

?>

<div class="memberkit-options">
    <div class="">
        <span style="margin-right: 20px;">Enable Memberkit for this product?</span>
        <input type="hidden" id="enable-memberkit" name="enable-memberkit" value="<?php echo $enable_memberkit; ?>">
        <label class="switch">
            <input type="checkbox" id="toggle-memberkit" <?php echo  $enable_memberkit === "1" ? "checked" : "" ?>>
            <span class="slider"></span>
        </label>
    </div>
    <div class="" id="classrooms-wrapper" style="<?php echo $enable_memberkit === "1" ? "display: block;" : "display: none;" ?>">
        <label for="memberkit_ext_classroom_id_field"  style="margin: 0 20px;">Select a classroom:</label>
        <select name="memberkit_ext_classroom_id_field" id="memberkit_ext_classroom_id_field">
            <option value="">Select a classroom</option>
            <?php
            foreach ($classrooms as $id => $name) {
                
                if($id == $selected_classroom)
                    echo "<option value='$id' selected>$name</option>";
                else
                    echo "<option value='$id'>$name</option>";
            }
            ?>
        </select>
    </div>
</div>