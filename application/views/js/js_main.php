		/** Store loading modal display on localStorage so it can be used later. */
		localStorage.setItem('loadingSection', '<div class="modal-dialog modal-dialog-centered modal" role="document"><div class="modal-content"><div class="modal-body"><div class="container-fluid"><div class="row"><div class="form-group col-12"><div class="d-flex justify-content-center loading align-items-center"><div class="spinner-border" role="status" style="width: 4rem; height: 4rem;"><span class="sr-only">Loading...</span></div></div></div></div></div></div></div></div>');

		/** 
		 * Store alert display in 3 joints. 
		 * Beetween 1st and 2nd is the alert color from bootstrap e.g. alert-success, alert-warning 
		 *   (Leave blank if you want to see white background)
		 * Beetween 2nd and 3rd is the alert title e.g. 'Success!', 'Something Wrong!'
		 * Beetween 3rd and 4th is the alert body. e.g. 'New directory successfully added.'
		 *   It's already wrapped on <p> tag with [margin-bottom = 0].
		 */
		localStorage.setItem('alertSection1', '<div class="modal-dialog modal-dialog-centered modal" role="document"><div class="modal-content"><div class="modal-body p-0"><div class="container-fluid"><div class="row"><div class="col-12 p-0"><div class="alert ');
		localStorage.setItem('alertSection2', ' alert-dismissible m-0 py-4" role="alert"><h4 class="alert-heading">');
		localStorage.setItem('alertSection3', '</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><hr><p class="mb-0">');
		localStorage.setItem('alertSection4', '</p></div></div></div></div></div></div></div>');

		/**
		 * Store delete confirmation modal in 3 joints.
		 * Between 1st and 2nd is the delete-title. It already contains "Delete ", 
		 *   so you only need to add the deletion type. E.g. "Account", "Folder".
		 * Between 2nd and 3rd is the entity name. E.g. [folder-name], [account-name]
		 * Between 3rd and 4th is the deletion type in the body. The format is like:
		 *  [
		 *     Are you sure want to delete <b>[Entity Name]</b> [body-deletion-type]?
		 *  ]
		 */
		localStorage.setItem('delModal1', '<div class="modal-dialog modal-dialog-centered modal-sm" role="document"><form class="modal-content bg_gray"><div class="modal-header bg_purple text-white"><div class="d-flex flex-row justify-content-center w-100"><div class="pl-4 mx-auto"><h3>Delete ');
		localStorage.setItem('delModal2', '</h3></div><div><button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div></div><div class="modal-body"><div class="container-fluid"><div class="row"><div class="col-12"><p>Are you sure want to delete <b>');
		localStorage.setItem('delModal3', '</b> ');
		localStorage.setItem('delModal4', '?</p></div></div></div></div><div class="modal-footer"><input type="button" class="btn btn-danger text-white shadow" id="delYes" value="Yes"/><input type="submit" class="d-none" value="Save"/><button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cancel</button></div></form></div>');

		/* Start of Tooltip, Modal and Popover global configuration. */
		/** Enable tooltip for floating button */
		 $('[data-tooltip="tooltip"]').tooltip();

		 /** Enable tooltip for data-toggle  */
		 $(document).on('mouseenter', '[data-toggle="tooltip"]', function(){
		 	$(this).tooltip('show');
		 });
		 $(document).on('mouseleave', '[data-toggle="tooltip"]', function(){
		 	$(this).tooltip('hide');
		 });

		 /* Bug fixing, modal sometimes can't be closed. */
		 $(document).on('click', '[data-dismiss="modal"]', function(){
		 	$(this).closest('.modal .fade').modal('hide');
		 });
		 /* End of Tooltip, Modal and Popover global configuration. */

		/** Fade in and fade out folder option button. */
		$('#accContainer').on('mouseenter', '.folderName', function(){
			if ($(window).width()>=992) {
				$(this).children('#folderOption').removeClass('d-lg-none').hide();
				$(this).children('#folderOption').fadeIn(100);
			}
		}).on('mouseleave', '.folderName', function(){
			if ($(window).width()>=992) {
				$(this).children('#folderOption').fadeOut(100).queue(function(next){
					$(this).show().addClass('d-lg-none');
					next();
				});
			}
		});

		/** Mouseover data account row. */
		$('#accContainer').on('mouseenter', '.dataItem', function(){
			$(this).addClass("bg_grayer")
		}).on('mouseleave', '.dataItem', function(){
			$(this).removeClass("bg_grayer")
		});

		/** Change directory caret-icon based on collapsing status */
		$('#accContainer').on('hide.bs.collapse', '.collapse.multi-collapse', function(){
			$(this).siblings('.folderName').find('a h4 i').removeClass('fa-caret-down');
			$(this).siblings('.folderName').find('a h4 i').addClass('fa-caret-right');
		}).on('show.bs.collapse', '.collapse.multi-collapse', function(){
			$(this).siblings('.folderName').find('a h4 i').removeClass('fa-caret-right');
			$(this).siblings('.folderName').find('a h4 i').addClass('fa-caret-down');
		});

		/** Show and hide floating button child */
		$('#plus_btn_main').click(function(){
			$('#plus_btn_child').toggleClass('d-none');
		});
		/** Hide floating button child when the child itself clicked */
		$('.plus_btn_items').click(function(){
			$('#plus_btn_child').addClass('d-none');
		});

		/* Handler for plus button child and exception for generate random password button */
		$('.plus_btn_items').click(function(){
			if(!($(this).hasClass('rndPass'))){
				$('#modalUti').html(localStorage.getItem('loadingSection'));

				var modalType = $(this).data('modalType');
				var urlSite = '<?php echo site_url('api/modal'); ?>/' + modalType;
				$.ajax({
					url: urlSite,
					method: "GET",
					dataType: 'html',
					success: function(r){
						$('#modalUti').html(r);
					}
				});
			}
		});

		$(document).on('click', '.rndPass', function(){
			$('#modalRndPass').modal('show');
			$('#rndButton').click();
		});
		
		/* Display change password form in modal. */
		$('#chPass').click(function(){
			var localObj = $(this);
			
			localObj.data('toggle', 'modal').data('target', '#modalUti');
			$('#modalUti').html(localStorage.getItem('loadingSection')).modal('show');

			$.ajax({
				url: '<?php echo site_url('api/changePass'); ?>/',
				method: "GET",
				dataType: 'html',
				success: function(r){
					$('#modalUti').html(r);
				}
			});
		});

		/** Copy Username */
		$('#accContainer').on('click', '.cpyUsername', function(){
			var cpy = $(this).closest('.dataItem').find('.userTarget').html();
			if(cpy){
				new ClipboardJS('.cpyUsername', {
					text: function() {
						return cpy;
					}
				});
				$('#notifToastBody').html('Username copied!');
			}else{
				new ClipboardJS('.cpyUsername', {
					text: function() {
						return " ";
					}
				});
				$('#notifToastBody').html('There is no username!');
			}
			$('#notifToast').toast('show');
		});

		/** 
		 * Copying password with ajax handler. 
		 * It will show the loading toast until the ajax finished.
		 */
		$('#accContainer').on('click', '.cpyPass', function(){
			var localObj = $(this);
			var dataAcc = localObj.parent().data('acc');

			$('#notifToastBody').html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div><div class="px-2">Loading...</div>');
			$('#notifToast').toast({
				autohide: false
			}).toast('show');

			$.when($.ajax({
				url: '<?php echo site_url('api/getPass'); ?>/' + dataAcc,
				method: 'GET',
				dataType: 'text'
			})).done(function(r){
				if(r){
					new ClipboardJS('#cpyHandler', {
						text: function() {
							return r;
						}
					});
					$('#notifToastBody').html('Password copied!');
				}else{
					new ClipboardJS('#cpyHandler', {
						text: function() {
							return " ";
						}
					});
					$('#notifToastBody').html('There is no password!');
				}
				$('#cpyHandler').click();
				$('#notifToast').toast({autohide: true});
				setTimeout(function(){
					$('#notifToast').toast('hide');
				}, 700);
			});
		});

		/** Triggering modal for edit account */
		$('#accContainer').on('click', '.edtAcc', function(){
			var localObj = $(this);
			var dataAcc = localObj.parent().data('acc');
			var urlSite = '<?php echo site_url('api/updateAccount'); ?>/' + dataAcc;
			
			localObj.data('toggle', 'modal').data('target', '#modalUti');
			$('#modalUti').html(localStorage.getItem('loadingSection')).modal('show');

			$.ajax({
				url: urlSite,
				method: "GET",
				dataType: 'html',
				success: function(r){
					$('#modalUti').html(r);
				}
			});
		});

		/**
		 * Trigger modal for delete confirmation.
		 * If the user choose to delete then does the account deletion.
		 */
		$('#accContainer').on('click', '.delAcc', function(){
			var localObj = $(this);
			var dataAcc = localObj.closest('.dataItem').find('.dropdown-menu').data('acc');
			var accName = localObj.closest('.dataItem').find('.userTarget').prev().find('big').html();

			localObj.data('toggle', 'modal').data('target', '#modalUti');
			$('#modalUti').html(
				localStorage.getItem('delModal1') +
				'Account' +
				localStorage.getItem('delModal2') +
				accName +
				localStorage.getItem('delModal3') +
				'account' +
				localStorage.getItem('delModal4')
			).modal('show');

			$('#delYes').click(function(){
				$('#modalUti').html(localStorage.getItem('loadingSection'));
				$.ajax({
					url: '<?php echo site_url('api/deleteAccount'); ?>/' + dataAcc,
					method: "GET",
					success: function(asd){
						modalUtiWithTimer('alert-success', 'Delete Success!', 'Your <b>' + accName + '</b> account successfully deleted!',2000);
					},
					error: function(err){
						modalUtiWithTimer('alert-warning', err.status + ': ' + err.statusText,'Oops, something is wrong. Try again later, but make sure to check your input field before resubmitting your data.',2000);
					},
					complete: function(){
						$('#loadData').click();
					}
				});
			})
		});

		/** Triggering modal for edit directory */
		$('#accContainer').on('click', '.edtDir', function(){
			var localObj = $(this);
			var dataDir = localObj.parent().data('dir');
			
			localObj.data('toggle', 'modal').data('target', '#modalUti');
			$('#modalUti').html(localStorage.getItem('loadingSection')).modal('show');

			$.ajax({
				url: '<?php echo site_url('api/updateDirectory'); ?>/' + dataDir,
				method: "GET",
				dataType: 'html',
				success: function(r){
					$('#modalUti').html(r);
				}
			});
		});

		/**
		 * Trigger modal for delete confirmation.
		 * If the user choose to delete then does the folder deletion.
		 */
		$('#accContainer').on('click', '.delDir', function(){
			var localObj = $(this);
			var dataDir = localObj.parent().data('dir');
			var dirName = localObj.closest('.folderName').find('.text_wrap').html();

			localObj.data('toggle', 'modal').data('target', '#modalUti');
			$('#modalUti').html(
				localStorage.getItem('delModal1') +
				'Folder' +
				localStorage.getItem('delModal2') +
				dirName +
				localStorage.getItem('delModal3') +
				'folder' +
				localStorage.getItem('delModal4')
			).modal('show');

			$('#delYes').click(function(){
				$('#modalUti').html(localStorage.getItem('loadingSection'));
				$.ajax({
					url: '<?php echo site_url('api/deleteDirectory'); ?>/' + dataDir,
					method: "GET",
					success: function(){
						modalUtiWithTimer('alert-success', 'Delete Success!', 'Folder <b>' + dirName + '</b> successfully deleted!',2000);
					},
					error: function(err){
						modalUtiWithTimer('alert-warning', err.status + ': ' + err.statusText,'Oops, something is wrong. Try again later, but make sure to check your input field before resubmitting your data.',2000);
					},
					complete: function(){
						$('#loadData').click();
					}
				});
			})
		});

		/** Start of Search function. */
		/** Search label button toggler between search icon and X icon. */
		function searchBtn(cont = true){
			if(cont){
				$('#bSearchAccount').removeClass('bg-light')
					.addClass('bg-danger text-white')
				.html('<i class="fas fa-times"></i>');
			}else{
				$('#bSearchAccount').removeClass('bg-danger text-white')
					.addClass('bg-light')
				.html('<i class="fas fa-search"></i>');
			}
		}

		/**
		 * Handler if the user hit the X icon then 
		 *   it will empty the search box and all the data will show up.
		 */
		$('#bSearchAccount').click(function(){
			if($(this).html() == '<i class="fas fa-times"></i>'){
				searchBtn(false);
				$('#searchAccount').val('');
				$('.folderName').each(function(){
					var localDir = $(this);

					localDir.parent().removeClass('d-none');
					localDir.next().find('.dataItem').each(function(){
						$(this).removeClass('d-none').addClass('d-flex');
					});
				});
			}
		});

		/**
		 * Handler for searching the the data that consists of 
		 *   [Folder Name], [Account Name] and [Username].
		 * It works by hiding the unmatched result and 
		 *   removing the [display: none] from the matched result.
		 */
		$('#searchAccount').on('keyup', function(){
			var keyWord = $(this).val().toLowerCase();

			if(keyWord != ""){
				searchBtn();
			}else{
				searchBtn(false);
			}

			$('.folderName').each(function(){
				var localDir = $(this);
				var localDirName = localDir.find('a h4.text_wrap').html();

				/** 
				 * If the search keyword matched with [Directory Name]
				 *   don't hide or unhide the entire directory. 
				 */
				if(localDirName.toLowerCase().includes(keyWord)){
					localDir.parent().removeClass('d-none');
					localDir.next().find('.dataItem').each(function(){
						$(this).removeClass('d-none').addClass('d-flex');
					});
				}else{
					/* i=> Not found account counter. */
					var i = 0;
					var totalAcc = localDir.next().find('.dataItem').length;

					localDir.next().find('.dataItem').each(function(){
						var localAcc = $(this);
						var localAccName = localAcc.find('.userTarget').prev().find('big').html();
						var localAccUsername = localAcc.find('.userTarget').html();
						
						if(localAccName.toLowerCase().includes(keyWord) || localAccUsername.toLowerCase().includes(keyWord)){
							localAcc.removeClass('d-none').addClass('d-flex');
						}else{
							localAcc.addClass('d-none').removeClass('d-flex');
							i++;
						}
					});

					/**
					 * If the amount of not found accounts as much as the 
					 *   amount of account that directory has then hide entire directory.
					 * Otherwise don't hide entire directory because there are found account 
					 *   at the search list.
					 */
					if(i >= totalAcc){
						localDir.parent().addClass('d-none');
					}else{
						localDir.parent().removeClass('d-none');
					}
				}
			});
		});
		/** End of Search function. */

		$('#accContainer').on('click', '#chkAcc', function(){

		});