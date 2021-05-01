<?php session_start();?>
<?php 
require_once(ROOT_PATH . 'Controllers/matchController.php');
$game = new matchController();
$params_friend = $game->show_chat_friend();

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
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/cfdc634195.js" crossorigin="anonymous"></script>
  <script src="/js/bootstrap.bundle.js"></script>
</head>
<body>
<div class="container-fluid" >
    <div class="row">
    <?php require_once('header.php')?>
    <div class="wrapper chat-background" >
      <section class="chat-area">
        <header>
        <?php foreach($params_friend['users'] as $friend):?>
          
          <img src="/<?php echo "{$friend['image']}"; ?>" alt="">
          <div class="details">
            <p><?=h($friend['team_name']);?></p>
          </div>
          <?php endforeach; ?>
        </header>
        <div class="chat-box" >
         
        </div>
        <form class="typing-area" >
          <input type="text" name="outgoing_id" value="<?=$_SESSION["login_user"]['id']; ?>" hidden>
          <input type="text" name="incoming_id" value="<?=$_SESSION["friend"]; ?>" hidden>
          <input type="text" name="message" class="input-field" placeholder="メッセージを入力">
          <button><i class="fab fa-telegram-plane"></i></button>
        </form>
      </section>
    </div>
      <?php require_once('footer.php')?>
  </div>
</div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="/js/chat.js"></script>
</body>
</html>