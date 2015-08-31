var kiklopStartDay=1;
var TretPanelKorekcija=0;
var ActivePanel = 1
var PanelsCaption = ["Projects", "Contact", "My cloud", "Calendar"]
var PanelsIcons = ["project20w", "client20w", "cloud20w", "calendar20w"]
var AllowedExtension = ["gif", "jpeg", "jpg", "png", "pdf", "pptx", "pps", "ppsx", "xlsx", "docx", "doc", "xls", "ppt", "vsd", "txt", "zip"]

var CloseText = 'Close'
var DenyAddProjectMessage = 'Your project limit are full !<br> If you want to add more project upgrade your profile. '
var DenyAddWorkspaceMessage = 'Your workspace limit are full !<br> If you want to add more workspaces upgrade your profile. '
var _captionAddNewTask = 'Add new task'
var _captionEditTask = 'Edit task'
var _captionSuccAddNewTask = 'Successfully add new task';
var _captionSuccEditTask = 'Successfully edit task';
var _captionAddNewProject = 'Add new project';
var _captionAddNewContact = 'Add new contact';
var _cAttachFile = 'Attach file';
var _ReinviteOK = 'Invitation for joining in this workspace was resend !';
var _Message = 'Message';
var focusElement = '';

var invitationCaption = '';
var ShareCaption = 'Share';
var PrivilegueMessage = '';

var fromdt = '';
var todt = '';
var remindersdt = '';
var eventdt = '';
var today = '';
var clickDay = '';

var ifcalendar = false;
var CanLoadProjects = false;
var CanLoadClients = false;
var CanLoadMyCloud = false;
var CanLoadCalendar = false;

var _newItemInList = '';
var _cNewFolder='';
var _cEditFolder='';
var _cEditFIleName='';
var _cEditChList='';
var _cAddReminder='';
var _cEditReminder='';
var _cAddFollower='';
var _cAddWorktime='';
var _cAddCost='';
var _cEditWorktime='';
var _cEditCost='';
var _cEditComment='';
var _cAddNewEvent='';
var _cDelEvent='';
var _cEditEvent='';

var TaskDetailUPDown = ''
var openNotif = 0;
function SelectPanelTab(_idx){
	if(ActivePanel == _idx && ActivePanel == 4)
	{
		debugger;
		Today();
		if(MiddleType != 'Events')
			LoadMiddleListEvents('Events', today);
	} else {
		ActivePanel = _idx;
		if (_idx==1){
			$('#tab-pnl-1').addClass("kiklop-tab-first-sel").removeClass("kiklop-tab-first")
		} else {
			$('#tab-pnl-1').removeClass("kiklop-tab-first-sel").addClass("kiklop-tab-first")
		}
		for (var i=2; i<=4; i++){
			if (_idx==i){
				$('#tab-pnl-'+i).addClass("kiklop-tab-sel").removeClass("kiklop-tab")
			} else {
				$('#tab-pnl-'+i).removeClass("kiklop-tab-sel").addClass("kiklop-tab")
			}
		}
		if(ActivePanel == 4)
		{
			$('#btn-list-more').css({display: 'none'});
			$('#btn-addevent').css({display: 'inline-block'});
			$('#span-panel-header').html('<span class="kiklop-icon20 k-'+PanelsIcons[_idx-1]+'" style="position:relative; top:4px" ></span> '+PanelsCaption[_idx-1])
		} else
		{
			if(ActivePanel == 3)
				$('#btn-list-more').css({display: 'none'});
			else
				$('#btn-list-more').css({display: 'inline-block'});
			$('#btn-addevent').css({display: 'none'});
			$('#span-panel-header').html('<span class="kiklop-icon20 k-'+PanelsIcons[_idx-1]+'" style="position:relative; top:4px" ></span> '+PanelsCaption[_idx-1])
		}
		LoadList()
	}
}
function AjaxListLoader(){
	$('#panel-list-body').html('<span class="ajax-loader"></span>')
}

var _selectedUserMember = ''
var _selectedUserMemberM = ''
var _selectedUserTeam = ''
function LoadList(){
	if (ActivePanel!=3){saveCloudTree()}
	AjaxListLoader()
	
	if (ActivePanel==1){LoadProjects()}
	if (ActivePanel==2){LoadClients()}
	if (ActivePanel==3){LoadCloud()}
	if (ActivePanel==4){LoadCalendar()}
	
}
function setPanel1Height(){
	//return
	var _newHeight =$('#teams-member-div').height()+$('#teams-member-div').offset().top+20
	var _oldHeight =$('#kiklop-panel-0').height()
	//if (_newHeight>_oldHeight){
		$('#kiklop-panel-0').css({height:_newHeight+'px'})
		kiklopSetLastVisiblePanelHeight()	
	//} 
	
}
function LoadTeams(){
	//$('#teams-div').html('<span class="ajax-loader" style="top:0px"></span>')
	$('#teams-div').load('./ajax/teams.php?userid='+_selectedUserMember, function(){
		setPanel1Height()
		kiklopSetTip()
	})
}
function LoadTeams2(_tid){
	//$('#teams-div').html('<span class="ajax-loader" style="top:0px"></span>')
	$('#teams-div').load('./ajax/teams.php?tid='+_tid, function(){
		setPanel1Height()
		kiklopSetTip()
	})
}

