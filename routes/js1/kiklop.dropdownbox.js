
(function( $ ){

    var methods = {   	
        init : function(options) {
        	var defaults = {
                type: 'normal',
                caption: '',
                onclick: '',
                onselect: function(){},
                click: function(){}
            }
            options = $.extend(defaults, options);
        	var position = $(this).offset();
        	var Dolu = true
        	var _left = position.left//getAbsoluteLeft(this)
        	var _top = position.top//getAbsoluteTop(this)
        	var _top_ = $(this).position().top

        	if (_top+300>document.body.scrollHeight){
        		Dolu=false
        		//_top = 	position.top-330
        	}
        	
        	if (options.onselect==null){
        		window[$(this).attr("id")+'-kiklopDD-onselect'] = function(){}	
        	} else {
        		window[$(this).attr("id")+'-kiklopDD-onselect'] = options.onselect
        	}
        	if (options.click==null){
        		window[$(this).attr("id")+'-kiklopDD-click'] = function(){}	
        	} else {
        		window[$(this).attr("id")+'-kiklopDD-click'] = options.click
        	}
        	
        	window[$(this).attr("id")+'-kiklopDD-Enable'] = true
        	
        	var _width = $(this).width()
        	var _currentcss = $(this).getStyleObject();
        	var newDDbox =  document.createElement('div')        	        	
			$(this).css({display:'none'})
			$(newDDbox).insertAfter($(this))
			newDDbox.setAttribute("id", $(this).attr("id")+'-kiklopDD')
			$(newDDbox).addClass("kiklop-dropdownbox")
        	$(newDDbox).addClass("kiklop-corner")
        	$(newDDbox).html('&nbsp;')
        	//$(newDDbox).css({width:_width+'px'})
        	
        	$(newDDbox).css(_currentcss)
        	var _items = $(this).children()
        	var DataSet = []
        	var CaptionID = $(this).attr("id")+'-dd-caption'
        	var ArrowID = $(this).attr("id")+'-dd-arrow'
        	
        	$(newDDbox).html('<span id="'+CaptionID+'" class="kiklop-dropdown-caption" style="width:'+(_width-20)+'px;">&nbsp;</span><span id="'+ArrowID+'" class="kiklop-icon k-arrow-down kiklop-right kiklop-dropdown-arrow"></span>')
			
        	var ListItems = '';
        	if(options.type == 'addnew')
        		ListItems += '<div id="'+$(this).attr("id")+'-kiklopDDList1" style="overflow-x: hidden; overflow-y: auto; min-height: 40px; max-height: 160px;">';
        	var selectedItem = '';
        	for (var i=0; i<_items.length; i++){
        		var _img = $(_items[i]).attr("image")
        		if (_img==null){_img='';}
        		var _clr = $(_items[i]).attr("color")
        		if (_clr==null){_clr='';}
        		DataSet[i] = {text:_items[i].text, value:_items[i].value, selected: _items[i].selected, image:_img, color: _clr}
        		
        		if (_items[i].selected==true){
        			var _iimmgg1='';
        			if (_img!=''){
        				var _iimmgg1 = '<span class="tfm-teams cornerBig" style="margin-top:1px; margin-right:10px; background-color:#FFFFFF; background-image: url(./upload/profiles/'+_img+'); background-size:100%">&nbsp;</span>';	
        				$('#'+CaptionID).css({marginTop:'5px'})
        			}
        			var _clr2 = '';
        			if (_clr!=''){
        				var _clr2 ='<span style="background-color: #'+_clr+'" class="project-color-sq kiklop-corner"></span>';
        			}
        			$('#'+CaptionID).html(_clr2+_iimmgg1+_items[i].text)
        			window[$(this).attr("id")+'-kiklopDD-text'] = _items[i].text
        			
        			$('#'+CaptionID).attr('title',_items[i].text)
        			window[$(this).attr("id")+'-kiklopDD-value'] = _items[i].value
        			window[$(this).attr("id")+'-kiklopDD-index'] = i
        			
        			selectedItem = ' kiklop-list-item123';
        		}else{
        			selectedItem = '';
        		}
        		if (_img!=''){
        			var _iimmgg = '<span  class="tfm-teams cornerBig" style="margin-top:0px; margin-right:10px; background-color:#FFFFFF; background-image: url(./upload/profiles/'+_img+'); background-size:100%">&nbsp;</span>';        			 
        			ListItems = ListItems + '<a class="kiklop-list-item'+selectedItem+'" title="'+_items[i].text+'" onclick="kiklopDropdownClick(\''+$(this).attr("id")+'\', '+i+', this)">'+_iimmgg+_items[i].text+'<a>';	
        		} else{
        			var _clr1 ='<span style="background-color: #'+_clr+'" class="project-color-sq kiklop-corner"></span>'
        			if (_clr!=''){
        				ListItems = ListItems + '<a class="kiklop-list-item'+selectedItem+'" title="'+_items[i].text+'" onclick="kiklopDropdownClick(\''+$(this).attr("id")+'\', '+i+', this)">'+_clr1+_items[i].text+'<a>';
        			}else{
        				ListItems = ListItems + '<a class="kiklop-list-item'+selectedItem+'" title="'+_items[i].text+'" onclick="kiklopDropdownClick(\''+$(this).attr("id")+'\', '+i+', this)">'+_items[i].text+'<a>';	
        			}
        				
        		}
        		
        	}
        	if(options.type == 'addnew')
        	{
        		ListItems += '</div><div style="border-top: 1px solid #14A3BC">';
        		ListItems += '<a onclick="$(\'#'+$(this).attr("id")+'-kiklopDD\').kiklopDropdownbox(\'CloseList\'); '+options.onclick+'" class="kiklop-list-item" style="display: inline-block;">'+options.caption+'</a>';
        		ListItems += '</div>';
        	}
        	window[$(this).attr("id")+'-kiklopDD'+'-ds'] = DataSet
        	// DropDown list
        	if (Dolu==false){
        		if (DataSet.length>=5){
        			_top = 	position.top - 200 -75
        		} else {
        			_top = 	position.top - (DataSet.length*40) -75
        		}
        		
        	}
        	
        	$('#'+$(this).attr("id")+'-kiklopDDList').remove();
        	var DDList = document.createElement('div');
        	DDList.setAttribute("id", $(this).attr("id")+'-kiklopDDList')
        	
        	
        	$(DDList).html(ListItems)
        	if(options.type == 'addnew')
        	{
        		$(DDList).addClass("kiklop-dropdown-list-add")
    		} else
    		{
    			$(DDList).addClass("kiklop-dropdown-list")
    		}
        	$(DDList).addClass("kiklop-corner")
        	$(DDList).addClass("kiklop-shadow")
        	$(DDList).css({width:(_width+46)+'px', left: _left+'px', top: (_top+48)+'px', display:'none'})
        	
        	
        	        	
        	
        	document.body.appendChild(DDList)
        	
        	var DDListUp = document.createElement('div');
        	DDListUp.setAttribute("id", $(this).attr("id")+'-kiklopDDListUP')
        	/*$(DDListUp).addClass('kiklop-dropdown-list-up')
        	$(DDListUp).css({left: (_left+_width)+'px', top: (_top+45)+'px', display:'none'})
        	*/
        	if (Dolu==false){
        		$(DDListUp).css({left: (_left+_width)+'px', top: (_top+250)+'px', display:'none'})
        		$(DDListUp).addClass('kiklop-dropdown-list-down')
        	} else {
        		$(DDListUp).css({left: (_left+_width-10)+'px', top: (_top+43)+'px', display:'none'})
        		$(DDListUp).addClass('kiklop-dropdown-list-up')
        	}
        	document.body.appendChild(DDListUp)
        	
        	
        	//Click event
        	$(newDDbox).click(function(e) {
        		
        		if (window[e.currentTarget.id+'-Enable']==false){
        			return false;
        		}
        		//e.stopPropagation();
        		if ( $('#'+e.currentTarget.id+'List').is(":visible") ) {
				    $(e.currentTarget).kiklopDropdownbox("CloseList")
				} else {					 
				     //$(e.currentTarget).kiklopDropdownbox("OpenList")
				     setTimeout('$("#'+e.currentTarget.id+'").kiklopDropdownbox("OpenList")',200)
				}
				        		
        	})
        	AddForClose($(this).attr("id")+'-kiklopDDList', 'DropdownBox')        	       	
        },
        OpenList:function(_value){
        	var _id = $(this).attr("id")
        	_id=_id.replace("-kiklopDD","")
        	var Dolu = true
        	var position = $(this).offset();
        	var _top = position.top
        	if (_top+300>document.body.scrollHeight){Dolu=false}
        	debugger;
        	if (Dolu==false){
        		if (DataSet.length>=5){
        			_top = 	position.top - 200 -75
        		} else {
        			_top = 	position.top - (DataSet.length*40) -75
        		}        		
        	}
        	if($('#'+_id+'-kiklopDDList1').length > 0)
        	{
        		var parentDiv = $('#'+_id+'-kiklopDDList1');
        		var innerListItem = $('#'+_id+'-kiklopDDList1 .kiklop-list-item123');
        	} else
        	{
        		var parentDiv = $('#'+_id+'-kiklopDDList');
        		var innerListItem = $('#'+_id+'-kiklopDDList .kiklop-list-item123');
        	}
        	
        	$('#'+_id+'-kiklopDDList').css({top: (_top+48)+'px'})        	
        	$('#'+_id+'-kiklopDDList').css({display:'block'})
        	
        	$('#'+_id+'-kiklopDDListUP').css({display:'block', top:(_top+44)+'px'})
        	$('#'+_id+'-kiklopDD').removeClass("kiklop-dropdownbox")
        	$('#'+_id+'-kiklopDD').addClass("kiklop-dropdownbox-opened")
        	$('#'+_id+'-dd-arrow').removeClass("k-arrow-down")
        	$('#'+_id+'-dd-arrow').addClass("k-arrow-up")
        	
        	if(innerListItem.offset() != undefined)
        		parentDiv.scrollTop(parentDiv.scrollTop() - parentDiv.offset().top + innerListItem.offset().top); 
        },
        CloseList:function(_value){
        	var _id = $(this).attr("id")
        	_id=_id.replace("-kiklopDD","")        	
        	
        	$('#'+_id+'-kiklopDDList').css({display:'none'})
        	$('#'+_id+'-kiklopDDListUP').css({display:'none'})
        	$('#'+_id+'-kiklopDD').addClass("kiklop-dropdownbox")
        	$('#'+_id+'-kiklopDD').removeClass("kiklop-dropdownbox-opened")
        	$('#'+_id+'-dd-arrow').addClass("k-arrow-down")
        	$('#'+_id+'-dd-arrow').removeClass("k-arrow-up")
        },     
        Enable:function(_value){
        	
        	var _id = $(this).attr("id")
        	window[_id+'-kiklopDD-Enable']=_value;        	
        	if (_value==true){
        		$('#'+_id+'-kiklopDD').css({opacity:1})
        	} else{
        		$('#'+_id+'-kiklopDD').css({opacity:0.4})	
        	}
        	
        },   
        setitem: function(_value){
        	
        	var CaptionID = $(this).attr("id")+'-dd-caption'
        	var _iimmgg1='';
        	var _clr2 = '';
        	var _img =window[$(this).attr("id")+'-kiklopDD-image'];
        	var _clr =  window[$(this).attr("id")+'-kiklopDD-color'];
        	if (_img==undefined){_img=''}
        	if (_clr==undefined){_clr=''}
        	
			if (_img!=''){
				var _iimmgg1 = '<span  class="tfm-teams cornerBig" style="margin-top:1px; margin-right:10px; background-color:#FFFFFF; background-image: url(./upload/profiles/'+_img+'); background-size:100%">&nbsp;</span>';	
				$('#'+CaptionID).css({marginTop:'5px'})
			}
			if (_clr!=''){
				var _clr2 ='<span style="background-color: #'+_clr+'" class="project-color-sq kiklop-corner"></span>'
			}
			
        	$('#'+CaptionID).html(_clr2+_iimmgg1+window[$(this).attr("id")+'-kiklopDD-text'])
			$(this).kiklopDropdownbox("CloseList")
        },   
        additem: function(_value, newid, _clr){
        	var _id = $(this).attr("id");
        	_id = _id.replace("-kiklopDD","");
        	$('#'+$('#'+_id+'-kiklopDDList1').attr('id') + ' .kiklop-list-item123').removeClass('kiklop-list-item123');
        	var _clr1 ='<span style="background-color: #'+_clr+'" class="project-color-sq kiklop-corner"></span>';
        	var _val = window[_id+'-kiklopDD'+'-ds'].length;
			if (_clr!=''){
				ListItems = '<a class="kiklop-list-item kiklop-list-item123" title="'+_value+'" onclick="kiklopDropdownClick(\''+_id+'\', '+_val+', this)">'+_clr1+_value+'<a>';
			}else{
				ListItems = '<a class="kiklop-list-item kiklop-list-item123" title="'+_value+'" onclick="kiklopDropdownClick(\''+_id+'\', '+_val+', this)">'+_value+'<a>';	
			}
			$($('#'+_id+'-kiklopDDList').children()[0]).append(ListItems);
        	var obj = new Object();
        	obj["color"] = _clr;
        	obj["image"] = "";
        	obj["selected"] = true;
        	obj["text"] = _value;
        	obj["value"] = newid;
        	window[_id+'-kiklopDD'+'-ds'].push(obj);
        	
        	var ddds = window[_id+'-kiklopDD'+'-ds']
			//document.getElementById(_id).selectedIndex = _val 
			window[_id+'-kiklopDD-index'] = _val
			window[_id+'-kiklopDD-value']= newid
			window[_id+'-kiklopDD-text']= _value
			window[_id+'-kiklopDD-image']= ''
			window[_id+'-kiklopDD-color']= _clr
        	
        	var CaptionID = _id+'-dd-caption'
        	var _iimmgg1='';
        	var _clr2 = '';
        	var _img = '';
        	
			if (_img!=''){
				var _iimmgg1 = '<span  class="tfm-teams cornerBig" style="margin-top:1px; margin-right:10px; background-color:#FFFFFF; background-image: url(./upload/profiles/'+_img+'); background-size:100%">&nbsp;</span>';	
				$('#'+CaptionID).css({marginTop:'5px'})
			}
			if (_clr!=''){
				var _clr2 ='<span style="background-color: #'+_clr+'" class="project-color-sq kiklop-corner"></span>'
			}
			
        	$('#'+CaptionID).html(_clr2+_iimmgg1+_value)
			//$(this).kiklopDropdownbox("CloseList")
        },
        dataset: function(_value){
        	_id = $(this).attr("id")
        	return window[_id+'-kiklopDD'+'-ds']
        },        
        value : function(_value) {
        	_id = $(this).attr("id")
        	if (_value==null){
        		return window[_id+'-kiklopDD-value']	
        	}  else {
        		var _index        		
        		var ddds = window[_id+'-kiklopDD'+'-ds']
        		for (var i=0; i<ddds.length;i++){        			
        			if (ddds[i].value+''==_value){
        				_index = i
        			}
        		}
        		
        		document.getElementById(_id).selectedIndex = _index
				window[_id+'-kiklopDD-index'] = _index
				window[_id+'-kiklopDD-value']= ddds[_index].value
				window[_id+'-kiklopDD-text']= ddds[_index].text
				$('#'+_id).kiklopDropdownbox("setitem")	
        	}
        },
        getIndex: function(_value){
        	_id = $(this).attr("id");
        	var ddds = window[_id+'-kiklopDD'+'-ds']
        	var _index =0;
        	for (var i=0; i<ddds.length;i++){        			
    			if (ddds[i].value+''==_value){
    				_index = i
    			}
    		}
    		return _index;
        }
    };

    $.fn.kiklopDropdownbox = function(methodOrOptions) {
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