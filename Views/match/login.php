<?php session_start();?>
<?php 
require_once(ROOT_PATH . 'Controllers/matchController.php');
if(isset($_POST["login"])) {
  // エラーメッセージ
  $err = [];
  // バリデーション
  if (!$mail = filter_input(INPUT_POST, 'mail')) {
    $err['mail'] = 'メールアドレスを記入してください。';
  }
  if (!$password = filter_input(INPUT_POST, 'password')) {
    $err['password'] = 'パスワードを記入してください。';
  }
    if (count($err) > 0) {
      // エラーがあった場合
      $_SESSION = $err;
      $_SESSION['mail'] = $_POST['mail'];
    } else {
      // ログイン成功時処理
      // echo 'ログインしました。';
      $users = new Game();
      $hasLogined = $users->LOGIN($mail, $password);
    // var_dump($hasLogined);
    if (!$hasLogined) {
      $err[] = "ログイン失敗しました。";
      $_SESSION['mail'] = $_POST['mail'];
      // var_dump($password);
    } else {
        $_SESSION['login'] = $_POST['login'];
        $users->role_update();
        header('Location: main.php');
        return;
        }
      }
  }

  ?>
  <?php 
// XSS対策
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
  }
?>
<?php 
if (isset($_SESSION["login_user"]['id'])) {
  session_destroy();
}
?>
<!-- <?php var_dump($_SESSION["login_user"]['id']);?> -->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Match UP ログイン</title>
  <link rel="stylesheet" href="/css/style.css">
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/cfdc634195.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="wrapper">
  <header>
      <div class="container">
        <nav class="navbar navbar-expand-sm navbar-light">
          <a href="main.php" class="navbar-brand"><img class="logo" src="/img/logo.png" alt="" width="150px" height="100px"></a>
          <button class="navbar-toggler" data-toggle="collapse" data-target="#menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div id="menu" class="collapse navbar-collapse">
            <ul id="header-nav" class="navbar-nav">
              <li class="nav-item"><a href="main.php" class="nav-link">トップページ</a></li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <section class="form login">
      <header>
        Match Up ログインフォーム
      </header>
      <form action="login.php" method="post">
        <?php if (isset($err)):?>
        <div class="error-txt login-err">
          <?php if (count($err) > 0):?>
          <?php foreach($err as $e):?>
          <p><?php echo $e?></p>
          <?php endforeach ?>
          <?php endif ?>
        </div>
          <?php endif ?>
          <div class="field input login-input">
            <label>メールアドレス</label>
            <input type="text" name="mail" placeholder="メールアドレスを入力してください" value="<?php if (isset($_SESSION['mail']) && isset($_POST['login'])) { echo h($_SESSION['mail']);}?>">
          </div>
          <div class="field input login-input">
            <label>パスワード</label>
            <input type="text" name="password" placeholder="パスワードを入力してください">
            <i class="fas fa-eye"></i>
          </div>
          <div class="field button">
            <input type="submit" name="login" value="ログイン">
          </div>
          <div class="link"><a href="signup_form.php">新規アカウント作成はこちら</a></div>
          <div class="link"><a href="reset.php">パスワードをお忘れですか？</a></div>
      </form>
    </section>
    <?php require_once('footer.php')?>
  </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
</body>
</html>