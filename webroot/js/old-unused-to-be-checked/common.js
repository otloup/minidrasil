function empty(variable) {
    return (typeof variable == 'undefined' || variable == '' || variable === null)
}

function getTemplates(){
	$.ajax({
		dataType	: 'html'
		,type			:	'GET'
		,async		:	false
		,url			:	'/templates'
		,success	: function(result){
			$('body').append(result)
		}
	})	
}

function swap(){
	var aSwapable = $('.swapable')
	var aResult = []
	
	aSwapable.sort(function(){
		return Math.round(Math.random());
	});
	
	$.each(aSwapable, function(key, val){
		aResult.push({
			 data:	$(val).data('option')	
			,html:	$(val).html()
		})
	})

	$('.swapable').each(function(key, val){
		$(val).attr({'data-option':aResult[key].data})		
		$(val).data({'option':aResult[key].data})
		$(val).html(aResult[key].html)
	})
}

function loadTriggers(sTarget, oFrame, bReload){
	var sTarget = typeof sTarget == 'undefined' ? '[data-trigger]' : '[data-trigger="'+sTarget+'"]'
	var oReference = typeof oFrame == 'undefined' ? $('body') : oFrame

	if(bReload){
		oReference.find(sTarget).data({'trigger_loaded':undefined})
		console.log(oReference.find(sTarget).data('trigger_loaded'))
		oReference.find(sTarget).unbind('click')
		console.log(oReference.find(sTarget).click)
	}

	if(typeof oReference.find(sTarget).data('trigger_loaded') == 'undefined'){
		oReference.find(sTarget).click(function(){
			var sTrigger = $(this).data('trigger')
			var sOption = $(this).data('option')
			var sCallback = $(this).data('callback')
			
			switch(sTrigger){
				case 'dialog':
					manageDialog(sOption, sCallback)
				break;

				case 'edition':
					editionAction(sOption)
				break;

				case 'edition_toggle':
					toggleEdition(sOption)
				break;

				case 'cookie_close':
					closeCookie()
				break;
			}
		})

		oReference.find(sTarget).data({trigger_loaded:true})

		return oReference.find(sTarget).data('trigger_loaded')
	}
	else{
		return true
	}
}

function scaleHead(iMaxWidth, iModifier){
	iModifier = typeof iModifier == 'undefined' ? 0 : iModifier
		
	var iCurrentWidth = $(window).width()
	var iZoom = Number(iCurrentWidth / iMaxWidth) + iModifier

	$('#header_wrapper').css({zoom:iZoom})
}

function scaleMultiple(aList, iMaxWidth, iModifier){
	iModifier = typeof iModifier == 'undefined' ? 0 : iModifier
		
	var iCurrentWidth = $(window).width()
	var iZoom = Number(iCurrentWidth / iMaxWidth) + iModifier

	aList.css({zoom:iZoom})
}

function bindKeys(oConfig){
	$(window).keyup(function(e){
		if(typeof oConfig[e.which] != 'undefined'){
			$.each(oConfig[e.which], function(key, val){
				window[val]()
			})
		}
	})
}

function readHash(){
	window.hash = {
		s:'',
		a:[],
		o:{}
	}

    if(location.hash != ''){
        var sHash = location.hash.substr(1)
        var aHash = sHash.split('&')
        delete sHash
        $.each(aHash, function(key, val){
            var aValue = val.split('=')
						window.hash.o[aValue[0]] = aValue[1]
						window.hash.s += aValue[0]+','+aValue[1]+','
						window.hash.a.push(aValue[0])
						window.hash.a.push(aValue[0])
        })
    }
}

function readSearch(){
    window.search = {}

    if(location.search != ''){
        var aSearch = location.search.substr(1).split('&')
        $.each(aSearch, function(key, val){
            var aValue = val.split('=')
            window.search[aValue[0]] = aValue[1]
        })
    }
}

function hashFocus(){
	if(!empty(hash)){
		if(!empty(hash.scroll)){
			scrollTo($('#'+hash.a[0]), -50)
		}

		if(!empty(hash.slide)){
			aSlideParams = hash.o.slide.split(',')
			window[aSlideParams[0]+'_slider'].focusSlide(aSlideParams[1])	
		}
	}
}

function closeCookie(){
	$('#cookie_confirmation').hide()
	cookie.set('cookie_confirmation', true)
}
