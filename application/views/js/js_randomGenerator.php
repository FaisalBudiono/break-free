		/** Handler for #rngLeng value that can't more than 50 and can't a decimal. */
		function rndLengthChecker(){
			var maxLength = $('#rndLeng');
			maxLength.prop('type', 'number');

			if(maxLength.val() > 50){
				maxLength.popover({
					html: true,
					title: '<i class="fas fa-exclamation-triangle text-warning mr-2"></i>Max Length is 50',
					content: '50 characters is enough for a random password.',
					trigger: 'manual',
					placement: 'top'
				}).popover('show');
				maxLength.val('50');

				setTimeout(function(){
					maxLength.popover('dispose');
				}, 1300);
			}else{
				maxLength.val(Math.floor(maxLength.val()));
			}
		}

		/** Handler for everytime the #rndLeng change or the value changed with keyboard. */
		$('#rndLeng').on('change keyup', function(){
			rndLengthChecker();
		});

		/** Generate random text from the checked checkbox and show it on the input text. */
		$('#rndButton').click(function(){
			var possRandom = '';
			var text = ''
			var maxLength = $('#rndLeng');

			$('.opRnd:checked').each(function(){
				var localOp = $(this).prop('id');
				if(localOp == 'opLow'){
					possRandom += 'abcdefghijklmnopqrstuvwxyz';
				}else if(localOp == 'opUpp'){
					possRandom += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				}else if(localOp == 'opNum'){
					possRandom += '0123456789';
				}else if(localOp == 'opSym'){
					possRandom += '!@#$%^&*_+-=';
				}
			});

			if(possRandom === ''){
				text = ' ';
			}else{
				rndLengthChecker();
				for(var i = 0; i < maxLength.val(); i++)
					text += possRandom.charAt(Math.floor(Math.random() * possRandom.length));
			}
			$('#rndPass').val(text);
		});

		/** Copying the random generated password. */
		$('#rndCopy').click(function(){
			var cpy = $('#rndPass').val();
			if(cpy != ' '){
				$('#notifToastBody').html('Password copied!');
			}else{
				$('#notifToastBody').html('The password is empty!');
			}
			$('#rndPass').select();
			document.execCommand('copy');
			$('#notifToast').toast('show');
		});