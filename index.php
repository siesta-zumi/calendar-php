<?php
  try { //tryブロックで囲んで
    if (!isset($_GET['t']) || !preg_match('/\A\d{4}-\d{2}\z/', $_GET['t'])) { //tがない場合や書式が会ってない場合（４桁、２桁じゃない）
      throw new Exception(); //例外を投げます。
    }
    $thisMonth = new DateTime($_GET['t']); //合っていればこれでOK
  } catch (Exception $e) { //例外をキャッチしたら
    $thisMonth = new DateTime('first day of this month'); //これを行います。
  }
  //年月部分の定義（月情報の取得）
  
  $yearMonth = $thisMonth->format('F Y'); //Fは January からDecsmber Yは(Year)4桁で2020など この場合は April 2020



  //前月の日付を取得
  $tail = ""; //空のtailを定義（tailは終わりという意味）
  $lastDayOfPrevMonth = new DateTime('last day of ' . $yearMonth . ' -1 month');
 
  while ($lastDayOfPrevMonth -> format('w') < 6) { //曜日が土曜日よりも小さい間
    $tail = sprintf('<td class = "gray">%d</td>', $lastDayOfPrevMonth -> format('d')) . $tail; //ここではtailの前に取得した日付を挿入する
    $lastDayOfPrevMonth -> sub(new DateInterval('P1D'));
  }

  //今月の日付を取得
  $body = "";
  $start = new DateTime('first day of' . $yearMonth); //今月の1日
  $interval = new DateInterval('P1D'); //1日間隔
  $end = new DateTime('first day of ' . $yearMonth . ' +1 month'); //来月の1日（endは含まないので今月の末日になる）

  $period = new DatePeriod( $start, $interval, $end ); //引数は（開始、間隔、終了の順番）

  foreach($period as $day) { //foreachで１つずつ採り出して<td>のなかに入れる。
    if ($day->format('w') % 7 === 0) {
      $body .= '</tr><tr>';
    }
    $body .= sprintf('<td class = "youbi_%d">%d</td>', $day->format('w'), //wは曜日を０〜６で表示
    $day->format('d')); //欲しいのは'd'(日付だけ) dは日付を２桁で表示
  }

  //翌月の日付を取得
  $head = ""; //からのheadを定義 （headは月初の意味）
  $firstDayOfNextMonth = new DateTime('first day of' . $yearMonth . '+1 month'); //翌月の月初を定義

  while ($firstDayOfNextMonth -> format('w') > 0) { //翌月の曜日が日曜日になるまで繰り返す。
    $head .= sprintf('<td class = "gray">%d</d>', $firstDayOfNextMonth -> format('d')); //空のheadにclass:grayの日付を追加
    $firstDayOfNextMonth -> add(new DateInterval('P1D')); //こちらの間隔も1日ごと
  }

  $html = '<tr>' . $tail . $body . $head . '</tr>';

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>calendar</title>
  <link rel ="stylesheet" href="style.css">
</head>
<body>
  <table>
    <thead>
    <tr>
      <th> <a href= "">&laquo;</th>
      <th colspan = "5"><?php echo $yearMonth; ?></th>
      <th><a href= "">&raquo;</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Sun</td>
        <td>Mon</td>
        <td>Tue</td>
        <td>Wed</td>
        <td>Thu</td>
        <td>Fri</td>
        <td>Sat</td>
      </tr>
        <?php echo $html; ?>

    </tbody>
    <tfoot>
    <th colspan = "7"><a href = "">Today</th>
    </tfoot>
    
  </table>
</body>
</html>