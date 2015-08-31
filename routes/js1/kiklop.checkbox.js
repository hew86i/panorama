(function( $ ){

    var methods = {   	
        init : function(options) {
        	var defaults = {                
                checked :false,   
                onChange: function(){}             
            }
            var caption = $(this).html()
            options = $.extend(defaults, options);
        	window[$(this).attr("id")+'-checked'] = options.checked
        	window[$(this).attr("id")+'-caption'] = caption
			window[$(this).attr("id")+'-onchange'] = options.onChange
			
        	        	
			$(this).addClass("kiklop-checkbox")
        	$(this).addClass("kiklop-corner")
        	$(this).css({padding:'0', cursor:'pointer'})
        	if (options.checked==true){
        		$(this).html('<span style="font-size:12px; position:relative; left:10px; top:10px; ">'+caption+'</span><span class="kiklop-icon k-check k-middle-right-first"></span>')	
        	} else {
        		$(this).html('<span style="font-size:12px; position:relative; left:10px; top:10px; ">'+caption+'</span><span class="kiklop-icon k-no-check k-middle-right-first"></span>')
        	}

  	       	$(this).click(function(e) {
  	       		$('#'+e.currentTarget.id).kiklopCheckbox('render')		        
  	       				
        	})
  	       	
        },         
        render: function(){
        	var chk = window[$(this).attr("id")+'-checked']
        	chk = ! chk
        	
        	caption = window[$(this).attr("id")+'-caption']
        	window[$(this).attr("id")+'-checked'] = chk
        	if (chk == true){
        		$(this).html('<span style="font-size:12px; position:relative; left:10px; top:10px; ">'+caption+'</span><span class="kiklop-icon k-check k-middle-right-first"></span>')	
        	} else {
        		$(this).html('<span style="font-size:12px; position:relative; left:10px; top:10px; ">'+caption+'</span><span class="kiklop-icon k-no-check k-middle-right-first"></span>')
        	}
        	window[$(this).attr("id")+'-onchange'](chk, $(this).attr("id"))
        },     
        value : function(_value) {
        	_id = $(this).attr("id")
        	var  chk =  window[_id+'-checked'] 
        	if (_value==null){        		
        		return chk;
        	} else {
				window[$(this).attr("id")+'-checked'] = _value
				caption = window[$(this).attr("id")+'-caption']
				if (_value == true){
	        		$(this).html('<span style="font-size:12px; position:relative; left:10px; top:10px; ">'+caption+'</span><span class="kiklop-icon k-check k-middle-right-first"></span>')	
	        	} else {
	        		$(this).html('<span style="font-size:12px; position:relative; left:10px; top:10px; ">'+caption+'</span><span class="kiklop-icon k-no-check k-middle-right-first"></span>')
	        	}
	        	window[$(this).attr("id")+'-onchange'](_value, $(this).attr("id"))
        	}       	
        }        
        
    };

    $.fn.kiklopCheckbox = function(methodOrOptions) {
        if ( methods[methodOrOptions] ) {
            return methods[ methodOrOptions ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof methodOrOptions === 'object' || ! methodOrOptions ) {
            // Default to "init"
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist !' );
        }    
    };


})( jQuery );


