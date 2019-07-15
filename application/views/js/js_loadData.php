		$('#loadData').click(function(){
			$('#accContainer').html('<div class="col-12 d-flex justify-content-center loading align-items-center" style="min-height: inherit;"><div class="spinner-border" role="status" style="width: 6rem; height: 6rem;"><span class="sr-only">Loading...</span></div></div>');

			function dataFetcher(accData, idDir, dirName = "UNCATEGORIZED"){
				if(idDir == 0 && JSON.stringify(accData) == JSON.stringify([])) return;
				var data = '';
				data +=
					'<!-- Account Folder List -->' +
					'<div class="col-12 flex-column mb-3">' +
						'<div class="d-flex justify-content-between align-items-center folderName">' +
							'<a class="d-flex align-items-center col text-body text-decoration-none" data-toggle="collapse" href="#directory' + idDir + '" role="button" aria-expanded="false" aria-controls="directory' + idDir + '">' +
								'<h4 class="py-2 text_wrap">' + dirName + '</h4>' +
								'<h4><i class="fas fa-caret-down ml-2" id="directoryCaret"></i></h4>' +
							'</a>'
				;

				if(idDir != 0){
					data +=
							'<div class="d-lg-none col-auto text-right mr-2" id="folderOption">' +
								'<div class="btn-group dropleft">' +
									'<button type="button" class="py-1 px-2 btn rounded shadow" id="dirData' + idDir + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">' +
										'<h4 class="m-0"><i class="fas fa-ellipsis-h"></i></h4>' +
									'</button>' +
									'<div class="dropdown-menu" aria-labelledby="dirData' + idDir + '" data-dir="' + idDir + '">' +
										'<a class="dropdown-item edtDir" href="javascript:void(0)">Rename Folder</a>' +
										'<a class="dropdown-item delDir" href="javascript:void(0)">Delete Folder</a>' +
									'</div>' +
								'</div>' +
							'</div>'
					;
				}

				data += 
						'</div>' + 
						'<div class="collapse show multi-collapse" id="directory' + idDir + '">' +
						'<hr class="separator my-2">'
				;

				/* Start of Account Data Handler */
				if(!(JSON.stringify(accData) == JSON.stringify([]))){
					for(var key in accData){
						data +=
							'<!-- Account Data List -->' + 
							'<div class="d-flex align-items-center py-2 px-3 mx-2 dataItem">' +
								// '<input type="checkbox" class="btn_account col-auto" id="chkAcc" data-acc="' + accData[key]['id_adl'] + '">' +
								'<div class="d-flex flex-column align-items-start mx-2 col-lg-4 col-5">' +
									'<div class="d-inline-block text-truncate w-100"><big>' + accData[key]['name'] + '</big></div>' +
									'<div class="d-inline-block text-truncate w-100 userTarget">' + accData[key]['username'] + '</div>' +
								'</div>' +
								'<div class="d-sm-flex flex-column align-items-start col-sm-3 d-none px-0">' +
									'<div class="d-sm-none d-md-flex"><big>Last Modified</big></div>' +
									'<div id="lastMod' + accData[key]['id_adl'] + '" class="text-muted">Please wait...</div>' +
								'</div>' +
								'<div class="d-flex justify-content-end ml-auto px-0 col-auto">'+
									'<div class="mr-2 dropleft">' +
										'<a class="text-dark text-decoration-none" id="accData' + accData[key]['id_adl'] + '" role="button" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">' +
											'<i class="fas fa-edit btn_account"></i>' +
										'</a>' +
										'<div class="dropdown-menu" aria-labelledby="accData' + accData[key]['id_adl'] + '" data-acc="' + accData[key]['id_adl'] + '">' +
											'<a class="dropdown-item edtAcc" href="javascript:void(0)">Edit Account</a>' +
											'<div class="dropdown-divider"></div>' +
											'<a class="dropdown-item cpyUsername" href="javascript:void(0)">Copy Username</a>' +
											'<a class="dropdown-item cpyPass" href="javascript:void(0)">Copy Password</a>' +
											'<div class="dropdown-divider"></div>' +
											'<a class="dropdown-item text-danger delAcc" href="javascript:void(0)">Delete Account</a>' +
										'</div>' +
									'</div>' +
									'<a class="text-danger text-decoration-none delAcc" href="javascript:void(0)">' +
										'<div class="ml-2"><i class="fas fa-trash-alt btn_account"></i></div>' +
									'</a>' +
								'</div>' +
							'</div>'
						;
					}
				}else{
					data +=
							'<!-- Account Data List -->' +
							'<div class="d-flex justify-content-center py-2 px-3 mx-2 dataItemNull">' +
								'<big class="text-muted">(None)</big>' +
							'</div>'
					;
				}
				/* End of Account Data Handler */

				data +=
						'</div>' +
					'</div>'
				;

				return data;
			}

			$.ajax({
				url: '<?php echo site_url('api/loadData'); ?>',
				method: 'GET',
				dataType: 'JSON',
				success: function(r){

					var dataJson = r;
					var dirJson = dataJson['dir'];
					var accJson = dataJson['acc'];

					if((JSON.stringify(accJson) == JSON.stringify([[]])) && JSON.stringify(dirJson) == JSON.stringify([])){
						$('#accContainer').html('<div class="col-12 d-flex flex-column justify-content-center loading align-items-center text-muted" style="min-height: inherit;"> <h4 class="mb-2"> You don\'t have any Folder or Account data. </h4> <h5> <hr> You can add Folder or Account data by pressing <b>(<i class="fas fa-plus"></i>)Plus Button</b> in the lower right corner. </h5> </div>');
					}else{
						$('#accContainer').html('');
						$('#accContainer').append(dataFetcher(accJson[0], 0));
						for(var key in dirJson){
							$('#accContainer').append(dataFetcher(accJson[dirJson[key]['id_directory']], dirJson[key]['id_directory'], dirJson[key]['directory_name']));
						}

						lm = [];

						var lmJson = dataJson['last_modified'];

						for(var key in lmJson){
							var lm = new Date(lmJson[key]);
							$("#lastMod"+key).removeClass('text-muted');
							$("#lastMod"+key).html(timeSince(lm)+" ago");
						}
					}

					/** Handler to empty the search query after the data modified.*/
					$('#bSearchAccount').click();

				}
			});
		});

		$('#loadData').click();