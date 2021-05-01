<?php 
require_once(ROOT_PATH . '/Models/Db.php');

class Game extends Db {
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }
  // // 入力データをテーブルに挿入する
// // @param string 
// // @return Array 
public function create_user($save_path) {
  try {
    $this->dbh->beginTransaction(); // トランザクションの開始
    $sql = "INSERT INTO users (team_name, user_name, image, mail, password, region, age, category) VALUES (:team_name, :user_name, :image, :mail, :password, :region, :age, :category)"; // INSERT文を変数に格納。
    $sth = $this->dbh->prepare($sql); 
      $params = array(':team_name'=>$_POST['team_name'], ':user_name'=>$_POST['user_name'], ':image'=>$save_path, ':mail'=>$_POST['mail'], ':password'=>password_hash($_POST['password'], PASSWORD_DEFAULT), ':region'=>$_POST['region'], ':age'=>$_POST['age'], ':category'=>$_POST['category']); // 挿入する値を配列に格納する
    $result = $sth->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
    $this->dbh->commit();// 
  } catch (PDOException $e) {
    $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
    exit('データベースに接続できませんでした。' . $e->getMessage());
  }
    return $result;
    }
// // テーブルからuserデータを全て表示する
// // @param string 
// // @return Array 
public function show() {
  // SQLの準備
    $sql = 'SELECT * FROM users';
    // SQL実行
    $sth = $this->dbh->prepare($sql);
    // SQL結果を受け取る
    $sth->execute();
    $result = $sth->fetchall(PDO::FETCH_ASSOC);
      return $result;
}
// ログインでroleを1に更新
public function  role_update() {
  $sql = 'UPDATE users 
  SET role = 1 WHERE id = :id';
  $sth = $this->dbh->prepare($sql);
  $sth->bindParam(':id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
  $sth->execute();
  $result = $sth->fetch(PDO::FETCH_ASSOC);
  return $result;
}
  /**
   * ログイン処理
   * @param string $email
   * @param string $password
   * @return bool $result
   */
// ユーザー登録
public function LOGIN($mail, $password) {
  // 結果
  $result = false; 
  // ユーザをemailから検索して取得
  $user = self::getUserByEmail($mail);
  if (!$user) {
    $_SESSION['msg'] = 'emailが一致しません。';
    return $result;
  }
  if (password_verify($password, $user['password'])) {
    // ログイン成功
    session_regenerate_id(true);
    $_SESSION['login_user'] = $user;
    $result = true;
    return $result;
  }
  $_SESSION['msg'] = 'パスワードが一致しません。';
    return $result;
}
/**
* emailからユーザを取得
* @param string $email
* @return array|bool $user|false
*/
// ユーザー登録
public function getUserByEmail($mail) {
// SQLの準備
  $sql = 'SELECT * FROM users WHERE mail = ?';
  // emailを配列に入れる
  $arr = [];
  $arr[] = $mail;
  try {
    $sth = $this->dbh->prepare($sql);
    $sth->execute($arr);
    $user = $sth->fetch();
    return $user;
  } catch(\Exception $e) {
    return false;
  }
  }
// // テーブルからログインユーザーデータを全て表示する
// // @param string 
// // @return Array 
public function find_login_user($page = 0):Array {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = 'SELECT * FROM users WHERE id = :id';
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
// // テーブルから同じカテゴリーの対戦募集中userデータを全て表示する
// // @param string 
// // @return Array 
public function find_users($page = 0):Array {
    try {
    $this->dbh->beginTransaction(); // トランザクションの開始
    $sql = 'SELECT id, team_name, user_name, image, region  FROM users WHERE id != :id AND category = :category AND match_up_flg = 1';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
    $sth->bindParam(':category',$_SESSION["login_user"]['category']);
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
// // テーブルから野球カテゴリーのuserデータを全て表示する
// // @param string 
// // @return Array 
public function find_baseball_users($page = 0):Array {
    try {
    $this->dbh->beginTransaction(); // トランザクションの開始
    $sql = 'SELECT DISTINCT * FROM users WHERE id != :id AND category = "野球"';
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
// // テーブルからサッカーカテゴリーのuserデータを全て表示する
// // @param string 
// // @return Array 
public function find_soccer_users($page = 0):Array {
    try {
    $this->dbh->beginTransaction(); // トランザクションの開始
    $sql = 'SELECT DISTINCT * FROM users WHERE id != :id AND category = "サッカー"';
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
// // テーブルからバスケットボールカテゴリーのuserデータを全て表示する
// // @param string 
// // @return Array 
public function find_basketball_users($page = 0):Array {
    try {
    $this->dbh->beginTransaction(); // トランザクションの開始
    $sql = 'SELECT DISTINCT * FROM users WHERE id != :id AND category = "バスケットボール"';
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
// // テーブルから友達データを表示する
// // @param string 
// // @return Array 
public function find_friend($page = 0):Array {
    try {
    $this->dbh->beginTransaction(); // トランザクションの開始
    $sql = 'SELECT DISTINCT id, team_name, user_name, image, region, age, category FROM users  WHERE users.id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id',$_POST['friend_profile'], PDO::PARAM_INT);
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
// // 申請ボタンの表示・非表示
// // @param string 
// // @return Array 
public function find_friendbtn():Array {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = 'SELECT DISTINCT id, team_name, user_name, image, region, age, category, friends.my_user_id,  friendship_status FROM users LEFT JOIN friends ON users.id = friends.my_user_id WHERE users.id = :id AND friends.friend_id = :friend_id';
  $sth = $this->dbh->prepare($sql);
  $sth->bindParam(':id',$_POST['friend_profile'], PDO::PARAM_INT);
  $sth->bindParam(':friend_id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
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
// // テーブルから友達データを表示する（チャットページ）
// // @param string 
// // @return Array 
public function find_chat_friend($page = 0):Array {
  try {
    $this->dbh->beginTransaction(); // トランザクションの開始
    $sql = 'SELECT DISTINCT id, team_name, user_name, image, region, age, category, friends.my_user_id FROM users LEFT JOIN friends ON users.id = friends.my_user_id WHERE users.id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id',$_SESSION['friend'], PDO::PARAM_INT);
    // $sth->bindParam(':friend_id',$_POST['friend_profile'], PDO::PARAM_INT);
    // $sth->bindParam(':my_user_id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
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
// user一覧の数字リンク
public function countAll():Int {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = 'SELECT count(*) as count FROM users';
  $sth = $this->dbh->prepare($sql);
  $sth->execute();
  $count = $sth->fetchColumn();
  $this->dbh->commit();
  } catch (PDOException $e) {
    $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
    exit('データベースに接続できませんでした。' . $e->getMessage());
  }
  return $count;
}

// // 編集したデータでログインユーザデータ（id）を更新する
// // @param string 
// // @return Array 
public function edit($save_path) {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = "UPDATE users SET team_name = :team_name, user_name = :user_name, image = :image, mail = :mail, password = :password, region = :region, age = :age, category = :category WHERE id = :id";
  $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
  $result = $sth->execute(array(":id"=>$_SESSION["login_user"]['id'],":team_name"=>$_POST['team_name'], ":user_name"=>$_POST['user_name'], ":image"=>$save_path, ":mail"=>$_POST['mail'], ":password"=>password_hash($_POST['password'], PASSWORD_DEFAULT), ":region"=>$_POST['region'], ":age"=>$_POST['age'], ":category"=>$_POST['category'])); //挿入する値が入った変数をexecuteにセットしてSQLを実行
  $this->dbh->commit();
  } catch (PDOException $e) {
    $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
    exit('データベースに接続できませんでした。' . $e->getMessage());
  }
  return $result;
}
// // マイページ削除ボタンで退会する
// // @param string 
// // @return Array 
public function delete_user() {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = "DELETE FROM users WHERE id = :id";
  $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
  $sth->bindParam(':id',$_GET['id'], PDO::PARAM_INT);
  $result = $sth->execute();
  $this->dbh->commit();
} catch (PDOException $e) {
  $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
  exit('データベースに接続できませんでした。' . $e->getMessage());
}
  return $result;
}
// // ボタンでマッチアップフラッグをactiveに更新する
// // @param string 
// // @return Array 
public function active() {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = "UPDATE users SET match_up_flg = 1 WHERE id = :id";
  $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
  $sth->bindParam(':id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
  $result = $sth->execute();
  $this->dbh->commit();
} catch (PDOException $e) {
  $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
  exit('データベースに接続できませんでした。' . $e->getMessage());
}
  return $result;
}
// // ボタンでマッチアップフラッグをinactiveに更新する
// // @param string 
// // @return Array 
public function inactive() {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = "UPDATE users SET match_up_flg = 0 WHERE id = :id";
  $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
  $sth->bindParam(':id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
  $result = $sth->execute();
  $this->dbh->commit();
} catch (PDOException $e) {
  $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
  exit('データベースに接続できませんでした。' . $e->getMessage());
}
  return $result;
}
// // 検索からサッカーuserデータを表示する
// // @param string 
// // @return Array 
public function find_soccer_from_search() {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  // SQLの準備
    $sql = 'SELECT * FROM users WHERE category = "サッカー" AND (team_name LIKE :team_name OR region LIKE :region)';
    // SQL実行
    $sth = $this->dbh->prepare($sql);
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
// // 検索から野球userデータを表示する
// // @param string 
// // @return Array 
public function find_baseball_from_search() {
  try {
    $this->dbh->beginTransaction(); // トランザクションの開始
  // SQLの準備
    $sql = 'SELECT * FROM users WHERE category = "野球" AND (team_name LIKE :team_name OR region LIKE :region)';
    // SQL実行
    $sth = $this->dbh->prepare($sql);
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
// // 検索からバスケットボールuserデータを表示する
// // @param string 
// // @return Array 
public function find_basketball_from_search() {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  // SQLの準備
    $sql = 'SELECT * FROM users WHERE category = "バスケットボール" AND (team_name LIKE :team_name OR region LIKE :region)';
    // SQL実行
    $sth = $this->dbh->prepare($sql);
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
// // 検索から対戦募集中userデータを全て表示する
// // @param string 
// // @return Array 
public function find_users_from_search($page = 0):Array {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = 'SELECT id, team_name, user_name, image, region  FROM users WHERE id != :id AND category = :category AND match_up_flg = 1 AND(team_name LIKE :team_name OR region LIKE :region)';
  $sth = $this->dbh->prepare($sql);
  $sth->bindParam(':id',$_SESSION["login_user"]['id'], PDO::PARAM_INT);
  $sth->bindParam(':category',$_SESSION["login_user"]['category']);
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
// ここからパスワードリセット
// // 既存のパスワードを削除する
// // @param string 
// // @return Array 
public function pwd_delete($userEmail) {
  try {
    $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = "DELETE FROM pwdReset WHERE pwdResetEmail = :pwdResetEmail";
  $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
  $sth->bindParam(':pwdResetEmail',$userEmail);
  $result = $sth->execute();
  $this->dbh->commit();
} catch (PDOException $e) {
  $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
  exit('データベースに接続できませんでした。' . $e->getMessage());
}
  return $result;
}
// // 新しいパスワードをテーブルに挿入する
// // @param string 
// // @return Array 
public function pwd_insert($userEmail, $selector, $hashedToken, $expires) {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (:pwdResetEmail, :pwdResetSelector, :pwdResetToken, :pwdResetExpires)"; 
    $sth = $this->dbh->prepare($sql); 
    $params = array(':pwdResetEmail'=>$userEmail,':pwdResetSelector'=>$selector, ':pwdResetToken'=>$hashedToken, ':pwdResetExpires'=>$expires); // 挿入する値を配列に格納する
  $result = $sth->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
  $this->dbh->commit();
} catch (PDOException $e) {
  $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
  exit('データベースに接続できませんでした。' . $e->getMessage());
}
  return $result;
  }

// // pwdを表示する
// // @param string 
// // @return Array 
public function find_pwd($selector) {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  // SQLの準備
    $sql = 'SELECT * FROM pwdReset WHERE pwdResetSelector = :pwdResetSelector';
    // SQL実行
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':pwdResetSelector',$selector);
    
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
// // テーブルからパスワード表示する
// // @param string 
// // @return Array 
public function find_pwd_user($tokenEmail, $newPwdHash){
 
  $sql = 'SELECT * FROM users WHERE mail = :mail';
  $sth = $this->dbh->prepare($sql);
  $sth->bindParam(':mail',$tokenEmail);
  // SQL結果を受け取る
  $sth->execute();
  $result = $sth->fetchall(PDO::FETCH_ASSOC);
  if ($result) {
    $sql = "UPDATE users SET password = :password WHERE mail = :mail";
    $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
    $sth->bindParam(':password', $newPwdHash);
    $sth->bindParam(':mail',$tokenEmail);
    $update = $sth->execute();
    return $update;
  }
}
// // 既存のパスワードを削除する
// // @param string 
// // @return Array 
public function pwd_complete() {
  try {
  $this->dbh->beginTransaction(); // トランザクションの開始
  $sql = "DELETE FROM pwdReset WHERE pwdResetEmail = :pwdResetEmail";
  $sth = $this->dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
  $sth->bindParam(':pwdResetEmail',$tokenEmail);
  $result = $sth->execute();
  $this->dbh->commit();
  } catch (PDOException $e) {
    $this->dbh->rollback();// 例外発生時に処理をなかったっ事にする
    exit('データベースに接続できませんでした。' . $e->getMessage());
  }
  return $result;
}

}