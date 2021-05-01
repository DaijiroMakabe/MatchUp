<?php session_start();?>
<?php 
require_once(ROOT_PATH . 'Controllers/matchController.php');
$game = new matchController();
$output = "";

$params_my_chat = $game->show_my_chat();
foreach($params_my_chat['users'] as $my_chat) {
  if ($my_chat['outgoing_msg_id'] === $_SESSION["login_user"]['id']) {
    $output .= ' <div class="chat outgoing">
                      <div class="details">
                        <p>'. $my_chat['msg'].'</p>
                      </div>
                    </div>';
  } else {
    $output .= ' <div class="chat incoming">
                            <img src="/'.$my_chat['image'].'" alt="">
                            <div class="details">
                              <p>'. $my_chat['msg'].'</p>
                            </div>
                          </div>';
  }
  }
  echo $output;
 



?>