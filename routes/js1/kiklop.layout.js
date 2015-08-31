var kiklopPanelContainer = null;
var kiklopPanelForDragIndex = null;
var kiklopPanelForDrag = null;
var kiklopLayoutOptions = null;
var kiklopPanelTolerance = 0
var kiklopStartY = 0;
var kiklopPanelCount = 0;



(function($){
    $.fn.extend({
        
        //pass the options variable to the function
        kiklopLayout: function(options) {
                    
            var defaults = {
                orientation: 'Horizontal',
                tolerance: 0, 
                onHide: function(){},
                onShow: function(){},
                onInit: function(){}                
            }
            
            var options = $.extend(defaults, options);
	        return this.each(function() {	    
	        		kiklopLayoutOptions = options         
	        		var deca = $(this).children()
	        		kiklopPanelCount = deca.length 
					kiklopPanelTolerance = options.tolerance
					kiklopPanelContainer = this
	        		for (var i=0; i<deca.length; i++){
	        			deca[i].setAttribute('id', 'kiklop-panel-'+i)
	        			var pnlH = parseFloat(kiklopGetCookie('pnl-'+i+'-hg'))
	        			if (pnlH<options.tolerance){pnlH=options.tolerance}
	        			var pnlV = kiklopGetCookie('pnl-'+i+'-vsb')
	        			var pnlVisible = 'block'
	        			if (pnlV=='false'){pnlVisible='none'}
	        			$(deca[i]).css({minHeight:options.tolerance+'px', height: pnlH+'px', display:pnlVisible})	        	        		
	        			var elspl = document.createElement('span')
	        			
	        			elspl.setAttribute('id', 'kiklop-splitter-'+i)
	        			if (options.orientation=='Horizontal'){
	        				$(elspl).addClass('kiklop-splitter-horizontal')	
	        			} else {
	        				$(elspl).addClass('kiklop-splitter-vertical')
	        			}	        			
	        			$(elspl).css({display:pnlVisible})
	        			$(elspl).insertAfter($(deca[i]))
	        			
	        			elspl.addEventListener('mousedown', kiklopInitDrag, false);
	        		}
	        		kiklopSetLastVisiblePanelHeight()
	        		$(window).resize(function() {
						kiklopSetLastVisiblePanelHeight()
					});
					kiklopLayoutOptions.onInit()	
	        		
	        });
	    }
    });
    
})(jQuery);

function kiklopGetPanelsHeight(){
	var sumOfVisiblePanels = 0;
	for (var i=0; i<=kiklopPanelCount; i++){
		if ($('#kiklop-panel-'+i).is(":visible")){				
			sumOfVisiblePanels = sumOfVisiblePanels + document.getElementById('kiklop-panel-'+i).offsetHeight+7
		}
	}
	return sumOfVisiblePanels
}
function kiklopSavePanelStates(){
	for (var i=0; i<kiklopPanelCount; i++){
		var vsb = $('#kiklop-panel-'+i).is(":visible")
		var hg = document.getElementById('kiklop-panel-'+i).offsetHeight
		kiklopSetCookie('pnl-'+i+'-vsb',vsb+'', 14)
		kiklopSetCookie('pnl-'+i+'-hg',hg+'', 14)		
	}
}
function kiklopSetLastVisiblePanelHeight(){	
	var maxHeight = kiklopPanelContainer.offsetHeight
	var sumOfVisiblePanels = kiklopGetPanelsHeight();
	var lastVisibleIndex = 0
	
	for (var i=kiklopPanelCount-1; i>=0; i--){		
		if ($('#kiklop-panel-'+i).is(":visible")){
			var pnlHeight = document.getElementById('kiklop-panel-'+i).offsetHeight			
			if (pnlHeight>=40){				
				var _newHeight = maxHeight-sumOfVisiblePanels + document.getElementById('kiklop-panel-'+i).offsetHeight
				
				if (_newHeight>=40){
					$('#kiklop-panel-'+i).css({height: _newHeight+'px'})
					kiklopSavePanelStates()
					return					
				} else {
					$('#kiklop-panel-'+i).css({height: 40 + 'px'})
					sumOfVisiblePanels = kiklopGetPanelsHeight();
				}				
			}
		}
	}	
	
}
function kiklopHidePanel(_index){
	$('#kiklop-panel-'+_index).fadeOut(200, function(){
		kiklopSetLastVisiblePanelHeight()	
	})
	$('#kiklop-splitter-'+_index).fadeOut(200)
	kiklopLayoutOptions.onHide(_index)	
}
function kiklopShowPanel(_index){
		
	$('#kiklop-panel-'+_index).fadeIn(200, function(){
		kiklopSetLastVisiblePanelHeight()	
	})
	$('#kiklop-splitter-'+_index).fadeIn(200)	
	kiklopLayoutOptions.onShow(_index)
}

function kiklopInitDrag(e) {	
	kiklopPanelForDragIndex = parseInt(e.currentTarget.id.replace("kiklop-splitter-",""))
	kiklopPanelForDrag = document.getElementById("kiklop-panel-"+kiklopPanelForDragIndex)
	kiklopStartY = e.clientY     
	document.documentElement.addEventListener('mousemove', kiklopDoDrag, false);
	document.documentElement.addEventListener('mouseup', kiklopStopDrag, false);	   	   
}

function kiklopDoDrag(e) {   
	var _delta = e.clientY - kiklopStartY;
	var pnlHeight =kiklopPanelForDrag.offsetHeight + _delta
	if ((pnlHeight<kiklopPanelTolerance) && (_delta<0)) {pnlHeight=kiklopPanelTolerance}
	//SET PANEL HEIGHT
	$(kiklopPanelForDrag).css({height:pnlHeight+'px'})
	kiklopSetLastVisiblePanelHeight()	
	
	kiklopStartY = e.clientY
}

function kiklopStopDrag(e) {
    document.documentElement.removeEventListener('mousemove', kiklopDoDrag, false);    
    document.documentElement.removeEventListener('mouseup', kiklopStopDrag, false);
}