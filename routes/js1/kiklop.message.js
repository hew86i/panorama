var kiklopMessageOnCloseEvent = function(){}

function kiklopInjectMessage(){
	var el = document.createElement('div')
	$(el).addClass('kiklop-windowBackground')
	
	el.setAttribute("id", 'kiklop-message-background')
	$(el).css({display:'none'})
	document.body.appendChild(el)
	
	var elw = document.createElement('div')
	$(elw).addClass('kiklop-window')
	$(elw).addClass('kiklop-shadow')
	$(elw).addClass('kiklop-cornerBig')
	elw.setAttribute("id", 'kiklop-message')
	$(elw).css({display:'none'})
	document.body.appendChild(elw)
	$(elw).html('<div  class="kiklop-message-caption"></div><div class="kiklop-message-body"></div>')
	
	
	$(el).click(function(e) {
		//$.kiklopMessageClose()		
	})
}

jQuery.kiklopMessage = function(options) {
	if (options.onClose==null){
		kiklopMessageOnCloseEvent = function(){}
	} else {
		kiklopMessageOnCloseEvent = options.onClose
	}
	
    var _left =(document.body.clientWidth - options.width)/2
   	var _top = (document.body.scrollHeight - options.height) / 2
   	if (options.caption==null){options.caption='&nbsp'}
   	$('#kiklop-message').css({width:options.width+'px', height:options.height+'px', left: _left+'px', top: _top+'px'})
   	$('#kiklop-message').fadeIn('slow')
   	if (options.modal==null){options.modal=false}
   	if (options.modal==true){
	   	$('#kiklop-message-background').css({width:document.body.clientWidth+'px', height:document.body.scrollHeight+'px'})
	   	$('#kiklop-message-background').fadeIn('slow')	
   	}   	
   	$('.kiklop-message-caption').html('&nbsp;&nbsp;&nbsp;'+options.caption)
   	if (options.content!=null){   			
		$('.kiklop-message-body').html(options.content)		
	}
   	if (options.page!=null){
   		if (options.page!=''){	
			$('.kiklop-message-body').load(options.page)
		}
	}
	
	
}

jQuery.kiklopMessageClose = function() {
	$('#kiklop-message').fadeOut(300, function(){
		kiklopMessageOnCloseEvent();
	})
	$('#kiklop-message-background').fadeOut(300)
	
}

var msgOnCloseEvent = function(){}
function kiklopMessage(_message, _caption, _buttonCloseCaption, _onClose){
	if (_onClose==null){
		msgOnCloseEvent = function(){}
	}else{
		msgOnCloseEvent = _onClose
	}
	var _ct =''
	_ct = _ct + '<span style="display:block; width:90%; margin-top:10px; margin-left:10px; font-size:14px">'+_message+'</span><button id="btn_msg_close" class="btn-message" onclick="$.kiklopMessageClose()">'+_buttonCloseCaption+'</button>'
		
	$.kiklopMessage({width:400, height:250, caption:_caption, content:_ct, modal:true,
		onClose: msgOnCloseEvent
	})
	$('#btn_msg_close').kiklopButton({})
	$('#btn_msg_close').focus();
}

function kiklopWindow2(_page, _caption, _width, _height, _onClose){
	if (_onClose==null){
		msgOnCloseEvent = function(){}
	}else{
		msgOnCloseEvent = _onClose
	}
		
	$.kiklopMessage({width:_width, height:_height, caption:_caption, page:_page, modal:false,
		onClose: msgOnCloseEvent
	})
}

var kiklopMessageOnCloseEvent1 = function(){}
var msgOnCloseEvent1 = function(){}
function kiklopInjectMessage1(){
	var el = document.createElement('div')
	$(el).addClass('kiklop-windowBackground')
	
	el.setAttribute("id", 'kiklop-message-background1')
	$(el).css({display:'none'})
	document.body.appendChild(el)
	
	var elw = document.createElement('div')
	$(elw).addClass('kiklop-window')
	$(elw).addClass('kiklop-shadow')
	$(elw).addClass('kiklop-cornerBig')
	elw.setAttribute("id", 'kiklop-message1')
	$(elw).css({display:'none'})
	document.body.appendChild(elw)
	$(elw).html('<div  class="kiklop-message-caption1"></div><div class="kiklop-message-body1"></div>')
	
	
	$(el).click(function(e) {
		//$.kiklopMessageClose()		
	})
}

jQuery.kiklopMessage1 = function(options) {
	if (options.onClose==null){
		kiklopMessageOnCloseEvent1 = function(){}
	} else {
		kiklopMessageOnCloseEvent1 = options.onClose
	}
	
    var _left =(document.body.clientWidth - options.width)/2
   	var _top = (document.body.scrollHeight - options.height) / 2
   	if (options.caption==null){options.caption='&nbsp'}
   	$('#kiklop-message1').css({width:options.width+'px', height:options.height+'px', left: _left+'px', top: _top+'px'})
   	$('#kiklop-message1').fadeIn('slow')
   	if (options.modal==null){options.modal=false}
   	if (options.modal==true){
	   	$('#kiklop-message-background1').css({width:document.body.clientWidth+'px', height:document.body.scrollHeight+'px'})
	   	$('#kiklop-message-background1').fadeIn('slow')	
   	}   	
   	$('.kiklop-message-caption1').html('&nbsp;&nbsp;&nbsp;'+options.caption)
   	if (options.content!=null){   			
		$('.kiklop-message-body1').html(options.content)		
	}
   	if (options.page!=null){
   		if (options.page!=''){	
			$('.kiklop-message-body1').load(options.page)
		}
	}
	
	
}

jQuery.kiklopMessageClose1 = function() {
	$('#kiklop-message1').fadeOut(300, function(){
		kiklopMessageOnCloseEvent1();
	})
	$('#kiklop-message-background1').fadeOut(300)
	
}

function kiklopMessage1(_message, _caption, _buttonCloseCaption, _onClose){
	if (_onClose==null){
		msgOnCloseEvent1 = function(){}
	}else{
		msgOnCloseEvent1 = _onClose
	}
	var _ct =''
	_ct = _ct + '<span style="display:block; width:90%; margin-top:10px; margin-left:10px; font-size:14px">'+_message+'</span><button id="btn_msg_close1" class="btn-message" onclick="$.kiklopMessageClose1()">'+_buttonCloseCaption+'</button>'
		
	$.kiklopMessage1({width:400, height:250, caption:_caption, content:_ct, modal:true,
		onClose: msgOnCloseEvent1
	})
	$('#btn_msg_close1').kiklopButton({})
	$('#btn_msg_close1').focus();
}
