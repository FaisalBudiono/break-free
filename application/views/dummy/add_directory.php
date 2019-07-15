<?php echo form_open('asd/add_directory'); ?>
	Directory Name: <input type="text" name="directory-name"><br>
	<input type="submit" name="b_add_directory" value="Save">
</form>

<?php
	echo validation_errors();
?>