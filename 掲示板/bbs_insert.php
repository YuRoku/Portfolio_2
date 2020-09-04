<?php

  //ユーザが入力する値
  $date = new DateTime(null,new DateTimeZone('Asia/Tokyo'));
  $nowDate = $date->format('Y-m-d H:i:s');    // 2014-08-06 13:09:59

  $intName = '';
  if (isset($_POST['name']) == true && $_POST['name'] != '') {
    $intName = $_POST['name'];
  }

  $intCategory = '';
  if (isset($_POST['category']) == true && $_POST['category'] != '') {
    $intCategory = $_POST['category'];
  }

  $intSubcategory = '';
  if (isset($_POST['subcategory']) == true && $_POST['subcategory'] != '') {
    $intSubcategory = $_POST['subcategory'];
  }

  $intMessage = '';
  if (isset($_POST['message']) == true && $_POST['message'] != '') {
    $intMessage = $_POST['message'];
  }

  try{

    require_once('DBInfo.php');
    $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
    //SQL
    $sql = 'INSERT INTO bbs
            SELECT MAX(id)+1,?,?,?,?,? FROM bbs';
    
    //SQLを設定する
    $statement = $pdo->prepare($sql);

    //最新のid
    // $id = $pdo->lastInsertId();

    //パラメータを設定する
    // $statement->bindValue(1, "{$id}");
    $statement->bindValue(1, "{$nowDate}");
    $statement->bindValue(2, "{$intName}");
    $statement->bindValue(3, "{$intCategory}級");
    $statement->bindValue(4, "{$intSubcategory}");
    $statement->bindValue(5, "{$intMessage}");

    //トランザクション開始
    $pdo->beginTransaction();

    //SQLを発行する
    $statement->execute();

    //コミット
    $pdo->commit();
    header('location: bbs.php');
  }

  catch(PDOException $e){

    //$pdoがsetされていて、トランザクション中であれば真
    if(isset($pdo) == true && $pdo->inTransaction() == true){
    
    //PDOクラスのcommitメソッドでロールバック
    $pdo->rollBack();
    header('location: bbs.php');
    }

  }
  
  $pdo = null;
