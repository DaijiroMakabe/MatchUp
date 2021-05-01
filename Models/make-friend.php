<?php
require_once(ROOT_PATH . '/Models/Db.php');

class Friend extends Db {
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }
  // 友達申請でステータスを更新
  public function add_friend() {
    
    $sql = 'SELECT * FROM friends WHERE friend_id = :friend_id AND my_user_id = :my_user_id';
    $sth = $this->dbh->prepare($sql); 
    $sth->bindParam(':friend_id',$_POST['add_friend'], PDO::PARAM_INT);
    $sth->bindParam(':my_user_id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
    $sth->execute();
    $data = $sth->fetchall(PDO::FETCH_ASSOC);
    if (!$data) {
    $sql = "INSERT INTO friends (my_user_id, friend_id, friendship_status) VALUES (:my_user_id, :friend_id, :friendship_status)"; // INSERT文を変数に格納。
    $sth = $this->dbh->prepare($sql); 
      $params = array(':my_user_id'=>$_SESSION["login_user"]['id'], ':friend_id'=>$_POST['add_friend'], ':friendship_status'=>1); 
    $result = $sth->execute($params); 
    return $result;
  } 
  
    }
// // テーブルから承認待ちチームのデータを全て表示する
// // @param string 
// // @return Array 
public function find_wait_isadded($page = 0):Array {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = 'SELECT DISTINCT * FROM friends JOIN users ON users.id = friends.my_user_id WHERE friend_id = :id AND friendship_status = 1';
  $sth = $this->dbh->prepare($sql);
  $sth->bindParam(':id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
  // SQL結果を受け取る
  $sth->execute();
  $result = $sth->fetchall(PDO::FETCH_ASSOC);
  $this->dbh->commit();
} catch (PDOException $e) {
  $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
  exit('データベースに接続できませんでした。' . $e->getMessage());
}
    return $result;
}
// // 友達承認ボタンでステータスを友達（２）に更新する
// // @param string 
// // @return Array 
public function accept_friend() {
   
    $sql = 'SELECT * FROM friends WHERE my_user_id = :my_user_id AND friend_id = :friend_id';
    $sth = $this->dbh->prepare($sql); 
    $sth->bindParam(':my_user_id',$_SESSION["login_user"]['id'] , PDO::PARAM_INT);
    $sth->bindParam(':friend_id', $_POST['accept_friend'], PDO::PARAM_INT);
    $sth->execute();
    $data = $sth->fetchall(PDO::FETCH_ASSOC);
  if (!$data) {
    $sql = "INSERT INTO friends (my_user_id, friend_id, friendship_status) VALUES (:my_user_id, :friend_id, :friendship_status)"; // INSERT文を変数に格納。
    $sth = $this->dbh->prepare($sql); 
      $params = array(':my_user_id'=>$_SESSION["login_user"]['id'], ':friend_id'=>$_POST['accept_friend'], ':friendship_status'=>2); 
    $insert = $sth->execute($params); 
  
    $sql = "UPDATE friends SET friendship_status = 2 WHERE my_user_id = :id AND friend_id = :friend_id";
    $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
    $sth->bindParam(':id', $_POST['accept_friend'], PDO::PARAM_INT);
    $sth->bindParam(':friend_id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
    $result = $sth->execute();
    return $result;
  } 
  else if ($data) {
    $sql = "UPDATE friends SET friendship_status = 2 WHERE my_user_id = :id AND friend_id = :friend_id";
    $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
    $sth->bindParam(':id', $_POST['accept_friend'], PDO::PARAM_INT);
    $sth->bindParam(':friend_id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
    $result = $sth->execute();
    return $result;
  }
}
// // 友達削除ボタンでrowを削除する
// // @param string 
// // @return Array 
public function delete_friend() {
  
  $sql = "DELETE FROM friends WHERE my_user_id = :id AND friend_id = :friend_id";
  $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
  $sth->bindParam(':id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
  $sth->bindParam(':friend_id',$_POST["delete_friend"], PDO::PARAM_INT);
  $delete = $sth->execute();
  $sql = "DELETE FROM friends WHERE friend_id = :id AND my_user_id = :friend_id";
  $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
  $sth->bindParam(':id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
  $sth->bindParam(':friend_id',$_POST["delete_friend"], PDO::PARAM_INT);
  $result = $sth->execute();
  return $result;
  return $delete;

}
// // テーブルからマイ友達データを表示する
// // @param string 
// // @return Array 
public function find_myfriend($page = 0):Array {
  try {
    $this->dbh->beginTransaction(); // トランザクションの開始
    $sql = 'SELECT DISTINCT * FROM friends JOIN users ON users.id = friends.friend_id WHERE friends.my_user_id = :id AND friendship_status = 2';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
    // SQL結果を受け取る
    $sth->execute();
    $result = $sth->fetchall(PDO::FETCH_ASSOC);
    $this->dbh->commit();
  } catch (PDOException $e) {
    $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
    exit('データベースに接続できませんでした。' . $e->getMessage());
  }
      return $result;
}
// // 検索からマイ友達データを表示する
// // @param string 
// // @return Array 
public function find_myfriend_from_search($page = 0):Array {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = 'SELECT * FROM friends JOIN users ON users.id = friends.friend_id WHERE (friends.my_user_id = :id AND friendship_status = 2) AND (team_name LIKE :team_name OR region LIKE :region)';
  $sth = $this->dbh->prepare($sql);
  $sth->bindParam(':id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
  $sth->bindParam(':team_name',$_POST["text"]);
  $sth->bindParam(':region',$_POST["text"], PDO::PARAM_INT);
  // SQL結果を受け取る
  $sth->execute();
  $result = $sth->fetchall(PDO::FETCH_ASSOC);
  $this->dbh->commit();
  } catch (PDOException $e) {
    $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
    exit('データベースに接続できませんでした。' . $e->getMessage());
  }
    return $result;
}
}
  ?>