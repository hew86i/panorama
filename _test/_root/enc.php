<?php
/**
 * simple method to encrypt or decrypt a plain text string
 * initialization vector(IV) has to be the same when encrypting and decrypting
 * PHP 5.4.9
 *
 * this is a beginners template for simple encryption decryption
 * before using this in production environments, please read about encryption
 *
 * @param string $action: can be 'encrypt' or 'decrypt'
 * @param string $string: string to encrypt or decrypt
 *
 * @return string
 */

include './include/functions.php';
include './include/verifyEmail.php';
include 'smtp-validate-email.php';


echo "start \n";



// $from = 'h14030@gmail.com'; // for SMTP FROM:<> command
// $email = 'info2@gps.mk';

// $validator = new SMTP_Validate_Email($email, $from);
// $smtp_results = $validator->validate();
// echo '<pre>';
// var_dump($smtp_results);
// $isExistingMail = $smtp_results[$email];
// if($smtp_results[$email]) {
// 	echo "the email exists!";
// } elseif(!$smtp_results[$email]){
// 	echo "the email does not exists!";
// }

// echo '</pre>';



?>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

<script>
	

</script>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <!-- <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet" /> -->
   <!--  <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet" /> -->
    <!-- <link href="style.css" rel="stylesheet" /> -->

</head>
    <body>
        <!-- <h1>Toastr with FontAwesome Icons</h1>
        <ul class="icons-ul">
            <li><i class="icon-li icon-ok"></i>Embedded icon using the &lt;i&gt; tag</li>
            <li><i class="icon-li icon-ok"></i>Doesn't work with background-image</li>
            <li><i class="icon-li icon-ok"></i>We can use the :before psuedo class</li>
            <li><i class="icon-li icon-ok"></i>Works in IE8+, FireFox 21+, Chrome 26+, Safari 5.1+, most mobile browsers</li>
            <li><i class="icon-li icon-ok"></i>See <a href="http://caniuse.com/#search=before">CanIUse.com</a> for browser support</li>
        </ul>
        <button class="btn btn-primary" id="tryMe">Try Me</button> -->
        <div id="dialog" title="File Download">
          <div class="progress-label">Starting download...</div>
          <div id="progressbar"></div>
        </div>
        <button id="downloadButton">Start Download</button>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js" ></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
          <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
       <!--  <script src="script.js"></script> -->
       <style>
		#toast-container {
			@extends .text1;
			padding-top: 100px;
		}
       #progressbar {
    margin-top: 20px;
  }
 
  .progress-label {
    font-weight: bold;
    text-shadow: 1px 1px 0 #fff;
  }
 
  .ui-dialog-titlebar-close {
    display: none;
  }
       </style>
       <script>

          $(function() {
    var progressTimer,
      progressbar = $( "#progressbar" ),
      progressLabel = $( ".progress-label" ),
      dialogButtons = [{
        text: "Cancel Download",
        click: closeDownload
      }],
      dialog = $( "#dialog" ).dialog({
        autoOpen: false,
        closeOnEscape: false,
        resizable: false,
        buttons: dialogButtons,
        open: function() {
          progressTimer = setTimeout( progress, 2000 );
        },
        beforeClose: function() {
          downloadButton.button( "option", {
            disabled: false,
            label: "Start Download"
          });
        }
      }),
      downloadButton = $( "#downloadButton" )
        .button()
        .on( "click", function() {
          $( this ).button( "option", {
            disabled: true,
            label: "Downloading..."
          });
          dialog.dialog( "open" );
        });
 
    progressbar.progressbar({
      value: false,
      change: function() {
        progressLabel.text( "Current Progress: " + progressbar.progressbar( "value" ) + "%" );
      },
      complete: function() {
        progressLabel.text( "Complete!" );
        dialog.dialog( "option", "buttons", [{
          text: "Close",
          click: closeDownload
        }]);
        $(".ui-dialog button").last().focus();
      }
    });
 
    function progress() {
      var val = progressbar.progressbar( "value" ) || 0;
      var progressplus = val + Math.floor( Math.random() * 3 );
      progressbar.progressbar( "value", progressplus );
      toastr.options ={  "positionClass": "toast-top-centar", "timeOut": "450"};toastr.options = {
  "closeButton": false,
  "debug": true,
  "newestOnTop": true,
  "progressBar": false,
  "positionClass": "toast-top-center",
  "preventDuplicates": true,
  "onclick": null,
  "showDuration": "10",
  "hideDuration": "10",
  "timeOut": "30",
  "extendedTimeOut": "5",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
      toastr.info("+ " + progressplus);
      if ( val <= 99 ) {
        progressTimer = setTimeout( progress, 50 );
      }
    }
 
    function closeDownload() {
      clearTimeout( progressTimer );
      dialog
        .dialog( "option", "buttons", dialogButtons )
        .dialog( "close" );
      progressbar.progressbar( "value", false );
      progressLabel
        .text( "Starting download..." );
      downloadButton.focus();
    }
  });


       var number = Math.random();       
      
  //    toastr.info("nubmer * 1000 + 1: " + ((number*1000)+1));
//      toastr.info("round: " + Math.floor((number*1000)+1));
      // toastr.info(Math.floor(Math.random() * 10) + 1);
			// toastr.info((Math.random() * 10) + 1);
       </script>

       <?php phpinfo(); ?>
    </body>
</html>