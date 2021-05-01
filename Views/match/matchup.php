<?php session_start();?>
<?php 
require_once(ROOT_PATH . 'Controllers/matchController.php');
$game = new matchController();
$params = $game->show_users();
// var_dump($params);
if (isset($_POST["text"])) {
  $params_search = $game->show_users_from_search();
  echo $_POST["text"]; 
    // var_dump($params_search); 
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
      <section class="users ">
      <?php require_once('header.php')?>
        <div id="search-all" class="col-xs-3 col-md-8 col-lg-8">
          <form name="set_text" action="matchup.php" method="post">
          <div class="search">
            <span class="text">チーム検索</span>
            <input name="text" type="text" placeholder="チーム名か場所を入力">
            <button type="submit"><i class="fas fa-search"></i></button>
          </div>
        </form>
        </div>
        <div class="tab-all col-xs-3 col-md-8 col-lg-8" >
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#friends" class="nav-link active" data-toggle="tab">チーム検索</a>
            </li>
          </ul>
        </div>
        <div class="page-title">
          <h1>対戦受付中チーム一覧</h1>
        </div>
        <div id="list-all" class="col-xs-3 col-md-8 col-lg-8">
            <div class="users-list tab-content">
            <?php if(isset($_POST['text'])):?>
              <div  id="friends" class="content tab-pane active">
                  <?php foreach( $params_search['users'] as $search_user):?>
              <a href="#">
                  <img src="/<?php echo "{$search_user['image']}"; ?>" alt="">
                  <div class="details">
                    <span><?=h($search_user['team_name']) ?></span>
                    <span><?=h($search_user['user_name']) ?></span>
                    <span><?=h($search_user['region']) ?></span>
                  </div>
                  <div class="friend-btn">
                  <form name="profile" action="friend.php" method="POST">
                      <input type="submit" value="プロフィール"  class="btn btn-primary btn-sm"></input>
                      <input name="friend_profile" type="hidden" value="<?=$search_user['id'] ?>" class="btn btn-primary btn-sm"></input>
                    </form>
                    
                  </div>
                </a>
                  <?php endforeach; ?>
              </div>
              <?php endif; ?>
            <?php if(!isset($_POST['text'])):?>
              <div  id="friends" class="content tab-pane active">
                  <?php foreach($params['users'] as $user):?>
              <a href="#">
                  <img src="/<?php echo "{$user['image']}"; ?>" alt="">
                  <div class="details">
                    <span><?=h($user['team_name']) ?></span>
                    <span><?=h($user['user_name']) ?></span>
                    <span><?=h($user['region']) ?></span>
                  </div>
                  <div class="friend-btn">
                  <form name="profile" action="friend.php" method="POST">
                      <input type="submit" value="プロフィール"  class="btn btn-primary btn-sm"></input>
                      <input name="friend_profile" type="hidden" value="<?=$user['id'] ?>" class="btn btn-primary btn-sm"></input>
                    </form>
                    
                  </div>
                </a>
                  <?php endforeach; ?>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <!-- <div class="nav-paging">
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#">前へ</a></li>
                <li class="page-item " aria-current="page"><a class="page-link" href="#">1</a></li>
                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">次へ</a></li>
              </ul>
            </nav>
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