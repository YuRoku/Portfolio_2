<?php

  try{
    require_once('DBInfo.php');
    $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    //日程の数をカウント
    $sql = "SELECT COUNT(*) FROM information_schema.columns WHERE table_name = 'add_name';";
    $statement = $pdo->query($sql);
    $row_count = $statement->fetchColumn();

    //日程の数だけ入力欄を作成
    for ($i = 1; $i < $row_count; $i++) {

      $entry_{$i} = '';
      if (isset($_GET["entry_{$i}"]) == true && $_GET["entry_{$i}"] != '') {
        $entry_{$i} = $_GET["entry_{$i}"];
      } else {
        $entry_{$i} = "-";
      }
    
     $personally_name = '';
      if (isset($_GET['personally_name']) == true && $_GET['personally_name'] != '') {
        $personally_name = $_GET['personally_name'];
      } 

      //日付のカラムを取得
      $sql = "SELECT COLUMN_NAME
              FROM INFORMATION_SCHEMA.COLUMNS
              WHERE TABLE_SCHEMA= 'web_schedule_service'
              AND TABLE_NAME= 'add_name';";

      $statement = $pdo->query($sql);
      $row = $statement->fetchAll();
      $date = $row[$i]["COLUMN_NAME"];
      
      //〇△×の更新
      $sql = "UPDATE add_name SET `$date`=? WHERE name=?;";
      $statement = $pdo->prepare($sql);
      $statement->bindValue(1, $entry_{$i});
      $statement->bindValue(2, $personally_name);
      $statement->execute();

    } 

    header('location: ../index.php');

    $pdo = null;
    

  }catch (PDOException $e) {
    // print($e->getMessage());
    header('location: ../error.html');
    $pdo = null;
  }
  