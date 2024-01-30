<?php
//1. POSTデータ取得
$title = $_POST['title'];
$url = $_POST['url'];
$comment= $_POST['comment'];


include("funcs.php");
$pdo = db_conn();

// //2. DB接続します
// try {
//   //Password:MAMP='root',XAMPP=''
//   $pdo = new PDO('mysql:dbname=k-koji_unit1;charset=utf8;host=mysql57.k-koji.sakura.ne.jp','k-koji','53r4ijgAXtnVUhY_');
// } catch (PDOException $e) {
//   exit('DBConnection Error:'.$e->getMessage());
// }

//３．データ登録SQL作成
$sql = "INSERT INTO `gs_bm_table`(title, url, comment, indate) VALUES (:title,:url,:comment,sysdate())";
$stmt = $pdo->prepare($sql); // statement
$stmt->bindValue(':title', $title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //*** function化を使う！*****************
  sql_error($stmt);
}else{
  //*** function化を使う！*****************
  redirect("index.php");
}
?>