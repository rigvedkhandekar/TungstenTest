<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>DJSCE | Moderator Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	  <base href="../../login-template/">
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
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form class="login100-form validate-form" id='staff-login' method="POST">

                  	<span >

                    <div class="div-img-banner" id="div-img-banner">
					<img src="images/icons/banner.jpg" class="img mb-3" alt="Cinque Terre" width="100%;">
				</div>
                        	<p class="login100-form-title p-b-33" id="header-text">Moderator Login</p>

				</span>


                    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text"  placeholder="Email" name="input_email" id="input_email">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" placeholder="Password" name="input_password" id="input_password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn" name="submit-login">
							Sign in
						</button>
					</div>
                    <span class="login100-form m-t-20" id="res-msg" style="text-align: center; display: block; color: red; "></span>

                </form>
			</div>
		</div>
	</div>



<!--===============================================================================================-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

        $("#staff-login").submit(function (event) {

            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../../admin/login/login.php',
                data: {
                    input_email: $('#input_email').val().trim(),
                    input_password: $('#input_password').val().trim(),
                    'submit-login': '1'
                },
                success: function (data) {
                    dataObj = JSON.parse(data);
                    console.log(dataObj)
                    if (dataObj['login-success'] == true) {
                        console.log('login success')
                        window.location.href = "../../admin/all-exams/";
                    } else {
                        $('#staff-login').trigger("reset");
                        $('#res-msg').text('Invalid Credentials')

                    }
                },

                statusCode: {
                    409: function () {
                        $('#staff-login').trigger("reset");
                        $('#res-msg').text('Invalid Credentials')
                    }
                },

                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.error("Status : " + textStatus);
                    console.error("Error  : " + errorThrown);
                }
            });
        });
    });
    </script>

</body>
</html>
