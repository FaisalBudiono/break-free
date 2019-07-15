		/* Start of checking password confirmation. */
		$('#oldPass, #newPass, #newPassConf').on('keyup', function(){
			var oldPass = $('#oldPass').val();
			var pass = $('#newPass').val();
			var passConf = $('#newPassConf').val();
			var disabledPass = 0;

			if(oldPass.length<10){
				$('#oldPassMessage').html('Your password must have at least 10 characters.');
				disabledPass = 0;
			}else{
				$('#oldPassMessage').html('');
				disabledPass++;
			}

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
			
			if(disabledPass >= 3){
				$('#b_changePass').prop('disabled', false);
				$('#sub_changePass').prop('disabled', false);
			}else {
				$('#b_changePass').prop('disabled', true);
				$('#sub_changePass').prop('disabled', true);
			}
		});
		/* End of checking password confirmation. */

		function formSubmitted(){
			if(!$('#formUpdate')[0].checkValidity()){
				$('#formUpdate').find('input[type="submit"]').click();
			}else{

				var oldPass = $('#oldPass').val();
				var newPass = $('#newPass').val();
				var newPassConf = $('#newPassConf').val();

				$('#modalUti').html(localStorage.getItem('loadingSection'));
				
				$.ajax({
					url: '<?php echo site_url('api/changePass'); ?>',
					method: "POST",
					data: {
						b_changePass: '1',
						oldPass: oldPass,
						newPass: newPass,
						newPassConf: newPassConf
					},
					success: function(r){
						if(r == 'success'){
							modalUtiWithTimer('alert-success', 'Password changed!', 'Your master password successfully changed!',2000);
						}else{
							modalUtiWithTimer('alert-warning', 'Password changed failed.', 'Your old master password is wrong!<br>Please check your old master password.',4000);
						}
					},
					error: function(err){
						modalUtiWithTimer('alert-warning', err.status + ': ' + err.statusText,'Oops, something is wrong. Try again later, but make sure to check your input field before resubmitting your data.',2000);
					},
					complete: function(){
						$('#loadData').click();
					}
				});
			}
		}
		$('#formUpdate').submit(function(e){
			e.preventDefault();
			formSubmitted();
		});

		$('#b_changePass').click(function(){
			formSubmitted();
		});