<?php echo form_open('landing/register'); ?>
	Email : <input type="text" name="email" value="<?php echo set_value('email'); ?>"><br>
	Password : <input type="password" name="password"><br>
	Re-enter Password : <input type="password" name="reenter-password"><br>
	<input type="submit" name="b_register" value="Register"><br><br>
	
	<?php 
		// Error Handler
		echo validation_errors(); 
	?>
</form>