<?php
include '../../util/config.php';
include '../../util/check-faculty-session.php';
include '../../util/util.php';
include '../../util/strings.php';
if (isset($_GET['eid']) && isset($_GET['year']) && isset($_GET['dept'])) {
    $fid = $_SESSION['faculty']['key'];
    $eid = hex2bin($_GET['eid']);
    $year = hex2bin($_GET['year']);
    $dept = hex2bin($_GET['dept']);

    $mcq_marks = '';
    $sa_marks = '';
    $la_marks = '';

    echo "<script> var eid = '$eid' </script>";
    echo "<script> var year = '$year' </script>";
    echo "<script> var dept = '$year' </script>";

} else {
    header("location:../../admin/examine/");
}


$query = "SELECT COUNT(*) as count FROM `attempts` where eid = :eid";
// echo $query;
$result = query($query,['eid'=>$eid]);
$appearedStudents = $result->fetchColumn();

if ($appearedStudents <= 0)
{
    echo "<script> alert('no students') </script>";
    header("location:../../admin/examine/");
}

$query = "SELECT * FROM `exam_data` where eid = :eid";
$result = query($query,['eid'=>$eid]);
$data = $result->fetch();

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
    <style>
        .student-control {
            background: aliceblue;
        }
    </style>
</head>

<body>
<div class="wrapper">
    <header class="header-top" header-theme="light">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <!-- <div class="top-menu d-flex align-items-center"> -->

                <!-- <img src="img/logo.jpg" width="55" class="rounded-circle" alt="user"> -->
                <marquee>
                    <h5 style="color : lime;">YOU ARE EXAMINING THE EXAM : <?php echo $eid; ?></h5>
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
                            <a href="#"><span><?php echo $eid; ?></span> </a>
                        </div>
                        <div class="nav-lavel">Exam Type</div>
                        <div class="nav-item">
                            <a href="#"><span><?php echo $data['exam_type']; ?></span> </a>

                        </div>

                        <div class="nav-lavel">Exam Marks</div>
                        <div class="nav-item">
                            <a href="#"><span><?php echo $data['exam_marks']; ?></span> </a>

                        </div>

                        <div class="nav-lavel">Students Appeared</div>
                        <div class="nav-item">
                            <a href="#"><span><?php echo $appearedStudents; ?></span> </a>

                        </div>
                        <div class="nav-lavel">Duration</div>
                        <div class="nav-item">
                            <a href="#"><span><?php echo $data['exam_duration'] / 60; ?> mins.</span> </a>

                        </div>

                    </nav>
                </div>
            </div>
        </div>


        <div class="main-content">


            <div class="container-fluid">

                <form action="../../admin/examine/load.php" id="examine-paper"  method="POST">

                    <input type="hidden" name="eid" id="eid" value="<?php echo $eid; ?>">

                    <input type="hidden" name="sid" id="sid" value="">


                    <h5 class="mt-1" id="header-mcq-question"><b>Student Details</b></h5>


                    <div class="mt-1 row clearfix" id="studentDetails">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="stuent_name">Student Name :</label>
                            <input type="text" class="form-control student-control" style="background-color: aliceblue;"
                                   name="stuent_name" id="student_name" readonly>
                            <label class="mt-3" for="roll_no">Roll No :</label>
                            <input type="text" class="form-control" style="background-color: aliceblue;" name="roll_no"
                                   id="roll_no" readonly>
                            <label class="mt-3" for="start_time">Start Time :</label>
                            <input type="text" class="form-control" style="background-color: aliceblue;"
                                   name="start_time" id="start_time" readonly>
                            <label class="mt-3" for="end_time">End Time :</label>
                            <input type="text" class="form-control" style="background-color: aliceblue;" name="end_time"
                                   id="end_time" readonly>
                            <label class="mt-3" for="isForcedSubmit">Forced submitted?</label>
                            <input type="text" class="form-control" style="background-color: aliceblue;"
                                   name="isForcedSubmit" id="isForcedSubmit" readonly>

                        </div>
                    </div>


                    <h5 class="mt-4" id="header-short-question"><b>Q.2 Answer in Short</b></h5>

                    <div class="mt-1 row clearfix" id="shortAnswers">

                    </div>


                    <h5 class="mt-3" id="header-large-question"><b>Q.3 Answer in Brief</b></h5>

                    <div class="mt-1 row clearfix" id="largeAnswers">

                    </div>


                    <div class=" mt-3 row clearfix">
                        <button type="submit"  class="m-2 ml-3 btn btn-success"><i
                                    class="ik ik-arrow-right"></i>Next
                        </button>
                        <button type="button" name="redirect-dashboard" id="redirect-dashboard"
                                class="m-2 ml-3 btn btn-warning"><i class="ik ik-rotate-ccw"></i>Stop
                        </button>

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
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>


