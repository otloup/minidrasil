
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
	var iScrollValue = Number(oTarget.offset().top-($('#emblem_header').height()))+60

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


					active = "about"
pactive = "about";



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


				$('.subpage').each(function(key, val){
					if(getNavTarget($(val).data('value')).offset().top-110 <= iScroll){
						markActiveNavButton($(val).data('value'))
					}


					bg = {
					 'about'	:	'/img/tlo01.jpg'
					 ,'services' : '/img/tlo02.jpg'
					 ,'portfolio' : '/img/tlo03.jpg'
					 ,'pricing' : '/img/tlo04.jpg'
					}

					target = getNavTarget($(val).data('value'))
					tname = $(val).data('value')
					ttop = target.offset().top
					bottom = ttop + target.height()


					if(ttop <= iScroll && bottom >= iScroll){
						if(active == $(val).data('value')){
							if(typeof bg[active] != 'undefined'){
								$('#content_wrapper').css({
									'background-image':'url('+bg[active]+')'
								})

								target.css({
									'background-image':'none'
								})
							}
						}

						target = target.next()
						pactive = target.prev().data('value')
						active = target.data('value')

						if(direction == 'top' && typeof bg[pactive] != 'undefined'){
								$('#content_wrapper').css({
									'background-image':'url('+bg[pactive]+')'
								})					
						}

						if(typeof bg[active] != 'undefined'){

							var increment = direction == 'bottom' ? -15 : 15
							var ph = Math.abs(ttop - parseInt(target.height(), 10)) / 10 + increment
							
							target.css({
								'background-image' : 'url('+bg[active]+')'
								,'background-position' : '50% '+ph+'px'
							})
						}
					}
				})
	});





