<?php session_start();?>
<?php 
 
if(isset($_POST['enemy_id'])) {
  $_SESSION['enemy_id'] = $_POST['enemy_id'];
  $_SESSION['unique_id'] = $_POST['unique_id'];
  // echo $_SESSION['enemy_id'];
  // echo $_SESSION['unique_id'];
}
if(isset($_POST['set_date'])) {
  $_SESSION['set_date'] = $_POST['set_date'];
  
}
if(isset($_POST["submit"])) {
// エラーメッセージ
$err = [];
// バリデーション
// チームネームのエラー判定
if (is_null($_POST["date"]) || $_POST["date"] === "" ) {
  $err[] = "＊日付は必須入力です。";
} 
if (is_null($_POST["get_point"]) || $_POST["get_point"] === "" || !ctype_digit($_POST["get_point"])) {
  $err[] = "＊得点は必須入力です。";
} 
if (is_null($_POST["lose_point"]) || $_POST["lose_point"] === "" || !ctype_digit($_POST["lose_point"])) {
  $err[] = "＊失点は必須入力です。";
} 
if (is_null($_POST["result"]) || $_POST["result"] === "" ) {
  $err[] = "＊勝敗は必須入力です。";
} 
  if (count($err) === 0) {
    require_once(ROOT_PATH . 'Controllers/matchController.php');
    $schedule = new Schedule();
    $schedule->create_result();
    header('Location: set_result.php');
  }
}

// var_dump($_SESSION["login_user"]['id']);
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
  <div class="wrapper">
  <?php require_once('header.php')?>
    <section class="form signup">
      <header>
        結果入力フォーム
      </header>
      <form action="result.php" method="post">
      <?php if (isset($err)):?>
        <div class="error-txt">
          <?php if (count($err) > 0):?>
          <?php foreach($err as $e):?>
          <p><?php echo $e?></p>
          <?php endforeach ?>
          <?php endif ?>
        </div>
          <?php endif ?>
          <div class="field input">
            <label>日付</label> 
            <input name="date" type="date" value="<?=$_SESSION['set_date'] ?>"/>
          </div>
          <div class="field input">
            <label>得点</label>
            <input name="get_point" type="text" placeholder="得点数を入力してください">
          </div>
          <div class="field input">
            <label>失点</label>
            <input name="lose_point" type="text" placeholder="失点数を入力してください">
          </div>
          <div class="field input">
            <label>勝敗</label>
            <select name="result" class="select-box">
              <option value="">結果を選択</option>
              <option value="勝利">勝利</option>
              <option value="敗北">敗北</option>
              <option value="引き分け">引き分け</option>
            </select>
          </div>
          <div class="field button">
            <input type="submit" name="submit" value="結果登録">
            <input type="hidden" name="set_result" value="<?= $_SESSION['friend']?>">
          </div>
      </form>
    </section>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
</body>
</html>