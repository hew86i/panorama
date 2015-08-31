
(function($){
    $.fn.extend({
        
        //pass the options variable to the function
        kiklopButton: function(options) {
                    
            var defaults = {
                type: 'normal',
                wait: false
            }
              
            var options = $.extend(defaults, options);
	        return this.each(function() {	               
	        		var Caption = $(this).text() 
	        		$(this).html('')
	        		window[$(this).attr("id")+'-wait'] = options.wait
	        		window[$(this).attr("id")+'-click'] = false
	        		$(this).kiklopCreateHTMLElement({type:'span'})
	        		var inElement = $(this).children()[0]
	        		$(inElement).addClass("kiklop-in")
	        		$(inElement).html(Caption)
	        		//alert(options.type)
					if (options.type=='normal'){$(this).addClass("kiklop-button")}
					if (options.type=='close'){$(this).addClass("kiklop-buttonCancel")}
					if (options.type=='login'){$(this).addClass("kiklop-buttonLogin")}
					if (options.type=='delete'){$(this).addClass("kiklop-buttonDelete")}
					               
	                
	                $(this).addClass("kiklop-corner")
	                $(this).addClass("kiklop-button-color")
	                $(this).addClass("kiklop-shadow")
	                $(this).click(function(e) {	      
	              //  	alert(1)
	              		clk = window[e.currentTarget.id+'-click']
	              		if (clk==true){
	              			return false	
	              		} else {
	              			$(e.currentTarget).css({opacity:0.7})
							setTimeout("kiklopEnableButton('"+e.currentTarget.id+"')",1000)	
	              		}
	              		          	
						//$(e.currentTarget).attr('disabled','disabled');
						
					
					})
	        });
	    }
    });
    
})(jQuery);

function kiklopEnableButton(_btn_id){
	$('#'+_btn_id).removeAttr('disabled')
	$('#'+_btn_id).css({opacity:1})
	window[_btn_id+'-click']=false
}
