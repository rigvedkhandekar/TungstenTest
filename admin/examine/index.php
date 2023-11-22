<?php
include '../../util/config.php';
include '../../util/check-faculty-session.php';
include '../../util/util.php';
include '../../util/strings.php';
  function isExamined($eid)
  {
    $query = "SELECT * FROM `attempts` where `eid` = :eid AND `isExamined` IS NULL";
    $result = query($query,['eid'=>$eid]);

    $count = $result->rowCount();

    if ($count > 0)
    {
      return true;
    }

    else {
      return false;
    }
  }
$todaysDate = date('Y-m-d');

?>

  <head>
    <base href="../../template/">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>DJSCE | Examine Dashboard</title>

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
                <div class="nav-item active">
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
                          <th>Start Time </th>
                          <th>End Time </th>
                          <th>Exam Duration</th>
                          <th>Concerned Faculty </th>
                          <th>Action </th>

                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $fetchExams = "SELECT faculty.faculty_name, `eid`, `exam_type`, `exam_marks`, `passing_marks`, `concerned_faculty`, `no_of_mcqs`, `no_of_sq`, `no_of_lq`, `exam_dept`, `exam_year`, `exam_date`, `start_time`, `end_time`, `exam_duration` FROM `exam_data` INNER JOIN faculty ON `exam_data`.`concerned_faculty` = `faculty`.`fid`";
                        $result = query($fetchExams,[]);
                        while ($data = $result->fetch()) {
                        ?>
                          <tr>
                              <td><?php echo $data['eid']; ?></td>
                              <td><?php echo $data['exam_type']; ?></td>
                              <td><?php echo $data['exam_date']; ?></td>
                              <td><?php echo $data['exam_marks']; ?></td>
                              <td><?php echo $data['start_time']; ?></td>
                              <td><?php echo $data['end_time']; ?></td>
                              <?php if ($data['exam_duration'] < 3600)
                                  {?>
                                     <td><?php echo $data['exam_duration']/60; ?> Minutes</td>
                <?php }
                else    {?>
                              <td><?php echo $data['exam_duration']/60/60; ?> Hrs.</td>
                <?php } ?>

                              <td><?php echo $data['faculty_name']; ?></td>
                              <?php if (isExamined($data['eid'])) { ?>
                                  <td>
                                      <a href="../../admin/examine/examine.php?eid=<?php echo bin2hex($data['eid']) . "&year=" . bin2hex($data['exam_year']) . "&dept=" . bin2hex($data['exam_dept']); ?>"
                                         class="btn btn-info"> Start Examining</a></td>
                              <?php } else { ?>
                                  <td>
                                      <button class="btn btn-warning">Examining Forbidden
                                  </td>
                              <?php } ?>
                          </tr>
                            <?php
                        } ?>

                      </tbody>
                      <tfoot>
                      <tr>
                          <th>Exam ID</th>
                          <th>Type</th>
                          <th>Date</th>
                          <th>Total Marks</th>
                          <th>Start Time</th>
                          <th>End Time</th>
                          <th>Exam Duration</th>
                          <th>Concerned Faculty</th>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js">
    </script>


  </body>

  </html>
