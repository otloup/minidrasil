function hideDialog(sOption){
	if(typeof sOption != 'undefined'){
		var oTarget = $('.overlay_wrapper[data-option="'+sOption+'"]')
	}
	else{
		oTarget = $('.overlay_wrapper')
	}
	
	$('#overlay_background').hide()
}

function showDialog(sOption){
	if(typeof sOption == 'undefined'){
		return false
	}

	$('.overlay_wrapper').removeClass('visible').addClass('hidden')
	$('#overlay_background').show()
	$('.overlay_wrapper[data-option="'+sOption+'"]').removeClass('hidden').addClass('visible')
}

function manageDialog(sOption, sCallback){
	switch(sOption){
		case 'close':
			hideDialog()

			if(typeof sCallback != 'undefined'){
				sCallback = sCallback.split(':')

				switch(sCallback[0]){
					case 'link':
						window.location = sCallback[1]
					break;


				}
			}
		break;

		default:
			showDialog(sOption)
		break;
	}
}
