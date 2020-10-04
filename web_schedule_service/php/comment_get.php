<?php

	$json = '';

	if(isset($_GET['count']) && $_GET['count'] !== ''){
		$count = $_GET['count'];
  }
  
  try{
    require_once('DBInfo.php');
    $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
    // コメントを取得
    $sql = "SELECT * FROM comment
            ORDER BY id desc
            LIMIT $count, 1;";
            
    $statement = $pdo->query($sql);
    
    while ($row = $statement->fetch()) {
      $json = [
        "id" => $row['id'],
        "date" => $row['date'],
        "name" => $row['name'],
        "category" => $row['category'],
        "message" => $row['message'],
      ];
    }

  } catch (PDOException $e) {
    // print($e->getMessage());
    header('location: error.html');
  }

  $pdo = null;

	//データをjson形式で送信する
	header('content-type:application/json; charset=utf-8');
	echo json_encode($json);
