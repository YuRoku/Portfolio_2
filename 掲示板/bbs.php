<?php

  $word = '';
  if (isset($_GET['word']) == true && $_GET['word'] != '') {
    // $word = htmlspecialchars($_GET['word']);
    $word = $_GET['word'];
  }

	// サニタイズ処理
	function e($str){
		return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
  }
  
  	// SQLのワイルドカードをエスケープ
	function escapeString($s){
		return mb_ereg_replace('([_%#])', '#\1', $s);
	}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>簿記なんでも掲示板</title>
  <link rel="stylesheet" href="bbs.css">
</head>
<body>
  
  <header>
    <h1>簿記なんでも掲示板</h1>
  </header>
  
  <div class="container">

    <noscript>
      <p>JavaScriptを有効にしてくさい。</p>
    </noscript>

    <main>

      <h2>掲示板のメニュー</h2>

      <section id="seach">
        <h3>記事の検索</h3>
        <form action="<?php print($_SERVER['PHP_SELF']) ?>" class="accordion">
          <p>次の項目を入力し、「検索」ボタンをクリックしてください。</p>
          <p><input type="text" name="word" id="word">をメッセージに含む記事</p>
          <input type="submit" class="submit" value="検索">
        </form>
      </section>

      <section id="writing">
        <h3>新規記事の書き込み</h3>
        <form action="bbs_insert.php" class="accordion" method="post">
          <p>次の項目を入力し、「書き込む」ボタンをクリックしてください。</p>
          <label for="name">お名前</label>
          <input type="text" id="name" name="name"  required>
          <br>
          <label for="category">カテゴリ</label>
          <select name="category" id="category">
            <option value="1">1級</option>
            <option value="2">2級</option>
            <option value="3">3級</option>
          </select>
          <br>
          <label for="subcategory">サブカテゴリ</label>
          <select name="subcategory" id="subcategory"></select>
          <br>
          <label for="message">メッセージ</label>
          <input type="text" id="message" name="message" required>
          <br>
          <input type="submit" class="submit" value="書き込む">
        </form>
      </section>

      <section id="delete">
        <h3>記事の削除（管理者専用）</h3>
        <form action="bbs_delete.php" class="accordion" method="post">
          <p>次の項目を入力し、「削除」ボタンをクリックしてください。</p>
          <label for="article_id">記事のID</label>
          <input type="text" id="article_id" name="article_id" pattern="^[0-9]+$" title="半角数字で入力して下さい" required>
          <div id="pass_box">
            <label for="password">管理パスワード</label>
            <div id="pass_area">
              <input type="password" id="password" name="password" maxlength="8" pattern="^([a-zA-Z0-9]{4,8})$" title="半角英数字（4文字以上8文字以下）で入力して下さい" required>
              <br>
              <input type="checkbox" id="passcheck"/>
              <label for="passcheck">パスワードを表示する</label>
              <br>
            </div>
          </div>
          <br>
          <input type="submit" class="submit" value="削除">
        </form>
      </section>

      <h2>記事一覧</h2>
      <p>検索条件:<br>
        <?php
          if ($word != '') {
            // $specialWord = htmlspecialchars($word);
            echo "メッセージに<u><b>".e($word)."</b></u>を含む記事";
          } else {
            echo "なし";
          }
        ?>
      </p>
 
      <?php
        try{
          require_once('DBInfo.php');
          $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
          $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
          
          //SQL
          $sql = "SELECT * FROM bbs
          WHERE id LIKE ? 
          OR date LIKE ? 
          OR name LIKE ? 
          OR category LIKE ? 
          OR subCategory LIKE ? 
          OR message LIKE ? ESCAPE'#'
          ORDER BY id DESC";
          
          //SQLを設定する
          $statement = $pdo->prepare($sql);

          // %をエスケープ
          // $replaceWord = str_replace('%', '\%', $word);

          //パラメータを設定する
          // $statement->bindValue(1, "%{$replaceWord}%");
          // $statement->bindValue(2, "%{$replaceWord}%");
          // $statement->bindValue(3, "%{$replaceWord}%");
          // $statement->bindValue(4, "%{$replaceWord}%");
          // $statement->bindValue(5, "%{$replaceWord}%");
          // $statement->bindValue(6, "%{$replaceWord}%");

          $statement->bindValue(1, "%".escapeString($word)."%");
          $statement->bindValue(2, "%".escapeString($word)."%");
          $statement->bindValue(3, "%".escapeString($word)."%");
          $statement->bindValue(4, "%".escapeString($word)."%");
          $statement->bindValue(5, "%".escapeString($word)."%");
          $statement->bindValue(6, "%".escapeString($word)."%");

          //SQLを発行する
          $statement->execute();
          $row = $statement->fetchAll();

          print_r(escapeString($word));

          if (!empty($row)){

            print("<table><thead><tr>");
            print("<td>ID</td>");
            print("<td>投稿日時</td>");
            print("<td>お名前</td>");
            print("<td>カテゴリ</td>");
            print("<td>サブカテゴリ</td>");
            print("<td>メッセージ</td>");
            print("</tr></thead><tbody>");
            
            foreach ($row as $result) {

              // $r0 = htmlspecialchars($result[0]);
              // $r1 = htmlspecialchars($result[1]);
              // $r2 = htmlspecialchars($result[2]);
              // $r3 = htmlspecialchars($result[3]);
              // $r4 = htmlspecialchars($result[4]);
              // $r5 = htmlspecialchars($result[5]);

              // print("<tr>");
              // print("<td>{$r0}</td>");
              // print("<td>{$r1}</td>");
              // print("<td>{$r2}</td>");
              // print("<td>{$r3}</td>");
              // print("<td>{$r4}</td>");
              // print("<td>{$r5}</td>");
              // print('</tr>');       
              
              print('<tr>');
							for($i = 0 ; $i < 6 ; $i++){
								print('<td>'.e($result[$i]).'</td>');
							}
							print('</tr>');

            }
              print("</tbody>");
              print("</table>");

          }else {
            print("<p class=\"nothing\">検索条件に一致する書き込みはありません</p>");
            }
          
          $pdo = null;

        } catch (PDOException $e) {
          $pdo = null;
          print($e->getMessage());
        }
        end:
      ?>
    </main>
  </div>

  <footer>
    <div class="container">
      <div id="footer_left">
        <a href="index.html"><img src="image/f-logo.png" alt=""></a>
        <ul>
          <li>
            <a href="#"><img src="image/arrow-green.png" alt="">学校の紹介はこちら</a>
          </li>
          <li>
            <a href="#"><img src="image/arrow-green.png" alt="">利用規約</a>
          </li>
          <li>
            <a href="#"><img src="image/arrow-green.png" alt="">個人情報保護方針</a>
          </li>
        </ul>
      </div>
      
      <div id="footer_right">
        <a href="#">お問い合わせ</a>
        <p>©CPA All Rights Reserved</p>
      </div>
      
    </div>
  </footer>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="bbs.js"></script>

</body>
</html>