function LoadMembers(_mid){
	if (_mid==null){_mid==''}
	if (typeof _mid == "undefined"){_mid=''}

	//$('#teams-member-div').html('<span class="ajax-loader" style="top:0px"></span>')
	$('#teams-member-div').load('./ajax/members.php?teamid=&userid='+_mid, function(){
		setPanel1Height()
		kiklopSetTip()
	})
}
function LoadMembers2(_tid){
	if (_tid==null){_tid==''}
	if (typeof _tid == "undefined"){_tid=''}

	//$('#teams-member-div').html('<span class="ajax-loader" style="top:0px"></span>')
	$('#teams-member-div').load('./ajax/members.php?teamid='+_tid+'&userid=', function(){
		setPanel1Height()
		kiklopSetTip()
	})
}

function LoadProjects(){
	
	$('#panel-list-body').load('./ajax/projects.php?userid='+_selectedUserMember+'&teamid='+_selectedUserTeam, function(){kiklopSetTip()})
}
function LoadClients(){
	
	$('#panel-list-body').load('./ajax/clients.php?userid='+_selectedUserMember+'&teamid='+_selectedUserTeam, function(){kiklopSetTip()})
}
function saveCloudTree(){
	if (SumNaCloud==true){
		if  ((_selectedUserMember=='') && (_selectedUserTeam=='')){
			$('#hidden-tree').html($('#panel-list-body').html())
		} else{
			$('#hidden-tree').html('')
		}	
	}
	SumNaCloud=false
}
function LoadCloud(){
	//hidden-tree
	if ((_selectedUserMember=='') && (_selectedUserTeam=='')){
		if ($('#hidden-tree').html()!=''){
			SumNaCloud=true
			$('#panel-list-body').html($('#hidden-tree').html())
		} else {
			SumNaCloud=false
			$('#panel-list-body').load('./ajax/mycloud.php?userid='+_selectedUserMember+'&teamid='+_selectedUserTeam, function(){kiklopSetTip()})	
		}	
	} else {
		SumNaCloud=false
		$('#hidden-tree').html('')
		$('#panel-list-body').load('./ajax/mycloud.php?userid='+_selectedUserMember+'&teamid='+_selectedUserTeam, function(){kiklopSetTip()})
	}
}
var SumNaCloud = false;
function LoadCalendar(){
	
	$('#panel-list-body').load('./ajax/calendar.php?userid='+_selectedUserMember+'&teamid='+_selectedUserTeam, function(){kiklopSetTip()})
}
function LoadWorkspaces(){
	$("#myWorkspace").load("./ajax/workspace.php", function(){
		kiklopSetTip()
	})
}
var MiddleType = ''
var MiddleId = ''
var MiddleDate = ''
function LoadMiddleList(_type, _id, _closeTaskPanel){
	// _type = "MyInbox" or "MyTasks" or "MyFollow" or "Project" or "Client" or "Member" or "Team" or "ActiveTasks"
	//LoadMiddleList('MyTasks',-1)	
	if (_closeTaskPanel==null){_closeTaskPanel=true}
	if (_closeTaskPanel==true){HideTaskPanel(); HideMessagePanel(); } 
	MiddleType = _type
	MiddleId = _id
	$('#middle-list').html('<span class="ajax-loader"></span>')
	if(_type == 'MyInbox')
	{
		$("#middle-list").load("./ajax/middle_list_messages.php", function(){
			kiklopSetTip()
		})
	} else
	{
		$("#middle-list").load("./ajax/middle_list.php?type="+_type+"&id="+_id+"&selUserMember="+_selectedUserMember, function(){
			kiklopSetTip()
		})
	}
}
function ReloadMiddleListInbox(_id){
	//LoadMiddleList('MyInbox', -1, false)
	$('#div-'+_id).css({ backgroundColor: '#EBEBEB', border: '1px solid #BEBEBE'});
}
function ReloadMiddleList(){
	LoadMiddleList(MiddleType, MiddleId, false)
}
function addNewCheckList(_tid){
	$.kiklopWindow({width:545, height:210, caption:_newItemInList, page:'./forms/add_checklist.php?tid='+_tid, modal:true,
		onClose: function(){}
	})			
}
function NewFolder(_fid){
	$.kiklopWindow({width:545, height:210, caption:_cNewFolder, page:'./forms/add_folder.php?fid='+_fid, modal:true,
		onClose: function(){}
	})			
}
function EditFolder(_fid){
	$.kiklopWindow({width:545, height:210, caption:_cEditFolder, page:'./forms/edit_folder.php?fid='+_fid, modal:true,
		onClose: function(){}
	})			
}
function EditFilename(_fnid){
	$.kiklopWindow({width:545, height:210, caption:_cEditFIleName, page:'./forms/edit_filename.php?fnid='+_fnid, modal:true,
		onClose: function(){}
	})			
}
function editCheckList(_cid){
	$.kiklopWindow({width:545, height:210, caption:_cEditChList, page:'./forms/edit_checklist.php?cid='+_cid, modal:true,
		onClose: function(){}
	})			
}
function addNewReminder(_tid){
	$.kiklopWindow({width:380, height:320, caption:_cAddReminder, page:'./forms/add_reminder.php?tid='+_tid, modal:true,
		onClose: function(){}
	})			
}
function editReminder(_rid){
	$.kiklopWindow({width:380, height:320, caption:_cEditReminder, page:'./forms/edit_reminder.php?rid='+_rid, modal:true,
		onClose: function(){}
	})
}

