
//go to subpage level
//switch color after scrolling
//append to the header at certain position
//-STILL WORK AFTER APPENDING TO THE HEADER!!!
//detach from header at certain position
//subpages colours
//make all nav buttons active
//try no masks on header navigation

function markActiveNavButton(sNavTarget){
	if(!$('.navigation[data-target="'+sNavTarget+'"]').hasClass('active')){
$('#substitute_title').html('')
$('.subpage').find('.title.hidden_title').removeClass('hidden_title')
		$('.navigation.active').removeClass('active').addClass('inactive')
		$('.navigation[data-target="'+sNavTarget+'"]').removeClass('inactive').addClass('active')
		//$('#content_wrapper').css({backgroundColor:$('.nav_button[data-target="'+sNavTarget+'"]').data('color')})

		$('#substitute_title').html($('.subpage[data-value='+sNavTarget+']').find('.title').html())
$('.subpage[data-value='+sNavTarget+']').find('.title').addClass('hidden_title')
	}
}

function disperseActiveNavButton(sNavTarget){
	return;
	if(!$('.navigation[data-target="'+sNavTarget+'"]').hasClass('dispersed')){
		$('.navigation.dispersed').removeClass('dispersed')
		$('.navigation[data-target="'+sNavTarget+'"]').addClass('dispersed')
	}
}

function getNavTarget(sNavTarget){
	var oBase = $('.navigation[data-target="'+sNavTarget+'"]').find('a')
	if(typeof oBase.data('target') != 'undefined'){
		return $(oBase.data('target'))
	}	
	
	return oBase
}

function scrollTo(oTarget, iBuffer){
	var iScrollValue = Number(oTarget.offset().top-($('#emblem_header').height()))

	if(typeof iBuffer != 'undefined'){
		iScrollValue += Number(iBuffer)
	}

	$('html, body').animate({
		scrollTop:	iScrollValue+'px'
	})

}

$(function(){
	$('.navigation>a').click(function(e){
		var oTarget = typeof $(this).data('target') != 'undefined' ? $($(this).data('target')) : $(this)

		scrollTo(oTarget)

		e.preventDefault();
	})
})





	$(document).scroll(function(e){
		window.ls = window.ls || 0
		window.aaa = window.aaa || null;
window.bbb = window.bbb || null;
window.ccc = window.ccc || {}



		    var iScroll = Number($(window).scrollTop());
		    direction = "bottom"

if(iScroll > window.ls){
	direction = "bottom"
}
else{
	direction = "top"
}

window.ls = iScroll;

				var iNavPos = $('#header_wrapper').find('.nav_wrapper').offset().top

/*				if(iNavPos-50 <= iScroll){
					$('#emblem_header').find('.nav_wrapper').show().css({'opacity':1})
					$('#container_wrapper').find('.nav_wrapper').css({'opacity':0})
				}
				
				else if(iNavPos-40 >= iScroll){
					$('#emblem_header').find('.nav_wrapper').css({'opacity':0}).hide()
					$('#container_wrapper').find('.nav_wrapper').css({'opacity':1})
				}*/

				$('.subpage').each(function(key, val){
					if(getNavTarget($(val).data('value')).offset().top-110 <= iScroll){
						markActiveNavButton($(val).data('value'))
						
					}

if(getNavTarget($(val).data('value')).offset().top-310 <= iScroll){
						if(window.aaa != $(val).data('value')){
							window.aaa = $(val).data('value')
							window.bbb = $(val).find('.header_backgorund')
							var ddd = window.bbb.css('background-position');
							ddd = ddd.split(' ')
							window.ccc[window.aaa] = parseInt(ddd[1], 10)
						}

						
					}

				})




				if(direction=="bottom"){
					if(window.ccc[window.aaa]>((1200-parseInt(window.bbb.height(), 10))*-1)-20){
window.ccc[window.aaa] = window.ccc[window.aaa]-5
					}
				}
				else{
					if(window.ccc[window.aaa]<20){
						window.ccc[window.aaa] = window.ccc[window.aaa]+5
					}
				}

							
						window.bbb.css("background-position", "50% "+window.ccc[window.aaa]+"px")
	});





