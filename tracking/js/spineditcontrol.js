/**
 * SpinEditControl.v.0.8.0
 *
 * Transform edit controls into spin edit control (aka up-down | numeric controls)
 *
 * By Hugo Ortega_Hernandez - hugorteg{no_spam}@gmail.com
 *
 * Last version of this code: http://dali.mty.itesm.mx/~hugo/js/spineditcontrol/
 *
 * Features:
 *   + Automatic input control conversion with a single attribute
 *     in the 'input' tag or a special 'id' attribute format.
 *   + Mouse and keyboard use
 *   + User input restricted to numeric characters (well, almost).
 *
 * License: GPL (that's, use this code as you wish, just keep it free)
 * Provided as is, without any warranty.
 * Feel free to use this code, but don't remove this disclaimer please.
 *
 * If you're going to use this library, please send me an email, and
 * would be great if you include a photo of your city :)
 * (se habla espa&ntilde;ol)
 *
 *                                        Veracruz & Monterrey, Mexico, 2005.
 */


//-----------------------------------------------------------------------------
// Some parameters for style and behaviour...

SpinEditControl.buttonOffsetX = 0;
SpinEditControl.buttonOffsetY = 0;
SpinEditControl.defaultMin    = 0;
SpinEditControl.defaultMax    = 100;
SpinEditControl.defaultStep   = 1;
SpinEditControl.buttonWidth   = 12; //px

// OK, I hate IE, but many people ask for patches
if (navigator.userAgent.indexOf("MSIE") > 1){
	SpinEditControl.buttonOffsetX = -1;
	SpinEditControl.buttonOffsetY = -1;
	// but if document have xhtml dtd, things are differents... :S
	if (document.getElementsByTagName("html")[0].getAttribute("xmlns") != null){
		SpinEditControl.buttonOffsetX = 9;
		SpinEditControl.buttonOffsetY = 14;
	}
}


//-----------------------------------------------------------------------------
// Some constants and internal stuff

SpinEditControl.editIdPrefix     = "SEC_";
SpinEditControl.buttonIdPrefix   = "SEC_button_";
SpinEditControl.buttonUpIdPost   = "_up_";
SpinEditControl.buttonDownIdPost = "_down_";
SpinEditControl.minAttr          = "spinedit_min";
SpinEditControl.maxAttr          = "spinedit_max";
SpinEditControl.stepAttr         = "spinedit_step";



//-----------------------------------------------------------------------------
// The fun

/**
 * Constructor
 */
function SpinEditControl()
{
}

/**
 * Search for input controls that will be transformed into SpinEditControls
 */
