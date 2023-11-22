<?php
include '../../util/config.php';
include '../../util/util.php';
include '../../util/check-faculty-session.php';
include '../../util/strings.php';

if (isset($_GET['eid']))
{
  $eid = hex2bin($_GET['eid']);
  $query = "Select * from exam_data where eid = :eid";
  $result = query($query,['eid'=>$eid]);
  $data = $result->fetch();
  $no_of_mcqs = $data['no_of_mcqs'];
  $no_of_sq = $data['no_of_sq'];
  $no_of_lq = $data['no_of_lq'];

}

 ?>

 <!doctype html>
 <html class="no-js" lang="en">

     <head>
         <base href="../../template/">
         <meta charset="utf-8">
         <meta http-equiv="x-ua-compatible" content="ie=edge">
         <title>DJSCE | Create Exam [Generate-Paper]</title>

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
                             <h5 class="mt-1">Generate Question Paper for <?php echo $eid; ?></h5>
                         </div>

                     </div>
                 </div>
             </header>

             <div class="page-wrap">
                 <div class="app-sidebar colored">
                     <div class="sidebar-header">
                         <a class="header-brand" href="index.html">
                             <div class="logo-img">
                                <img src="src/img/brand-white.svg" class="header-brand-img" alt="lavalite">
                             </div>
                             <span class="text">DJSCE</span>
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
                           <div class="nav-item">
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

                               <form action="../../admin/create-exam/generate-paper.php" method="POST">
                                 <input type="hidden" name="eid" value="<?php echo $eid; ?>">

                               <div class="container-fluid">
                                 <h6 class="mt-1"><b>MCQ Questions</b></h6>

                                 <div class="mt-3 row clearfix">


                                <?php for ($i=1; $i<=$no_of_mcqs; $i++) {
                                  ?>
                                  <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                                      <label for="q_1_[][]>">MCQ Question : <?php if ($i<=9){echo "0".$i;} else {echo $i;}?></label>
                                                      <input type="text" class="form-control" id="q_1_<?php echo $i."_"; ?>[]" name="q_1_<?php echo $i."_"; ?>[]" placeholder="MCQ Question : <?php echo $i; ?>" required="">
                                                      <input type="text" class="form-control" id="q_1_<?php echo $i."_"; ?>[]" name="q_1_<?php echo $i."_"; ?>[]" placeholder="Option : A" maxlength="1024" required="">
                                                      <input type="text" class="form-control" id="q_1_<?php echo $i."_"; ?>[]" name="q_1_<?php echo $i."_"; ?>[]" placeholder="Option : B" maxlength="1024" required="">
                                                      <input type="text" class="form-control" id="q_1_<?php echo $i."_"; ?>[]" name="q_1_<?php echo $i."_"; ?>[]" placeholder="Option : C" maxlength="1024" required="">
                                                      <input type="text" class="form-control" id="q_1_<?php echo $i."_"; ?>[]" name="q_1_<?php echo $i."_"; ?>[]" placeholder="Option : D" maxlength="1024" required="">
                                                      <select class="form-control" id="q_1_<?php echo $i."_"; ?>[]" name="q_1_<?php echo $i."_"; ?>[]" required>
                                                      <option  selected disabled value="">Select Correct Option</option>
                                                      <option value="a">A</option>
                                                      <option value="b">B</option>
                                                      <option value="c">C</option>
                                                      <option value="d">D</option>
                                                    </select>

                                            </div>
                                    </div>
                                  <?php } ?>
                                  </div>




                                       <h6 class="mt-1"><b>Short Questions</b></h6>
                                                    <div class="mt-3 row clearfix">


                                                      <?php for ($i=1; $i<=$no_of_sq; $i++) {
                                                        ?>
                                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                                          <div class="form-group">
                                                                            <label for="q_2_[]">Short Question : <?php if ($i<=9){echo "0".$i;} else {echo $i;}?></label>
                                                                            <input type="text" class="form-control" id="q_2_[]" name="q_2_[]" placeholder="Short Question : <?php echo $i; ?>" required="">
                                                                  </div>
                                                          </div>
                                                        <?php } ?>
                                                        </div>

                                    <h6 class="mt-1"><b>Long Questions</b></h6>
                                                 <div class="mt-3 row clearfix">


                                                   <?php for ($i=1; $i<=$no_of_lq; $i++) {
                                                     ?>
                                                     <div class="col-lg-3 col-md-6 col-sm-12">
                                                       <div class="form-group">
                                                                         <label for="q_3_[]">Long Question : <?php if ($i<=9){echo "0".$i;} else {echo $i;}?></label>
                                                                         <input type="text" class="form-control" id="q_3_[]" name="q_3_[]" placeholder="Long Question : <?php echo $i; ?>" required="">
                                                               </div>
                                                       </div>
                                                     <?php } ?>
                                                     </div>



                                   <div class=" mt-3 row clearfix">
                                   <button type="submit" name="generate-paper" class="m-2 ml-3 btn btn-success"><i class="ik ik-plus-circle"></i>Create Exam</button>
                                   <button type="reset" class="m-2 btn btn-danger"><i class="ik ik-x"></i>Reset</button>
                                   </div>




                                                   </div>
                                                 </form>
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




     </body>
 </html>
