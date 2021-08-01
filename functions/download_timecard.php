
<?php
 
require_once "../includes/db_config.php";
date_default_timezone_set("Asia/Manila"); 
$date_t = date("Y-m-d");
$time_t = date("H:i:s");

$id = $_GET['id'];
//Create our SQL query.

$src_timecard=$conn->prepare("SELECT CONCAT(a.firstname,a.lastname) as Name, CONCAT(DATE_FORMAT(b.date_in,'%b-%d-%Y'),' ',TIME_FORMAT(b.time_in,'%h:%i %p')) AS TimeIN ,CONCAT(DATE_FORMAT(b.date_out,'%b-%d-%Y'),' ',TIME_FORMAT(b.time_out,'%h:%i %p')) AS TimeOut,b.tasks,CONCAT(HOUR(TIMEDIFF(CONCAT(b.date_in,' ',b.time_in),CONCAT(b.date_out,' ',b.time_out))),' hours, ',MINUTE(TIMEDIFF(CONCAT(b.date_in,' ',b.time_in),CONCAT(b.date_out,' ',b.time_out))),' minutes') AS TimeRendered, b.NSD as Nigh_Shift_Differential FROM users a INNER JOIN attendance b ON a.userid = b.userid WHERE b.userid = :uid");
$src_timecard->execute(array(':uid'=>$id));


 
//Fetch all of the rows from our MySQL table.
$rows = $src_timecard->fetchAll(PDO::FETCH_ASSOC);

//Get the column names.
$columnNames = array();
if(!empty($rows)){
    //We only need to loop through the first row of our result
    //in order to collate the column names.
    $firstRow = $rows[0];
    foreach($firstRow as $colName => $val){
        $columnNames[] = $colName;
    }
}
 
//Setup the filename that our CSV will have when it is downloaded.
$fileName = "MyTimecard_".$date_t."_".$time_t.".csv";
 
//Set the Content-Type and Content-Disposition headers to force the download.
header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
 
//Open up a file pointer
$fp = fopen('php://output', 'w');
 
//Start off by writing the column names to the file.
fputcsv($fp, $columnNames);
 
//Then, loop through the rows and write them to the CSV file.
foreach ($rows as $row) {
    fputcsv($fp, $row);
}
 
//Close the file pointer.
fclose($fp);