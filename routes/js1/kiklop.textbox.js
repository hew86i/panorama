(function( $ ){

    var methods = {
    	Pero: '', 
        init : function(options) {
			$(this).addClass("kiklop-textbox")
        	$(this).addClass("kiklop-corner")
        	Pero = 'Goran';
        	window[$(this).attr("id")+'Enable']=true
        },
        value : function(_value) {
        	if (_value==null){
        		return this.val()	
        	}  else {
        		this.val(_value)
        		return _value
        	}
        },
        Enable: function(_value){
        	window[$(this).attr("id")+'Enable']=_value
        	if (_value==true){
        		$(this).css({opacity:1})
        		$(this).removeAttr("disabled"); 
        	}else{
        		$(this).css({opacity:0.4})
        		$(this).attr("disabled", "disabled"); 
        	}
        }
    };

    $.fn.kiklopTextbox = function(methodOrOptions) {
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