<?php session_start();?>
<?php 
require_once(ROOT_PATH . 'Controllers/matchController.php');
$schedule = new matchController();
$params_schedule = $schedule->show_my_schedule();
// var_dump($params_schedule);
// var_dump($params_schedule['users']);

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
      <section class="users">
      <?php require_once('header.php')?>
        <div id="profile" class="col-xs-3 col-md-8 col-lg-8">
        </section>
        <section class="schedule">
          <div class="container">
            <div class="row">
            <h1>対戦スケジュール</h1>
              <table class="table">
                <thead>
                  <tr>
                    <th>日付</th><th>チーム</th><th>開始時間</th><th>終了時間</th><th>結果入力</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($params_schedule['users'] as $show_schedule):?>
                  <tr>
                    <td><?= $show_schedule['date'] ?></td><td><?= $show_schedule['team_name'] ?></td><td><?= $show_schedule['start_time'] ?></td><td><?= $show_schedule['end_time'] ?></td>
                    <td>
                    <form id="btn" action="result.php" method="post">
                      <button type="submit" name="enemy_id" value="<?=$show_schedule['enemy_user_id'] ?>" class="btn btn-primary btn-sm">結果入力</button>
                      <input type="hidden" name="set_date" value="<?=$show_schedule['date'];?>"></input>
                      <input type="hidden" name="unique_id" value="<?=$show_schedule['unique_id'];?>">
                    </form>
                    </td>
                  </tr>
                </tbody>
                <?php endforeach; ?>
              </table>
            </div>
          </div>
          <!-- <div class="more-btn">
            <button type="button" class="btn btn-outline-secondary">More</button>
          </div> -->
        </section>
        <?php require_once('footer.php')?>
    </div>
  </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>