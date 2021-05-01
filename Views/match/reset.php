<?php session_start();?>
<?php 
  // HPMailer のクラスをグローバル名前空間（global namespace）にインポート
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
if(isset($_POST["reset-request-submit"])) {
  require_once(ROOT_PATH . 'Controllers/matchController.php');
// エラーメッセージ
$err = [];
// バリデーション
// メールアドレスのエラー判定
if (!$mail = filter_input(INPUT_POST, 'mail')) {
  $err['mail'] = 'メールアドレスを記入してください。';
}

if (count($err) === 0) {
  require_once(ROOT_PATH . 'Controllers/matchController.php');
  
  $selector = bin2hex(random_bytes(8));
  $token = random_bytes(32);
  $url = "http://localhost:8888/match/send.php?selector=" . $selector . "&validator=" . bin2hex($token);
  $expires = date("U") + 1800;
  $userEmail = $_POST['mail'];
  $hashedToken = password_hash($token, PASSWORD_DEFAULT);
  
  $game = new Game();
  $game->pwd_delete($userEmail);
  $game->pwd_insert($userEmail, $selector, $hashedToken, $expires);


  // PHPMailer のソースファイルの読み込み（ファイルの位置によりパスを適宜変更）
require('PHPMailer/src/Exception.php');
require('PHPMailer/src/PHPMailer.php');
require('PHPMailer/src/SMTP.php');

mb_language("Japanese");
mb_internal_encoding("UTF-8");
// インスタンスを生成（引数に true を指定して例外 Exception を有効に）
$mail = new PHPMailer(true);
//日本語用設定
$mail->CharSet = "UTF-8";
$mail->Encoding = "7bit";
try {
//サーバの設定
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;  // デバグの出力を有効に（テスト環境での検証用）
$mail->isSMTP();   // SMTP を使用
$mail->Host       = "smtp.gmail.com";  // Gmail SMTP サーバーを指定
$mail->SMTPAuth   = true;   // SMTP authentication を有効に
$mail->Username   = 'dai.makabe12571257@gmail.com';  // Gmail ユーザ名
$mail->Password   = 'Kyhd1018569';  // Gmail パスワード
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // 暗号化（TLS)を有効に
$mail->Port = 587;  // ポートは 587
//受信者設定
//差出人アドレス, 差出人名
$mail->setFrom('dai.makabe12571257@gmail.com', mb_encode_mimeheader("MatchUp"));
// 受信者アドレス, 受信者名
$mail->addAddress($userEmail);
//Cc 受信者の指定
//$mail->addCC('@');

//コンテンツ設定
$mail->isHTML(true);   // HTML形式を指定
//メール表題（タイトル）
$mail->Subject = mb_encode_mimeheader("件名：パスワード再設定について");
//本文（HTML用）
$mail->Body  = '<p>パスワード再設定のリクエストを受け取りました。下記のリンクでパスワード再設定ができます。このメールに見覚えがない場合には、お手数ですがメールを破棄してください</p>';
$mail->Body .=  '<p>パスワード再設定リンク:</br>';
$mail->Body .=  '<a href="' . $url . '">' . $url . '</a></p>';
// mb_convert_encoding(



$mail->send();  //送信
header("Location: reset.php?reset=success");
} catch (Exception $e) {
echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
        パスワード再設定メール送信
      </header>
      <form action="reset.php" method="post">
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
            <label>メールアドレス</label>
            <input type="text" name="mail" placeholder="メールアドレスを入力してください">
          </div>
          <div class="field button">
            <input type="submit" name="reset-request-submit" value="送信">
          </div>
          <div class="link"><a href="login.php">ログイン画面へ</a></div>
      </form>
      <?php 
        if (isset($_GET['reset'])) {
          if ($_GET['reset'] == "success") {
            echo '<p class="signupsuccess">メールが正しく送信されました。メールを確認してください</p>';
          }else if ($_GET['reset'] == "reset") {
            echo '<p class="signupsuccess">パスワード再設定成功しました。新しいパスワードでログインしてください</p>';
        }
      }
      ?>
    </section>
    <?php require_once('footer.php')?>
  </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
</body>
</html>