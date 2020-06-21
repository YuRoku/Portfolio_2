<?php
	session_start() ;
	$_SESSION["name"] = $_POST["name"];
	$_SESSION["mail"] = $_POST["mail"];
	// $_SESSION["subject"] = $_POST["subject"];
  $_SESSION["content"] = $_POST["content"];
  
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  $to = "yugo.suemasu.2020@gmail.com"; //ここのメールアドレスを変更する
  $subject = ”お問い合わせを受信しました”;
  $name = htmlspecialchars($_SESSION['name']);
  $mail = htmlspecialchars($_SESSION['mail']);
  $content = htmlspecialchars($_SESSION['content']);
  $header = "From:$mail";
  $body = "------------------------------------------------------------
  ▼送信内容
  ------------------------------------------------------------"."\n"."\n".
  "【お名前】"."\n"."$name"."\n\n"
  ."【メールアドレス】"."\n"."$mail"."\n\n"
  // ."題名"."\n"."$subject"."\n\n"
  ."【お問い合わせ内容】"."\n"."$content"."\n\n";

  $_SESSION['mailexit'] = 'complete';

  header('Location: /#contact');

  ?>
  <?php if((mb_send_mail($to,$subject,$body,$header))) : ?>
    <p >メールの送信が完了しました</p>
  <?php else : ?>
    <p>メールの送信が失敗しました</p>
  <?php endif ; ?>
  <a href="index.html">戻る</a>