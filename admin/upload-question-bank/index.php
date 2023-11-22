<?php
include '../../util/config.php';
include '../../util/util.php';
include '../../util/strings.php';
include '../../util/check-faculty-session.php';


if (isset($_POST['create_exam']) && $_POST['create_exam'] == 1) {

    $exam_type = $_POST['exam_type'];
    $exam_marks = $_POST['exam_marks'];
    $passing_marks = $_POST['passing_marks'];
    $concerned_faculty = $_POST['concerned_faculty'];
    $exam_subject = $_POST['exam_subject'];
    $no_of_mcqs = $_POST['no_of_mcqs'];
    $no_of_sq = $_POST['no_of_sq'];
    $no_of_lq = $_POST['no_of_lq'];
    $mcq_marks = $_POST['mcq_marks'];
    $sq_marks = $_POST['sq_marks'];
    $lq_marks = $_POST['lq_marks'];
    $exam_dept = $_POST['exam_dept'];
    $exam_year = $_POST['exam_year'];
    $exam_date = $_POST['exam_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $exam_duration = $_POST['exam_duration'];



    $eid = $exam_subject . "-" . str_replace("-", "", $exam_date) . "-" . $exam_dept . "-" .str_replace(":", "", $start_time);
    // echo $eid;
//
//    echo $passing_marks;
//    echo $exam_duration;

    $query = "INSERT INTO `exam_data` (`eid`, `exam_type`, `exam_subject`, `exam_marks`, `passing_marks`, `concerned_faculty`, `no_of_mcqs`, `no_of_sq`, `no_of_lq`, `mcq_marks`, `sq_marks`, `lq_marks`, `exam_dept`, `exam_year`, `exam_date`, `start_time`, `end_time`,`exam_duration`) VALUES (:eid,:exam_type,:exam_subject,:exam_marks,:passing_marks,:concerned_faculty,:no_of_mcqs,:no_of_sq,:no_of_lq,:mcq_marks,:sq_marks,:lq_marks,:exam_dept,:exam_year,:exam_date,:start_time,:end_time,:exam_duration)";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['eid' => $eid, 'exam_type' => $exam_type, 'exam_subject' => $exam_subject, 'exam_marks' => $exam_marks, 'passing_marks' => $passing_marks, 'concerned_faculty' => $concerned_faculty, 'no_of_mcqs' => $no_of_mcqs, 'no_of_sq' => $no_of_sq, 'no_of_lq' => $no_of_lq, 'mcq_marks' => $mcq_marks, 'sq_marks' => $sq_marks, 'lq_marks' => $lq_marks, 'exam_dept' => $exam_dept, 'exam_year' => $exam_year, 'exam_date' => $exam_date, 'start_time' => $start_time, 'end_time' => $end_time,'exam_duration'=>$exam_duration]);
//    $stmt->debugDumpParams();

    echo $stmt->rowCount();

    if ($stmt->rowCount() > 0) {
        $successFlag = true;
    } else {
        $error = true;
    }
}
?>

