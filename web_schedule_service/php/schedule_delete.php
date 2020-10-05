<?php
  try{
    require_once('DBInfo.php');
    $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    for ($i = 0; $i < count($_GET["delete_day"]); $i++){

      $delete_day = '';
      if (isset($_GET['delete_day']) == true && $_GET['delete_day'] != '') {
        $delete_day = $_GET['delete_day'][$i];
      }

        //スケジュールから日程を削除
        $sql = "DELETE FROM schedule WHERE date='$delete_day';";
        $statement = $pdo->query($sql);

        //個人登録用から日程を削除
        $sql = "ALTER TABLE add_name DROP `$delete_day`;";
        $statement = $pdo->query($sql);

        //一度カラムごと削除
        $sql = "ALTER TABLE schedule DROP day_id;";
        $statement = $pdo->query($sql);

        //削除したday_idを作り直して番号の振り直し
        $sql = "ALTER TABLE schedule ADD day_id int(11) primary key not null auto_increment first;";
        $statement = $pdo->query($sql);

      }
    
    header('location: ../index.php');

    $pdo = null;

  } catch (PDOException $e) {
    // print($e->getMessage());
    header('location: ../error.html');
    $pdo = null;
  }
  