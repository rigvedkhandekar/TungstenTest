<?php
include 'config.php';

function query($query,$paramters)
{
  try {
    $stmt = $GLOBALS['pdo']->prepare($query);
    $stmt->execute($paramters);
//  $stmt->debugDumpParams();
    return $stmt;
  }
  catch (Exception $e)
  {
    error_log($e);
  }

}


function checkStartTime ($currentTime , $startTime)
{
  if ($currentTime >= strtotime($startTime))
  {
  return true;
  }
  else
  {
  return false;
  }
}

function checkEndTime ($currentTime , $endTime)
{
  if ($currentTime <= strtotime($endTime))
  {
    return true;
  }
  else
  {
    return false;
  }
}

function isTimePassed($currentTime,$stamp,$mins)
{

  $stamp = strtotime($stamp);
  $endTime = strtotime('+'.$mins.' mins',$stamp);


  if ($currentTime > $endTime)
  {
    return true;
  }

  else {
    return false;
  }

}
?>
