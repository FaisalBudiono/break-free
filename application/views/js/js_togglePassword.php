		/* Toggle password visibity. */
		$('.password_toggle').click(function(){
			if($(this).children().prop('class')=="fas fa-eye-slash"){
				$(this).parent().siblings().prop('type','text');
				$(this).children().prop('class', 'fas fa-eye text_purple');
			}else{
				$(this).parent().siblings().prop('type','password');
				$(this).children().prop('class', 'fas fa-eye-slash');
			}
		});