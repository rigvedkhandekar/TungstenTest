<?php
require ('../../util/strings.php');
session_start();
session_destroy ();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $project_name; ?> Student Login</title>
    <meta charset="UTF-8">
    <base href="/login-template/">

    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">

	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->

</head>

<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<span >
					<p class="login100-form-title p-b-33" id="header-text">Student Login</p>
					<center>
						<h5 class="login100-form-sub-title p-b-40" id="sub-header-text" style="display :none;"></h5>
					</center>
				</span>

				<div class="div-img-success" id="div-img-success" style="display :none;">
				<center>	<img src="images/a.png" class="img mb-3" alt="Cinque Terre"> </center>
				</div>
				<div class="wrap-input100 form-group m-t-2" id="div-input-otp" style="display : none;">
					<input class="input100" type="text" name="input-otp" id="input-otp" placeholder="Enter the OTP" required maxlength="6">
				</div>


				<form class="login100-form validate-form" action="../../student/login/index.php" id="student-login" method="POST">

					<div class="wrap-input100 validate-input form-group" id="div-rollno">
						<input class="input100" type="text" name="rollno" id="rollno" placeholder="Roll no" required maxlength="2">

					</div>

					<div class="form-group" data-validate="Select Department" id="div-dept">
						<select name="dept" id="dept" class="form-control" required>
							<option selected disabled value="">Select Department</option>
							<option value="101">Computer Engineering</option>
							<option value="102">Information Technology</option>
							<option value="103">Electronics & Tel.</option>
						</select>
					</div>



					<div class="form-group" data-validate="Select Year" id="div-year">
						<select name="year" id="year" class="form-control" required>
							<option value="" disabled selected>Select Year</option>
							<option value="2nd">2<sup>nd</sup></option>
							<option value="3rd">3<sup>rd</sup></option>
						</select>
					</div>

					<div class="container-login100-form-btn m-t-20 form-group" id="div-submit-btn">
						<button class="login100-form-btn" name="submit-login" id="submit-login">
							Sign in
						</button>
					</div>


				</form>

				<div class="container-login100-form-btn m-t-20 form-group" id="div-verify-otp-btn" style="display : none;">
					<button class="login100-form-btn" name="verify-otp" id="verify-otp" onclick="verifyOtp();">
						Confirm OTP
					</button>
				</div>

				<div id="recaptcha-container"></div>
			</div>
		</div>
	</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="vendor/animsition/js/animsition.min.js"></script>
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.3/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<script src="vendor/countdowntime/countdowntime.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.4/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.4/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.4/firebase-auth.js"></script>
<script src="../../js/cryptojs-aes.min.js"></script>
<script src="../../js/cryptojs-aes-format.js"></script>


<script>
    $(document).ready(function() {
        const AeshHash = '0188997453';
        let isCaptchaSolved = false;

        $("#student-login").submit(function (event) {

            event.preventDefault();
            if (!isCaptchaSolved)
                alert('Please solve the captcha')
            else {
                $.ajax({
                    type: 'POST',
                    url: '../../student/login/login.php',
                    data: {
                        rollno: $('#rollno').val(),
                        dept: $('#dept').val(),
                        year: $('#year').val(),
                        'submit-login': 1
                    },

                    success: function (data) {
                        var dataObj = JSON.parse(data)
                        if (dataObj.success == '1') {
                            //contactNo = CryptoJS.AES.decrypt(dataObj.contact_no, AeshHash, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8).replace(/\"/g, "");
                            contactNo = dataObj.contact_no;
                            submitPhone(contactNo)
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Error Occured");
                    }
                });
            }
        });

        var firebaseConfig = {
            apiKey: "AIzaSyB8FJj4fP7NKR2GM2GW6Z2754bPelcnPCc",
            authDomain: "oep-bgit.firebaseapp.com",
            databaseURL: "https://oep-bgit.firebaseio.com",
            projectId: "oep-bgit",
            storageBucket: "oep-bgit.appspot.com",
            messagingSenderId: "275012776149",
            appId: "1:275012776149:web:d078fccf43ee04c056b25c",
            measurementId: "G-VT6NPJELDG"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        firebase.analytics();
        firebase.auth()


        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
            'size': 'normal',
            'callback': function (response) {
                isCaptchaSolved = true;
            },
            'expired-callback': function () {
                // Response expired. Ask user to solve reCAPTCHA again.
                // ...
            }
        });

        recaptchaVerifier.render().then(function (widgetId) {
            window.recaptchaWidgetId = widgetId;
        });


    });

    function verifyOtp() {
            var code = $('#input-otp').val();
            console.log(code);
            confirmationResult.confirm(code).then(function (result) {
                // User signed in successfully.
                alert("OTP verified successfully")
                $.ajax({
                        type: 'POST',
                        url: '../../student/login/session.php',
                        data: {
                            contactNo: contactNo,
                            year: $('#year').val().substring(0,1),
                            dept: $('#dept').val()
                        },
                        success: function (data) {
                            window.location.href = "../../student/dashboard/";
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            alert("Error Occured");
                        }
                    }
                );
                // ...
            }).catch(function (error) {
                console.log (error)
                alert("OTP didnt match.")
            });
        }

        function submitPhone(contactNo) {
            var phoneNumber = "+91" + Number(contactNo);
            console.log(phoneNumber);
            var appVerifier = window.recaptchaVerifier;
            firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                .then(function (confirmationResult) {
                    window.confirmationResult = confirmationResult;
                    console.log("Result :" + confirmationResult);
                    showOtpScreen();
                }).catch(function (error) {
                console.log("Error : " + error);
                console.log("Resetting recpatcha");
                grecaptcha.reset(window.recaptchaWidgetId);
                window.recaptchaVerifier.render().then(function (widgetId) {
                    grecaptcha.reset(widgetId);
                });
            });
        }

        function showOtpScreen() {
            $('#div-rollno').hide ();
            $('#div-dept').hide ();
            $('#div-year').hide ();
            $('#div-submit-btn').remove ();
            $('#div-verify-otp-btn').show();
            $('#div-input-otp').show();
            $('#div-img-success').show();
            $('#header-text').text("OTP has been successfully sent.");
            $('#sub-header-text').show();
            var maskedNo = contactNo.toString();
            maskedNo = maskedNo.substring(6);
            $('#sub-header-text').text("to your registered No. \n xxxxxx" + maskedNo);
            $('#recaptcha-container').hide();

        }
</script>
</body>
</html>
