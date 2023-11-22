<?php
include '../../util/config.php';
include '../../util/util.php';
include '../../util/check-student-session.php';
include '../../util/strings.php';
$sid = $_SESSION['student-session']['key'];
$sYear = $_SESSION['student-session']['year'];

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.0.1/collection/components/icon/icon.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icon-kit@1.0.0/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/theme.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  </head>

  <body>
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
            <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
            <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
          </div>

          <div class="sidebar-content">
            <div class="nav-container">
              <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-lavel">Exam</div>
                <div class="nav-item">
                  <a href="../../student/dashboard/"><i class="ik ik-bar-chart-2"></i><span>Assessments</span> </a>
                </div>
                <div class="nav-item active">
                  <a href="../../student/dashboard/"><i class="ik ik-database"></i><span>My Attempts</span> </a>
                </div>
                <div class="nav-lavel">Profile</div>
                <div class="nav-item">
                  <a href="../../student/profile"><i class="ik ik-user"></i><span>View Profile</span> </a>
                </div>
                <div class="nav-lavel">Account</div>
                <div class="nav-item">
                  <a href="../../student/login/logout.php"><i class="ik ik-log-out"></i><span>Logout</span> </a>
                </div>

              </nav>
            </div>
          </div>
        </div>

          <div class="main-content">


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
                                          <th>Total Marks</th>
                                          <th>Start Time</th>
                                          <th>End Time</th>
                                          <th>Forced Submit?</th>
                                          <th>Examined?</th>

                                      </tr>
                                      </thead>

                                      <tbody>
                                      <?php
                                      $fetchExams = "SELECT `faculty`.`faculty_name` as `examiner`, `attempts`.`eid`, `exam_data`.`exam_marks`, `exam_data`.`exam_date`, `exam_data`.`exam_type`, `exam_data`.`exam_marks`, `attempts`.`start_time`, `attempts`.`submission_time`, `attempts`.`isForcedSubmit`, `attempts`.`isExamined`, `attempts`.`score` FROM `attempts` INNER JOIN `exam_data` ON `exam_data`.`eid` = `attempts`.`eid` INNER JOIN `faculty` ON `faculty`.`fid` = `exam_data`.`concerned_faculty` where `attempts`.`sid` = :sid";
                                      $stmt = $pdo->prepare($fetchExams);
                                      $stmt->execute(['sid' => $sid]);
                                      while ($data = $stmt->fetch()) {
                                          ?>
                                          <tr>
                                              <td><?php echo $data['eid']; ?></td>
                                              <td><?php echo $data['exam_type']; ?></td>
                                              <td><?php echo $data['exam_date']; ?></td>
                                              <td><?php echo $data['exam_marks']; ?></td>
                                              <td><?php echo $data['start_time']; ?></td>
                                              <td><?php echo $data['submission_time']; ?></td>
                                              <td><?php if ($data['isForcedSubmit']) {
                                                      echo "Yes";
                                                  } else {
                                                      echo "No";
                                                  } ?></td>
                                              <td>
                                                  <?php if ($data['isExamined']) { ?>
                                                      <button type="button" class="btn btn-info" data-toggle="modal"
                                                              data-target="#view-result-modal"
                                                              data-eid="<?php echo $data['eid']; ?>"
                                                              data-total_marks="<?php echo $data['score']; ?>"
                                                              data-examiner="<?php echo $data['examiner']; ?>"
                                                              data-exam_marks="<?php echo $data['exam_marks']; ?>"
                                                              data-age="<?php echo $sid; ?>"> View Result
                                                      </button>
                                                      <?php
                                                  } else {
                                                      echo "No";
                                                  }
                                                  ?>
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
                                          <th>Total Marks</th>
                                          <th>Start Time</th>
                                          <th>End Time</th>
                                          <th>Forced Submit?</th>
                                          <th>Examined?</th>
                                      </tr>
                                      </tfoot>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

          </div>

          <div class="modal" id="view-result-modal" tabindex="-1" role="dialog" aria-labelledby="view-result-modal"

               aria-hidden="true">
              <div class="modal-dialog modal-md" role="document">
                  <div class="modal-content">
                      <div class="modal-header">

                          <h5 class="modal-title" id="vrm-title"></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">

                          <div class="mt-1 row clearfix" id="vrm-body">

                          </div>

                      </div>


                      <div class="modal-footer" id='vrm-footer'>

                      </div>
                  </div>
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
    src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js">
    </script>
    <script src="../../js/cryptojs-aes.min.js"></script>
    <script src="../../js/cryptojs-aes-format.js"></script>



    <script type="text/javascript">
        const AeshHash = '0188997453';

        $(document).ready(function () {

            $('#view-result-modal').on('hidden.bs.modal', function (event) {
                $('.appended').remove();
            });

            $('#view-result-modal').on('shown.bs.modal', function (event) {

                // console.log("modal called")
                var button = $(event.relatedTarget)
                var eid = button.data('eid');
                var examiner = button.data('examiner');
                var totalScore = button.data('total_marks');
                var examMarks = button.data('exam_marks');

                console.log(eid, totalScore, examMarks)
                load(eid, totalScore, examMarks, examiner);
            });
        });

        function load(eid, totalScore, examMarks, examiner) {
            $.ajax({
                type: 'POST',
                url: '../../student/my-attempts/view-result.php',
                data: {
                    eid: eid
                },
                success: function (data) {
                    var dataObj = JSON.parse(data);
                    // var mcq_answers = CryptoJS.AES.decrypt(dataObj.mcq_answers, AeshHash, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8);
                    // var short_answers = CryptoJS.AES.decrypt(dataObj.short_answers, AeshHash, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8);
                    // var large_answers = CryptoJS.AES.decrypt(dataObj.large_answers, AeshHash, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8);
                    var mcq_answers = dataObj.mcq_answers;
                    var short_answers = dataObj.short_answers;
                    var large_answers = dataObj.large_answers;


                    console.log(mcq_answers);


                    $('#vrm-title').text('Examined by : ' + examiner)
                    $('#vrm-body').append("<h6 class='appended ml-3 mb-2' id='header-mcq-question'><b>Q1. Select the correct option.</b></h6>");

                    var i = 0;
                    for (let [key, value] of Object.entries(mcq_answers['answers'])) {
                        i++;
                        for(var j=0; j<4; j++)
                        {
                            if (value[j].substring(0,4) == 'img:')
                            {
                                value[j] = "<img src='"+value[j].substring(4)+"' alt='couldnt load image' width='256' height='256'>"
                            }
                        }
                        $('#vrm-body').append("<div class='mt-2 col-lg-12 col-md-12 col-sm-12 appended'>" +
                            "<h6>" + i + "." + key + "</h6>" +
                            "<div class='form-radio'>" +
                            "<div class='radio'>" +
                            "<label id=" + i + "l-a>" +
                            "<input type='radio' required='true' id=" + i + "r-a  disabled>" +
                            "<i class='helper'></i>" + value[0] +
                            "</label>" +

                            "<label id=" + i + "l-b>" +
                            "<input type='radio' required='true' id=" + i + "r-b  disabled>" +
                            "<i class='helper'></i>" + value[1] +
                            "</label>" +

                            "<label id=" + i + "l-c>" +
                            "<input type='radio' required='true' id=" + i + "r-c  disabled>" +
                            "<i class='helper'></i>" + value[2] +
                            "</label>" +

                            "<label id=" + i + "l-d>" +
                            "<input type='radio' required='true' id=" + i + "r-d  disabled>" +
                            "<i class='helper'></i>" + value[3] +
                            "</label>" +
                            "</div>" +
                            "</div>" +
                            "</div>"
                        )

                        if (value[4] == value[5]) {
                            $('#' + i + 'l-' + value[5]).append("  <i class='fas fa-check text-success'</i>")
                        } else {
                            $('#' + i + 'l-' + value[5]).append("  <i class='fas fa-times text-danger'</i>")
                            $('#' + i + 'l-' + value[4]).append("  <i class='fas fa-check text-success'</i>")
                        }

                        $('#' + i + 'r-' + value[5]).prop('checked', true);


                    }

                    var i = 0;
                    $('#vrm-body').append("<h6 class='appended mt-3 ml-3 mb-2' id='header-short-question'><b>Q2. Answer in Short</b></h6>");
                    for (let [key, value] of Object.entries(short_answers['answers'])) {
                        i++;
                        $('#vrm-body').append("<div class='mt-2 col-lg-12 col-md-12 col-sm-12 appended'>" +
                            "<div class='form-group'>" +
                            "<h6>" + i + "." + key + "</h6>" +
                            "</div>" +
                            "</div>" +

                            "<div class='col-lg-10 col-md-12 col-sm-12 appended'>" +
                            "<div class='form-group'>" +
                            "<textarea class='form-control' rows='3' spellcheck='false' maxlength='2000' required='true' cols='1' readonly>" + value[0] + "</textarea>" +
                            "</div>" +
                            "</div>" +

                            "<div class='col-lg-2 col-md-4 col-sm-12 appended'>" +
                            "<label for='q_2_[]'>Marks</label>" +
                            "<input type='text' class='form-control' style='font-size:11px;' value=" + value[1] + "/" + short_answers['max_marks'] + " readonly>" +
                            "</div>"
                        )
                    }

                    i = 0;
                    $('#vrm-body').append("<h6 class='appended mt-3 ml-3 mb-2' id='header-large-question'><b>Q3. Answer in Brief</b></h6>");


                    for (let [key, value] of Object.entries(large_answers['answers'])) {
                        i++;
                        $('#vrm-body').append("<div class='mt-2 col-lg-12 col-md-8 col-sm-12 appended'>" +
                            "<div class='form-group'>" +
                            "<h6>" + i + "." + key + "</h6>" +
                            "</div>" +
                            "</div>" +

                            "<div class='col-lg-10 col-md-8 col-sm-12 appended'>" +
                            "<div class='form-group'>" +
                            "<textarea class='form-control' rows='4' spellcheck='false' maxlength='2000' required='true' cols='1' readonly>" + value[0] + "</textarea>" +
                            "</div>" +
                            "</div>" +

                            "<div class='col-lg-2 col-md-4 col-sm-12 appended'>" +
                            "<label for='q_3_[]'>Marks</label>" +
                            "<input type='text' class='form-control' style='font-size:11px;' value=" + value[1] + "/" + large_answers['max_marks'] + " readonly>" +
                            "</div>"
                        )
                    }


                    $('#vrm-footer').append("<h6 class='appended'> Total : " + totalScore + "/" + examMarks + "</h6>")

                },
                statusCode: {
                    409: function () {
                        Swal.fire({
                            title: 'Invalid Eid !',
                            html: 'Please Wait, Redirecting in 2 Seconds...',
                            icon: 'warning',
                            timer: 2000,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                            .then(() => {
                                window.location.href = "../../student/my-attempts/";
                            })
                    }
                },

                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.error("Status : " + textStatus);
                    console.error("Error  : " + errorThrown);
                }
            });
        }

    </script>

  </body>

  </html>