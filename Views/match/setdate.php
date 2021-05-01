<?php session_start();?>
<?php 
if(is_null($_SESSION["login_user"]['id'])) {
  header('Location: login.php');
}
?>
<?php 
if(isset($_POST["submit"])) {
  require_once(ROOT_PATH . 'Controllers/matchController.php');
// エラーメッセージ
$err = [];
// バリデーション
// チームネームのエラー判定
if (is_null($_POST["date"]) || $_POST["date"] === "" ) {
  $err[] = "＊日付は必須入力です。";
} 
if (is_null($_POST["start_time"]) || $_POST["start_time"] === "" ) {
  $err[] = "＊開始時間は必須入力です。";
} 
if (is_null($_POST["end_time"]) || $_POST["end_time"] === "" ) {
  $err[] = "＊終了時間は必須入力です。";
} 
  if (count($err) === 0) {
    require_once(ROOT_PATH . 'Controllers/matchController.php');
    $schedule = new Schedule();
    $schedule->create_schedule();
    header('Location: set_schedule.php');
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
  <div class="wrapper">
  <?php require_once('header.php')?>
    <section class="form signup">
      <header>
        スケジュール入力フォーム
      </header>
      <form action="setdate.php" method="post">
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
            <input name="date" type="date" />
          </div>
          <div class="field input">
            <label for="scheduled-time">開始時間を入力</label>
            <input type="time" name="start_time" id="scheduled-time">
          </div>
          <div class="field input">
            <label for="scheduled-time">終了時間を入力</label>
            <input type="time" name="end_time" id="scheduled-time">
          </div>
          <div class="field button">
            <input type="submit" name="submit" value="スケジュール登録">
            <input type="hidden" name="set_schedule" value="<?= $_SESSION['friend']?>">
          </div>
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