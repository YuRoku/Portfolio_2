<?php

  $add_name = '';
  if (isset($_GET['add_name']) == true && $_GET['add_name'] != '') {
    $add_name = $_GET['add_name'];
  } else {
    header('location: ../index.php');
  }

  try{
    require_once('DBInfo.php');
    $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    //既存の名前を取得して配列へ
    $sql = "SELECT name FROM add_name;";
    $statement = $pdo->query($sql);
    while ($row = $statement->fetch()) {
      $rows[] = $row['name'];
    }

    //名前被りがないか確認して処理
    if (in_array($add_name, $rows) == false) {

      $sql = "INSERT INTO add_name (name) VALUES (?);";
      $statement = $pdo->prepare($sql);
      $statement->bindValue(1, $add_name);
      $statement->execute();

      header('location: ../index.php');
      
    } else {
      print('同じ名前が存在します<br>');
      print('<a href="../index.php">トップページに戻る</a>');
    }

    $pdo = null;

  } catch (PDOException $e) {
    // print($e->getMessage());
    header('location: ../error.html');
    $pdo = null;
  }
  
