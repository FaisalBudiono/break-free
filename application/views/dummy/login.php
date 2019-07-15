<?php echo form_open('landing/login');?>
	Email : <input type="text" name="email" value="<?php echo set_value('email');?>"><br>
	Password : <input type="password" name="password"><br>
	<input type="submit" name="b_login" value="Login"><br><br>

	<?php
		// Error Handler
		echo validation_errors(); 
	?>
</form>