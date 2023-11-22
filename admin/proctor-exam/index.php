<?php
include '../../util/config.php';
include '../../util/util.php';
include '../../util/check-faculty-session.php';
include '../../util/strings.php';

if (isset($_GET['eid'])) {
    $eid = ($_GET['eid']);
    $query = "SELECT * FROM `exam_data` where eid = :eid";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['eid' => $eid]);
    $examData = $stmt->fetch();
}
?>

<head>
  <base href="../../template/">
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>DJSCE | Admin Proctoring Dashboard</title>

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

    <style>
        body{
            background:#0F2027;
            background:-webkit-linear-gradient(to right, #2C5364, #203A43, #0F2027) ;
            background: linear-gradient(to right, #2C5364, #203A43, #0F2027);
        }

        #join-btn{
            position: fixed;
            top:50%;
            left:50%;
            margin-top:-50px;
            margin-left:-100px;
            font-size:18px;
            padding:20px 40px;
        }

        #video-streams{
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            height: 90vh;
            width: 1400px;
            margin:0 auto;
        }

        .video-container{
            max-height: 100%;
            border: 2px solid black;
            background-color: #203A49;
        }

        .video-player{
            height: 100%;
            width: 100%;
        }



        #stream-controls{
            /*display: ;*/
            justify-content: center;
            margin-top:0.5em;
        }

        @media screen and (max-width:1400px){
            #video-streams{
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                width: 95%;
            }
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
          <div id="stream-wrapper">
              <div id="video-streams" ></div>

              <div id="stream-controls">
                  <button id="leave-btn" class="btn btn-danger">Leave Stream</button>
                  <button id="mic-btn" class="btn btn-success">Mic On</button>
                  <button id="camera-btn" class="btn btn-warning">Camera Off</button>
              </div>
          </div>

<!--          <div class="container-fluid">-->
<!---->
<!--            <div class="mt-1 row clearfix">-->
<!--              <div class="col-lg-12 col-md-12 col-sm-12">-->
<!---->
<!--                  <div id="stream-wrapper">-->
<!--                      <div id="video-streams"></div>-->
<!---->
<!--                      <div id="stream-controls">-->
<!--                          <button id="leave-btn">Leave Stream</button>-->
<!--                          <button id="mic-btn">Mic On</button>-->
<!--                          <button id="camera-btn">Camera on</button>-->
<!--                      </div>-->
<!--                  </div>-->
<!---->
<!--              </div>-->
<!---->
<!--            </div>-->
<!---->
<!--            <div class=" mt-3 row clearfix">-->
<!--            <button type="submit" class="m-2 ml-3 btn btn-success"><i class="ik ik-check"></i>Finish</button>-->
<!--            <button type="reset" class="m-2 btn btn-danger"><i class="ik ik-x"></i>Reset Answers</button>-->
<!--            </div>-->
<!---->
<!---->
<!---->
<!--        </form>-->
<!---->
<!--          </div>-->
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

  <script src="../js/AgoraRTC_N-4.11.0.js"></script>
  <script src='../js/f-main.js'></script>

</body>

</html>