function addNewFollower(_id, _type){
	$.kiklopWindow({width:550, height:500, caption:_cAddFollower, page:'./forms/add_follower.php?tid='+_id + '&type=' + _type, modal:true,
		onClose: function(){}
	})			
}

function addNewWorktime(_tid){
	$.kiklopWindow({width:500, height:320, caption:_cAddWorktime, page:'./forms/add_worktime.php?tid='+_tid, modal:true,
		onClose: function(){}
	})			
}
function addNewCost(_tid){
	$.kiklopWindow({width:500, height:320, caption:_cAddCost, page:'./forms/add_cost.php?tid='+_tid, modal:true,
		onClose: function(){}
	})			
}
function editWorktime(_rid){
	$.kiklopWindow({width:500, height:320, caption:_cEditWorktime, page:'./forms/edit_worktime.php?rid='+_rid, modal:true,
		onClose: function(){}
	})			
}
function editCost(_cid){
	$.kiklopWindow({width:500, height:320, caption:_cEditCost, page:'./forms/edit_cost.php?cid='+_cid, modal:true,
		onClose: function(){}
	})			
}
function editComment(_cid){
	$.kiklopWindow({width:545, height:210, caption:_cEditComment, page:'./forms/edit_comment.php?cid='+_cid, modal:true,
		onClose: function(){}
	})			
}

function addNewProject(_caption){
	$.ajax({url: "./action/projects.php?action=check&"}).done(function(_data) {
		_data = _data.replace(/\r/g,'').replace(/\n/g,'');
		if (_data=='TRUE'){
			$.kiklopWindow({width:545, height:274, caption:_caption, page:'./forms/add_project.php?close=0', modal:true,
				onClose: function(){}
			})		
		} else {
			if (_data=='PRIVILEGE'){
				kiklopMessage(PrivilegueMessage, _caption, CloseText)
			} else {
				kiklopMessage(DenyAddProjectMessage, _caption, CloseText)	
			}
				
		}
			
	})	
}
function addNewClient(_caption){
	$.ajax({url: "./action/clients.php?action=check&"}).done(function(_data) {
		_data = _data.replace(/\r/g,'').replace(/\n/g,'');
		if (_data=='TRUE'){
			$.kiklopWindow({width:825, height:420, caption:_caption, page:'./forms/add_client.php?close=1', modal:true,
				onClose: function(){}
			})		
		} else {
			if (_data=='PRIVILEGE'){
				kiklopMessage(PrivilegueMessage, _caption, CloseText)
			} else {
				kiklopMessage(DenyAddProjectMessage, _caption, CloseText)	
			}				
		}
			
	})	
}
function addNewProject1(_caption){
	$.ajax({url: "./action/projects.php?action=check&"}).done(function(_data) {
		_data = _data.replace(/\r/g,'').replace(/\n/g,'');
		if (_data=='TRUE'){
			$.kiklopWindow1({width:545, height:274, caption:_caption, page:'./forms/add_project.php?close=1', modal:true,
				onClose: function(){}
			})		
		} else {
			if (_data=='PRIVILEGE'){
				kiklopMessage(PrivilegueMessage, _caption, CloseText)
			} else {
				kiklopMessage(DenyAddProjectMessage, _caption, CloseText)	
			}
				
		}
			
	})	
}
function addNewClient1(_caption){
	$.ajax({url: "./action/clients.php?action=check&"}).done(function(_data) {
		_data = _data.replace(/\r/g,'').replace(/\n/g,'');
		if (_data=='TRUE'){
			$.kiklopWindow1({width:825, height:420, caption:_caption, page:'./forms/add_client.php?close=1', modal:true,
				onClose: function(){}
			})		
		} else {
			if (_data=='PRIVILEGE'){
				kiklopMessage(PrivilegueMessage, _caption, CloseText)
			} else {
				kiklopMessage(DenyAddProjectMessage, _caption, CloseText)	
			}				
		}
			
	})	
}
function addNewTeam(_caption){
	$.ajax({url: "./action/teams.php?action=check&"}).done(function(_data) {
		_data = _data.replace(/\r/g,'').replace(/\n/g,'');
		if (_data=='TRUE'){
			$.kiklopWindow({width:545, height:274, caption:_caption, page:'./forms/add_team.php', modal:true,
				onClose: function(){}
			})		
		} else {
			if (_data=='PRIVILEGE'){
				kiklopMessage(PrivilegueMessage, _caption, CloseText)
			} else {
				kiklopMessage(DenyAddProjectMessage, _caption, CloseText)	
			}				
		};
			
	})	
}
function EditTeam(_caption, _id){
	$.kiklopWindow({width:545, height:274, caption:_caption, page:'./forms/edit_team.php?id='+_id, modal:true,
		onClose: function(){}
	})			
}
function EditMember(_caption, _id){
	$.kiklopWindow({width:545, height:515, caption:_caption, page:'./forms/edit_member.php?id='+_id, modal:true,
		onClose: function(){}
	})			
}
function EditProject(_caption, _id){
	$.kiklopWindow({width:545, height:274, caption:_caption, page:'./forms/edit_project.php?id='+_id, modal:true,
		onClose: function(){}
	})			
}
function EditClient(_caption, _id){
	$.kiklopWindow({width:825, height:420, caption:_caption, page:'./forms/edit_client.php?id='+_id, modal:true,
		onClose: function(){}
	})			
}

