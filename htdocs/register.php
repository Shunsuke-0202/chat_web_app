<?php

require_once("config.php");
//データベースへ接続、テーブルが無い場合は作成
try{
    $pdo=new PDO(DSN,DB_USER,DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->exec("create table if not exists userData(
        id int not null auto_increment primary key,
        email varchar(255),
        password varchar(255),
        created timestamp not null default current_timestamp
    )");
}catch(Exception $e){
    echo $e->getMessage().PHP_EOL;
}
//メールアドレスのバリデーション
if (!$email=filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
?>
    <p>入力された値が不正です。</p>
    <p><a href="signup.php">戻る</a></p>
<?php
    return false;
}
//正規表現でパスワードのバリデーション
if(preg_match("/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i",$_POST["password"])){
    $password=password_hash($_POST["password"],PASSWORD_DEFAULT);
}else{
?>
    <p>パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。</p>
    <p><a href="signup.php">戻る</a></p>
<?php
    return false;
}
//入力されたメールアドレスを取り出す処理を行い、すでに登録されていないか確認する。ない場合登録する
$stmt=$pdo->prepare("select email from userData where email=?");
$stmt->execute([$email]);
$row=$stmt->fetch(PDO::FETCH_ASSOC);

if(!isset($row["email"])){
    $stmt=$pdo->prepare("insert into userData(email,password)value(?,?)");
    $stmt->execute([$email,$password]);
?>

<head>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include "header.html" ?>
    <h3>登録完了</h3>
    <p><a href="login.php">ログインページへ</a></p>
</body>
<?php
}else{
?>
    <p>既に登録されているメールアドレスです。</p>
    <p class="page-jump"><a href="signup.php">戻る</a></p>
<?php
return false;
}
?>

<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
</html>