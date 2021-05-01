<?php session_start();?>
<?php 
  require_once(ROOT_PATH . 'Controllers/matchController.php');
  $set_result = new matchController();
  $params_result = $set_result->show_my_result();
 
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
        <header>
          <div class="container">
            <nav class="navbar navbar-expand-sm navbar-light">
              <a href="" class="navbar-brand"><img class="logo" src="/img/logo.png" alt="" width="150px" height="100px"></a>
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
        </section>
        <section class="history">
          <div class="container">
            <div class="row">
            <h1>対戦履歴</h1>
           
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
                  <td><?=$show_result['date'];?></td><td><?=$show_result['team_name'];?></td><td><?php echo $show_result['my_goals']; $point_count[] = $show_result['my_goals'];;?>-<?php echo $show_result['enemy_goals']; $lost_count[] = $show_result['enemy_goals'];;?></td><td><?php if ($show_result['my_goals'] > $show_result['enemy_goals']) {echo "勝利"; $win_count[] = "勝利";} else if ($show_result['my_goals'] < $show_result['enemy_goals']) {echo "敗北"; $lose_count[] = "敗北";} else if ($show_result['enemy_goals'] === $show_result['my_goals']) {echo "引き分け"; $draw_count[] = "引き分け";}?></td>
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
</body>
</html>