function addWorkspace(_caption){
	$.ajax({url: "./action/workspaceadd.php?action=check&"}).done(function(_data) {
		_data = _data.replace(/\r/g,'').replace(/\n/g,'');
		if (_data=='TRUE'){
			$.kiklopWindow({width:545, height:230, caption:_caption, page:'./forms/add_workspace.php', modal:true,
				onClose: function(){}
			})
		} else
		{
			kiklopMessage(DenyAddWorkspaceMessage, _caption, CloseText)
		}
	})
}

function addNewMember(_caption){
	$.ajax({url: "./action/members.php?action=check&"}).done(function(_data) {
		_data = _data.replace(/\r/g,'').replace(/\n/g,'');
		if (_data=='TRUE'){
			$.kiklopWindow({width:545, height:515, caption:_caption, page:'./forms/add_member.php', modal:true,
				onClose: function(){}
			})		
		} else {
			if (_data=='PRIVILEGE'){
				kiklopMessage(PrivilegueMessage, _caption, CloseText)
			} else {
				kiklopMessage(DenyAddProjectMessage, _caption, CloseText)	
			}	
		}
			
	})	
}

function openSettings(_caption){
	$.kiklopWindow({width:667, height:570, caption:_caption, page:'./forms/settings.php', modal:true,
		onClose: function(){}
	})		
}


function addNewTask(_userID, _projectID, _clientID){
	if (_userID==null){_userID==''}; if (typeof _userID == "undefined"){_userID=''}
	if (_projectID==null){_projectID==''}; if (typeof _projectID == "undefined"){_projectID=''}
	if (_clientID==null){_clientID==''}; if (typeof _clientID == "undefined"){_clientID=''}
	$.kiklopWindow({width:600, height:570, caption:_captionAddNewTask, page:'./forms/add_task.php?userid='+_userID+'&projectid='+_projectID+'&clientid='+_clientID, modal:true,
		onClose: function(){
			$.kiklopMessageClose()
		}
	})
}
function EditTaskForm(_id, _idx){
	$.kiklopWindow({width:600, height:570, caption:_captionEditTask, page:'./forms/edit_task.php?id='+_id+'&idx='+_idx, modal:true,
		onClose: function(){
			$.kiklopMessageClose()
		}
	})
}

function OpenInvitationWSWindow(){
	$.ajax({url: "./action/ws_invitation.php?action=check"}).done(function(_data) {
		_data = _data.replace(/\r/g,'').replace(/\n/g,'');
		if (_data=="TRUE"){
			$.kiklopWindow({width:545, height:200, caption:invitationCaption, page:'./forms/ws_invitation.php', modal:true,
				onClose: function(){
					
				}
			})				
		}
	})
	
}


function shareItem(_type, _id){
	$.kiklopWindow({width:550, height:500, caption:ShareCaption, page:'./forms/share.php?type='+_type+'&id='+_id, modal:true,
		onClose: function(){
			/*if ((_type=='PR') && (MiddleType=='Project')){
				ReloadMiddleList()	
			}
			if ((_type=='CL') && (MiddleType=='Client')){
				ReloadMiddleList()	
			}*/			
		}
	})
}


function ShowShareIcon(el){
	return
	var icn = $(el).children(".tfm-private-icon")
	if ($(icn[0]).is(":visible")==false){
		$(icn[0]).css({display:'inline-block'})
	}
}
function HideShareIcon(el){
	return
	var icn = $(el).children(".tfm-private-icon")
	if ($(icn[0]).is(":visible")==true){
		$(icn[0]).css({display:'none'})
	}
}

