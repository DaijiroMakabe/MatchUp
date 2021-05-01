<?php session_start();?>
<?php 

require_once(ROOT_PATH . 'Controllers/matchController.php');
    $chat = new Chat();
    $params_msg = $chat->send_message();

?>