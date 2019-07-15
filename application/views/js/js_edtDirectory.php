		function formSubmitted(){
			if(!$('#formUpdate')[0].checkValidity()){
				$('#formUpdate').find('input[type="submit"]').click();
			}else{

				var folderName = ($('#dirName').val()).toUpperCase();

				$('#modalUti').html(localStorage.getItem('loadingSection'));
				
				$.ajax({
					url: '<?php echo site_url('api/updateDirectory') . "/" . $dir['id_directory']; ?>',
					method: "POST",
					data: {
						b_update_directory: '1',
						directoryName: folderName
					},
					success: function(){
						modalUtiWithTimer('alert-success', 'Success!', '<b>' + folderName + '</b> successfully changed!',2000);
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

		$('#b_updateDir').click(function(){
			formSubmitted();
		});