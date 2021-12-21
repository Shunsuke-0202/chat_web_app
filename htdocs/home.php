<html>
<head>
    <title>チャットアプリ</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include "header.html" ?>
    <h1>チャット</h1>
    <form action="home.php" method="POST">
        名前<input type="text" name="name">
        メッセージ<input type="text" method="POST" name="message">

        <button name="send" type="submit" class="button">送信</button>
    </form>

    チャット履歴
<section>
<?php
session_start();

if($_SERVER['REQUEST_METHOD']==='POST'){
    header('Location:home.php');
}

require_once("config.php");
//データの挿入、表示。テーブルが無い場合は作成

if(isset($_POST["send"])){
    insert();
    $stmt=select();
    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $message){

        echo "<p class='message'>",$message["created"],":   <span class='name'>",$message["name"],"</span>:   ",$message["message"],"</p>";
        echo nl2br("\n");
    }
    /*
    foreach($stmt->fetchAll(PDO::FETCH::ASSOC) as $message){
        echo $message["time"],": ",$message["name"],":",$message["message"];
        echo nl2br("\n");
    }
    */
}else{
    $stmt=select();
    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $message){

    echo "<p class='message'>",$message["created"],":   <span class='name'>",$message["name"],"</span>:   ",$message["message"],"</p>";
    echo nl2br("\n");
    }
}



//DB接続
function connectDB(){
    try{
        $pdo=new PDO(DSN,DB_USER,DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->exec("create table if not exists message(
            message_id int not null auto_increment primary key,
            name varchar(255),
            email varchar(255),
            message varchar(255),
            created timestamp not null default current_timestamp
        )");
    }catch(Exception $e){
        echo $e->getMessage().PHP_EOL;
    }
    return $pdo;
}

//DBから投稿内容の取得
function select(){
    $pdo=connectDB();
    $sql="SELECT * FROM message ORDER BY message_id DESC";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    return $stmt;
}

//DBに投稿内容の登録
function insert(){
    $pdo=connectDB();
    $sql="INSERT INTO message (name,email,message) VALUES (:name,:email,:message)";
    $stmt=$pdo->prepare($sql);
    $params=array(':name'=>$_POST['name'],':email'=>$_SESSION['EMAIL'],':message'=>$_POST['message']);
    $stmt->execute($params);
}

?>
</section>

</body>
</html>