<script type="text/javascript">


    $(document).ready(function () {

        load();

        $('#simpletable').DataTable();

        $('#redirect-dashboard').on('click', function (e) {
            e.preventDefault();
            window.location.href = "../../admin/examine/";
        })


        $("#examine-paper").submit(function (event) {

            event.preventDefault();

            console.log("submission prevented")

            $.ajax({
                type: 'POST',
                url: '../../admin/examine/submit.php',
                data: $('#examine-paper').serialize() + "&examine-paper=1",
                success: function (data) {
                    var dataObj = JSON.parse(data)
                    console.log(dataObj)
                    if(dataObj['examined'] == true) {
                        $('#examine-paper').trigger("reset");
                        Swal.fire({
                            title: 'Please wait generating the result',
                            html: 'may take few seconds...',
                            icon: 'info',
                            timer: 2000,
                        }).then(() => {
                            generateResult();

                        });
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Error Occured");
                }
            });

        });

    });

    function generateResult() {
        $.ajax({
            type: 'POST',
            url: '../../admin/examine/result.php',
            data: {
                eid: $('#eid').val(),
                sid: $('#sid').val(),
                'generate-result': 1
            },
            success: function (data) {
                var dataObj = JSON.parse(data)
                console.log (dataObj)
                if (dataObj['result-generated'] == true)
                    load();
            },

            statusCode: {
                409: function () {
                    Swal.fire({
                        title: 'Error occured while generating the result',
                        html: 'Please Wait, Redirecting in 2 Seconds...',
                        icon: 'warning',
                        timer: 1000,
                        allowOutsideClick: false,
                        showCancelButton: false,
                        showConfirmButton: false
                    })
                        .then(() => {
                            window.location.href = "../../admin/examine/";
                        })
                }
            },

            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.error("Status : " + textStatus);
                console.error("Error  : " + errorThrown);
            }
        });
    }

    function load() {
        $.ajax({
            type: 'POST',
            url: '../../admin/examine/load.php',
            data: {
                eid: eid,
                year: year,
                dept: dept
            },
            success: function (data) {
                $('.appended').remove();
                var dataObj = JSON.parse(data);
                var studentDetails = dataObj[0];
                var examData = dataObj[1];
                console.log(examData)
                console.log(studentDetails)

                var sa_marks = examData.short_answers['max_marks'];
                var la_marks = examData.large_answers['max_marks'];


                for (let [key, value] of Object.entries(examData.short_answers['answers'])) {
                        if (value == null)
                        {
                            value = "NOT ATTEMPTED."
                        }

                    $('#shortAnswers').append("<div class='mt-2 col-lg-12 col-md-12 col-sm-12 appended'>" +
                        "<div class='form-group'>" +
                        "<h6>Question : " + key + "</h6>" +
                        "</div>" +
                        "</div>" +

                        "<div class='col-lg-4 col-md-12 col-sm-12 appended'>" +
                        "<div class='form-group'>" +
                        "<textarea class='form-control' rows='3' spellcheck='false' maxlength='2000' required='true' cols='1' readonly>" + value + "</textarea>" +
                        "</div>" +
                        "</div>" +

                        "<div class='mb-3 col-lg-1 col-md-4 col-sm-12 appended'>" +
                        "<label for='q_2_[]'>Marks</label>" +
                        "<select class='q-2 form-control' id='q_2_[]' name='q_2_[]' required>" +
                        "<option value='' disabled selected>Choose</option>" +
                        +"</select>" +
                        "</div>"
                    )
                }


                for (var i = 0; i <= sa_marks; i = i + 0.5) {
                    $("<option value=" + i + ">" + i + "</option>").appendTo(".q-2");
                }


                for (let [key, value] of Object.entries(examData.large_answers['answers'])) {
                    if (value == null)
                    {
                        value = "NOT ATTEMPTED."
                    }
                    $('#largeAnswers').append("<div class='mt-2 col-lg-12 col-md-8 col-sm-12 appended'>" +
                        "<div class='form-group'>" +
                        "<h6>Question : " + key + "</h6>" +
                        "</div>" +
                        "</div>" +

                        "<div class='col-lg-4 col-md-8 col-sm-12 appended'>" +
                        "<div class='form-group'>" +
                        "<textarea class='form-control' rows='4' spellcheck='false' maxlength='2000' required='true' cols='1' readonly>" + value + "</textarea>" +
                        "</div>" +
                        "</div>" +

                        "<div class='mb-3 col-lg-1 col-md-4 col-sm-12 appended'>" +
                        "<label for='q_3_[]'>Marks</label>" +
                        "<select class='q-3 form-control' id='q_3_[]' name='q_3_[]' required>" +
                        "<option value='' disabled selected>Choose</option>" +
                        +"</select>" +
                        "</div>"
                    )
                }


                for (var i = 0; i <= la_marks; i = i + 0.5) {
                    $("<option value=" + i + ">" + i + "</option>").appendTo(".q-3");
                }

                $('#student_name').val(studentDetails.name)
                $('#roll_no').val(studentDetails.rollno)
                $('#sid').val(studentDetails.sid)
                $('#start_time').val(studentDetails.start_time)
                $('#end_time').val(studentDetails.end_time)
                var fs;
                if (studentDetails.isForcedSubmit == 0)
                    fs = 'No';
                else
                    fs = 'Yes';
                $('#isForcedSubmit').val(fs)


            },
            statusCode: {
                409: function () {
                    Swal.fire({
                        title: 'Test fully examined.',
                        html: 'Please Wait, Redirecting in 2 Seconds...',
                        icon: 'warning',
                        timer: 1000,
                        allowOutsideClick: false,
                        showCancelButton: false,
                        showConfirmButton: false
                    })
                        .then(() => {
                            window.location.href = "../../admin/all-exams/";
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
