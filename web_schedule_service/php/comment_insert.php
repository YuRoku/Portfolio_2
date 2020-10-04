<?php

  //現在の日付を取得
  $date = new DateTime(null,new DateTimeZone('Asia/Tokyo'));
  $now_date = $date->format('Y-m-d');

  $name = '';
  if (isset($_POST['name']) == true && $_POST['name'] != '') {
    $name = $_POST['name'];
  } else {
    header('location: ../index.php');
  }

  $category = '';
  if (isset($_POST['category']) == true && $_POST['category'] != '') {
    $category = $_POST['category'];
  } else {
    header('location: ../index.php');
  }

  $message = '';
  if (isset($_POST['message']) == true && $_POST['message'] != '') {
    $message = $_POST['message'];
  } else {
    header('location: ../index.php');
  }

  try{
    require_once('DBInfo.php');
    $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
    $sql = "INSERT INTO comment (date,name,category,message)
            VALUES (?,?,?,?);";
    
    $statement = $pdo->prepare($sql);

    $statement->bindValue(1, $now_date);
    $statement->bindValue(2, "$name");
    $statement->bindValue(3, "$category");
    $statement->bindValue(4, "$message");

    $statement->execute();

    header('location: ../index.php');

    $pdo = null;

  } catch (PDOException $e) {
    // print($e->getMessage());
    header('location: ../error.html');
    $pdo = null;
  }
  