<!doctype html>
<html class="no-js" lang="en">
<?php
if (isset($successFlag) && $successFlag == true) {
    $eid = bin2hex($eid);
    $no_of_mcqs = bin2hex($no_of_mcqs);
    $no_of_sq = bin2hex($no_of_sq);
    $no_of_lq = bin2hex($no_of_lq);

    header("refresh:6;`url=../../add-questions.php?eid=$eid&no_of_mcqs=$no_of_mcqs&no_of_sq=$no_of_sq&no_of_lq=$no_of_lq");

    $eid = hex2bin($eid);
    $no_of_mcqs = hex2bin($no_of_mcqs);
    $no_of_sq = hex2bin($no_of_sq);
    $no_of_lq = hex2bin($no_of_lq);
}
?>
<head>
    <base href="../../template/">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>DJSCE | Create Exam</title>

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
    <link rel="stylesheet" href="plugins/datedropper/datedropper.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css"/>
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
                <button type="button" class="nav-toggle"><i data-toggle="expanded"
                                                            class="ik ik-toggle-right toggle-icon"></i></button>
                <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
            </div>

            <div class="sidebar-content">
                <div class="nav-container">
                    <nav id="main-menu-navigation" class="navigation-main">
                        <div class="nav-lavel">Exam</div>
                        <div class="nav-item">
                            <a href="../../admin/all-exams/"><i
                                        class="ik ik-bar-chart-2"></i><span>All Assessments</span> </a>
                        </div>
                        <div class="nav-item">
                            <a href="../../admin/create-exam"><i class="ik ik-file-plus"></i><span>New Assessment</span>
                            </a>
                        </div>
                        <div class="nav-item ">
                            <a href="../../admin/examine/"><i class="ik ik-check-square"></i><span>Examine</span> </a>
                        </div>
                        <div class="nav-item active">
                            <a href="../../admin/upload-question-bank/"><i class="ik ik-upload"></i><span>Upload Question Bank</span> </a>
                        </div>
                        <div class="nav-item">
                            <a href="../../admin/manage-qb/"><i class="ik ik-settings"></i><span>Manage Question Bank</span> </a>
                        </div>
                        <div class="nav-lavel">Account</div>
                        <div class="nav-item">
                            <a href="../../admin/login/logout.php"><i class="ik ik-log-out"></i><span>Logout</span> </a>
                        </div>

                    </nav>
                </div>
            </div>
        </div>

        <div class="main-content">

            <?php
            if (isset($successFlag) && $successFlag == true) {

                echo "
                                                <script>

                                                Swal.fire ({
                                                title: 'Exam Created ! Please wait...',
                                                html:   'Exam id : <b> $eid </b> <br>' +
                                                          'Subject : $exam_subject <br>'+
                                                          'Date : $exam_date <br>'+
                                                          'Start Time : $start_time <br>'+
                                                          'End Time : $end_time <br>',

                                           icon : 'success',
                                            timer: 5000,
                                            allowOutsideClick: false,
                                            showCancelButton: false,
                                             showConfirmButton: false
                                             })
                                             </script>";

                ?>

                <div class="alert bg-success alert-success alert-dismissible text-white" role="alert">
                    Exam created successfully.

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ik ik-x"></i>
                    </button>

                </div>

                <?php
            } else if (isset($error) && $error == true) {
                ?>
                <div class="alert bg-danger alert-danger alert-dismissible text-white" id="create-exam-error"
                     role="alert" style="display: none;">
                    An Error occured while creating a exam.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ik ik-x"></i>
                    </button>

                </div>
                <?php
            } else if (isset($_GET['error'])) {

                echo "<script>
                                             Swal.fire({
                                           title: 'Error occured while generating the result',
                                           html: 'Please Wait, Redirecting in 2 Seconds...',
                                           icon: 'warning',
                                           timer: 3000,
                                           allowOutsideClick: false,
                                           showCancelButton: false,
                                           showConfirmButton: false
                                         }).then(() => {
                                          window.location.href = '../../admin/all-exams/'
                                       })
                    </script>";
                header("refresh:5;`url=../../index.php");
            }
            ?>

            <form name='upload-qb' id='upload-qb' method="POST" enctype="multipart/form-data">
                <input type="hidden" name="upload-qb" value="1">
                <div class="container-fluid">

                    <h5 class="mt-4">Question Bank Structure</h5>

                    <div class="mt-3 row clearfix">

                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="qb_type">Question Type</label>
                                <select class="form-control" id="qb_type" name="qb_type" required>
                                    <option selected disabled value="">Select Question Type</option>
                                    <option value="1">M.C.Q.</option>
                                    <option value="2">Short Questions</option>
                                    <option value="3">Long Questions</option>

                                </select>

                            </div>


                        </div>
                    </div>

                    <div class="mt-3 row clearfix">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="qb_file">Upload Excel File</label>
                            <div class="custom-file">
                                <label class="custom-file-label" for="qb_file">Choose file</label>
                                <input type="file" name="qb_file" class="custom-file-input" id="qb_file" accept=".xlsx" required>
                            </div>
                        </div>
                        </div>

                    </div>

                    <div class=" mt-3 row clearfix">
                        <button type="submit" name="upload-qb" value="1" class="m-2 ml-3 btn btn-success"><i
                                    class="ik ik-upload"></i>Upload Question Bank
                        </button>
                        <button type="reset" class="m-2 btn btn-danger"><i class="ik ik-x"></i>Reset</button>
                    </div>

                    <div class=" mt-3 row clearfix">
                    <div id="result">
                    </div>
                    </div>
                </div>
            </form>
            <a style="color:blue" href="../admin/upload-question-bank/Long-Questions.xlsx">Download: Sample file for Long Questions </a>
          <br>  <a style="color:blue" href="../admin/upload-question-bank/Short-Questions.xlsx">Download: Sample file for Short Questions </a>
           <br> <a style="color:blue" href="../admin/upload-question-bank/MCQ-Questions.xlsx">Download: Sample file for MCQ Questions </a>

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
<script src="plugins/datedropper/datedropper.min.js"></script>
<script src="js/datatables.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.3/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="js/form-picker.js"></script>


<script type="text/javascript">

    $(document).ready(function() {

        $('#upload-qb').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"../admin/upload-question-bank/upload-qb.php",
                method:"POST",
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                    $('#result').html(data);
                    $('#upload-qb').val('');
                }
                });
            });

        $('#qb_file').change(function() {
            var i = $(this).prev('label').clone();
            var file = $('#qb_file')[0].files[0].name;
            $(this).prev('label').text(file);
        });

        $("#create-exam").submit(function (event) {

            finalise();
            if (!validateFields()) {
                event.preventDefault();
                alert('Please validate exam time')
            }
        });


        $('#exam_date').dateDropper({
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            format: 'Y-m-d',
            minDate: new Date()
        });

        $('#start_time').datetimepicker({
            use24hours: true,
            format: 'HH:mm'

        });

        $('#end_time').datetimepicker({
            use24hours: true,
            format: 'HH:mm'

        });

    });

        function finalise() {
            var mcq_marks = $("#no_of_mcqs").val() * $("#mcq_marks").val();
            // alert (mcq_marks);
            var sq_marks = $("#no_of_sq").val() * $("#sq_marks").val();
            // alert (sq_marks);
            var lq_marks = $("#no_of_lq").val() * $("#lq_marks").val();

            var passing_perc = $("#passing_perc").val();

            // alert (lq_marks)

            var total = Number(mcq_marks + sq_marks + lq_marks);
            alert('Exam Total : '+total);

            var passingMarks = (total * passing_perc ) / 100;

            alert('Passing Marks : '+passingMarks)

            $('#passing_marks').val (passingMarks)

            $("#exam_marks").val(total);


        }

        function validateFields() {
            var et = $('#end_time').val ();
            var st = $('#start_time').val();

            if (et < st || st == et)
            {
                return false;
            }
            else
            {

                var diff = ( new Date("1970-1-1 " + et) - new Date("1970-1-1 " + st) ) / 1000;

                // alert(diff)

                $("#exam_duration").val(diff);

                return true;


            }
        }
</script>

</body>
</html>
