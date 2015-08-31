
function kiklopInjectMenuWindow(){
		
	var elw = document.createElement('div')
	elw.setAttribute("id", 'kiklop-menu-container')
	$(elw).css({display:'none', border:'1px solid #00afd1'})
	document.body.appendChild(elw)
	
	var elsw = document.createElement('div')
	elsw.setAttribute("id", 'kiklop-menu-container-sub')
	$(elsw).css({display:'none', border:'1px solid #00afd1', overflow:'hidden'})
	document.body.appendChild(elsw)
	
	
	
	var mUp = document.createElement('div');
	mUp.setAttribute("id", 'kiklop-menu-container-up')
	$(mUp).css({display:'none'})
	$(mUp).addClass('kiklop-menu-up')
	
	document.body.appendChild(mUp)
}
(function( $ ){

    var methods = {   	
        init : function(options) {
    		var defaults = {
		        items:[], 
		        onClick: function(){},
		        beforeOpen: function(){}
		    }
			options = $.extend(defaults, options);
        	var position = $(this).offset();        	
			var _left = position.left
			var _top = position.top
			
			$('#kiklop-menu-container').addClass("kiklop-corner").addClass("kiklop-shadow")
			$('#kiklop-menu-container-sub').addClass("kiklop-corner").addClass("kiklop-shadow")
		   	$('#kiklop-menu-container').css({minWidth:'200px', minHeight:'20px', left: (_left-5)+'px', top: (_top+35)+'px'})
		   	$('#kiklop-menu-container-up').css({left: (_left+8)+'px', top: (_top+30)+'px', display:'none'})
		   	window[$(this).attr('id')+'-items']=options.items
		   	window[$(this).attr('id')+'-onclick']=options.onClick
		   	window[$(this).attr('id')+'-beforeOpen']=options.beforeOpen
		   	
        	
        	
        	$(this).click(function(e) {    
        		    		
        		if ( $('#kiklop-menu-container').is(":visible") ) {
				    $(e.currentTarget).kiklopMenu("CloseMenu")
				} else {					 
				     setTimeout('$("#'+e.currentTarget.id+'").kiklopMenu("OpenMenu")',200)
				}
				        		
        	})
        	
        	AddForClose($(this).attr("id"), 'Menu')
        	        	       	
        },
        ClickItem: function(_index){
        	//kiklopLayoutOptions.onShow(_index)
        	//alert('Go klikna: '+_index)
        	window[$(this).attr('id')+'-onclick'](_index)
        },
        CloseMenu: function(){
        	$('#kiklop-menu-container').fadeOut('fast')
        	$('#kiklop-menu-container-sub').fadeOut('fast')
        	$('#kiklop-menu-container-up').fadeOut('fast')
        },
        OpenMenu: function(){
        	
        	var position = $(this).offset();        	
			var _left = position.left
			var _top = position.top
			var wndWidth = $(window).width()
			
			
			//$('#kiklop-menu-container').css({minWidth:'200px', maxHeight:'290px', minHeight:'20px', left: (_left-5)+'px', top: (_top+35)+'px'})
			$('#kiklop-menu-container').css({minWidth:'200px', maxHeight:'323px', minHeight:'20px', left: (_left-5)+'px', top: (_top+35)+'px'})
		   	$('#kiklop-menu-container-up').css({left: (_left+8)+'px', top: (_top+30)+'px', display:'none'})
        	var itm = window[$(this).attr('id')+'-items']
        	window[$(this).attr('id')+'-beforeOpen'](itm)
        	//alert(itm)
        	var ListItems = '';
        	for (var i=0; i<itm.length; i++){        	
        		var spl = true;
        		if (itm[i].spliter==null){
        			spl=false
        		} else {
        			spl=itm[i].spliter
        		}	        	
        		var icn = '';
        		var onHover = '';
        		var onLeave = '';
        		if (itm[i].icon==null){itm[i].icon=''}
        		if (itm[i].icon!=''){
        			icn='<span class="kiklop-icon k-'+itm[i].icon+'-white k-middle-left-menu" onclick=""></span>'
        			onHover = 'onHoverMenuList(this, '+i+', \''+$(this).attr('id')+'\')'
        			onLeave = 'onHoverLeaveMenuList(this)'
        		}
        		
        		if (itm[i].visible==null){itm[i].visible=true}
        		if  (itm[i].visible==true){
        			var rarrow = '';
        			if (itm[i].items==null){itm[i].items=[]}
        			if (itm[i].items.length>0){
        				rarrow = '<span class="kiklop-icon k-right2 k-middle-right-first kiklop-more-right" style="margin-right: 10px;"></span>'
        			}
	        		if (spl==false){
	        			ListItems = ListItems + '<a onmousemove="'+onHover+'" onmouseout="'+onLeave+'" class="kiklop-list-item" onclick="kiklopClickMenu(\''+$(this).attr('id')+'\', \''+itm[i].value+'\')">'+icn+itm[i].text+rarrow+'<a>';	
	        		}	else {
	        			ListItems = ListItems + '<a onmousemove="'+onHover+'" onmouseout="'+onLeave+'" class="kiklop-list-item kiklop-list-item-spliter" onclick="kiklopClickMenu(\''+$(this).attr('id')+'\', \''+itm[i].value+'\')">'+icn+itm[i].text+rarrow+'<a>';
	        		}	
        		}
        			
        		
        	}
		   	$('#kiklop-menu-container').html(ListItems)
		   	if (_left+$('#kiklop-menu-container').width()>wndWidth){
		   		$('#kiklop-menu-container').css({left: (_left-$('#kiklop-menu-container').width()+30)+'px'})
		   	}
        	$('#kiklop-menu-container').fadeIn('fast')
        	$('#kiklop-menu-container-up').fadeIn('fast')
        }
        
    };

    $.fn.kiklopMenu = function(methodOrOptions) {
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
function onHoverMenuList(el, idx, elid){
	var icn = $(el).children()[0]
	if (icn==null){return}
	if (icn.className.indexOf("-white-hoverred")==-1) {
		icn.className = icn.className.replace("-white", "-white-hoverred")	     
	}
	if (idx==-1){return}
	var itm = window[elid+'-items']
	if (itm[idx].items.length==0){$('#kiklop-menu-container-sub').css({display:'none'})}
	var chList =true;
	if (itm[idx].checklist!=null){
		chList=itm[idx].checklist
	}
	if (itm[idx].items.length>0){		
			var position = $('#kiklop-menu-container').offset();   		
			var _left = position.left+$('#kiklop-menu-container').width()
			//var _top = position.top+$(el).offset().top
			var _top = $(el).offset().top
			
			$('#kiklop-menu-container-sub').css({position:'absolute', minWidth:'200px', minHeight:'20px', left: (_left)+'px', top: (_top)+'px'})
			
			if(itm[idx].checkIndex==null){itm[idx].checkIndex=0}
			
			ListItems = '';
			for (var i=0; i<itm[idx].items.length; i++){
				onHover = 'onHoverMenuList(this, -1, \''+elid+'\')'
        		onLeave = 'onHoverLeaveMenuList(this)'
        		icn2='';    
        		if (chList==true){
	        		if (itm[idx].checkIndex==i){        		
	        			icn2='<span class="kiklop-icon k-check2-white k-middle-left-menu" onclick=""></span>'
	        		}else{
	        			icn2='<span class="kiklop-icon k-nocheck2-white k-middle-left-menu" onclick=""></span>'
	        		}	
        		} 		
        		
				ListItems = ListItems + '<a onmousemove="'+onHover+'" onmouseout="'+onLeave+'" class="kiklop-list-item" onclick="kiklopSetSubmenuChecked(\''+elid+'\', '+idx+', '+i+'); kiklopClickMenu(\''+elid+'\', \''+itm[idx].items[i].value+'\')">'+icn2+itm[idx].items[i].text+'<a>';
			}
			$('#kiklop-menu-container-sub').html(ListItems)
        	var wndWidth = $(window).width()
        	
        	if (_left+$('#kiklop-menu-container-sub').width()>wndWidth){
        		$('#kiklop-menu-container-sub').css({left: (position.left-$('#kiklop-menu-container-sub').width())+'px'})
        	}
        	
        	$('#kiklop-menu-container-sub').css({display:'block'})
        	
	}
	
}
function onHoverLeaveMenuList(el){
	var icn = $(el).children()[0]
	if (icn!=null){
		if (icn.className.indexOf("-white-hoverred")>-1) {
			icn.className = icn.className.replace("-white-hoverred", "-white")	     
		}	
	}
	
}

function kiklopClickMenu(_id, _index){
	$('#'+_id).kiklopMenu("ClickItem",_index)	
}
function kiklopSetSubmenuChecked(elid, idx, sidx){
	var itm = window[elid+'-items']
	itm[idx].checkIndex=sidx
}
