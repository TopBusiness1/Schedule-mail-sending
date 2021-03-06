<?php
//include the database
include 'functions.php';

use Medoo\Medoo;

$selector = getWhere(getTimeFrom($_POST['timefrom']), 
                    getTimeTo($_POST['timefrom'], $_POST['timeto']), 
                    $_POST['callfrom'], 
                    $_POST['callto'], 
                    $_POST['callduration'], 
                    $_POST['talkduration'], 
                    $_POST['status'], 
                    $_POST['drunk'], 
                    $_POST['communicationtype'], 
                    $_POST['pincode']);

    // var_dump(json_encode($selector));

// $selector['LIMIT'] = [0,50];

$data = $database->select("cdr", ["datetime","src", "dst","extfield1","extfield2","billable","duration","disposition"], $selector);

//var_dump($data);
$index = 1;
if (count($data)) {
    // output data of each row
    foreach($data as $row) {
      $billhours = floor($row['billable'] / 3600);
      $billmins = floor($row['billable'] / 60 % 60);
      $billsecs = floor($row['billable'] % 60);
      $billtimeFormat = sprintf('%02d:%02d:%02d', $billhours, $billmins, $billsecs);
      $talkhours = floor($row['duration'] / 3600);
      $talkmins = floor($row['duration'] / 60 % 60);
      $talksecs = floor($row['duration'] % 60);
      $talktimeFormat = sprintf('%02d:%02d:%02d', $talkhours, $talkmins, $talksecs);


      echo "<tr>";
      echo "<td style='width: 5%'>".($index++)."</td>";
      echo "<td style='width: 10%' data-toggle='tooltip' title='".$row['datetime']."'>".$row['datetime']."</td>";
      echo "<td style='width: 10%' data-toggle='tooltip' title='".$row['extfield1'].($row['extfield1'] == ""?"":"<").$row['src'].($row['extfield1'] == ""?"":">")."'>".$row['extfield1'].($row['extfield1'] == ""?"":"<").$row['src'].($row['extfield1'] == ""?"":">")."</td>";
      echo "<td style='width: 10%' data-toggle='tooltip' title='".$row['dst']."'>".$row['extfield2'].'<'.$row['dst'].'>'."</td>";
      echo "<td style='width: 10%' data-toggle='tooltip' title='".$talktimeFormat."'>".$talktimeFormat."</td>";
      echo "<td style='width: 10%' data-toggle='tooltip' title='".$billtimeFormat."'>".$billtimeFormat."</td>";
      echo "<td style='width: 10%' data-toggle='tooltip' title='".$row['disposition']."'>".$row['disposition']."</td>";
      echo "</tr>";

    }
} else {
    echo "No items defiend.";
}
// echo json_encode($data);

?>