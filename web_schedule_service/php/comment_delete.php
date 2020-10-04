<?php

  try{
    require_once('DBInfo.php');
    $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    //選択した数だけ繰り返す
    for ($i = 0; $i < count($_GET["delete_comment_id"]); $i++){

      //idを取得して代入
      $delete_comment_id = '';
      if (isset($_GET['delete_comment_id']) == true && $_GET['delete_comment_id'] != '') {
      $delete_comment_id = $_GET['delete_comment_id'][$i];
      }
      
      //コメントを削除
      $sql = "DELETE FROM comment WHERE id=?;";
      $statement = $pdo->prepare($sql);
      $statement->bindValue(1, $delete_comment_id);
      $statement->execute();

    }
    
    header('location: ../index.php');

    $pdo = null;

  } catch (PDOException $e) {
    // print($e->getMessage());
    header('location: ../error.html');
    $pdo = null;
  }