SpinEditControl.init = function () {
    
    // search for input controls that will be transformed into SpinEditControls.
    var inputsLength = document.getElementsByTagName("input").length;
    for (i = 0; i < inputsLength; i++) {
        if (document.getElementsByTagName("input")[i].type.toLowerCase() == "text") {
            var editctrl = document.getElementsByTagName("input")[i];
            var cecattr = editctrl.getAttribute("spinedit");
            var setEvents = false;
            // if currencyedit pseudo-attribute:
            if (cecattr != null && cecattr == "true") {
                if (editctrl.id) {
                    if (!this.createSpinButtons(editctrl)) continue;
                    // Set min, max and incr...
                    var min = editctrl.getAttribute(this.minAttr);
                    if (!min || isNaN(parseInt(min))) {
                        editctrl.setAttribute(this.minAttr, this.defaultMin);
                    }
                    var max = editctrl.getAttribute(this.maxAttr);
                    if (!max || isNaN(parseInt(max))) {
                        editctrl.setAttribute(this.maxAttr, this.defaultMax);
                    }
                    var stp = editctrl.getAttribute(this.stepAttr);
                    if (!stp || isNaN(parseInt(stp))) {
                        editctrl.setAttribute(this.stepAttr, this.defaultStep);
                    }
                    setEvents = true;
                }
                else {
                    alert("Attribute 'id' is mandatory for SpinEditControl.");
                }
            }
            // if fomatted id attr:
            else if (editctrl.id && editctrl.id.indexOf(this.editIdPrefix) == 0) {
                if (!this.createSpinButtons(editctrl)) continue;
                // get min, max and stp from id SEC_name_min_max_inc
                var min = this.defaultMin;
                var max = this.defaultMax;
                var stp = this.defaultStep;
                var values = editctrl.id.split("_");
                var l = values.length;
                if (l >= 3) {
                    v = parseInt(values[2]);
                    min = isNaN(v) ? this.defaultMin : v;
                    if (l >= 4) {
                        v = parseInt(values[3]);
                        max = isNaN(v) ? this.defaultMax : v;
                    }
                    if (l == 5) {
                        v = parseInt(values[4]);
                        stp = isNaN(v) ? this.defaultStep : v;
                    }
                }
                editctrl.setAttribute(this.minAttr, min);
                editctrl.setAttribute(this.maxAttr, max);
                editctrl.setAttribute(this.stepAttr, stp);
                setEvents = true;
            }
            // add the events:
            if (setEvents) {
                editctrl.style.textAlign = "right";
                if (editctrl.addEventListener) {
                    editctrl.addEventListener("blur", SEC_onEditControlBlur, false);
                    editctrl.addEventListener("keydown", SEC_onEditControlKeyDown, false);
                    editctrl.addEventListener("keyup", SEC_onEditControlKeyUp, false);
                }
                else if (editctrl.attachEvent) {
                    editctrl.attachEvent("onblur", SEC_onEditControlBlur);
                    editctrl.attachEvent("onkeydown", SEC_onEditControlKeyDown);
                    editctrl.attachEvent("onkeyup", SEC_onEditControlKeyUp);
                }
            }
        }
    }
}


function SEC_autoInit()
{
	SpinEditControl.init();
}

if (window.addEventListener){
	window.addEventListener("load", SEC_autoInit, false);
	window.addEventListener("resize", SEC_onWindowResize, false);
}
else if (window.attachEvent){
	window.attachEvent("onload", SEC_autoInit);
	window.attachEvent("onresize", SEC_onWindowResize);
}


/**
 * Creates the spin buttons
 */
SpinEditControl.createSpinButtons = function(input)
{
	var newid = this.buttonIdPrefix + input.id;
	if (document.getElementById(newid + this.buttonUpIdPost)) return false; // if exists previously....
	var nTop       = getObject.getSize("offsetTop", input);
	var nLeft      = getObject.getSize("offsetLeft", input);
	var nHeight    = Math.ceil((input.offsetHeight-1)/2);
	// up button
	var buttonUp            = document.createElement("input");
	buttonUp.id             = newid + this.buttonUpIdPost;
	buttonUp.type           = "button";
	buttonUp.className      = "SpinButtonUp";
	buttonUp.style.position = "absolute";
	buttonUp.style.zIndex   = 10000;
	buttonUp.style.top      = (nTop + this.buttonOffsetY) + "px";
	buttonUp.style.left     = (nLeft + input.offsetWidth + this.buttonOffsetX +1) + "px";
	buttonUp.style.width    = this.buttonWidth + "px";
	buttonUp.style.height   = nHeight + "px";
	buttonUp.setAttribute("inputid", input.id);
	buttonUp.style.backgroundImage = "url(../Images/up1.png)";
	document.body.appendChild(buttonUp);
	// down button
	var buttonDown              = document.createElement("input");
	buttonDown.id               = newid + this.buttonDownIdPost;
	buttonDown.type             = "button";
 	buttonDown.className        = "SpinButtonDown";
	buttonDown.style.position   = "absolute";
	buttonDown.style.zIndex     = 10000;
	buttonDown.style.top        = (nTop + nHeight + this.buttonOffsetY) + "px";
	buttonDown.style.left       = (nLeft + input.offsetWidth + this.buttonOffsetX +1) + "px";
	buttonDown.style.width      = this.buttonWidth + "px";
	buttonDown.style.height     = nHeight + "px";
	buttonDown.setAttribute("inputid", input.id);
	buttonDown.style.backgroundImage = "url(../Images/down1.png)";
	document.body.appendChild(buttonDown);

	if(buttonUp.addEventListener){
		buttonUp.addEventListener("click", SEC_onButtonClick, false);
		buttonDown.addEventListener("click", SEC_onButtonClick, false);
	}
	else if (buttonUp.attachEvent){
		buttonUp.attachEvent("onclick", SEC_onButtonClick);
		buttonDown.attachEvent("onclick", SEC_onButtonClick);
	}
	else{
		return false;
	}

	return true;
}


