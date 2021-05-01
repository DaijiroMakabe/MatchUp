<?php session_start();?>
<?php 
if(is_null($_SESSION["login_user"]['id'])) {
  header('Location: login.php');
}
?>
<?php 
require_once(ROOT_PATH . 'Controllers/matchController.php');
$game = new matchController();
$params_baseball = $game->show_baseball_users();
$params_soccer = $game->show_soccer_users();
$params_basketball = $game->show_basketball_users();

if (isset($_POST['friend_profile'])) {
  $_SESSION['friend_profile'] = $_POST['friend_profile'];
  echo $_SESSION['friend_profile'];
}
if (isset($_POST['add_friend'])) {
  $game->make_friend();
  echo $_POST['add_friend'];
  $_SESSION['add_friend'] = $_POST['add_friend'];
  // header('Location: main.php');
}

if (isset($_POST["text"])) {
  // if ($_POST['search'] != "") {
    
    $params_soccer_search = $game->show_soccer_from_search();
    $params_baseball_search = $game->show_baseball_from_search();
    $params_basketball_search = $game->show_basketball_from_search();
    // echo $_POST["text"]; 
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
  <!-- <script src="/js/jquery-3.5.1.min"></script> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
  <div class="container-fluid" >
    <div class="row">
      <section class="users ">
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
        <div id="search-all" class="col-xs-3 col-md-8 col-lg-8">
        <form name="set_text" action="main.php" method="post">
          <div class="search">
            <span class="text">チーム検索</span>
            <input name="text" type="text" placeholder="チーム名か場所を入力">
            <button name="search" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </div>
        </form>
        <div class="tab-all col-xs-3 col-md-8 col-lg-8" >
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#soccer" class="nav-link active" data-toggle="tab">サッカー</a>
            </li>
            <li class="nav-item">
              <a href="#baseball" class="nav-link" data-toggle="tab">野球</a>
            </li>
            <li class="nav-item">
              <a href="#basketball" class="nav-link" data-toggle="tab">バスケットボール</a>
            </li>
          </ul>
        </div>
        
        <div id="list-all" class="col-xs-3 col-md-8 col-lg-8">
            <div class="users-list tab-content">
            <?php if(isset($_POST['text'])):?>
              <div  id="soccer" class="content tab-pane active">
              <?php foreach($params_soccer_search['users'] as $search_user):?>
              <a href="#">
                  <img src="/<?= "{$search_user['image']}"; ?>" alt="">
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
              <div  id="soccer" class="content tab-pane active">
              <?php foreach($params_soccer['users'] as $soccer_user):?>
              <a href="#">
                  <img src="/<?= "{$soccer_user['image']}"; ?>" alt="">
                  <div class="details">
                    <span><?=h($soccer_user['team_name']) ?></span>
                    <span><?=h($soccer_user['user_name']) ?></span>
                    <span><?=h($soccer_user['region']) ?></span>
                  </div>
                  <div class="friend-btn">
                    <form name="profile" action="friend.php" method="POST">
                      <input type="submit" value="プロフィール"  class="btn btn-primary btn-sm"></input>
                      <input name="friend_profile" type="hidden" value="<?=$soccer_user['id'] ?>" class="btn btn-primary btn-sm"></input>
                    </form>
                  </div>
                </a>
                <?php endforeach; ?>
              </div>
              <?php endif; ?>
              <?php if(isset($_POST['text'])):?>
              <div  id="baseball" class="content tab-pane">
              <?php foreach($params_baseball_search['users'] as $search_user):?>
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
              <div  id="baseball" class="content tab-pane">
              <?php foreach($params_baseball['users'] as $baseball_user):?>
              <a href="#">
                  <img src="/<?php echo "{$baseball_user['image']}"; ?>" alt="">
                  <div class="details">
                    <span><?=h($baseball_user['team_name']) ?></span>
                    <span><?=h($baseball_user['user_name']) ?></span>
                    <span><?=h($baseball_user['region']) ?></span>
                  </div>
                  <div class="friend-btn">
                  <form name="profile" action="friend.php" method="POST">
                      <input type="submit" value="プロフィール"  class="btn btn-primary btn-sm"></input>
                      <input name="friend_profile" type="hidden" value="<?=$baseball_user['id'] ?>" class="btn btn-primary btn-sm"></input>
                    </form>
                  </div>
                </a>
                <?php endforeach; ?>
              </div>
              <?php endif; ?>
              <?php if(isset($_POST['text'])):?>
              <div  id="basketball" class="content tab-pane">
              <?php foreach($params_basketball_search['users'] as $search_user):?>
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
              <div  id="basketball" class="content tab-pane">
              <?php foreach($params_basketball['users'] as $basketball_user):?>
              <a href="#">
                  <img src="/<?php echo "{$basketball_user['image']}"; ?>" alt="">
                  <div class="details">
                    <span><?=h($basketball_user['team_name']) ?></span>
                    <span><?=h($basketball_user['user_name']) ?></span>
                    <span><?=h($basketball_user['region']) ?></span>
                  </div>
                  <div class="friend-btn">
                  <form name="profile" action="friend.php" method="POST">
                      <input type="submit" value="プロフィール"  class="btn btn-primary btn-sm"></input>
                      <input name="friend_profile" type="hidden" value="<?=$basketball_user['id'] ?>" class="btn btn-primary btn-sm"></input>
                    </form>           
                  </div>
                </a>
                <?php endforeach; ?>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="nav-paging">
            <!-- <nav aria-label="Page navigation">
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