function SetTaskPanelPosition(){
	var docWidth = $(window).width()
	var docHeight = $(document.body).height()
	var _width = docWidth-865-5
	var _left = 865
	if (_width<400){
		_width = 400
		_left = docWidth-10-400
	}
	if (_width>570){
		_width = 570
	}
	//$('#task-panel').css({width:'570px', left:'270px', top:'200px', height:'100px', display:'block', opacity:0})
	$('#task-panel').css({width:_width+'px', left:_left+'px', top:'0px', height:(docHeight-13)+'px'})
	//$('#task-panel').animate({width:_width+'px', left:_left+'px', top:'0px', height:(docHeight-13)+'px', opacity:1},400)
}
function SetPanelPosition(_id){
	var docWidth = $(window).width()
	var docHeight = $(document.body).height()
	var _width = docWidth-865-5
	var _left = 865
	if (_width<400){
		_width = 400
		_left = docWidth-10-400
	}
	if (_width>570){
		_width = 570
	}
	//$('#task-panel').css({width:'570px', left:'270px', top:'200px', height:'100px', display:'block', opacity:0})
	$('#'+_id).css({width:_width+'px', left:_left+'px', top:'0px', height:(docHeight-13)+'px'})
	//$('#task-panel').animate({width:_width+'px', left:_left+'px', top:'0px', height:(docHeight-13)+'px', opacity:1},400)
}

function SelectThisRow(el){
	
	$(".trList-sel").removeClass("trList-sel").addClass("trList")
	$(el).removeClass("trList").addClass("trList-sel")
}
var SelectedTaskID = 0;
var SelectedMessageID = 0;
function ShowTaskPanel(taskid, _idx, e){
	if (_idx==null){_idx='2'}
	if (typeof _idx == "undefined"){_idx='2'}
	var backmessageid = 0;
	if(e != undefined)
	{
		if(e.target.className.indexOf("attachment") != -1)
			_idx = 3;
		if(e.target.className.indexOf("reminder") != -1)
			_idx = 4;
		if(e.target.className.indexOf("k-chk16") != -1)
			_idx = 5;
		if(e.target.className.indexOf("follow") != -1)
			_idx = 6;
		if(e.target.className.indexOf("worktime") != -1)
			_idx = 7;
		if(e.target.className.indexOf("costs") != -1)
			_idx = 8;
		if(e.target.parentNode.id == 'switch_to_task' || e.target.id == 'switch_to_task')
			var backmessageid = SelectedMessageID;
	}
	
	HideWelcomeInfo();
	
	SelectedTaskID = taskid
	SetPanelPosition('task-panel')
	$('#task-panel').html('<span class="ajax-loader"></span>')
	$('#task-panel').load('./ajax/task_panel.php?id='+taskid+'&idx='+_idx+'&messid='+backmessageid, function(){
		kiklopSetTip()
	})
	if ($('#task-panel').is(":visible")==false){		
		$('#task-panel').fadeIn('fast')		
	}
}
function ShowMessagePanel(messageid){
	SelectedMessageID = messageid
	SetPanelPosition('message-panel')
	$('#message-panel').html('<span class="ajax-loader"></span>')
	$('#message-panel').load('./ajax/message_panel.php?messid='+messageid, function(){
		kiklopSetTip()
	})
	if ($('#message-panel').is(":visible")==false){		
		$('#message-panel').fadeIn('fast')		
	}
}
function HideTaskPanel(){
	if ($('#task-panel').is(":visible")==true){
		$('#task-panel').fadeOut('fast')	
	}
}
function HideMessagePanel(){
	if ($('#message-panel').is(":visible")==true){
		$('#message-panel').fadeOut('fast')	
	}
}
function HideWelcomeInfo()
{
	$('#ChangeWorkspace').fadeOut('fast', function(){
		$('#main-panel-div').removeClass('mpheight');
		setPanel1Height();
	});
}
function HideNotifications()
{
	$('#ShowNotifications').fadeOut('fast', function(){
		$('#main-panel-div').removeClass('mpheight1');
		//$('#main-panel-div').css({height: 'calc(100% - 0px)', height: '-webkit-calc(100% - 0px)', height: '-moz-calc(100% - 0px)'});
		setPanel1Height();
		//var id = $('#spanNotif')[0].attributes[0].nodeValue;
		var id = $('#inputNotif').val();
//alert(document.getElementById('spanNotif').attributes[0].value)
//debugger;
		$.ajax({url: "./ajax/removenotifications.php?id=" + id}).done(function(_data) {
		})	
		$('#spanNotifications1').html('');
		$("#spanNotifications1").css({display:'none'})
	});
}
function ClickTaskDetailArrow(){
	var newUD = 'down'
	if (TaskDetailUPDown=='down'){newUD='up'}
	TaskDetailUPDown = newUD
	setTaskDetailHeight(newUD)
}

