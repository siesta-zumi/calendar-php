<?php
  $body = "";
  $start = new DateTime('first day of this month'); //今月の1日
  $interval = new DateInterval('P1D'); //1日間隔
  $end = new DateTime('first day of next month'); //来月の1日（endは含まないので今月の末日になる）

  $period = new DatePeriod( $start, $interval, $end ); //引数は（開始、間隔、終了の順番）

  foreach($period as $day) { //foreachで１つずつ採り出して<td>のなかに入れる。
    if ($day->format('w') % 7 === 0) {
      $body .= '</tr><tr>';
    }
    $body .= sprintf('<td class = "youbi_%d">%d</td>', $day->format('w'), //wは曜日を０〜６で表示
    $day->format('d')); //欲しいのは'd'(日付だけ) dは日付を２桁で表示

    //翌月の日付を取得
    $head = ""; //からのheadを定義 （headは月初の意味）
    $firstDayOfNextMonth = new DateTime('first day of next month'); //翌月の月初を定義
    while($firstDayOfNextMonth -> format('w') === 0) { //翌月の曜日が日曜日になるまで繰り返す。
    $head .= sprintf('<td class = "gray">%d</d>', $firstDayOfNextMonth -> format('d')); //空のheadにclass:grayの日付を追加
    $firstDayOfNextMonth -> add(new DateInterval('P1D')); //こちらの間隔も1日ごと
  }
  }

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
      <th colspan = "5">August 2020</th>
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
      <tr>
        <?php echo $body; ?>
        <!--<td class="youbi_0">1</td>
        <td class="youbi_1">2</td>
        <td class="youbi_2">3</td>
        <td class="youbi_3">4</td>
        <td class="youbi_4 today">5</td>
        <td class="youbi_5">6</td>
        <td class="youbi_6">7</td>
      </tr>
      <tr>
      
        <td class="youbi_0">30</td>
        <td class="youbi_1">31</td>
        <td class="gray">1</td>
        <td class="gray">2</td>
        <td class="gray">3</td>
        <td class="gray">4</td>
        <td class="gray">5</td> -->
      </tr>
      
    </tbody>
    <tfoot>
    <th colspan = "7"><a href = "">Today</th>
    </tfoot>
    
  </table>
</body>
</html>