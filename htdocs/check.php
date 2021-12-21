<?php

require_once("config.php");
session_start();

//メールアドレスのバリデーション
if(!$email=filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
?>
    <p>入力された値が不正です。</p>
    <p><a href="login.php">戻る</a></p>
<?php
  return false;
}
//DB内でメールアドレスの検索、取り出し
try{
  $pdo=new PDO(DSN,DB_USER,DB_PASS);
  $stmt=$pdo->prepare("select * from userData where email=?");
  $stmt->execute(["$email"]);
  $row=$stmt->fetch(PDO::FETCH_ASSOC);
}catch(\Exception $e){
  echo $e->getMessage(),PHP_EOL;
}
//DB内にメールアドレスが存在するか
if(!isset($row["email"])){
?>
  <p>メールアドレスが存在しません。</p>
  <p><a href="login.php">戻る</a></p>
<?php
  return false;
}
//パスワードをチェックし、それぞれのページへ遷移
if(password_verify($_POST["password"],$row["password"])){
  session_regenerate_id(true);
  $_SESSION["EMAIL"]=$row["email"];
  header("Location:home.php");
  exit;
}else{
?>
  <p>パスワードが違います。</p>
  <p><a href="login.php">戻る</a></p>
<?php
}
?>

<html>
<head>
  <link href="css/style.css">
</head>
</html>