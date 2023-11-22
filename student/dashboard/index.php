<?php
include '../../util/config.php';
include '../../util/util.php';
include '../../util/check-student-session.php';
include '../../util/strings.php';

$sid = $_SESSION['student-session']['key'];
$sYear = $_SESSION['student-session']['year'];
$student_dept = $_SESSION['student-session']['dept'];
$todaysDate = date('Y-m-d');
$currentTime = date('H:i:s');

?>
<head>
    <base href="../../template/">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>DJSCE | Student Dashboard</title>

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="favicon.ico" type="image/x-icon"/>

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.0.1/collection/components/icon/icon.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icon-kit@1.0.0/dist/css/iconkit.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/theme.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
   

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css'><link rel="stylesheet" href="../../template/dist/css/style.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.24/webcam.js"></script>
</head>

<body >
<div class="wrapper">
    <header class="header-top" header-theme="light">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <div class="top-menu d-flex align-items-center">
                    <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                </div>
                <div class="top-menu d-flex align-items-center">
                    <h5><?php echo $h5Tag; ?></h5>
                </div>
            </div>
        </div>
    </header>

    <div class="page-wrap">
        <div class="app-sidebar colored">
            <div class="sidebar-header">
                <a class="header-brand" href="index.html">
                    <!-- bs center ka kya tha?? kya bootsrap c ealnter align center? maybe -->
                    <div class="logo-img">
                        <img src="img/logo.jpg" width="55" class="rounded-circle" alt="user">
                    </div>
                    <!-- <span class="text">BGIT</span> -->
                </a>
                <button type="button" class="nav-toggle"><i data-toggle="expanded"
                                                            class="ik ik-toggle-right toggle-icon"></i></button>
                <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
            </div>

            <div class="sidebar-content">
                <div class="nav-container">
                    <nav id="main-menu-navigation" class="navigation-main">
                        <div class="nav-lavel">Exam</div>
                        <div class="nav-item active">
                            <a href="../../student/dashboard/"><i class="ik ik-bar-chart-2"></i><span>Assessments</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a href="../../student/my-attempts"><i class="ik ik-database"></i><span>My Attempts</span>
                            </a>
                        </div>
                        <div class="nav-lavel">Profile</div>
                        <div class="nav-item">
                            <a href="../../student/profile"><i class="ik ik-user"></i><span>View Profile</span> </a>
                        </div>
                        <div class="nav-lavel">Account</div>
                        <div class="nav-item">
                            <a href="../../student/login/logout.php"><i class="ik ik-log-out"></i><span>Logout</span>
                            </a>
                        </div>

                    </nav>
                </div>
            </div>
        </div>

        <div class="main-content">
<!-- <button type="button" id="open-modal-btn" class="btn btn-primary">Open Modal</button> -->


                        <div class="modal fade " id="pictureModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="demoModalLabel">Prerequisites</h5>
                                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> -->
                                    </div>
                                    <div class="modal-body">
                                    <!-- Multi step form --> 
<section class="multi_step_form">  
  <form id="msform"> 
    <!-- Tittle -->
    <div class="tittle">
      <h2 id="modal-title">Face Registration</h2>
      <p id="modal-subtitle">In order to attempt the exam, you have to register your face id in college database.</p>
    </div>
    <!-- progressbar -->
    <ul id="progressbar" style="padding-left: 0px;">
      <li class="active">Allow Permissions</li>  
      <li>Capture Photo</li> 
      <li id="modal-step3">Save</li>
    </ul>
    <!-- fieldsets -->
    <!-- <! -----------  FIELDSET 01 ----------------------- > -->
    <fieldset> 
      <h3 id="lbl1">Please allow Camera and microphone Permissions</h3>
      <div class="mt-4">
      <img id="loader" src="https://media.tenor.com/joLYNfFQGDgAAAAi/loading.gif" alt="Loading..." >
</div>
      <button type="button" id="btn1" class="mt-4 next action-button" disabled>Continue</button>  

    </fieldset>  

    <fieldset>
      <h3>Capture your picture</h3>
      
      <div class="container">	
  <div class="row justify-content-center">
	<div class="col-lg-12" align="center">
		<!-- <label>Capture live photo</label> -->
		<div id="my_camera" class="pre_capture_frame" ></div>
		<input type="hidden" name="captured_image_data" id="captured_image_data">
		<br>
		<input type="button" class="next action-button" value="Take Picture" id="btn-snapshot">	
	</div>
	
  </div><!--  end row -->
