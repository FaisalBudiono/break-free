		var alm = new Date('<?php echo $acc['last_modified']; ?>');
		$("#accLastMod<?php echo $acc['id_adl']; ?>").removeClass('text-muted')
			.html(timeSince(alm)+" ago");


		function formSubmitted(){
			if(!$('#formUpdate')[0].checkValidity()){
				$('#formUpdate').find('input[type="submit"]').click();
			}else{

				var accName = $('#accName').val();
				var accDirName = $('#accDirName').val();
				var accSite = $('#accSite').val();
				var accUsername = $('#accUsername').val();
				var accPassword = $('#accPassword').val();
				var accNote = $('#accNote').val();

				$('#modalUti').html(localStorage.getItem('loadingSection'));

				$.ajax({
					url: '<?php echo site_url('api/updateAccount') . "/" . $acc['id_adl']; ?>',
					method: "POST",
					data: {
						b_update_acc: '1',
						accountName: accName,
						accountSite: accSite,
						accountUsername: accUsername,
						accountPassword: accPassword,
						accountNote: accNote,
						accountDirectory: accDirName
					},
					success: function(){
						modalUtiWithTimer('alert-success', 'Success!', 'Your <b>' + accName + '</b> account data successfully updated!',2000);
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

		$('#b_updateAcc').click(function(){
			formSubmitted();
		});