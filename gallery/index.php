<?php
  
  $totalPage = 5;
  $range = 5;

  if (isset($_GET["page"]) && $_GET["page"] > 0 && $_GET["page"] <= $totalPage) {
    $page = (int)$_GET["page"];
  } else {
    $page = 1;
  }

  // 配列化
  $dir = glob('images/*');

  // pdf.txt削除
  for ($i = 0 ; $i < count($dir); $i++){

    $finfo = new finfo();
    $mimeType = $finfo->file( "{$dir[$i]}", FILEINFO_MIME_TYPE);

    if ($mimeType == 'application/pdf' || $mimeType == 'text/plain'){
      unset($dir[$i]);
    }
    
  }

  $images = array_values($dir);
  
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>画像ギャラリーのプログラム</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <div id="container">

    <?php

    $imageCount = count($images);
    $perPage = 6;


	// 現在のページで最初に表示する画像の番号
	$start = ($page - 1) * $perPage;
	// 現在のページで最後に表示する画像の番号
	$end = $start + $perPage - 1;

      // リサイズ
        for ($i = $start; $i <= $end && $i < $imageCount; $i++){

          $thumbSize = 130; // 画像横幅を指定
          $url = "{$images[$i]}"; // 画像URLを指定

          list($image_w, $image_h) = getimagesize($url);

         if ($image_w > $image_h) {
          $max = $image_w;
         } else {
           $max = $image_h;
         }

         $ratio = $max / $thumbSize;
         $new_w = round($image_w / $ratio);
         $new_h = round($image_h / $ratio);

            echo "<div class=\"box\">";
            echo "<a class=\"modal-open\" id=\"{$images[$i]}\"><img src=\"{$images[$i]}\" width=\"{$new_w}\" height=\"{$new_h}\"></a>";
            echo "</div>";

        }
    ?>

  </div>

  <!-- ページネーション -->
  <section id="pagination">
    <div id="first">
      <?php if ($page > 1) : ?>
        <a href="?page=<?php echo '1'; ?>">≪ first</a>
      <?php endif; ?>
    </div>

    <div id="middle">
      <?php for ($i = $range; $i > 0; $i--) : ?>
        <?php if ($page - $i < 1) continue; ?>
        <a href="?page=<?php echo ($page - $i); ?>"><?php echo ($page - $i); ?></a>
      <?php endfor; ?>
    
      <span><strong><?php echo $page; ?></strong></span>

      <?php for ($i = 1; $i <= $range; $i++) : ?>
        <?php if ($page + $i > $totalPage) break; ?>
        <a href="?page=<?php echo ($page + $i); ?>"><?php echo ($page + $i); ?></a>
      <?php endfor; ?>
    </div>

    <div id="last">
      <?php if ($page < $totalPage) : ?>
        <a href="?page=<?php echo $totalPage; ?>">last ≫</a>
      <?php endif; ?>
    </div>

  </section>


  <script type="text/javascript" src="jquery.js"></script>
  <script src="index.js"></script>
</body>
</html>