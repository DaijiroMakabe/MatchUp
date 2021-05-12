<?php
require_once(ROOT_PATH . '/Models/Db.php');

class Schedule extends Db {
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }
// // スケジュール入力データをテーブルに挿入する
// // @param string 
// // @return Array 
public function create_schedule() {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = "INSERT INTO schedule (date, my_user_id, enemy_user_id, start_time, end_time) VALUES (:date, :my_user_id, :enemy_user_id, :start_time, :end_time)"; 
    $sth = $this->dbh->prepare($sql); 
    $params = array(':date'=>$_POST["date"],':my_user_id'=>$_SESSION["login_user"]['id'], ':enemy_user_id'=>$_POST['set_schedule'], ':start_time'=>$_POST['start_time'], ':end_time'=>$_POST['end_time']); // 挿入する値を配列に格納する
  $result = $sth->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
  $this->dbh->commit();
} catch (PDOException $e) {
  $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
  exit('データベースに接続できませんでした。' . $e->getMessage());
}
  return $result;
  }
// // ログインユーザーのスケジュール表示する
// // @param string 
// // @return Array 
public function find_my_schedule($page = 0):Array {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = 'SELECT unique_id, date, team_name, start_time, end_time, enemy_user_id FROM schedule JOIN users ON users.id = schedule.enemy_user_id WHERE my_user_id = :id ORDER BY date';
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
// // 友達チームのスケジュール表示する
// // @param string 
// // @return Array 
public function find_frined_schedule($page = 0):Array {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = 'SELECT date, team_name, start_time, end_time FROM schedule JOIN users ON users.id = schedule.my_user_id WHERE my_user_id = :id AND enemy_user_id = :enemy_user_id';
  $sth = $this->dbh->prepare($sql);
  $sth->bindParam(':id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
  $sth->bindParam(':enemy_user_id',$_SESSION['friend'], PDO::PARAM_INT);
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
// ここから結果登録
// // 結果入力データをテーブルに挿入する
// // @param string 
// // @return Array 
public function create_result() {
  $sql = "INSERT INTO result (date, my_user_id, enemy_user_id, my_goals, enemy_goals, result) VALUES (:date, :my_user_id, :enemy_user_id, :my_goals, :enemy_goals, :result)"; 
  $sth = $this->dbh->prepare($sql); 
  $params = array(':date'=>$_POST["date"],':my_user_id'=>$_SESSION["login_user"]['id'], ':enemy_user_id'=>$_SESSION['enemy_id'], ':my_goals'=>$_POST['get_point'], ':enemy_goals'=>$_POST['lose_point'], ':result'=>$_POST['result']); // 挿入する値を配列に格納する
  $create = $sth->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
  if ($create) {
  $sql = "DELETE FROM schedule WHERE unique_id = :unique_id";
  $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
  $sth->bindParam(':unique_id',$_SESSION['unique_id'], PDO::PARAM_INT);
  $result = $sth->execute();
  return $result;
  };
  }
// // ログインユーザーの結果表示する
// // @param string 
// // @return Array 
public function find_my_result($page = 0):Array {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = 'SELECT date, team_name, my_goals, enemy_goals, result FROM result JOIN users ON users.id = result.enemy_user_id WHERE my_user_id = :id ORDER BY date';
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
// // 友達ユーザーの結果表示する
// // @param string 
// // @return Array 
public function find_friend_result($page = 0):Array {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = 'SELECT date, team_name, my_goals, enemy_goals, result FROM result JOIN users ON users.id = result.enemy_user_id WHERE my_user_id = :enemy_user_id ORDER BY date';
  $sth = $this->dbh->prepare($sql);
  $sth->bindParam(':enemy_user_id',$_SESSION['friend'], PDO::PARAM_INT);
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