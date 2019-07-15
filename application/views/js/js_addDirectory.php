		function formSubmitted(){
			if(!$('#formAddFolder')[0].checkValidity()){
				$('#formAddFolder').find('input[type="submit"]').click();
			}else{

				var folderName = ($('#dirName').val()).toUpperCase();

				$('#modalUti').html(localStorage.getItem('loadingSection'));

				$.ajax({
					url: '<?php echo site_url('api/addDirectory'); ?>',
					method: "POST",
					data: {
						b_add_directory: '1',
						directoryName: folderName
					},
					success: function(asd){
						modalUtiWithTimer('alert-success', 'Success!', 'Your <b>' + folderName + '</b> folder successfully added!',2000);
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

		$('#formAddFolder').submit(function(e){
			e.preventDefault();
			formSubmitted();
		});

		$('#b_addDirectory').click(function(){
			formSubmitted();
		});