</div><!-- end container -->

      
      <!-- <button type="button" class="next action-button">Continue</button>   -->
    </fieldset>  
    
    <fieldset>
      <h3>Confirm your picture</h3>
      <!-- <h6>Please update your account with security questions</h6>  -->
      <div style="display" class="col-lg-12" align="center">
		<!-- <label>Result</label> -->
		<div id="results" >
			<img style="width: 550px;" class="after_capture_frame" src="image_placeholder.jpg" />
		</div>
		<br>
		<!-- <button type="button" class="next action-button" onclick="saveSnap()">Save Picture</button> -->
	</div>
      <button type="button" class="action-button previous previous_button">Re-Take</button> 
      <button type="button" class="action-button" id="btn-submit-img">Submit</button> 
      <button type="button" class="action-button" id="btn-verify-img">Verify</button> 


    </fieldset>  
  </form>  
</section> 
<!-- End Multi step form -->   

</div>
                                </div>
                            </div>
                        </div>



            <?php
            if (isset($_GET['error']) && hex2bin($_GET['error']) == '402') {

                echo "
                                              <script>
                                              Swal.fire({
                                               title: 'Expired redirection...',
                                               html: 'Broken Link',
                                               icon: 'error',
                                               timer: 3000,
                                               allowOutsideClick: false,
                                               showCancelButton: false,
                                               showConfirmButton: false
                                               })
                                               .then(() => {
                                                 window.location.href = '../../student/dashboard/';
                                               });
                                           </script>";

            } else if (isset($_GET['error']) && hex2bin($_GET['error']) == 23000) {
                echo "
                                              <script>
                                              Swal.fire({
                                               title: 'Previous attempt found...',
                                               html: 'You are trying to re-attempt the same exam.',
                                               icon: 'error',
                                               timer: 3000,
                                               allowOutsideClick: false,
                                               showCancelButton: false,
                                               showConfirmButton: false
                                               })
                                               .then(() => {
                                                 window.location.href = '../../student/dashboard/';
                                               });
                                           </script>";
            }
            ?>

            <div class="mt-4 row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-block">
                            <h3>All Exams</h3>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap table-responsive">
                                    <colgroup>
                                        <col span="1" style="width: 100%;">
                                        <col span="2" style="width: 100%;">
                                        <col span="3" style="width: 100%;">
                                        <col span="4" style="width: 100%;">
                                        <col span="5" style="width: 100%;">
                                        <col span="6" style="width: 100%;">
                                    </colgroup>

                                    <thead>
                                    <tr>
                                        <th>Exam ID</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Subject</th>
                                        <th>Total Marks</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Duration</th>
                                        <th>Action</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $fetchExams = "SELECT `exam_data`.* ,`subjects`.`sub_name` as subject FROM `exam_data` INNER JOIN `subjects` ON `subjects`.`sub_id` = `exam_data`.`exam_subject` where `exam_year` = :year AND `exam_dept` = :student_dept";
                                    $stmt = $pdo->prepare($fetchExams);
                                    $stmt->execute(['year' => $sYear, 'student_dept' => $student_dept]);
                                    while ($data = $stmt->fetch()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $data['eid']; ?></td>
                                            <td><?php echo $data['exam_type']; ?></td>
                                            <td><?php echo $data['exam_date']; ?></td>
                                            <td><?php echo $data['subject']; ?></td>
                                            <td><?php echo $data['exam_marks']; ?></td>
                                            <td><?php echo $data['start_time']; ?></td>
                                            <td><?php echo $data['end_time']; ?></td>
                                            <td><?php $examDuration = $data['exam_duration'] / 60 / 60;
                                                echo $examDuration; ?> Hrs
                                            </td>
                                            <td>
                                                <?php
//   if ($data['exam_date'] == $todaysDate && checkStartTime(time(), $data['start_time']) && checkEndTime(time(), $data['end_time'])) {
                                                if ($data['exam_date'] == $todaysDate) {
                                                    ?>

                                                    <button type="button" name="attempt"
                                                            data-id= <?php echo $data['eid']; ?>
                                                            data-eid=<?php echo bin2hex($data['eid']); ?>
                                                            class="btn btn-success start-exam"> Start Exam
                                                    </button>
                                                <?php } else {
                                                    ?>
                                                    <button type="button" class="btn btn-success disabled" disabled>
                                                        Start Exam
                                                    </button>
                                                    <?php
                                                } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Exam ID</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Subject</th>
                                        <th>Total Marks</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Duration</th>
                                        <th>Action</th>

                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


         <footer class="footer">
                    <div class="w-100 clearfix">
                        <span class="text-center text-sm-left d-md-inline-block">Copyright © 2021 <?php echo $copyRightOwner; ?>. All Rights Reserved.</span>
                        <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Developed and Designed by  <?php echo $developerLink; ?></span>
                    </div>
                    <div id="status"></div>
                </footer>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="plugins/popper.js/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/screenfull.js/5.0.0/screenfull.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="dist/js/theme.min.js"></script>
<script src="js/datatables.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.3/moment.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js'></script><script  src="../../template/dist/js/script.js"></script>
<script type="text/javascript">


    $(document).ready(function () {

        var exam_id;
        
  $.ajax({
    url: '../../student/dashboard/capture_images/'+<?php echo $sid; ?>+'.png',
    type: 'HEAD',
    error: function() {
      // If the file doesn't exist, show the popup
      $('#pictureModal').modal('show');
    getPermissions();
    }
  });

  function verifyFaceIDwithExisting ()
{
    alert ('in verify');
    var base64data = $("#captured_image_data").val();
    var email = <?php echo $sid; ?>;
    var form_data = new FormData();
    alert ('exam id: '+exam_id)
    
    form_data.append('current_image', base64data);
    form_data.append('email', email);
    alert (email);
	 $.ajax({
            url: 'http://localhost:5000/validateFace',
            type: 'POST',
            data: form_data,
            processData: false,
            contentType: false, 
			success: function(data) { 
                if (data == 1)
                {
                    Swal.fire({
                            title: 'Face Matched !',
                            html: 'Please Wait, Redirecting to exam page in 5 Seconds...',
                            icon: 'success',
                            timer: 5000,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                            .then(() => {
                                initExam(exam_id);
                            })
                }

                else
                {
                    Swal.fire({
                                title: 'FORBIDDEN',
                                html: '<h5>Face verification failed.</h5>',
                                icon: 'error'
                            });
                }
			}
		});
}

        function take_snapshot() {
	 // play sound effect
	 //shutter.play();
	 // take snapshot and get image data
	 Webcam.snap( function(data_uri) {
	 // display results in page
	 document.getElementById('results').innerHTML = 
	  '<img class="after_capture_frame" src="'+data_uri+'"/>';
	 $("#captured_image_data").val(data_uri);
	 });	 
	}

     

    var form = $("#msform");
  var progress = $("#progressbar");
  var fieldsets = form.find("fieldset");
  var loading = $(".loading");
  
  // Hide all fieldsets except the first one
  fieldsets.not(":first").hide();
  
  // Set up progress bar
  progress.children("li").eq(0).addClass("active");
  
  // Set up event listeners
  $(".next").click(function() {
    // Get current fieldset and index
    var current = $(this).closest("fieldset");
    var index = fieldsets.index(current);
    if (index == 0)
    {
        initStepper2 ();
    }

    if (index == 1 )
    {
        take_snapshot();
    }
    // Validate current fieldset
    var valid = true;
    current.find(":input").each(function() {
      var input = $(this);
      if (input.prop("required") && !input.val()) {
        valid = false;
      }
    });
    if (!valid) {
      return false;
    }
    
    // Hide loading spinner and show next fieldset
    loading.show();
    setTimeout(function() {
      loading.hide();
      current.hide();
      fieldsets.eq(index + 1).show();
      progress.children("li").eq(index + 1).addClass("active");
    }, 1000);
  });
  
  $(".previous").click(function() {
    // Get current fieldset and index
    var current = $(this).closest("fieldset");
    var index = fieldsets.index(current);
    
    // Hide current fieldset and show previous fieldset
    current.hide();
    fieldsets.eq(index - 1).show();
    progress.children("li").eq(index).removeClass("active");
  });


        function getPermissions ()
        {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Get the camera and microphone permissions
        navigator.mediaDevices
          .getUserMedia({ video: true, audio: true })
          .then(function(stream) {
            // Permission is allowed
            document.getElementById("status").innerHTML = "Camera and microphone permission is allowed!";
            stream.getTracks().forEach(track => track.stop());

                            // select the image element by its ID
                var myImage = $('#loader');

                // set the new image path
                var newImagePath = 'img/check.png';

                // change the src attribute of the image element
                myImage.attr('src', newImagePath);
                // select the button element by its ID
                var myButton = $('#btn1');

                $('#lbl1').text("All Permissions Ok !")

                // remove the "disabled" class from the button element
                myButton.removeAttr('disabled');


          })
          .catch(function(error) {
            // Permission is not allowed
            document.getElementById("status").innerHTML = "Camera and microphone permission is not allowed!";
          });
      } else {
        // WebRTC is not supported
        document.getElementById("status").innerHTML = "WebRTC is not supported!";
      }

        }
     function initStepper2 ()
     {
        console.log ('cam intlzed.')
        Webcam.set({
	  width: 400,
	  height: 300,
	  image_format: 'jpeg',
	  jpeg_quality: 90
	 });	 
	 Webcam.attach( '#my_camera' );
     }
	

     function saveSnap(){
	var base64data = $("#captured_image_data").val();
	 $.ajax({
			type: "POST",
			dataType: "json",
			url: "../../student/dashboard/upload-image.php",
			data: {image: base64data},
			success: function(data) { 
                Swal.fire({
                            title: 'Congratulations !',
                            html: 'Face ID Successfully Saved.',
                            icon: 'success',
                            timer: 5000,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                        
                        .then(() => {
                                                 window.location.href = '../../student/dashboard/';
                                               });
			}
		});
	}
    
    $('#btn-submit-img').on('click', function() {

    saveSnap();
});

$('#btn-verify-img').on('click', function() {

verifyFaceIDwithExisting();
});


        $('#open-modal-btn').on('click', function() {
            $('#btn-verify-img').hide();
    // Show the modal
    $('#pictureModal').modal('show');
    getPermissions();
  });

        $('.start-exam').on('click', function () {
            var eid = $(this).data('eid');
            var id = $(this).data('id');
            handleStartExam(eid, id);
        });

        $('#simpletable').DataTable();

        function initExam(eid) {

            $.ajax({
                    type: 'POST',
                    url: '../../student/dashboard/update-session-eid.php',
                    data: {
                        eid: eid
                    },
                    success: function (data) {
                        window.location.href = "../../exam/attempt.php?eid=" + eid;

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Error Occured");
                    }
                }
            );
        }

        function verifyFaceID (eid, sid)
        {
            $('#pictureModal').modal('show');
            $('#modal-title').text ('Face Verification');
            $('#modal-subtitle').text ('In order to proceed with the exam please verify your face.');
            $('#modal-step3').text ('Face Verification');
            $('#btn-submit-img').hide();
            $('#btn-verify-img').show();
            
            getPermissions();
        }

        function handleStartExam(eid, id) {

            $.ajax({
                    type: 'POST',
                    url: '../../exam/checkAttempt.php',
                    data: {
                        eid: eid
                    },
                    success: function (data) {
                        Swal.fire({
                            title: 'You are being redirected to Face Verification',
                            html: 'Please Wait, Redirecting in 5 Seconds...',
                            icon: 'success',
                            timer: 5000,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                            .then(() => {
                                exam_id = eid;
                                verifyFaceID (<?php echo $sid; ?>);
                                // initExam(eid);
                            })

                    },
                    statusCode: {
                        409: function () {
                            Swal.fire({
                                title: 'FORBIDDEN',
                                html: '<h5>You have already appeared for the Exam.</h5>',
                                icon: 'error'
                            });
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // console.error ("Response : "+XMLHttpRequest);
                        console.error("Status : " + textStatus);
                        console.error("Error  : " + errorThrown);

                    }
                }
            );

        }
    });
</script>

</body>
</html>