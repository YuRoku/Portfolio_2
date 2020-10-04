<?php

for ($i = 0; $i < count($_GET["date"]); $i++){

  $date = '';
  if (isset($_GET['date']) == true && $_GET['date'] != '') {
    $date = $_GET['date'][$i];
  } else {
    header('location: ../index.php');
  }

  $time_select_start = '';
  if (isset($_GET['time_select_start']) == true && $_GET['time_select_start'] != '') {
    $time_select_start = $_GET['time_select_start'][$i];
  } else {
    header('location: ../index.php');
  }

  $time_select_end = '';
  if (isset($_GET['time_select_end']) == true && $_GET['time_select_end'] != '') {
    $time_select_end = $_GET['time_select_end'][$i];
  } else {
    header('location: ../index.php');
  }

  $place = '';
  if (isset($_GET['place']) == true && $_GET['place'] != '') {
    $place = $_GET['place'][$i];
  } else {
    header('location: ../index.php');
  }

  try{
    require_once('DBInfo.php');
    $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  
    //日程を追加
    $sql = 'INSERT INTO schedule (date,time,place)
            VALUES (?,?,?)';

    $statement = $pdo->prepare($sql);

    $statement->bindValue(1, "$date");
    $statement->bindValue(2, "$time_select_start-$time_select_end");
    $statement->bindValue(3, "＠$place");

    $statement->execute();

    //日程の数をカウント
    $sql = "SELECT count(*) FROM schedule";
    $statement = $pdo->query($sql);
    $row_count = $statement->fetchColumn();
    
    //日程の数だけ個人登録用にスケジュール追加
    $sql = "ALTER TABLE add_name ADD `$date` varchar(10);";
    $statement = $pdo->query($sql);

    header('location: ../index.php');

    $pdo = null;

  } catch (PDOException $e) {
    // print($e->getMessage());
    header('location: ../error.html');
    $pdo = null;
  }
  
}