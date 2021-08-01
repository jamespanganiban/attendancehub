<?php  
 //filter.php  
 if(isset($_POST["from_date"], $_POST["to_date"]))  
 {  
      include '../includes/db_config.php';  
      $output = '';  
      $fd = $_POST["from_date"];
      $td = $_POST["to_date"];
      $mn_timecard=$conn->prepare("SELECT b.attendanceid,a.userid,a.firstname,a.lastname,b.date_in,b.time_in,b.date_out,b.time_out,b.tasks,b.time_rendered,a.level,c.shift_in,c.shift_out FROM users a INNER JOIN attendance b ON a.userid = b.userid INNER JOIN shift c ON a.shiftid = c.shiftid
        WHERE b.date_in BETWEEN '$fd' AND '$td' ");
        $mn_timecard->execute(array());
       
    
      $output .= '  
           <table class="table table-bordered">  
                <tr>
                <th class="th-sm">#</th>
                <th class="th-sm">Name</th>
                <th class="th-sm">Date In</th>
                <th class="th-sm">Time In</th>
                <th class="th-sm">Date Out</th>
                <th class="th-sm">Time Out</th>
                <th class="th-sm">Task Accomplished</th>
                <th class="th-sm">Time Rendered</th>
                <th class="th-sm">Level</th>

              </tr>
      ';  
      if($mn_timecard->rowCount() > 0)
      {  
            $n = 1;
           while($row=$mn_timecard->fetch(PDO::FETCH_ASSOC)) 
           {  
                $output .= '  

                    <tr style="font-size: 14px">
                        

                     
                      <td> '.$n.' </td>
                      <td> '.$row['firstname']." ".$row['lastname'].' </td>
                      <td> '.$row['date_in'].'</td>
                      <td> '.$row['time_in'].'</td>
                      <td> '.$row['date_out'].' </td>
                      <td> '.$row['time_out'].' </td>
                      <td> '.$row['tasks'].'</td>
                      <td> '.$row['time_rendered'].' </td>
                      <td> '.$row['level'].' </td>

                        

                    </tr>
                ';  

                    $n ++; 
       
       
           }  
      }  
      else  
      {  
           $output .= '  
                <tr>  
                     <td colspan="5">No Order Found</td>  
                </tr>  
           ';  
      }  
      $output .= '</table>';  
      echo $output;  
 }  
 ?>

