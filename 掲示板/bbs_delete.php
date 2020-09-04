<?php

  //ユーザが入力する値
  $articleId = '';
  if (isset($_POST['article_id']) == true && $_POST['article_id'] != '') {
    $articleId = $_POST['article_id'];
  }

  $password = '';
  if (isset($_POST['password']) == true && $_POST['password'] != '') {
    $password = $_POST['password'];
  }


  if ($password == 'password') {

    try{
      require_once('DBInfo.php');
      $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
      $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      
      //SQL
      $sql = 'DELETE FROM bbs WHERE id = ?';
      
      //SQLを設定する
      $statement = $pdo->prepare($sql);

      //パラメータを設定する
      $statement->bindValue(1, "{$articleId}");

      //トランザクション開始
      $pdo->beginTransaction();

      //SQLを発行する
      $statement->execute();

      //削除した数を確認
      $count = $statement->rowCount();
      
      if ($count != 0) {
        //コミット
        $pdo->commit();
        header('location: bbs.php');
      } else if (isset($pdo) == true && $pdo->inTransaction() == true){
      
        //PDOクラスのcommitメソッドでロールバック
        $pdo->rollBack();
        // print('削除できる書き込みはありません<br/>');
         header('location: bbs.php');
      }

    }
    catch (PDOException $e) {

      //$pdoがsetされていて、トランザクション中であれば真
      if(isset($pdo) == true && $pdo->inTransaction() == true){
      
      //PDOクラスのcommitメソッドでロールバック
      $pdo->rollBack();
      // print('削除に失敗しました<br/>');
       header('location: bbs.php');

      }
      
    }
  
  $pdo = null;

} else {
  header('location: bbs.php');
}