function setTaskDetailHeight(updown){
	
	if ($('#task-panel').is(":visible")==false){
		return
	}
	
	if (updown==null){updown=TaskDetailUPDown}
	
	$('#div-task-detail-up').css({overflow:'hidden', maxHeight:'70%'})
	var minup = $("#div-task-detail-up").height()
	var wndHeight = $(window).height()
	var topHeight = wndHeight-minup-40-20-TretPanelKorekcija
	if (topHeight<260){
		
		//ova treba da se preraboti		
	}
	$('#div-task-detail-down').css({height:topHeight+'px'})
	
	$('#div-task-detail-up').css({height:minup+'px'})
	$('#icon-task-detail-arrow').removeClass('k-down').removeClass('k-arrow-up').addClass("k-arrow-down")
	return
		
	if (updown=='up'){
		var minDown = 160
		var wndHeight = $(window).height()
		var topHeight = wndHeight-minDown-40-40-20
		$('#div-task-detail-up').css({height:topHeight+'px'})
		$('#div-task-detail-down').css({height:minDown+'px'})
		$('#icon-task-detail-arrow').removeClass('k-down').removeClass('k-arrow-down').addClass("k-arrow-up")
	}
	if (updown=='down'){
		var minup = 260
		var wndHeight = $(window).height()
		var topHeight = wndHeight-minup-40-40-20
		$('#div-task-detail-down').css({height:topHeight+'px'})
		$('#div-task-detail-up').css({height:minup+'px'})
		$('#icon-task-detail-arrow').removeClass('k-down').removeClass('k-arrow-up').addClass("k-arrow-down")
	}
	
}

function ReLoadTask(_idx){
	$('#task-panel').load('./ajax/task_panel.php?id='+SelectedTaskID+'&idx='+_idx, function(){
		kiklopSetTip()
	})	
}

function OnMouseEnterPC(el){
	$(el).children(".tfm-private-icon").css({display:'inline-block'})
}
function OnMouseOutPC(el){
	$(el).children(".tfm-private-icon").css({display:'none'})		
}
function OnMouseEnterME(el){
	$(el).find(".k-plus-blue").css({opacity:1})
}
function OnMouseOutME(el){
	$(el).find(".k-plus-blue").css({opacity:0})		
}
function getTaskCounters(taskID){
	$.ajax({url: "./ajax/gettaskcounters.php?tid="+taskID}).done(function(_data) {
		_data = _data.replace(/\r/g,'').replace(/\n/g,'');
		cnts = _data.split("#");
		$("#span-ccomments").html(cnts[2])
		$("#span-cfiles").html(cnts[0])
		$("#span-creminders").html(cnts[1])
		$("#span-ccheck").html(cnts[4])
		$("#span-cfollowers").html(cnts[3])
		$("#span-cworktime").html(cnts[5])	
		$("#span-ccost").html(cnts[6])	
		$("#task-list-"+taskID).load("./ajax/middle_list_task.php?type="+MiddleType+"&id="+taskID)
	})	
}
function getPanelCounters(_type) {
	$.ajax({url: "./ajax/getpanelcounters.php?type="+_type}).done(function(_data) {
		_data = _data.replace(/\r/g,'').replace(/\n/g,'');
		if(_type == 'all')
		{
			cnts = _data.split("#");
			$("#span-mytasks-cnt").html(cnts[0]);
			$("#span-followers-cnt").html(cnts[1]);
			$("#span-activetasks-cnt").html(cnts[2]);
			$("#span-workspaces-cnt").html(cnts[3]);
			$("#span-myinbox-cnt").html(cnts[4]);
		} else
			$("#span-"+_type+"-cnt").html(_data);
	})	
}
function getNotifications() {
	//if ($('#ChangeWorkspace').css('display') == "none" && $('#ShowNotifications').css('display') == "none") {
	if ($('#ChangeWorkspace').css('display') == "none") {
		$.ajax({url: "./ajax/getnotifications.php"}).done(function(_data) {
			_data = _data.replace(/\r/g,'').replace(/\n/g,'');
			if (_data != "-") {
				$("#spanNotifications").html(_data);
				$('#ShowNotifications').fadeIn('fast', function(){
					$('#main-panel-div').addClass('mpheight1');
					setPanel1Height()
				});
			} else {
				HideNotifications();
			}	
		})	
	}
}
function OpenNotifications() {
	$("#spanNotifications1").css({width: ($('#ShowNotifications')[0].clientWidth - 10) + 'px'})
	if (openNotif == 0) openNotif = 1;
	else openNotif = 0;
	if (openNotif == 1) {
		$.ajax({url: "./ajax/opennotifications.php"}).done(function(_data) {
			_data = _data.replace(/\r/g,'').replace(/\n/g,'');
			if (_data != "-") {
				$('#spanNotifications1').fadeIn('fast', function(){
					$("#spanNotifications1").html(_data);
				});
			}
		})
	} else {
		$('#spanNotifications1').fadeOut('fast', function(){
		});
	}
}
function MarkAsRead(_id, _type){
	$.ajax({url: "./action/markasread.php?action=update&messid="+_id+"&type="+_type}).done(function(_data) {
		if(_id == 'AllRead')
		{
			$('.allreadunread').css({ backgroundColor: '#EBEBEB', border: '1px solid #BEBEBE'});
		} else
			if(_id == 'AllUnRead')
			{
				$('.allreadunread').css({ backgroundColor: '#4FC4F6', border: '1px solid #09A8C3'});
			}
		getPanelCounters("myinbox");
	})	
}

