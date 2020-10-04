<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>【出欠管理】Bestaidm（個人編集用）</title>
  <link rel="stylesheet" href="../css/destyle.css">
  <link href="https://fonts.googleapis.com/css2?family=Chivo:ital,wght@1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/personally.css">
   <link rel="stylesheet" href="../css/style.css">
   <link rel="stylesheet" href="../css/responsive.css">
</head>

<body>
  <div id="bg-emblem">
    <!--------------------- 
      ヘッダー
    ------------------------>
    <header>
      <div class="container">
        <a href="../index.php"><img id="logo" src="..//images/べすたロゴ.png" alt="ロゴ"></a>
        <h1><span>W</span>eb <span>S</span>chedule <span>S</span>ervice</h1>
      </div>
    </header>

    <main>
      <div class="container">

        <!--------------------- 
          登録フォーム
        ------------------------>
        <section id="personally">
          <h2 class="title">参加可否を入力</h2>
          <form action="personally_update.php">
            <div id="wrap">
              <table>
                <?php
                  try{
                    require_once('DBInfo.php');
                    $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                    
                    // ------------------------
                    // 名前を取得
                    // ------------------------
                    $personally_name = $_GET['personally_name'];
                    
                    $sql = "SELECT * FROM add_name
                            WHERE name = '$personally_name';";
                    $statement = $pdo->query($sql);
                    
                    if ($row = $statement->fetch()) {
                      print("<tr><td></td><td colspan=\"3\"><input type=\"text\" name=\"personally_name\" value=\"{$row['name']}\" readonly></td></tr>");
                    }
                    
                    // ------------------------
                    // DBのデータ数を取得
                    // ------------------------
                    $sql = "SELECT count(*) FROM schedule";
                    $statement = $pdo->query($sql);
                    $row_count = $statement->fetchColumn();
                    
                    // ------------------------
                    // 必要分だけ繰り返す
                    // ------------------------
                    for ($i = 1; $i <= $row_count; $i++) {

                      //登録済み出席情報を取得
                      $sql = "SELECT * FROM add_name
                              WHERE name = '$personally_name';";
                      $statement = $pdo->query($sql);
                      $row = $statement->fetchAll();
                      $current = $row[0][$i];
                      
                      print("<tr>");
                      
                      //日程を追加
                      $sql = "SELECT * FROM schedule
                      ORDER BY date + 0, 
                      substring(date, 3) + 0, 
                      substring(date, 4) + 0;";
                      $statement = $pdo->query($sql);
                      $row = $statement->fetchAll();
                      print("<td>{$row[$i-1]['date']}<br>{$row[$i-1]['time']}<br>{$row[$i-1]['place']}</td>");

                      $current_ok = $current === '〇' ? 'checked' : '';
                      print("<td>
                      <input type=\"radio\" name=\"entry_{$i}\" value=\"〇\" id=\"ok_{$i}\"".$current_ok.">
                      <label for =\"ok_{$i}\">〇</label>
                      </td>");

                      $current_yet = $current === '△' ? 'checked' : '';
                      print("<td>
                      <input type=\"radio\" name=\"entry_{$i}\" value=\"△\" id=\"yet_{$i}\"".$current_yet.">
                      <label for =\"yet_{$i}\">△</label>
                      </td>");

                      $current_ng = $current === '×' ? 'checked' : '';
                      print("<td>
                      <input type=\"radio\" name=\"entry_{$i}\" value=\"×\" id=\"ng_{$i}\" ".$current_ng.">
                      <label for =\"ng_{$i}\">×</label>
                      </td>");
                      
                      print("</tr>");
                      
                    }
                    
                  } catch (PDOException $e) {
                    // print($e->getMessage());
                    header('location: error.html');
                  }
                  $pdo = null;
                ?>

              </table>
              <input type="submit" class="button" id="delete_name" onclick="multipleaction('name_delete.php')" value="名前削除">
            </div>
            
            <input type="submit" class="button" value="送信">

          </form>
        </section>

      </div>
    </main>

<!--------------------- 
  フッター
------------------------>
    <footer>
      <div class="container">
        <p>© 2020 YuuRoku.</p>
      </div>
    </footer>
    

  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../js/index.js"></script>
</body>
</html>