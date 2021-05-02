<?php session_start();?>
<?php 
require_once(ROOT_PATH . 'Controllers/matchController.php');
$game = new matchController();
$params_friend = $game->show_friend();
$params_btn = $game->show_friendbtn();
$params_result = $game->show_friend_result();
$params_myfriend = $game->show_myfriend();

if (isset($_POST['add_friend'])) {
  // var_dump($_POST['add_friend']);
  $game->make_friend();
  $_SESSION['already_app'] = $_POST['add_friend'];
  header('Location: already-app.php');
}
if (isset($_POST['delete_friend'])) {
  $friend = new Friend();
  $friend->delete_friend();
  $_SESSION['already_del'] = $_POST['delete_friend'];
  header('Location: already-del.php');
}
if(isset($_POST['friend_profile'])) {
  $_SESSION['friend'] = $_POST['friend_profile'];
  $params_result = $game->show_friend_result();
  // header('Location: friend.php');
  // echo  $_SESSION['friend'];
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
  <div class="container-fluid" >
    <div class="row">
      <section class="users">
        <header>
          <div class="container">
            <nav class="navbar navbar-expand-sm navbar-light">
              <a href="main.php" class="navbar-brand"><img class="logo" src="/img/logo.png" alt="" width="150px" height="100px"></a>
              <button class="navbar-toggler" data-toggle="collapse" data-target="#menu">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div id="menu" class="collapse navbar-collapse">
                <ul id="header-nav" class="navbar-nav">
                  <li class="nav-item"><a href="mypage.php" class="nav-link">マイページ</a></li>
                  <li class="nav-item"><a href="login.php" class="nav-link">ログイン</a></li>
                  <li class="nav-item"><a href="signup_form.php" class="nav-link">新規登録</a></li>
                </ul>
              </div>
            </nav>
          </div>
        </header>
        <div id="profile" class="col-xs-3 col-md-8 col-lg-8">
        <header>
        <?php foreach($params_friend['users'] as $friend):?>
        
          <div class="profile-img">
            <img src="/<?php echo "{$friend['image']}"; ?>" alt="プロフィール画像" width="120" height="120">
            <h1><?=$friend['team_name'] ?></h1>
          </div>
          <div class="main-profile">
              <span>種目    ：<?=h($friend['category']) ?><br></span>  
              <span>監督    ：<?=h($friend['user_name']) ?><br></span> 
              <span>年代    ：<?=h($friend['age']) ?><br></span>
              <span>エリア  ：<?=h($friend['region']) ?><br></span>        
      </div> 
          <div class="switch">
      <?php if (!empty($_SESSION["login_user"]['id'])):?>
            <form name="add_friend" action="friend.php" method="POST">
              <button id="app_btn" type="submit" value="友達申請"  class="btn btn-primary btn-sm">友達申請</button>
              <input name="add_friend" type="hidden" value="<?=$friend['id'] ?>" class="btn btn-primary btn-sm"></input>
            </form>
            <form name="add-friend" action="friend.php" method="POST">
              <button id="del_btn" type="submit" value="申請削除"  class="btn btn-success btn-sm">友達削除</button>
              <input name="delete_friend" type="hidden" value="<?=$friend['id'] ?>" class="btn btn-primary btn-sm"></input>
            </form>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
         
        </header> 
        </section>
        <div class="friend-btn">
        <?php foreach($params_myfriend['users'] as $myfriend):?>

     
        <?php if ($myfriend['friend_id'] == $_SESSION['friend']):?> 
            <a id="del" href="chat.php?id=<?=$_SESSION['friend'] ?>" class="btn btn-outline-info">チャットを始める</a>
            <a href="setdate.php?id=<?=$_SESSION['friend'] ?>" class="btn btn-outline-warning">新しい試合を登録する</a>
            <?php endif ?>
            <?php endforeach;?>
            
        </div>
        <section class="history">
          <div class="container">
            <div class="row">
            <h1>対戦成績</h1>
              <table class="table">
                <thead>
                  <tr>
                    <th>日付</th><th>チーム</th><th>スコア</th><th>結果</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $win_count = [];?>
                  <?php $lose_count = [];?>
                  <?php $draw_count = [];?>
                  <?php $point_count = [];?>
                  <?php $lost_count = [];?>
                <?php foreach($params_result['users'] as $show_result):?>
                  <tr>
                    <td><?=$show_result['date'];?></td><td><?=$show_result['team_name'];?></td><td><?php echo $show_result['enemy_goals']; $point_count[] = $show_result['enemy_goals'];;?>-<?php echo $show_result['my_goals']; $lost_count[] = $show_result['my_goals'];;?></td><td><?php if ($show_result['enemy_goals'] > $show_result['my_goals']) {echo "勝利"; $win_count[] = "勝利";} else if ($show_result['enemy_goals'] < $show_result['my_goals']) {echo "敗北"; $lose_count[] = "敗北";} else if ($show_result['enemy_goals'] === $show_result['my_goals']) {echo "引き分け"; $draw_count[] = "引き分け";}?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>  
              </table>
              <table class="table">
                <thead>
                  <tr>
                    <th>勝利数</th><th>敗北数</th><th>引き分け数</th><th>総合得点</th><th>総合失点</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?=count($win_count);?></td><td><?=count($lose_count);?></td><td><?=count($draw_count);?></td><td><?=array_sum($point_count);?></td><td><?=array_sum($lost_count);?></td>
                  </tr>
                </tbody>  
              </table>
            </div>
          </div>
          <!-- <div class="more-btn">
            <button type="button" class="btn btn-outline-secondary">More</button>
          </div> -->
        </section>
        <?php require_once('footer.php')?>
    </div>
  </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
</body>
</html>