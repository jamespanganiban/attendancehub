<?php
    class Attendance{

        // Connection
        private $conn;

        // Table
        private $db_table = "attendance";

        // Columns
        public $attendanceid;
        public $userid;
        public $date_in;
        public $time_in;
        public $date_out;
        public $time_out;
        public $tasks;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getAttendance(){
            $sqlQuery = "SELECT attendanceid,userid, date_in, time_in , date_out, time_out, tasks  FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createAttendance(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        userid = :userid, 
                        date_in = :date_in, 
                        time_in = :time_in, 
                        date_out = :date_out, 
                        time_out = :time_out,
                        tasks = :tasks";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->userid=htmlspecialchars(strip_tags($this->userid));
            $this->date_in=htmlspecialchars(strip_tags($this->date_in));
            $this->time_in=htmlspecialchars(strip_tags($this->time_in));
            $this->date_out=htmlspecialchars(strip_tags($this->date_out));
            $this->time_out=htmlspecialchars(strip_tags($this->time_out));
            $this->tasks=htmlspecialchars(strip_tags($this->tasks));
        
        
            // bind data
            $stmt->bindParam(":userid", $this->userid);
            $stmt->bindParam(":date_in", $this->date_in);
            $stmt->bindParam(":time_in", $this->time_in);
            $stmt->bindParam(":date_out", $this->date_out);
            $stmt->bindParam(":time_out", $this->time_out);
            $stmt->bindParam(":tasks", $this->tasks);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getSpecificAttendance(){
            $sqlQuery = "SELECT
                        userid, 
                        date_in, 
                        time_in, 
                        date_out, 
                        time_out, 
                        tasks
                      FROM
                        ".$this->db_table."
                    WHERE 
                       attendanceid = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->attendanceid);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if($dataRow){
            $this->userid = $dataRow['userid'];
            $this->date_in = $dataRow['date_in'];
            $this->time_in = $dataRow['time_in'];
            $this->date_out = $dataRow['date_out'];
            $this->time_out = $dataRow['time_out'];
            $this->tasks = $dataRow['tasks'];
            }
        }        

        // UPDATE
        public function updateAttendance(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        date_in = :date_in, 
                        time_in = :time_in, 
                        date_out = :date_out, 
                        time_out = :time_out 
                    
                    WHERE 
                        attendanceid = :attendanceid";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->attendanceid=htmlspecialchars(strip_tags($this->attendanceid));
            $this->date_in=htmlspecialchars(strip_tags($this->date_in));
            $this->time_in=htmlspecialchars(strip_tags($this->time_in));
            $this->date_out=htmlspecialchars(strip_tags($this->date_out));
            $this->time_out=htmlspecialchars(strip_tags($this->time_out));
           // $this->tasks=htmlspecialchars(strip_tags($this->tasks));
        
        
            // bind data
            $stmt->bindParam(":attendanceid", $this->attendanceid);
            $stmt->bindParam(":date_in", $this->date_in);
            $stmt->bindParam(":time_in", $this->time_in);
            $stmt->bindParam(":date_out", $this->date_out);
            $stmt->bindParam(":time_out", $this->time_out);
            //$stmt->bindParam(":tasks", $this->tasks);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteAttendance(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE attendanceid = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->attendanceid=htmlspecialchars(strip_tags($this->attendanceid));
        
            $stmt->bindParam(1, $this->attendanceid);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>