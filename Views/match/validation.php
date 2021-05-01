
<?php 

// エラーメッセージ
$err = [];

// バリデーション

// チームネームのエラー判定
if (is_null($_POST["team_name"]) || $_POST["team_name"] === "" || mb_strlen($_POST["team_name"]) > 20 ) {
  $err[] = "＊チームネームは必須入力です。";
} 

// 監督者ネームのエラー判定
if (is_null($_POST["user_name"]) || $_POST["user_name"] === "" || 10 < mb_strlen($_POST["user_name"])) {
  $err[] = "＊監督者ネームは必須入力です。"; 
} 
// 画像のエラー判定
// ファイル関連の取得

if (isset($_FILES['image'])) {
  $file = $_FILES['image'];
  $filename = basename($file['name']);
  $tmp_path = $file['tmp_name'];
  $file_err = $file['error'];
  $filesize = $file['size'];
  $upload_dir = 'img/';
  $save_filename = date('YmdHis') . $filename;
  $save_path = $upload_dir . $save_filename;
  // ファイルのバリデーション
  // ファイルサイズが1MB未満か
  if ($filesize > 1048576 || $file_err == 2) {
    $err[] = "＊ファイルサイズは1MB未満にしてください。"; 
  }
  // 拡張は画像形式か
  $allow_ext = array('jpg', 'jpeg', 'png');
  $file_ext = pathinfo($filename, PATHINFO_EXTENSION);

  if (!in_array(strtolower($file_ext), $allow_ext)) {
    $err[] = "＊画像ファイルを添付してください。"; 
  }
  // ファイルはあるかどうか
  if (is_uploaded_file($tmp_path)) {
    move_uploaded_file($tmp_path, $save_path);
      // DBにファイルを保存(ファイル名、ファイルパス)
      // $result = fileSave($filename, $save_path);
    } else {
    $err[] = "＊ファイルが選択されていません。"; 
  }
}
// メールアドレスのエラー判定
if (!$mail = filter_input(INPUT_POST, 'mail')) {
  $err['mail'] = 'メールアドレスを記入してください。';
}
// パスワードのエラー判定
if (isset($_POST['password'])) {
  $password = filter_input(INPUT_POST, 'password');
  if (!preg_match("/\A[a-z\d]{8,100}+\z/i",$password)) {
    $err[] = '＊パスワードを正しく記入してください。';
  }
}
// 地域のエラー判定
if (is_null($_POST["region"]) || $_POST["region"] === "" || 10 < mb_strlen($_POST["region"])) {
  $err[] = "＊地域は必須入力です。"; 
} 
// 年代のエラー判定
if (is_null($_POST["age"]) || $_POST["age"] === "") {
  $err[] = "＊ 年代は必須入力です。"; 
} 
// 種目のエラー判定
if (is_null($_POST["category"]) || $_POST["category"] === "") {
  $err[] = "＊種目は必須入力です。"; 
} 
?>