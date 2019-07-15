		lm = [];

		var lmJson = JSON.parse('<?php echo $last_modified; ?>');

		for(var key in lmJson){
			var lm = new Date(lmJson[key]);
			$("#lastMod"+key).removeClass('text-muted');
			$("#lastMod"+key).html(timeSince(lm)+" ago");
		}