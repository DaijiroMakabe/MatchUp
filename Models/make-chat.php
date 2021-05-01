<?php 
require_once(ROOT_PATH . '/Models/Db.php');

class Chat extends Db {
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }
// // メッセージ入力データをテーブルに挿入する
// // @param string 
// // @return Array 
public function send_message() {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) VALUES (:incoming_msg_id, :outgoing_msg_id, :msg)"; 
    $sth = $this->dbh->prepare($sql); 
    $params = array(':incoming_msg_id'=>$_SESSION["friend"],':outgoing_msg_id'=>$_SESSION["login_user"]['id'], ':msg'=>$_POST["message"]); // 挿入する値を配列に格納する
  $result = $sth->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
  $this->dbh->commit();
} catch (PDOException $e) {
  $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
  exit('データベースに接続できませんでした。' . $e->getMessage());
}
  return $result;
  }
// // マイchatデータを表示する
// // @param string 
// // @return Array 
public function find_my_chat() {
  try {
    $this->dbh->beginTransaction(); // トランザクションの開始
    $sql = 'SELECT * FROM messages LEFT JOIN users ON users.id = messages.outgoing_msg_id WHERE (outgoing_msg_id = :outgoing_msg_id AND incoming_msg_id = :incoming_msg_id)  OR (incoming_msg_id = :outgoing_id AND outgoing_msg_id = :incoming_id) ORDER BY msg_id';
    // SQL実行
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':outgoing_msg_id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
    $sth->bindParam(':incoming_msg_id',$_SESSION["friend"], PDO::PARAM_INT);
    $sth->bindParam(':outgoing_id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
    $sth->bindParam(':incoming_id',$_SESSION["friend"], PDO::PARAM_INT);
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