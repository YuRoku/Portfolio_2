<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>【出欠管理】Bestaidm</title>
  <link rel="stylesheet" href="css/destyle.css">
  <link href="https://fonts.googleapis.com/css2?family=Chivo:ital,wght@1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/responsive.css">
</head>

<body>
  <div id="bg-emblem">
<!--------------------- 
  ヘッダー
------------------------>
    <header>
      <div class="container">
        <a href="index.php"><img id="logo" src="images/besta_logo.png" alt="ロゴ"></a>
        <h1><span>W</span>eb <span>S</span>chedule <span>S</span>ervice</h1>
      </div>
    </header>

    <main>
      <div class="container">

<!--------------------- 
  スケジュール
------------------------>
        <section id="schedule">
          <h2 class="title">Team Schedule</h2>
          <table>
            <thead>
              <form action="php/personally_edit.php">
                <tr>
                  <td></td>
                  <td><p>〇</p></td>
                  <td><p>△</p></td>
                  <td><p>✕</p></td>
                  <?php
                    try{
                      require_once('php/DBInfo.php');
                      $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
                      $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                      
                      $sql = "SELECT * FROM add_name;";
                      $statement = $pdo->query($sql);

                      foreach ($statement as $row) {
                        print("<td><input type=\"submit\" name=\"personally_name\" class=\"button\" value=\"{$row['name']}\"></td>");
                      }

                    } catch (PDOException $e) {
                      // print($e->getMessage());
                      header('location: error.html');
                    }
                    $pdo = null;
                  ?>
                </tr>
              </form>
            </thead>
            <tbody>

              <?php
                try{
                  require_once('php/DBInfo.php');
                  $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
                  $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                  
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

                    print("<tr>");

                    //日程を追加
                    $sql = "SELECT * FROM schedule
                            ORDER BY date + 0, 
                            substring(date, 3) + 0, 
                            substring(date, 4) + 0;";
                    $statement = $pdo->query($sql);
                    $row = $statement->fetchAll();
                    print("<td>{$row[$i-1]['date']}<br>{$row[$i-1]['time']}<br>{$row[$i-1]['place']}</td>");

                    //日付のカラムを取得
                    $sql = "SELECT COLUMN_NAME
                            FROM INFORMATION_SCHEMA.COLUMNS
                            WHERE TABLE_SCHEMA= 'yuuroku_web_schedule'
                            AND TABLE_NAME= 'add_name';";

                    $statement = $pdo->query($sql);
                    $row = $statement->fetchAll();
                    $date = $row[$i]["COLUMN_NAME"];

                    //出席結果
                    $sql = "SELECT `$date` FROM add_name
                    WHERE `$date` LIKE '〇'
                    OR `$date` LIKE '△'
                    OR `$date` LIKE '×';";
                    $statement = $pdo->query($sql);
                    $row = $statement->fetchAll();

                    $ok = 0;
                    foreach($row as $val){
                      if(stristr($val[$date], "〇") !== false) {
                          $ok++;
                      }
                    }
                    $yet = 0;
                    foreach($row as $val){
                      if(stristr($val[$date], "△") !== false) {
                          $yet++;
                      }
                    }
                    $ng = 0;
                    foreach($row as $val){
                      if(stristr($val[$date], "×") !== false) {
                          $ng++;
                      }
                    }

                    //出席結果を表示
                    print("<td><p>$ok</p></td><td><p>$yet</p></td><td><p>$ng</p></td>");

                    //個人ごとに〇△×を表示
                    $sql = "SELECT * FROM add_name;";
                    $statement = $pdo->query($sql);

                    foreach ($statement as $row) {
                      if ($row[$date] != null) {
                        print("<td><p>{$row[$date]}</p></td>");
                      } else {
                        print("<td><p>-</p></td>");
                      }
                    }
                  
                    print("</tr>");

                  }

                } catch (PDOException $e) {
                  // print($e->getMessage());
                  header('location: error.html');
                }
                $pdo = null;
              ?>

            </tbody>
          </table>
          <a href="php/schedule_edit.php" id="schedule_edit" class="button">日程編集</a>

          <form action="php/name_insert.php">
            <h3 class="sub_title">新規メンバー登録</h3>
            <label for="add_name">名前：</label>
            <input type="text" id="add_name" name="add_name">
            <input type="submit" class="button" value="登録">
          </form>

        </section>


<!--------------------- 
  コメント
------------------------>
        <section id="comment">
          <h2 class="title">Comment</h2>
          <form action="php/comment_delete.php">
          <article>
            <?php
              try{
                require_once('php/DBInfo.php');
                $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                
                // ------------------------
                // コメントを表示
                // ------------------------
                $offset = 0;
                $limit = 5;
                                
                $sql = "SELECT * FROM comment
                        ORDER BY id desc
                        LIMIT $offset, $limit;";
                $statement = $pdo->query($sql);
                
                while ($row = $statement->fetch()) {

                  print("<div class=\"article_top\">");
                  print("<i class=\"fas fa-calendar-day fa-lg\"></i><p>{$row['date']}</p>");
                  print("<i class=\"fas fa-user-edit fa-lg\"></i><p>{$row['name']}</p>");
                  print("<i class=\"fas fa-futbol fa-lg\"></i><p>{$row['category']}</p>");
                  print("<input type=\"checkbox\" name=\"delete_comment_id[]\" value=\"{$row['id']}\" id=\"delete_comment_{$row['id']}\">
                  <label for =\"delete_comment_{$row['id']}\" class=\"delete_comment\">選択");
                  print("</div>");
                  
                  print("<div class=\"article_main\">");
                  print(nl2br("<i class=\"fas fa-user-circle fa-3x\"></i><p>{$row['message']}</p>"));
                  print("</div>");

                }

              } catch (PDOException $e) {
                // print($e->getMessage());
                header('location: error.html');
              }

              $pdo = null;

              ?>
          <button type="button" class="button">もっと見る</button>
              
          </article>

          <input type="submit" class="button" id="delete_comment_button" value="選択したコメントを削除">

          </form>

          <h3 class="sub_title">新規コメント</h3>

          <form action="php/comment_insert.php" method="post">
            <div class="form_box">
              <label for="name">▼名前</label>
              <br>
              <input type="text" id="name" name="name"  required>
            </div>
            <div class="form_box">
              <label for="category">▼カテゴリ</label>
              <br>
              <div id="selecter">
                <select name="category" id="category">
                  <option value="練習">練習</option>
                  <option value="練習試合">練習試合</option>
                  <option value="県リーグ">県リーグ</option>
                  <option value="大会">大会</option>
                  <option value="会計">会計</option>
                </select>
              </div>
            </div>
            <div class="form_box">
              <label for="message">▼メッセージ</label>
              <br>
              <textarea type="text" id="message" name="message" required></textarea>
            </div>
            <br>
            <input type="submit" class="button" value="書き込む">
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
  <script src="js/index.js"></script>
</body>
</html>