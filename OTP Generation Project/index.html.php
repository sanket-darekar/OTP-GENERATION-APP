<!DOCKTYPE html>
<html>
<head>
<title>How to implement OTP sms Mobile verification in php with text local </title>
<link href ="style.css"rel ="stylesheet"/>
</head>
<body>
 <div class="container">
  <div class="error"></div>
   <form id="form-mobile-verification">
    <div class="form-heading">Mobile Number Verification</div>
     
     <div class="form-row">
      <input type="number"id="mobile"class="form-input"placeholder="Enter the 10 digit Mobile">
     </div>
     
     <input type="button"class="btnsubmit"value="send OTP"onclic="sendotp();">
   </form>
  </div>
  <script src="jquery-3.6.1.min.js"type="text/javascript"></script>
  <script src="verification.js"></script>
 </body>
</html>					