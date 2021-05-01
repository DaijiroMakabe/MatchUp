<?php session_start();?>
<?php 
// echo $_SESSION["login_user"]['id'];
if(is_null($_SESSION["login_user"]['id'])) {
  header('Location: login.php');
}
require_once(ROOT_PATH . 'Controllers/matchController.php');
$game = new matchController();
$params_login_user = $game->show_login_user();
// var_dump($params_login_user);
if (isset($_POST['active'])) {
  $active = new Game();
  $active->active();
  header('Location: mypage.php');
}
if (isset($_POST['inactive'])) {
  $inactive = new Game();
  $inactive->inactive();
  header('Location: mypage.php');
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
  <!-- <script src="/js/jquery-3.5.1.min"></script> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
  <div class="container-fluid" >
    <div class="row">
      <section class="users">
        <?php require_once('header.php')?>
        <div id="profile" class="col-xs-3 col-md-8 col-lg-8">
        <header>
        <?php foreach($params_login_user['users'] as $login_user):?>
        
          <div class="profile-img">
            <img src="/<?php echo "{$login_user['image']}"; ?>" alt="プロフィール画像" width="120" height="120">
            <h1><?=$login_user['team_name'] ?></h1>
          </div>
          <div class="main-profile">
                  <span>種目    ：<?=h($login_user['category']) ?><br></span>  
                  <span>監督    ：<?=h($login_user['user_name']) ?><br></span> 
                  <span>年代    ：<?=h($login_user['age']) ?><br></span>
                  <span>エリア  ：<?=h($login_user['region']) ?><br></span>  
                  <a  href="edit.php">編集</a>
                  <a id="delete" href="delete.php?id=<?=$login_user['id'] ?>">退会</a>
          </div> 
          <div class="switch">
            <form id="btn" action="mypage.php" method="post">
            <?php if ($login_user['match_up_flg'] == 0):?>
            <button id="active-btn" name="active" type="submit" value="<?=$login_user['id'] ?>" class="btn btn-danger btn-lg active btn-sm">対戦募集する</button>
            <?php endif; ?>
            <?php if ($login_user['match_up_flg'] == 1):?>
            <button  id="inactive-btn" name="inactive" type="submit" value="<?=$login_user['id'] ?>" class="btn btn-secondary btn-lg active btn-sm">対戦募集しない</button>
            <?php endif; ?>
            </form>
          </div>
          
          <?php endforeach; ?>
        </header> 
        </section>
        <section class="profile-body">
          <div class="container">
            <div class="row">
              <div class="col-lg-4">
                <div class="card">
                  <img class="card-img-top" src="/img/vs.png" alt="イメージ画像">
                  <div class="card-body">
                    <h4 class="card-title">Match Up</h4>
                    <p class="card-text">対戦募集中のチームを探して友達を作ろう。
                    </p>
                    <a href="matchup.php" class="btn btn-primary">一覧へ</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card">
                  <img class="card-img-top" src="/img/friends.jpg" alt="イメージ画像">
                  <div class="card-body">
                    <h4 class="card-title">友達チーム一覧</h4>
                    <p class="card-text">友達を選んでチャットや対戦申し込みをしよう。
                    </p>
                    <a href="friends.php" class="btn btn-primary">一覧へ</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card card-height">
                  <img class="card-img-top" src="/img/field.jpg" alt="イメージ画像" height="348px">
                  <div class="card-body">
                    <h4 class="card-title">試合成績</h4>
                    <p class="card-text">今までの登録された試合の記録をみよう。試合結果からチームを分析しよう。</p>
                    <a href="history.php" class="btn btn-primary">試合履歴へ</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 schedule-link">
                <div class="card">
                  <img class="card-img-top" src="/img/schedule.jpg" alt="イメージ画像">
                  <div class="card-body">
                    <h4 class="card-title">試合スケジュール</h4>
                    <p class="card-text">登録された試合予定を確認しよう。</p>
                    <a href="schedule.php" class="btn btn-primary">スケジュールを見る</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <?php require_once('footer.php')?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
</body>
</html>