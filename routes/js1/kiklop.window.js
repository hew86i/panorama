var kiklopWindowOnCloseEvent = function(){}

function kiklopInjectWindow(){
	var el = document.createElement('div')
	$(el).addClass('kiklop-windowBackground')
	
	el.setAttribute("id", 'kiklop-window-background')
	$(el).css({display:'none'})
	document.body.appendChild(el)
	
	var elw = document.createElement('div')
	$(elw).addClass('kiklop-window')
	$(elw).addClass('kiklop-shadow')
	$(elw).addClass('kiklop-cornerBig')
	elw.setAttribute("id", 'kiklop-window')
	$(elw).css({display:'none'})
	document.body.appendChild(elw)
	$(elw).html('<div class="kiklop-window-caption kiklo-cornerUpBig"></div><div class="kiklop-window-body"></div>')
	
	
	$(el).click(function(e) {
		//$.kiklopWindowClose()		
	})
}

jQuery.kiklopWindow = function(options) {
	if (options.onClose==null){
		kiklopWindowOnCloseEvent = function(){}
	} else {
		kiklopWindowOnCloseEvent = options.onClose
	}
	$('.kiklop-window-body').html('&nbsp;')
	
    var _left =(document.body.clientWidth - options.width)/2
   	var _top = (document.body.scrollHeight - options.height) / 2
   	if (options.caption==null){options.caption='&nbsp'}
   	$('#kiklop-window').css({width:options.width+'px', height:options.height+'px', left: _left+'px', top: _top+'px'})
   	$('#kiklop-window').fadeIn('slow')
   	if (options.modal==null){options.modal=false}
   	if (options.modal==true){
	   	$('#kiklop-window-background').css({width:document.body.clientWidth+'px', height:document.body.scrollHeight+'px'})
	   	$('#kiklop-window-background').fadeIn('slow')	
   	}   	
   	$('.kiklop-window-caption').html('&nbsp;&nbsp;&nbsp;'+options.caption+'<span onclick="$.kiklopWindowClose()	" class="kiklop-icon k-close kiklop-wnd-close"></span>')
   	if (options.content!=null){   			
		$('.kiklop-window-body').html(options.content)		
	}
   	if (options.page!=null){
   		if (options.page!=''){	
			$('.kiklop-window-body').load(options.page)
		}
	}
	
	
}
jQuery.kiklopWindowClose = function() {
	$('#kiklop-window').fadeOut(300, function(){
		kiklopWindowOnCloseEvent();
	})
	$('#kiklop-window-background').fadeOut(300)
	
}

var kiklopWindowOnCloseEvent1 = function(){}

function kiklopInjectWindow1(){
	var el = document.createElement('div')
	$(el).addClass('kiklop-windowBackground')
	
	el.setAttribute("id", 'kiklop-window-background1')
	$(el).css({display:'none'})
	document.body.appendChild(el)
	
	var elw = document.createElement('div')
	$(elw).addClass('kiklop-window')
	$(elw).addClass('kiklop-shadow')
	$(elw).addClass('kiklop-cornerBig')
	elw.setAttribute("id", 'kiklop-window1')
	$(elw).css({display:'none'})
	document.body.appendChild(elw)
	$(elw).html('<div class="kiklop-window-caption1 kiklo-cornerUpBig"></div><div class="kiklop-window-body1"></div>')
	
	
	$(el).click(function(e) {
		//$.kiklopWindowClose()		
	})
}

jQuery.kiklopWindow1 = function(options) {
	if (options.onClose==null){
		kiklopWindowOnCloseEvent1 = function(){}
	} else {
		kiklopWindowOnCloseEvent1 = options.onClose
	}
	$('.kiklop-window-body1').html('&nbsp;')
	
    var _left =(document.body.clientWidth - options.width)/2
   	var _top = (document.body.scrollHeight - options.height) / 2
   	if (options.caption==null){options.caption='&nbsp'}
   	$('#kiklop-window1').css({width:options.width+'px', height:options.height+'px', left: _left+'px', top: _top+'px'})
   	$('#kiklop-window1').fadeIn('slow')
   	if (options.modal==null){options.modal=false}
   	if (options.modal==true){
	   	$('#kiklop-window-background1').css({width:document.body.clientWidth+'px', height:document.body.scrollHeight+'px'})
	   	$('#kiklop-window-background1').fadeIn('slow')	
   	}   	
   	$('.kiklop-window-caption1').html('&nbsp;&nbsp;&nbsp;'+options.caption+'<span onclick="$.kiklopWindowClose1()" class="kiklop-icon k-close kiklop-wnd-close"></span>')
   	if (options.content!=null){   			
		$('.kiklop-window-body1').html(options.content)		
	}
   	if (options.page!=null){
   		if (options.page!=''){	
			$('.kiklop-window-body1').load(options.page)
		}
	}
	
	
}

jQuery.kiklopWindowClose1 = function() {
	$('#kiklop-window1').fadeOut(300, function(){
		kiklopWindowOnCloseEvent1();
	})
	$('#kiklop-window-background1').fadeOut(300)
	
}