var TaskForDelete = 0
function deleteTask(taskID){
	TaskForDelete = taskID
	$.ajax({url: "./action/tasks.php?action=delete&id="+taskID}).done(function(_data) {
		HideTaskPanel()
		$("#task-list-"+TaskForDelete).fadeOut("fast", function(){
			$("#task-list-"+TaskForDelete).remove();
		})
		getPanelCounters("mytasks");
	})	
}


function MoreDetailsList(){
	cn = $('#icn-more-detail').attr("class")
	if (cn.indexOf('k-right-tiny')>=0){
		$('#icn-more-detail').removeClass("k-right-tiny").addClass("k-down-tiny")
		$('.tfm-list-detail').css({display:''})	
		$.ajax({url: "./action/other.php?d=1"})
		$('#icn-more-detail').attr("title","Hide more details");
		$('#icn-more-detail').tipTip({maxWidth: "auto", edgeOffset: 10, delay: 100});
	} else {
		$('#icn-more-detail').removeClass("k-down-tiny").addClass("k-right-tiny")
		$('.tfm-list-detail').css({display:'none'})
		$.ajax({url: "./action/other.php?d=0"})
		$('#icn-more-detail').attr("title","Show more details");
		$('#icn-more-detail').tipTip({maxWidth: "auto", edgeOffset: 10, delay: 100});
	}
	
}


