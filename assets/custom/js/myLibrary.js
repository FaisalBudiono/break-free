/**
 * Function for comparing the original time and the current time
 * then returning the value of years, months, days, hours, minutes or seconds.
 */
function timeSince(date) {
	var seconds = Math.floor((new Date() - date) / 1000);
	if(seconds<0){
		return "a second";
	}

	var interval = Math.floor(seconds / 31536000);
	if (interval > 1) {
		return interval + " years";
	}else if (interval == 1) {
		return interval + " year";
	}
	interval = Math.floor(seconds / 2592000);
	if (interval > 1) {
		return interval + " months";
	}else if (interval == 1) {
		return interval + " month";
	}
	interval = Math.floor(seconds / 86400);
	if (interval > 1) {
		return interval + " days";
	}else if (interval == 1) {
		return interval + " day";
	}
	interval = Math.floor(seconds / 3600);
	if (interval > 1) {
		return interval + " hours";
	}else if (interval == 1) {
		return interval + " hour";
	}
	interval = Math.floor(seconds / 60);
	if (interval > 1) {
		return interval + " minutes";
	}else if (interval == 1) {
		return interval + " minute";
	}
	return Math.floor(seconds) + " seconds";
}

/** Contain alert modal and modal auto close function.  */
function modalUtiWithTimer(alertStyle, title, messages, time){
	$('#modalUti').html(
		localStorage.getItem('alertSection1') + 
		alertStyle + 
		localStorage.getItem('alertSection2') + 
		title + 
		localStorage.getItem('alertSection3') + 
		messages + 
		localStorage.getItem('alertSection4')
		);
	setTimeout(function(){
		$('#modalUti').find('[data-dismiss="modal"]').click();
	}, time);
}