/**
 * Increase the value of edit
 */
SpinEditControl.editUp = function (edit) {
    var min = parseInt(edit.getAttribute(this.minAttr));
    var max = parseInt(edit.getAttribute(this.maxAttr));
    var stp = parseInt(edit.getAttribute(this.stepAttr));
    if (edit.value == "") {
        edit.value = min;
    }
    else {
        var current = parseInt(edit.name);
   
        if (isNaN(current)) current = min;
        var newVal = current + stp;
        var newVal1 = "";
       
         if (newVal < 10) {
         newVal1 = "0" + newVal;
        }
         else {
            newVal1 = "" + newVal;
         }

        if (newVal <= max) {
            edit.name = newVal;
            edit.value = newVal1;
        }
    }
    edit.focus();
}

/**
 * Decrease the value of edit
 */
SpinEditControl.editDown = function (edit) {
    var min = parseInt(edit.getAttribute(this.minAttr));
    var max = parseInt(edit.getAttribute(this.maxAttr));
    var stp = parseInt(edit.getAttribute(this.stepAttr));
    if (edit.value == "") {
        edit.value = max;
    }
    else {
        var current = parseInt(edit.name);
        if (isNaN(current)) current = min;
        var newVal = current - stp;
        var newVal1 = "";

        if (newVal < 10) {
            newVal1 = "0" + newVal;
        }
        else {
            newVal1 = "" + newVal;
        }
        if (newVal >= min) {
            edit.name = newVal;
            edit.value = newVal1;
        }
    }
    edit.focus();
}


/**
 * Spin button's click event
 */
function SEC_onButtonClick(event){SpinEditControl.onButtonClick(event)}
SpinEditControl.onButtonClick = function(event)
{
	if (event == null) event = window.event;
	var button = (event.srcElement) ? event.srcElement : event.originalTarget;
	var edit = document.getElementById(button.getAttribute("inputid"));
	if (!edit) return;
	if (button.id.toString().indexOf(this.buttonUpIdPost) > 0){
		this.editUp(edit);
	}
	else{
		this.editDown(edit);
	}
}


/**
 * Key-down event for edit controls
 */
function SEC_onEditControlKeyDown(event){SpinEditControl.onEditControlKeyDown(event);}
SpinEditControl.onEditControlKeyDown = function(event)
{
	if (event == null) event = window.event;
	var edit = (event.srcElement) ? event.srcElement : event.originalTarget;
	//alert(event.keyCode);
	var kc = event.keyCode;
	if (kc == 38){ // up
		this.editUp(edit);
	}
	else if (kc == 40){ // down
		this.editDown(edit);
	}
	else if ( kc >= 65 && kc <= 90 ){ // letters
		if (event.stopPropagation) event.stopPropagation();
		if (event.preventDefault) event.preventDefault();
		event.returnValue = false;
		this.cancelKey = true;
		return false;
	}
	 // other symbols (the event is not canceled to verify if it is a separator)
	 // there are some keys with same code, v.gr. "9" and "("... strange...
	else if (!((kc > 48 && kc < 57) || (kc >= 96 && kc <= 105))){
		this.cancelKey = true;
	}
}