function ShowSelectedUser(_type, _id){
	
	$("#div-selected-user").load('./ajax/tmcaption.php?type='+_type+'&id='+_id, function(){
		if ($("#div-selected-user").is(":visible")==false){$("#div-selected-user").fadeIn('fast');}
	})
	//$("#span-selected-user").html(_title)
	//$("#div-selected-user").fadeIn('fast');
}
function hideSelectedUser(){
	$("#div-selected-user").fadeOut('fast');
	_selectedUserMember='';
	_selectedUserTeam='';
	LoadList()
	LoadMembers(); 
	LoadTeams();
	LoadMiddleList('MyTasks',-1)	
}
function ReloadEditTask(_data, tousr, usr, idx, proj, cli, taskid){
	if(_data != tousr && _data != "TRUE")
	{
		//ReloadMiddleList();
		$("#task-list-"+taskid).fadeOut("fast", function(){
			$(this).remove();
		})
	} else
	{
		$("#task-list-"+taskid).load("./ajax/middle_list_task.php?type="+MiddleType+"&id="+taskid);
	}
	ReLoadTask(idx);
}
function ReloadAddTask(_data, tousr, usr, idx, proj, cli, taskid)
{
	if(_data == '-1')
	{
		LoadMiddleList('MyFollow',-1);
	} else
	{
		$.kiklopWindow({width:500, height:440, caption:_captionSuccAddNewTask, page:'./forms/add_task_success.php?action=addnew&userid='+tousr+'&projectid='+proj+'&clientid='+cli+'&taskid='+taskid, modal:true,
			onClose: function(){
				$.kiklopMessageClose()
			}
		})
	}
}
function LoadTasksOnCalendarParam(_date){
	if(_selectedUserTeam == '')
		var teaid = 0;
	else
		var teaid = _selectedUserTeam;
	clickDay = _date;
	$('#txt_cal').DatePickerSetDate(_date, true);
	$.ajax({url: "./ajax/reload_calendar.php?date="+_date+"&uid="+_selectedUserMember+"&tid="+teaid}).done(function(_data) {
		_data = _data.replace(/\r/g,'').replace(/\n/g,'');

		var dayswithtasks = _data.split("*");
		fromdt = ","+dayswithtasks[0]+",";
		todt = ","+dayswithtasks[1]+",";
		remindersdt = ","+dayswithtasks[2]+",";
		eventdt = ","+dayswithtasks[3]+",";
		LoadTasksOnCalendar();
	})	
}
function LoadTasksOnCalendar()
{
	var cntSpanItem = $('.datepickerDays').find('span').length;
	for(var i = 0; i < cntSpanItem; i++)
	{
		var _className = $($('.datepickerDays').find('span')[i]).parent().parent().attr('class');
		if(_className == '' || _className == 'datepickerSelected' || _className == 'datepickerSaturday' || _className == 'datepickerSunday' || _className == 'datepickerSaturday datepickerSelected' || _className == 'datepickerSunday datepickerSelected')
		{
			_num = $($('.datepickerDays').find('span')[i]).html();
			
			_html = '<div style="height: 5px; margin-top: -8px; position: absolute; width: 31px;">';
			var checkbool = false;
			if(fromdt.indexOf(","+_num+",") != -1)
			{
				_html += '<span class="calendarTaskStart"></span>';
				checkbool = true;
			}
			if(todt.indexOf(","+_num+",") != -1)
			{
					_html += '<span class="calendarTaskEnd"></span>';
				checkbool = true;
			}
			if(remindersdt.indexOf(","+_num+",") != -1)
			{
					_html += '<span class="calendarTaskReminder"></span>';
				checkbool = true;
			}
			if(eventdt.indexOf(","+_num+",") != -1)
			{
					_html += '<span class="calendarTaskEvent"></span>';
				checkbool = true;
			}
			_html += '</div>';
			if(checkbool)
				$($('.datepickerDays').find('span')[i]).parent().html(_num + _html);
			cntSpanItem = $('.datepickerDays').find('span').length;	
		}
	}
}
function addNewEvent(_userID, _projectID, _clientID){
	$.kiklopWindow({width:600, height:590, caption: _cAddNewEvent, page:'./forms/add_event.php', modal:true,
		onClose: function(){
			$.kiklopMessageClose()
		}
	})
}
function DeleteEvent(eventID){
	$.ajax({url: "./action/events.php?action=delete&eid="+eventID}).done(function(_data) {
		$.kiklopWindowClose()
		LoadTasksOnCalendarParam(clickDay);
		LoadMiddleListEvents('Events', clickDay);
	})	
}
function deleteEv(_eid){
	var msg2 = escape(_cDelEvent)
	kiklopWindow2('./forms/yesno1.php?msg='+msg2+'&yes=DeleteEvent('+_eid+')', _Message, 380, 260, function(){
		
	})   
}
function editEvent(_eid){
	$.kiklopWindow({width:600, height:590, caption:_cEditEvent+'<span onclick="deleteEv('+_eid+')" class="kiklop-icon k-delete-white1 kiklop-wnd-button3"></span>', page:'./forms/edit_event.php?eid='+_eid, modal:true,
		onClose: function(){}
	})			
}
function LoadMiddleListEvents(_type, _date, _closeTaskPanel){
	if (_closeTaskPanel==null){_closeTaskPanel=true}
	if (_closeTaskPanel==true){HideTaskPanel(); HideMessagePanel(); } 
	MiddleType = _type
	MiddleDate = _date
	$('#middle-list').html('<span class="ajax-loader"></span>')
	$("#middle-list").load("./ajax/middle_list_events.php?type="+_type+"&date="+_date+"&userid="+_selectedUserMember+"&teamid="+_selectedUserTeam, function(){
		kiklopSetTip()
	})
}
function ReloadMiddleListEvents(){
	LoadMiddleListEvents(MiddleType, MiddleDate, false)
}
function DefocusElement(obj, discard, column, taskid, idx, _desc){
	if(discard == '0')
	{
		$(obj).removeClass("editableelement"+_desc);
		$('#result').css({display: 'none'});
		if($(obj).html() != localStorage.contenteditable)
		{
			$.ajax({url: './action/tasksOneClick.php?id='+taskid+'&content='+$(obj).html()+'&column='+column}).done(function(_data) {				
				$("#task-list-"+taskid).load("./ajax/middle_list_task.php?type="+MiddleType+"&id="+taskid);
				ReLoadTask(idx)
			})
		}
	} else
	{
		$(obj).removeClass("editableelement"+_desc);
		$('#result').css({display: 'none'});
	}
}
function FocusElement(obj, column, _desc){
	focusElement = $(obj).html();
	localStorage.setItem('contenteditable', $(obj).html());
	$(obj).addClass("editableelement"+_desc);
	$('#result').css({display: 'block'});
}
function DiscardChange(e, obj, column, taskid, idx){
	if(e.keyCode == 27)
	{
		$(obj).html(localStorage.contenteditable);
		//$(obj).removeClass("editableelement");
		DefocusElement(obj, '1', column, taskid);
	}
	/*if(parseInt($(obj).html().length, 10) >= 60)
	{
		
		$(obj).html($(obj).html().substring(0, ($(obj).html().length)-1));
	}*/
}
var tmpContent = '';
function DisableEnterDown(e, obj){
    if(e.keyCode == 13) {
		tmpContent = $(obj).html();
    }
}
function DisableEnterUp(e, obj){
    if(e.keyCode == 13) {
       	$(obj).html(tmpContent);
    }
}

 function kescape(_tekst){
	_tekst = escape(_tekst).replace(/\+/g, '%plus%');
	return _tekst;
}

function resendInvitation(_memid){
	$.ajax({url: './action/members.php?mid='+_memid+'&action=reinvite'}).done(function(_data) {				
		
	})
	kiklopMessage(_ReinviteOK, '', CloseText)
}

