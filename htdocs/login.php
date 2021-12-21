<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログインページ</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include "header.html" ?>
    <h1 class="page_title">ログイン</h1>
    <form action="check.php" method="post" class="login_form">
        <input type="email" name="email" placeholder="メールアドレス"><br>
        <input type="password" name="password" placeholder="パスワード"><br>
        <button type="submit" class="button">ログイン</button>
    </form>

        <div class="link_block">
    <a href="signup.php">
        <div  class="page_jump margin_0_auto">
            <p>新規登録画面へ</p>
        </div>
    </a>
    </div>
</body>
</html>