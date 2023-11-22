<?php
include '../../util/config.php';
include '../../util/check-faculty-session.php';
include '../../util/strings.php';

if (isset($_GET['view-questions']) && $_GET['view-questions'] == 1 && isset($_GET['eid']))
{
    $eid = hex2bin($_GET['eid']);
//    echo $eid;
    $query = "SELECT * FROM `exam_data` where eid=:eid";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['eid' => $eid]);
    if ($stmt->rowCount() == 0)
        header("location:../../admin/all-exams/");
    $data = $stmt->fetch();
}

else {
    header("location:../../admin/all-exams/");
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
                            <a href="../../admin/all-exams/"><i class="ik ik-bar-chart-2"></i><span>All Assessments</span> </a>
                          </div>
                          <div class="nav-item">
                            <a href="../../admin/create-exam"><i class="ik ik-file-plus"></i><span>New Assessment</span> </a>
                          </div>
                            <div class="nav-item ">
                            <a href="../../admin/examine/"><i class="ik ik-check-square"></i><span>Examine</span> </a>
                          </div>

                     <div class="nav-item ">
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
                            <div class="mt-4 row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header d-block">
                                            <h3>MCQ Questions [Exam : <?php echo $eid; ?>]</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="dt-responsive">
                                                <table id="simpletable1" class="table table-striped table-bordered nowrap table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Exam ID</th>
                                                            <th>MCQ Question</th>
                                                            <th>Option A</th>
                                                            <th>Option B</th>
                                                            <th>Option C</th>
                                                            <th>Option D</th>
                                                            <th>Correct Option</th>
                                                            <th>Max Marks</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        $fetchQuestions = "SELECT `mcq_questions`.*, `exam_data`.`mcq_marks` FROM  `mcq_questions` INNER JOIN `exam_data` ON `exam_data`.`eid` = `mcq_questions`.`eid`  where `mcq_questions`.`eid`=:eid ";
                                                        // echo $fetchQuestions;
                                                        $stmt = $pdo->prepare($fetchQuestions);
                                                        $stmt->execute(['eid' => $eid]);

                                                        $i = 1;
                                                        while ($data = $stmt->fetch()) {

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $data['eid']; ?></td>
                                                                <td><?php echo $data['question']; ?></td>
                                                                <td><?php echo $data['a']; ?></td>
                                                                <td><?php echo $data['b']; ?></td>
                                                                <td><?php echo $data['c']; ?></td>
                                                                <td><?php echo $data['d']; ?></td>
                                                                <td><?php echo $data['answer']; ?></td>
                                                                <td><?php echo $data['mcq_marks']; ?></td>

                                                            </tr>
                                                        <?php
                                                          $i++;
                                                        }
                                                        ?>

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                          <th>Sr. No.</th>
                                                          <th>Exam ID</th>
                                                          <th>MCQ Question</th>
                                                          <th>Option A</th>
                                                          <th>Option B</th>
                                                          <th>Option C</th>
                                                          <th>Option D</th>
                                                          <th>Correct Option</th>
                                                          <th>Max Marks</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="mt-4 row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header d-block">
                                            <h3>Short Questions [Exam : <?php echo $eid; ?>]</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="dt-responsive">
                                                <table id="simpletable2" class="table table-striped table-bordered nowrap table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Exam ID</th>
                                                            <th>Short Question</th>
                                                            <th>Max Marks</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        $fetchQuestions = "SELECT `short_questions`.*, `exam_data`.`sq_marks` FROM  `short_questions` INNER JOIN `exam_data` ON `exam_data`.`eid` = `short_questions`.`eid`  where `short_questions`.`eid`=:eid ";
                                                        $stmt = $pdo->prepare($fetchQuestions);
                                                        $stmt->execute(['eid' => $eid]);

                                                        $i = 1;
                                                        while ($data = $stmt->fetch()) {

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $data['eid']; ?></td>
                                                                <td><?php echo $data['question']; ?></td>
                                                                <td><?php echo $data['sq_marks']; ?></td>

                                                            </tr>
                                                        <?php
                                                          $i++;
                                                        }
                                                        ?>

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                          <th>Sr. No.</th>
                                                          <th>Exam ID</th>
                                                          <th>Short Question</th>
                                                          <th>Max Marks</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="mt-4 row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header d-block">
                                            <h3>Large Questions [Exam : <?php echo $eid; ?>]</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="dt-responsive">
                                                <table id="simpletable" class="table table-striped table-bordered nowrap table-responsive">
                                                    <thead>
                                                        <tr>
                                                          <th>Sr. No.</th>
                                                          <th>Exam ID</th>
                                                          <th>Large Question</th>
                                                          <th>Max Marks</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        $fetchQuestions = "SELECT `large_questions`.*, `exam_data`.`lq_marks` FROM `large_questions` INNER JOIN `exam_data` ON `exam_data`.`eid` = `large_questions`.`eid`  where `large_questions`.`eid`=:eid ";
                                                        // echo $fetchQuestions;
                                                        $stmt = $pdo->prepare($fetchQuestions);
                                                        $stmt->execute(['eid' => $eid]);

                                                        $i = 1;
                                                        while ($data = $stmt->fetch()) {

                                                        ?>
                                                            <tr>
                                                              <td><?php echo $i; ?></td>
                                                              <td><?php echo $data['eid']; ?></td>
                                                              <td><?php echo $data['question']; ?></td>
                                                              <td><?php echo $data['lq_marks']; ?></td>

                                                            </tr>
                                                        <?php
                                                          $i++;
                                                        }
                                                        ?>

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                          <th>Sr. No.</th>
                                                          <th>Exam ID</th>
                                                          <th>Large Question</th>
                                                          <th>Max Marks</th>

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
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>


        <script type="text/javascript">

            $('#exam_date').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: new Date()
            });

            $('#exam_time').datetimepicker({
                use24hours: true,
                format: 'HH:mm'

            });

            $('#simpletable1').DataTable();

            $('#simpletable2').DataTable();


        </script>

    </body>
</html>
