(function( $ ){

    var methods = {   	
        init : function(options) {
        	var defaults = {
                current: new Date(),
                format: 'dMy',
                change: function(){return true;}
            }
            options = $.extend(defaults, options);
        	if (options.current==null){
        		options.current = new Date();
        	}
        	
        	window[$(this).attr("id")+'-kiklopCalFormat'] = options.format
        	window[$(this).attr("id")+'-kiklopCalValue'] = kiklopFormatDate(options.current,'ymd')
        	window[$(this).attr("id")+'-kiklopCalEnable'] = true
        	window[$(this).attr("id")+'-kiklopCalChange'] = options.change
        	
        	var Dolu = true
        	var _width = $(this).width()
        	var _currentcss = $(this).getStyleObject();
        	var newCal =  document.createElement('div')        	        	
			$(this).css({display:'none'})
			$(newCal).insertAfter($(this))
			newCal.setAttribute("id", $(this).attr("id")+'-kiklopCal')
			$(newCal).addClass("kiklop-calendar")
        	$(newCal).addClass("kiklop-corner")
        	$(newCal).html('&nbsp;')
        	$(newCal).css({width:_width+'px'})
        	$(newCal).css(_currentcss)
        	var _items = $(this).children()
        	var DataSet = []
        	var CaptionID = $(this).attr("id")+'-kiklopCalendar-caption'
        	var IconID = $(this).attr("id")+'-kiklopCalendar-icon'
        	
        	var position = $(newCal).offset();
        	
        	var _left = position.left//getAbsoluteLeft(this)
        	var _top = position.top//getAbsoluteTop(this)
        	
        	$(newCal).html('<span id="'+CaptionID+'" class="kiklop-dropdown-caption" style="width:'+(_width-30)+'px;">'+kiklopFormatDate(options.current,options.format)+'</span><span id="'+IconID+'" class="kiklop-icon k-calendar kiklop-right kiklop-dropdown-arrow"></span>')
        	
        	if (_top+300>document.body.scrollHeight){
        		Dolu=false
        		_top = 	position.top-330
        	}
        	// DropDown list
        	var DDList = document.createElement('div');
        	DDList.setAttribute("id", $(this).attr("id")+'-kiklopCalList')
        	$(DDList).addClass("kiklop-dropdown-list")
        	$(DDList).addClass("kiklop-corner")
        	$(DDList).addClass("kiklop-shadow")        	
        	$(DDList).css({width:'296px', overflow:'hidden', maxHeight:'250px', left: _left+'px', top: (_top+40)+'px', display:'none'})
        	document.body.appendChild(DDList)
        	
        	var DDListUp = document.createElement('div');
        	DDListUp.setAttribute("id", $(this).attr("id")+'-kiklopCalListUP')
        	
        	if (Dolu==false){
        		$(DDListUp).css({left: (_left+_width)+'px', top: (_top+290)+'px', display:'none'})
        		$(DDListUp).addClass('kiklop-dropdown-list-down')
        	} else {
        		$(DDListUp).css({left: (_left+_width)+'px', top: (_top+35)+'px', display:'none'})
        		$(DDListUp).addClass('kiklop-dropdown-list-up')
        	}
        	
        	
        	document.body.appendChild(DDListUp)
        	//$(DDList).html(ListItems)
        	
        	//Click event
        	$(newCal).click(function(e) {
        		//e.stopPropagation();
        		if(window[e.currentTarget.id+'Enable']==false){
        			return false
        		}
        		if ( $('#'+e.currentTarget.id+'List').is(":visible") ) {
				    $(e.currentTarget).kiklopCalendar("CloseList")
				} else {
					setTimeout('$("#'+e.currentTarget.id+'").kiklopCalendar("OpenList")',200)
				}
				        		
        	})
        	AddForClose($(this).attr("id")+'-kiklopCalList', 'Calendar')
        	      	       	
        },
        Enable: function(_value){
        	var _id = $(this).attr("id")
        	_id=_id.replace("-kiklopCal","")
        	
        	window[_id+'-kiklopCalEnable']=_value
        	
        	if (_value==true){
        		$('#'+_id+'-kiklopCal').css({opacity:1})
        	}else{
        		$('#'+_id+'-kiklopCal').css({opacity:0.4})
        	}
        },
        OpenList:function(_value){        	        	
        	var _id = $(this).attr("id")
        	_id=_id.replace("-kiklopCal","")
        	var Dolu = true;
        	var position = $(this).offset();
        	var _top = position.top//getAbsoluteTop(this)
        	if (_top+300>document.body.scrollHeight){
        		Dolu=false
        		_top = 	position.top-330
        	} else {
        		_top = _top-10 
        	}
        	$('#'+_id+'-kiklopCalList').css({top: (_top+63)+'px'})
        	if (Dolu==false){
        		$('#'+_id+'-kiklopCalListUP').css({top: (_top+318)+'px'})
        	} else {
        		$('#'+_id+'-kiklopCalListUP').css({top: (_top+58)+'px'})        		
        	}
        	
        	$('#'+_id+'-kiklopCalList').css({display:'block'})
        	$('#'+_id+'-kiklopCalListUP').css({display:'block'})
        	$('#'+_id+'-kiklopCal').removeClass("kiklop-calendar")
        	$('#'+_id+'-kiklopCal').addClass("kiklop-calendar-opened")
        	
        	$('#'+_id+'-kiklopCalList').DatePicker({
				flat: true,
				MyTargetID: _id+'-kiklopCalendar-caption',
				MyFormat: window[_id+'-kiklopCalFormat'],	
				date: window[_id+'-kiklopCalValue'],
				current: window[_id+'-kiklopCalValue'],
				calendars: 1,
				starts: kiklopStartDay,
				locale: {
					days: kiklopWeekdays,
					daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
					daysMin: kiklopWeekdaysShort, 
					months: kiklopMonths,
					monthsShort: kiklopMonthsShort,
					weekMin: '#'
				},
				onRender: function(){
					ifcalendar = false;
					return {};
				},
				change: window[_id+'-kiklopCalChange']
			});
			//$('#'+_id+'-kiklopCalList').DatePickerSetDate(window[_id+'-kiklopCalValue'], true);
        	
        	
        },
        CloseList:function(_value){
        	var _id = $(this).attr("id")
        	_id=_id.replace("-kiklopCal","")        	
        	
        	$('#'+_id+'-kiklopCalList').css({display:'none'})
        	$('#'+_id+'-kiklopCalListUP').css({display:'none'})
        	$('#'+_id+'-kiklopCal').addClass("kiklop-calendar")
        	$('#'+_id+'-kiklopCal').removeClass("kiklop-calendar-opened")        	
        },        
        value : function(_value) {
        	_id = $(this).attr("id")
        	if (_value==null){
        		
        		return window[_id+'-kiklopCalValue']	
        	}  else {
        		window[_id+'-kiklopCalValue'] = _value
        		var dd = new Date(_value)
        		
        		$('#'+_id+'-kiklopCalendar-caption').html(kiklopFormatDate(dd, window[_id+'-kiklopCalFormat']))
        		return _value
        	}
        }
        
    };

    $.fn.kiklopCalendar = function(methodOrOptions) {
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
