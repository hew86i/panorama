(function( $ ){

    var methods = {   	
        init : function(options) {
        	var defaults = {
                colors: ["00afd1", "f27935", "8db3e2", "d0c974", "e2a293", "548dd4", "a29a36", "f6c781", "cba092", "d4735e", "746153", "FFCC33", "3A4C8B", "FB455F"],
                selectedIndex :0                
            }
            options = $.extend(defaults, options);
        	window[$(this).attr("id")+'-colors'] = options.colors
        	window[$(this).attr("id")+'-selectedIndex'] = options.selectedIndex
        	
			$(this).addClass("kiklop-colorbox")
        	$(this).addClass("kiklop-corner")
        	$(this).css({padding:'0'})
        	$(this).html('&nbsp;')
        	var ColorList = '';
        	var _width = $(this).width()/options.colors.length
        	
			for (var i=0; i<options.colors.length; i++){
				if (i==options.selectedIndex){
					//ColorList = ColorList + '<span class="kiklop-shadow" style="display:block; height:100%; float:left; background-color:#'+options.colors[i]+'; width:'+_width+'px"></span>';
					ColorList = ColorList + '<span class="cornerBig kiklop-color-item" style="background-color:#'+options.colors[i]+'"><span  class="kiklop-icon20 k-check20 kiklop-check-icon" ></span></span>';	
				} else {
					ColorList = ColorList + '<span class="cornerBig kiklop-color-item" style="background-color:#'+options.colors[i]+'"><span onclick="$(\'#'+$(this).attr("id")+'\').kiklopColorbox(\'selectColor\', '+i+')" class="cornerBig kiklop-color-item-small"></span></span>';
				}
				
			}        	
        	$(this).html(ColorList)
        	      	       	
        },              
        value : function(_value) {
        	_id = $(this).attr("id")
        	var  clr =  window[_id+'-colors'] 
        	if (_value==null){        		
        		return clr[window[_id+'-selectedIndex']]
        	} else {
				var _idx = 0        		
        		for (var i=0; i<clr.length; i++){
        			if (clr[i]==_value){
        				_idx =i;
        			}
        		}
        		$('#'+_id).kiklopColorbox("selectColor",_idx)
        	}       	
        },
        selectColor : function(_index) {
        	_id = $(this).attr("id")
        	var  clr =  window[$(this).attr("id")+'-colors']
        	window[$(this).attr("id")+'-selectedIndex'] = _index
			var ColorList = '';
			for (var i=0; i<clr.length; i++){
				if (i==_index){					
					ColorList = ColorList + '<span class="cornerBig kiklop-color-item" style="background-color:#'+clr[i]+'"><span  class="kiklop-icon20 k-check20 kiklop-check-icon"></span></span>';	
				} else {
					ColorList = ColorList + '<span class="cornerBig kiklop-color-item" style="background-color:#'+clr[i]+'"><span onclick="$(\'#'+$(this).attr("id")+'\').kiklopColorbox(\'selectColor\', '+i+')" class="cornerBig kiklop-color-item-small"></span></span>';
				}
				
			}
			$(this).html(ColorList)
        }
        
    };

    $.fn.kiklopColorbox = function(methodOrOptions) {
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


