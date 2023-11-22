<?php
include '../util/config.php';
include '../util/util.php';
include '../util/check-student-session.php';
include '../util/strings.php';
if (isset($_SESSION['exam']['eid']) && $_SESSION['exam']['eid'] == $_GET['eid'])
{
    $sid = $_SESSION['student-session']['key'];
    $sYear = $_SESSION['student-session']['year'];

    $eid = hex2bin($_GET['eid']);

    $query = "SELECT * FROM `exam_data` where eid = :eid";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['eid' => $eid]);
    $examData = $stmt->fetch();
//    echo $examData['sq_marks'];

    $loadMcqs = "SELECT * FROM `mcq_questions` where `eid` = :eid";
    $loadSq = "SELECT * FROM `short_questions` where `eid` = :eid";
    $loadLq = "SELECT * FROM `large_questions` where `eid` = :eid";

    $result_mcqs = query ($loadMcqs,['eid'=>$eid]);
    $result_sq = query ($loadSq,['eid'=>$eid]);
    $result_lq = query ($loadLq,['eid'=>$eid]);

}

//else if (isset($_POST['get-exam-data']) && $_POST['get-exam-data'] == 1 && isset($_POST['eid']))
//{
//    $eid = $_POST['eid'];
//    $query = "SELECT * FROM `exam_data` where eid = :eid";
//    $stmt = $pdo->prepare($query);
//    $stmt->execute(['eid' => $eid]);
//    $data = $stmt->fetch();
//    echo json_encode(array(
//            'exam_type'=>$data['exam_type'],
//            'exam_marks'=>$data['exam_marks'],
//            'exam_duration'=>$data['exam_duration'],
//            'start_time'=>$data['start_time']
//    ));
//
//}

else {

    $error = bin2hex('402');
    header("location:../../student/dashboard/index.php?error=".$error);

}
?>

<head>
  <base href="../../template/">
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>DJSCE | Student Dashboard</title>

  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="favicon.ico" type="image/x-icon" />

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
    href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>

<body>
  <div class="wrapper">
    <header class="header-top" header-theme="light">
      <div class="container-fluid">
        <div class="d-flex justify-content-between">
          <!-- <div class="top-menu d-flex align-items-center"> -->

            <!-- <img src="img/logo.jpg" width="55" class="rounded-circle" alt="user"> -->
            <marquee>
              <h5 style="color : lime;">YOUR EXAM IS NOW LIVE. ALL THE BEST !</h5>
            </marquee>

          <!-- </div> -->

          <!--
          <div class="top-menu d-flex align-items-center">
            <h5>Online Examination Portal</h5> //WILL ADD DURATION COUNTER HERE LATER. k
          </div> -->
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
              <div class="nav-lavel">Exam ID</div>
              <div class="nav-item">
                <a href="javascript: void(0)"><span><?php echo $eid; ?></span> </a>
              </div>
              <div class="nav-lavel">Exam Type</div>
              <div class="nav-item">
                <a href="javascript: void(0)"><span id="exam_type"><?php echo $examData['exam_type']; ?></span> </a>

              </div>


              <div class="nav-lavel">Exam Marks</div>
              <div class="nav-item">
                <a href="javascript: void(0)"><span id="exam_marks"><?php echo $examData['exam_marks']; ?></span> </a>

              </div>

              <div class="nav-lavel">Start Time</div>
              <div class="nav-item">
                <a href="javascript: void(0)"><span id="start_time"><?php echo $examData['start_time']; ?></span> </a>

              </div>
              <div class="nav-lavel">Duration</div>
              <div class="nav-item">
                <a href="javascript: void(0)"><span id="exam_duration"><?php echo $examData['exam_duration']/60; ?> mins.</span> </a>

              </div>

            </nav>
          </div>
        </div>
      </div>



      <div class="main-content">


          <div class="container-fluid">

            <form action="../../exam/submit.php" id="submit-paper"  method="POST">
