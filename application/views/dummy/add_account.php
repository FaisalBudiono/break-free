<?php echo form_open('asd/add_account'); ?>
	Directory:
	<select name="account-directory">
		<option>None</option>
		<?php
		foreach ($dir as $key) {
			echo "<option value=\"$key[id_directory]\">$key[directory_name]</option>";
		}
		?>
	</select><br>
	Account name: <input type="text" name="account-name"><br>
	Site: <input type="text" name="account-site"><br>
	Username: <input type="text" name="account-username"><br>
	Password: <input type="password" name="account-password"><br>
	Note: <textarea name="account-note"></textarea><br>
	<input type="submit" name="b_add_account" value="Save">
</form>

<?php
	echo validation_errors();
?>