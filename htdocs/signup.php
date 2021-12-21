<html>
<head>
    <meta charset="UTF-8">
    <title>新規登録ページ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include "header.html" ?>
    <h1 class="page_title">新規登録</h1>
    <form action="register.php" method="post" class="login_form">
        <input type="email" name="email" placeholder="メールアドレス"><br>
        <input type="password" name="password" placeholder="パスワード"><br>
        <button type="submit" class="button">新規登録</button>
    </form>
    <div class="link_block">
    <a href="login.php">
        <div  class="page_jump margin_0_auto">
            <p>ログイン画面へ</p>
        </div>
    </a>
    </div>
</body>
</html>