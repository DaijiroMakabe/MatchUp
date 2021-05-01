<?php session_start();?>
<?php 
if(is_null($_SESSION["login_user"]['id'])) {
  header('Location: login.php');
}
?>
<?php 
require_once(ROOT_PATH . 'Controllers/matchController.php');
$game = new matchController();
$params_login_user = $game->show_login_user();
if(isset($_POST["submit"])) {
  require_once('validation.php');
  if (count($err) === 0) {
    $params = $game->edit_user_data($save_path);
    header('Location: complete.php');
  }
}
?>
<?php 
// XSS対策
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
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
  <?php require_once('header.php')?>
    <section class="form signup">
      <header>
        プロフィール編集フォーム
      </header>
      <form enctype="multipart/form-data" action="edit.php" method="post">
           <?php if (isset($err)):?>
        <div class="error-txt">
          <?php if (count($err) > 0):?>
          <?php foreach($err as $e):?>
          <p><?php echo $e?></p>
          <?php endforeach ?>
          <?php endif ?>
        </div>
          <?php endif ?>
          <?php foreach($params_login_user['users'] as $login_user):?>
          <div class="field input">
            <label>チームネーム</label>
            <input type="text" name="team_name" value="<?=h($login_user['team_name']) ?>" placeholder="チームネームを入力してください">
          </div>
          <div class="profile-img">
            <div class="field input">
              <label>監督者ネーム</label>
              <input type="text" name="user_name" value="<?=h($login_user['user_name']) ?>" placeholder="監督者氏名を入力してください">
            </div>
            <div class="field input image">
              <label>プロフィール画像</label>
              <input type="hidden" name="MAX_FILE_SIZE" value="1048576">
              <input type="file" name="image" accept="image/*">
          </div>
          </div>
          <div class="field input">
            <label>メールアドレス</label>
            <input type="text" name="mail" value="<?=h($login_user['mail']) ?>" placeholder="メールアドレスを入力してください">
          </div>
          <div class="field input">
            <label>地域</label>
            <input type="text" name="region" value="<?=h($login_user['region']) ?>" placeholder="埼玉県内の市町村を入力してください">
          </div>
          <div class="field input">
            <label>年代</label>
            <select class="select-box" name="age">
            <option value="">年代を選択</option>
            <option value="小学校低学年">小学校低学年</option>
            <option value="小学校中学年">小学校中学年</option>
            <option value="小学校高学年">小学校高学年</option>
            <option value="中学">中学</option>
            <option value="高校">高校</option>
            <option value="大学・社会人">大学・社会人</option>
            </select>
          </div>
          <div class="field input">
            <label>種目</label>
            <select class="select-box" name="category">
            <option value="">種目を選択</option>
            <option value="サッカー">サッカー</option>
            <option value="野球">野球</option>
            <option value="バスケットボール">バスケットボール</option>
            </select>
          </div>
          <div class="field button">
            <input type="submit" name="submit" value="編集">
          </div>
          <?php endforeach ?>
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