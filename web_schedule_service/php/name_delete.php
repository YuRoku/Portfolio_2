<?php

$personally_name = '';
if (isset($_GET['personally_name']) == true && $_GET['personally_name'] != '') {
  $personally_name = $_GET['personally_name'];
}

try{
  require_once('DBInfo.php');
  $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
  //名前を削除
  $sql = "DELETE FROM add_name WHERE name=?;";
  $statement = $pdo->prepare($sql);
  $statement->bindValue(1, "$personally_name");
  $statement->execute();
  
  header('location: ../index.php');

  $pdo = null;

} catch (PDOException $e) {
  // print($e->getMessage());
  header('location: ../error.html');
  $pdo = null;
}
