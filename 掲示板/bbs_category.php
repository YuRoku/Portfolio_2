<?php

//データが見つからない場合は空にする
$json = '[]';

//リクエストパラメータ「category」を取得
if(isset($_REQUEST['category']) == true && $_REQUEST['category'] != ''){
	$parameter = $_REQUEST['category'];
}
else{
	goto end;
}

//カテゴリごとの表示
if($parameter == 1){
	$json = "[{\"subcate\":\"商業簿記\"},{\"subcate\":\"会計学\"},{\"subcate\":\"工業簿記\"},{\"subcate\":\"原価計算\"}]";
}
else if($parameter == 2){
	$json = "[{\"subcate\":\"商業簿記\"},{\"subcate\":\"工業簿記\"}]";
}
else if($parameter == 3){
	$json = "[{\"subcate\":\"商業簿記\"}]";
}

end:

//データをjson形式で返信する
header('content-type:application/json; charset=UTF-8');
print($json);