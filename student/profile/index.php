<?php
include '../../util/config.php';
include '../../util/util.php';
include '../../util/check-student-session.php';
include '../../util/strings.php';

//*********************************************************************************
$sid = $_SESSION['student-session']['key'];
$sYear = $_SESSION['student-session']['year'];
$query = "SELECT `student_data_3_2019_2020`.*, `dept`.`dept_name` from `student_data_3_2019_2020` INNER JOIN `dept` on `dept`.`dept_id` = `student_data_3_2019_2020`.`dept` where `contact_no` = :sid";
$result = query($query,['sid'=>$sid]);
$data = $result->fetch();
$student_dept_id = $data['dept'];
$student_dept = $data['dept_name'];

?>
<!DOCTYPE html>
<html lang="en">
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
                                <div class="nav-item ">
                                    <a href="../../student/dashboard/"><i class="ik ik-bar-chart-2"></i><span>Assessments</span> </a>
                                </div>
                                <div class="nav-item">
                                  <a href="../../student/my-attempts"><i class="ik ik-database"></i><span>My Attempts</span> </a>
                                </div>
                                <div class="nav-lavel">Profile</div>
                                <div class="nav-item active">
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
                            <div class="mt-4 row clearfix">


                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="fname">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['name']; ?>" disabled>


                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="lname">Roll No.</label>
                                        <input type="text" class="form-control" id="rollno" name="rollno" value="<?php echo $data['rollno']; ?>" disabled>


                                    </div>
                                </div>


                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="age">Department</label>
                                        <input type="text" class="form-control" id="dept" name="dept" value="<?php echo $student_dept; ?>" disabled>

                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="city">Contact No.</label>
                                        <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?php echo $data['contact_no']; ?>" disabled>

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


            $('#simpletable').DataTable();

        </script>

    </body>
</html>
