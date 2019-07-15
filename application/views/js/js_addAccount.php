		function formSubmitted(){
			if(!$('#formAddAccount')[0].checkValidity()){
				$('#formAddAccount').find('input[type="submit"]').click();
			}else{

				var accName = $('#accName').val();
				var accSite = $('#accSite').val();
				var accUsername = $('#accUsername').val();
				var accPassword = $('#accPassword').val();
				var accNote = $('#accNote').val();
				var accDirName = $('#accDirName').val();

				$('#modalUti').html(localStorage.getItem('loadingSection'));

				$.ajax({
					url: '<?php echo site_url('api/addAccount'); ?>',
					method: "POST",
					data: {
						b_add_account: '1',
						accountName: accName,
						accountSite: accSite,
						accountUsername: accUsername,
						accountPassword: accPassword,
						accountNote: accNote,
						accountDirectory: accDirName
					},
					success: function(){
						modalUtiWithTimer('alert-success', 'Success!', 'Your <b>' + accName + '</b> account data successfully added!',2000);
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
		$('#formAddAccount').submit(function(e){
			e.preventDefault();
			formSubmitted();
		});

		$('#b_addAccount').click(function(){
			formSubmitted();
		});