/**
 * Key-up event for edit controls
 */
function SEC_onEditControlKeyUp(event){SpinEditControl.onEditControlKeyUp(event);}
SpinEditControl.onEditControlKeyUp = function (event) {

    if (event == null) event = window.event;
    var edit = (event.srcElement) ? event.srcElement : event.originalTarget;
    if (this.cancelKey) {
        this.cancelKey = false;
        var cv = "";
        var replace = false;
        var val = edit.value.toString();

        for (i = 0; i < edit.value.length; i++) {
            if (!isNaN(parseInt(val.charAt(i))) || (val.charAt(i) == "-" && i == 0)) {
                cv += val.charAt(i);
            }
            else {
                replace = true;
            }
        }

        if (replace) {
            edit.value = cv;
            edit.name = cv;
        }

    }
    edit.name = edit.value;
    
}


/**
 * Blur event for edit controls
 */
function SEC_onEditControlBlur(event){SpinEditControl.onEditControlBlur(event);}
SpinEditControl.onEditControlBlur = function(event)
{
	if (event == null) event = window.event;
	var edit = (event.srcElement) ? event.srcElement : event.originalTarget;
	var val = edit.value;
	var max = parseInt(edit.getAttribute(this.maxAttr));
	var min = parseInt(edit.getAttribute(this.minAttr));
	var nan = isNaN(parseInt(val));
	if (val != "" && nan){
		edit.value = min;
	}
	else if (val > max){
		edit.value = max;
	}
	else if (val < min){
		edit.value = min;
	}
}


/**
 * Window resize event.
 */
function SEC_onWindowResize(event){SpinEditControl.onWindowResize(event);}
SpinEditControl.onWindowResize = function(event)
{
	this.relocateButtons();
}

/**
 * Relocate curr-symbols
 */
SpinEditControl.relocateButtons = function()
{
	var inputElements = document.getElementsByTagName("input");
	for (key in inputElements){
		if (inputElements[key].id && inputElements[key].id.indexOf(this.buttonIdPrefix) == 0){
			var button  = inputElements[key];
			var input   = document.getElementById(button.getAttribute("inputid"));
			if (!input) return;
			var nTop    = getObject.getSize("offsetTop", input);
			var nLeft   = getObject.getSize("offsetLeft", input);
			var nHeight = Math.ceil((input.offsetHeight-1)/2);
			if (inputElements[key].id.indexOf(this.buttonUpIdPost) > 0){
				button.style.top  = (nTop + this.buttonOffsetY) + "px";
				button.style.left = (nLeft + input.offsetWidth + this.buttonOffsetX) + "px";
			}
			else{
				button.style.top  = (nTop + nHeight + this.buttonOffsetY) + "px";
				button.style.left = (nLeft + input.offsetWidth + this.buttonOffsetX) + "px";
			}
		}
	}
}

//-----------------------------------------------------------------------------
// Following 2 functions by: Mircho Mirev

function getObject(sId)
{
	if (bw.dom){
		this.hElement = document.getElementById(sId);
		this.hStyle = this.hElement.style;
	}
	else if (bw.ns4){
		this.hElement = document.layers[sId];
		this.hStyle = this.hElement;
	}
	else if (bw.ie){
		this.hElement = document.all[sId];
		this.hStyle = this.hElement.style;
	}
}

getObject.getSize = function(sParam, hLayer)
{
	nPos = 0;
	while ((hLayer.tagName) && !( /(body|html)/i.test(hLayer.tagName))){
		nPos += eval('hLayer.' + sParam);
		if (sParam == 'offsetTop'){
			if (hLayer.clientTop){
				nPos += hLayer.clientTop;
			}
		}
		if (sParam == 'offsetLeft'){
			if (hLayer.clientLeft){
				nPos += hLayer.clientLeft;
			}
		}
		hLayer = hLayer.offsetParent;
	}
	return nPos;
}

// EOF
