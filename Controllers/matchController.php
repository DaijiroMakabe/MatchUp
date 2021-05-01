<?php 
require_once(ROOT_PATH . '/Models/game.php');
require_once(ROOT_PATH . '/Models/make-friend.php');
require_once(ROOT_PATH . '/Models/make-schedule.php');
require_once(ROOT_PATH . '/Models/make-chat.php');


class MatchController {
private $Db;
private $Game;
private $Friend;
private $Schedule;
private $Chat;


public function __construct() {
// リクエストパラメータの取得
$this->request['get'] = $_GET;
$this->request['post'] = $_POST;
// モデルオブジェクトの作成
$this->Db = new Db();
$this->Game = new Game();
$dbh = $this->Game->get_db_handler();
    $this->Friend = new Friend($dbh);
    $this->Schedule = new Schedule($dbh);
    $this->Chat = new Chat($dbh);
}
// ユーザーデータをデータベースへ保存する
public function user_data($save_path) {
  $users = $this->Game->create_user($save_path);
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// 編集したユーザーデータをデータベースへ保存する
public function edit_user_data($save_path) {
  $users = $this->Game->edit($save_path);
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// ログインユーザーのデータを全て表示
public function show_login_user() {
  $page = 0;
  $users = $this->Game->find_login_user($page);
  $user_count = $this->Game->countAll();
  $params = [
    'users' => $users, 
    'pages' => $user_count / 20
  ];
  return $params;
}
// ログインユーザー以外の同じカテゴリーのチームを表示
public function show_users() {
  $page = 0;
  $users = $this->Game->find_users($page);
  $user_count = $this->Game->countAll();
  $params = [
    'users' => $users, 
    'pages' => $user_count / 20
  ];
  return $params;
}
// 全ての野球カテゴリーのチームを表示
public function show_baseball_users() {
  $page = 0;
  $users = $this->Game->find_baseball_users($page);
  $user_count = $this->Game->countAll();
  $params = [
    'users' => $users, 
    'pages' => $user_count / 20
  ];
  return $params;
}
// 全てのサッカーカテゴリーのチームを表示
public function show_soccer_users() {
  $page = 0;
  $users = $this->Game->find_soccer_users($page);
  $user_count = $this->Game->countAll();
  $params = [
    'users' => $users, 
    'pages' => $user_count / 20
  ];
  return $params;
}
// 全てのバスケットボールカテゴリーのチームを表示
public function show_basketball_users() {
  $page = 0;
  $users = $this->Game->find_basketball_users($page);
  $user_count = $this->Game->countAll();
  $params = [
    'users' => $users, 
    'pages' => $user_count / 20
  ];
  return $params;
}
// 友達チームを表示
public function show_friend() {
  $page = 0;
  $users = $this->Game->find_friend($page);
  $user_count = $this->Game->countAll();
  $params = [
    'users' => $users, 
    'pages' => $user_count / 20
  ];
  return $params;
}
// 友達チームを表示
public function show_friendbtn() {
  $page = 0;
  $users = $this->Game->find_friendbtn();
  // $user_count = $this->Game->countAll();
  $params = [
    'users' => $users, 
    // 'pages' => $user_count / 20
  ];
  return $params;
}
// 友達チームを表示(チャット)
public function show_chat_friend() {
  $page = 0;
  $users = $this->Game->find_chat_friend($page);
  $user_count = $this->Game->countAll();
  $params = [
    'users' => $users, 
    'pages' => $user_count / 20
  ];
  return $params;
}
// 検索結果(対戦募集中)を表示する
public function show_users_from_search() {
  $users = $this->Game->find_users_from_search();
  $params = [
    'users' => $users, 
  ];
  return $params;
}

// ここからFriendテーブル
// ユーザーデータをデータベースへ保存する
public function make_friend() {
  $users = $this->Friend->add_friend();
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// ユーザーデータをデータベースへ保存する
public function show_wait_isadded() {
  $users = $this->Friend->find_wait_isadded();
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// ユーザーデータをデータベースへ保存する
public function show_myfriend() {
  $users = $this->Friend->find_myfriend();
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// 検索結果(サッカー)を表示する
public function show_soccer_from_search() {
  $users = $this->Game->find_soccer_from_search();
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// 検索結果(野球)を表示する
public function show_baseball_from_search() {
  $users = $this->Game->find_baseball_from_search();
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// 検索結果(バスケットボール)を表示する
public function show_basketball_from_search() {
  $users = $this->Game->find_basketball_from_search();
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// 検索結果(友達)を表示する
public function show_myfriend_from_search() {
  $users = $this->Friend->find_myfriend_from_search();
  $params = [
    'users' => $users, 
  ];
  return $params;
}

// ここからスケジュールテーブル
public function show_my_schedule(){
  $users = $this->Schedule->find_my_schedule();
  $params = [
    'users' => $users, 
  ];
  return $params;
}

// ここから対戦成績テーブル
public function show_my_result(){
  $users = $this->Schedule->find_my_result();
  $params = [
    'users' => $users, 
  ];
  return $params;
}
public function show_friend_result(){
  $users = $this->Schedule->find_friend_result();
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// ここからchatテーブル
// マイチャット表示
public function show_my_chat(){
  $users = $this->Chat->find_my_chat();
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// 友達チャット表示
public function show_friend_chat(){
  $users = $this->Chat->find_friend_chat();
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// 最後のチャット表示
public function show_last_chat(){
  $users = $this->Chat->find_last_chat();
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// 最後のチャット表示
public function show_new_pwd($selector){
  $users = $this->Game->find_pwd($selector);
  $params = [
    'users' => $users, 
  ];
  return $params;
}
// 最後のチャット表示
public function show_reset_pwd($tokenEmail, $newPwdHash){
  $users = $this->Game->find_pwd_user($tokenEmail, $newPwdHash);
  $params = [
    'users' => $users, 
  ];
  return $params;
}

 }