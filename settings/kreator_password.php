<?php
header("Content-type: text/html; charset=utf-8");
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../style.css">
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/share.js"></script>
		<script type="text/javascript" src="../js/settings.js"></script>
		<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
		<script src="../js/jquery-ui.js"></script>
		<script>
		function sendInfo()
		 {
		 		var name = $("#name").val();
	     		var email = $("#email").val();
		 		var site = $("#site").val();
				var message = $("#message").val();
		
				$.ajax({
                url: "mailform.php?name="+name+"&email="+email+"&site="+site+"&message="+message, 
                context: document.body,
                success: function(data){
                    alert("mailform.php?name="+name+"&email="+email+"&site="+site+"&message="+message);
                    window.location.reload();
			      }
        		});
			return false;
         }
                   
		</script>
	</head>
<body>
	
<div align = "center">

 
<table border="0" cellspacing="0" cellpadding="4" width="90%" > 
<tr> 
    <td width="30%"><div align="right">Име:</div></td> 
    <td width="70%"><input type="text" id="name" size="30" /></td> 
</tr> 
 
<tr> 
    <td><div align="right">Email:</div></td> 
    <td><input type="text" id="email" size="30" /></td> 
</tr> 
 
<tr> 
    <td><div align="right">Веб страна:</div></td> 
    <td><input type="text" id="site" size="30" /></td> 
</tr> 
 
<tr> 
    <td><div align="right">Порака:</div></td> 
    <td><textarea id="message" cols="40" rows="4"></textarea></td> 
</tr> 
 
<tr> 
<td>&nbsp;</td> 
    <td> 
    <input type="submit" name="submit" value="Прати" onclick="sendInfo()"/> 

    </td> 
</tr> 
 
</table> 

</div>	
</body>
</html>