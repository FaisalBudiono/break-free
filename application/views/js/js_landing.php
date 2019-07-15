		/*Autorun from controller. */
		<?php echo $run; ?>
		
		/* Enable tooltip/ */
		$('[data-toggle="popover"').popover({
			container: 'body',
			html: true
		});

		$('#b_register').prop('disabled', true);

		/*Modifying the URL. */
		$('#btnRegister').click(function(){
			history.pushState({}, "Break Free. Only one password, that's what you only need.", "<?php echo base_url("register"); ?>");
		});
		$('.btnLogin').click(function(){
			history.pushState({}, "Break Free. Only one password, that's what you only need.", "<?php echo base_url("login"); ?>");
		});
		$('.modal').on('hide.bs.modal', function() {
		  history.pushState({}, "Break Free. Only one password, that's what you only need.", "<?php echo base_url(""); ?>");
		})

		/* Start of checking password confirmation. */
		$('#passwordReg, #passwordConfReg').on('keyup', function(){
			var pass = $('#passwordReg').val();
			var passConf = $('#passwordConfReg').val();
			var disabledPass = 0;

			if(pass.length<10){
				$('#passMessage').html('Your password must have at least 10 characters.');
				disabledPass = 0;
			}else{
				$('#passMessage').html('');
				disabledPass++;
			}
			
			if(pass!==passConf){
				$('#confMessage').html('Your confirmation password doesn\'t match your master password.');
				disabledPass = 0;
			}else{
				$('#confMessage').html('');
				disabledPass++;
			}
			
			if(disabledPass >= 2){
				$('#b_register').prop('disabled', false);
			}else {
				$('#b_register').prop('disabled', true);
			}
		});
		/* End of checking password confirmation. */