<?php session_start();?>
<?php 
if (isset($_GET['selector'])) {
  $_SESSION['selector'] = $_GET['selector'];
  $_SESSION['validator'] = $_GET['validator'];
  
}

if (empty($_SESSION['selector']) || empty($_SESSION['validator'])) {
  echo "リクエストに失敗しました";
} 

 

if (isset($_POST['reset-password-submit'])) {
  $selector = $_POST['selector'];
  $validator = $_POST['validator'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];
  
  $err = [];
  if (empty($password) || empty($passwordRepeat)) {
    $err[] = 'パスワードを入力してください';
  } else if ($password != $passwordRepeat) {
    $err[] = 'パスワードが異なっています';
  }
  if (count($err) === 0) {
    require_once(ROOT_PATH . 'Controllers/matchController.php');
    $currentDate = date("U");
    
      $game = new Game();
      $result = $game->find_pwd($selector, $currentDate);
      // var_dump($result);


      foreach($result as $new_pwd) {
        
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin, $new_pwd['pwdResetToken']);
        if ($tokenCheck === false) {
          $err[] = 'もう一度リクエストを送信してください';
          var_dump($new_pwd['pwdResetToken']);
          exit();
        } else if ($tokenCheck === true) {
          $tokenEmail = $new_pwd['pwdResetEmail'];
          var_dump($new_pwd['pwdResetEmail']);
          $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
          $update = $game->find_pwd_user($tokenEmail, $newPwdHash);
          if ($update) {
            header("Location: login.php?reset=reset");
          }
      }
      }

  }
}


?>

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
        パスワード再設定フォーム
      </header>
      <?php if (ctype_xdigit($_SESSION['selector']) !== false && ctype_xdigit($_SESSION['validator'])): ?>
      <form action="send.php" method="post">
      <?php if (isset($err)):?>
        <div class="error-txt">
          <?php if (count($err) > 0):?>
          <?php foreach($err as $e):?>
          <p><?php echo $e?></p>
          <?php endforeach ?>
          <?php endif ?>
        </div>
          <?php endif ?>
          <div class="field input login-input">
            <label>新しいパスワード</label>
            <input type="password" name="pwd" placeholder="パスワードを入力してください">
          </div>
          <div class="field input login-input">
            <label>パスワード確認</label>
            <input type="password" name="pwd-repeat" placeholder="もう一度パスワードを入力してください">
          </div>
          <div class="field button">
            <input type="hidden" name="selector" value="<?php echo  $_SESSION['selector'] ;?>">
            <input type="hidden" name="validator" value="<?php echo $_SESSION['validator'];?>">
            <input type="submit" name="reset-password-submit" value="送信">
          </div>
          <div class="link"><a href="login.php">ログイン画面へ</a></div>
      </form>
      <?php endif;?>
    </section>
    <?php require_once('footer.php')?>
  </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
</body>
</html>