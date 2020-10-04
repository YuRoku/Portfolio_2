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
    
    $sql = "INSERT INTO add_name (name) VALUES (?);";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(1, $add_name);
    $statement->execute();

    header('location: ../index.php');

    $pdo = null;

  } catch (PDOException $e) {
    // print($e->getMessage());
    header('location: ../error.html');
    $pdo = null;
  }
  
