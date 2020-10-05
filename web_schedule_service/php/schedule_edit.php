<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>【出欠管理】Bestaidm（日程編集用）</title>
  <link rel="stylesheet" href="../css/destyle.css">
  <link href="https://fonts.googleapis.com/css2?family=Chivo:ital,wght@1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/calendar.css">
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
        <a href="../index.php"><img id="logo" src="../images/besta_logo.png" alt="ロゴ"></a>
        <h1><span>W</span>eb <span>S</span>chedule <span>S</span>ervice</h1>
      </div>
    </header>

    <main>
      <div class="container">

        <!--------------------- 
          カレンダー
        ------------------------>
        <h2 class="title">日付を選択</h2>

        <section id="step1" class="container-calendar">
          <h4 id="monthAndYear"></h4>
          <div class="button-container-calendar">
              <button id="previous" onclick="previous()">＜</button>
              <button id="next" onclick="next()">＞</button>
          </div>
          
          <table class="table-calendar" id="calendar" data-lang="ja">
              <thead id="thead-month"></thead>
              <tbody id="calendar-body"></tbody>
          </table>
          
          <div class="footer-container-calendar">
              <label for="month">年月指定：</label>
              <select id="month" onchange="jump()">
                  <option value=0>1月</option>
                  <option value=1>2月</option>
                  <option value=2>3月</option>
                  <option value=3>4月</option>
                  <option value=4>5月</option>
                  <option value=5>6月</option>
                  <option value=6>7月</option>
                  <option value=7>8月</option>
                  <option value=8>9月</option>
                  <option value=9>10月</option>
                  <option value=10>11月</option>
                  <option value=11>12月</option>
              </select>
              <select id="year" onchange="jump()"></select>
              <p>※日付は複数選択可能</p>
          </div>
        </section>

        <section id="time_place">
          <h2 class="title">時間と場所を入力</h2>
          <form action="schedule_insert.php">
            <?php
            print("<table>");
              
            print("</table>");
            ?>
            <input type="submit" class="button" value="追加">
          </form>
        </section>


        <!--------------------- 
          削除フォーム
        ------------------------>
        <section id="delete">
          <h2 class="title">日程削除</h2>
          <form action="schedule_delete.php">
            <table>

            <?php
            try{
              require_once('DBInfo.php');
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

              print("<tr>");
              for ($i = 1; $i <= $row_count; $i++) {

                //日程を表示
                $sql = "SELECT * FROM schedule
                        ORDER BY date + 0, 
                        substring(date, 3) + 0, 
                        substring(date, 4) + 0;";
                $statement = $pdo->query($sql);
                $row = $statement->fetchAll();

                print("<td>
                <input type=\"checkbox\" name=\"delete_day[]\" value=\"{$row[$i-1]['date']}\" id=\"delete_day_{$i}\">
                <label for =\"delete_day_{$i}\">
                <div class=\"delete_wrap\"><p>{$row[$i-1]['date']}<br>{$row[$i-1]['time']}<br>{$row[$i-1]['place']}</p></div>
                </label>
                </td>");

              }
              

              print("</tr>");
              
            } catch (PDOException $e) {
              // print($e->getMessage());
              header('location: error.html');
            }
            $pdo = null;
            ?>

            </table>

            <input type="submit" class="button" value="削除">
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
  <script src="../js/calendar.js"></script>
</body>
</html>