<!--               <input type="hidden" name="submit-paper" value="1">-->

              <input type="hidden" name="eid" id="eid" value="<?php echo $eid; ?>">


            <h5 class="mt-1" id="header-mcq-question"><b>Q.1 Select the correct option.</b></h5>

            <div class="mt-1 row clearfix">

              <?php $i=1;
                           while ($data = $result_mcqs->fetch())
                            {

                             ?>

              <div class="col-lg-12 col-md-12 col-sm-12">
                <h6 class="mt-2" for="q_1_<?php echo $i."_"; ?>[]"><?php echo $i.". "; echo $data['question'];?></h6>

                                 <div class="form-radio">
                                     <div class="radio">
                                         <label>
                                             <input type="radio" name="q_1_<?php echo $i."_"; ?>[]" id="q_1_<?php echo $i."_"; ?>1" required="true" value="a" RE>
                                             <i class="helper"></i>
                                             <?php
                                             if(substr($data['a'], 0, 4 ) === "img:") {
                                                 $link = substr($data['a'], 4);
                                                 echo "<img src='$link'alt='couldnt load image' width='600px' height='480px'>";
                                             }
                                             else {
                                                 echo $data['a'];
                                             }
                                             ?>

                                         </label>

                                         <label>
                                             <input type="radio" name="q_1_<?php echo $i."_"; ?>[]" id="q_1_<?php echo $i."_"; ?>2" required="true" value="b">
                                             <i class="helper"></i>
                                             <?php
                                             if(substr($data['b'], 0, 4 ) === "img:") {
                                                 $link = substr($data['b'], 4);
                                                 echo "<img src='$link'alt='couldnt load image' width='600px' height='480px'>";
                                             }
                                             else {
                                                 echo $data['b'];
                                             }
                                             ?>
                                         </label>

                                         <label>
                                             <input type="radio" name="q_1_<?php echo $i."_"; ?>[]" id="q_1_<?php echo $i."_"; ?>3" required="true" value="c">
                                             <i class="helper"></i>     <?php
                                             if(substr($data['c'], 0, 4 ) === "img:") {
                                                 $link = substr($data['c'], 4);
                                                 echo "<img src='$link'alt='couldnt load image' width='600px' height='480px'>";
                                             }
                                             else {
                                                 echo $data['c'];
                                             }
                                             ?>
                                         </label>

                                         <label>
                                             <input type="radio" name="q_1_<?php echo $i."_"; ?>[]" id="q_1_<?php echo $i."_"; ?>4" required="true" value="d">
                                             <i class="helper"></i>
                                             <?php
                                             if(substr($data['d'], 0, 4 ) === "img:") {
                                                 $link = substr($data['d'], 4);
                                                 echo "<img src='$link'alt='couldnt load image' width='600px' height='480px'>";
                                             }
                                             else {
                                                 echo $data['d'];
                                             }
                                             ?>
                                         </label>

                                     </div>
                                 </div>

              </div>




              <?php
              $i++; } ?>
            </div>


            <h5 class="mt-3" id="header-short-question"><b>Q.2 Answer in Short</b></h5>

            <div class="mt-1 row clearfix">

              <?php $i=1;
                             while ($data = $result_sq->fetch())
                              {


                               ?>

              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <h6 for="q_2_[]"><?php echo $i.". "; echo $data['question'];?></h6>



                </div>

              </div>

              <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="form-group">
                  <textarea class="form-control" id="q_2_[]" name= "q_2_[]" rows="3" spellcheck="false" maxlength="2000"
                    required="true" cols="1"></textarea>


                </div>

              </div>




              <?php $i++; } ?>
            </div>

            <h5 class="mt-3" id='header-large-question'><b>Q.3 Answer in Brief</b></h5>

            <div class="mt-1 row clearfix">

              <?php $i=1;
                            while ($data = $result_lq->fetch())
                             {

                              ?>

              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <h6 for="q_3_[]"><?php echo $i.". "; echo $data['question'];?></h6>


                </div>

              </div>

              <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="form-group">
                  <textarea class="form-control" id="q_3_[]" name="q_3_[]" rows="4" spellcheck="false" maxlength="3000"
                    required="true" cols="1"></textarea>


                </div>

              </div>




              <?php $i++; } ?>
            </div>

            <div class=" mt-3 row clearfix">
            <button type="submit" class="m-2 ml-3 btn btn-success"><i class="ik ik-check"></i>Finish</button>
            <button type="reset" class="m-2 btn btn-danger"><i class="ik ik-x"></i>Reset Answers</button>
            </div>



        </form>

          </div>
      </div>



        <footer class="footer">
            <div class="w-100 clearfix">
                <span class="text-center text-sm-left d-md-inline-block">Copyright © 2021 <?php echo $copyRightOwner; ?>. All Rights Reserved.</span>
                <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Developed and Designed by  <?php echo $developerLink; ?></span>
            </div>
        </footer>

    </div>
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
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js">  </script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"> </script>


  <script type="text/javascript">
      <?php
      echo 'var mcq_marks = '.$examData['mcq_marks'].'; var sq_marks = '.$examData['sq_marks'].'; var lq_marks = '.$examData['lq_marks'].';';
      ?>

      $(document).ready(function () {

          $('#header-mcq-question').append("<button type='button' class='btn btn-warning ml-2'>M : <span class='badge badge-light'> " + mcq_marks + " </span></button>");
          $('#header-short-question').append("<button type='button' class='btn btn-warning ml-2'>M : <span class='badge badge-light'> " + sq_marks + " </span></button>");
          $('#header-large-question').append("<button type='button' class='btn btn-warning ml-2'>M : <span class='badge badge-light'> " + lq_marks + " </span></button>");


          $("#submit-paper").submit(function (event) {
              event.preventDefault();
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You are going to submit the paper.",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, Submit !'
              }).then((result) => {
                  if (result.value) {
                      submitExam();
                  }
              })


          });

      $.ajax({
       type : 'POST',
       url : '../exam/updateAttempt.php',
       data : {
                eid : $('#eid').val ()
              },
       success : function(data){
           var dataObj = JSON.parse(data);
           console.log (dataObj)
           if (dataObj.success == 1)
           {
               Swal.fire({
                   title: 'Exam has Started !',
                   html: 'Closing or Minimizing exam page may forcefully submit your paper',
                   icon: 'info',
                   timer: 6000,
               });
       }},
        statusCode : {
            400: function() {
                Swal.fire({
                    title: 'Multiple attempts are forbidden !',
                    html: 'Please Wait, Redirecting in 2 Seconds...',
                    icon: 'warning',
                    timer: 2000,
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showConfirmButton: false
                })
                    .then(() => {
                        forceSubmitForm();
                    })
            }
        },
       error : function(XMLHttpRequest, textStatus, errorThrown)
       {
         // alert ("Error Occured");
       }
      });

    var switchCounter = 0;

      document.addEventListener("visibilitychange", function() {
        if (document.hidden){
    
        } else {
          switchCounter++;
          if (switchCounter == 1)
          {
          Swal.fire({
               title: 'Switching or Minimizing exam page is forbidden',
               html: 'This is the last warning otherwise your exam will be automatically submitted.',
               icon: 'warning',
           });
          }
          else {
    
            forceSubmitForm ();
    
          }
    
        }
    });


  });

      function submitExam() {

          $.ajax({
              type: 'POST',
              url: '../exam/submit.php',
              data: $('#submit-paper').serialize() + "&submit-paper=1",
              success: function (data) {
                  var dataObj = JSON.parse(data)
                  if (dataObj['attempt-success'] == true) {
                      $('#submit-paper').trigger("reset");
                      Swal.fire({
                          title: 'Exam successfully submitted',
                          html: 'You will be notified once your results are out.',
                          icon: 'success',
                          timer: 4000,
                          allowOutsideClick: false,
                          showCancelButton: false,
                          showConfirmButton: false
                      }).then(() => {
                          window.location.href = "../student/dashboard/index.php";
                      })
                  }
              },
              statusCode: {
                  400: function () {
                      Swal.fire({
                          title: 'Error occured while submitting the exam',
                          html: 'Please Wait, Redirecting in 2 Seconds...',
                          icon: 'warning',
                          timer: 1000,
                          allowOutsideClick: false,
                          showCancelButton: false,
                          showConfirmButton: false
                      })
                          .then(() => {
                              window.location.href = "../../student/dashboard/";
                          })
                  }
              },
              error: function (XMLHttpRequest, textStatus, errorThrown) {
                  alert("Error Occured");
              }
          });
      }

    function forceSubmitForm ()
    {
      $.ajax({
         type : 'POST',
         url : '../exam/submit.php',
         data : $('#submit-paper').serialize()  + "&submit-paper=1&isForcedSubmit=1",
         success : function(data){

         Swal.fire({
              title: 'Exam automatically submitted',
              html: 'You switched or refreshed the tab.',
              icon: 'warning',
              timer : 4000,
          }).then(() => {
            window.location.href = "../student/dashboard/index.php";
          })



         },
         error : function(XMLHttpRequest, textStatus, errorThrown)
         {
           alert ("Error Occured");}
        });
    }
    
    // function loadExamData(eid) {
    //     $.ajax({
    //         type : 'POST',
    //         url : '../exam/attempt.php',
    //         data : {
    //             'get-exam-data' : 1,
    //             'eid' : eid
    //         },
    //         success : function(data){
    //             var dataObj = JSON.parse(data)
    //             console.log(dataObj)
    //
    //         },
    //         error : function(XMLHttpRequest, textStatus, errorThrown)
    //         {
    //             alert ("Error Occured");}
    //     });
    //
    // }






  </script>

  <script src="../js/AgoraRTC_N-4.11.0.js"></script>
  <script src='../js/s-main.js'></script>

</body>

</html>
