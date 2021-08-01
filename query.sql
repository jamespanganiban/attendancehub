
#admin export query

SELECT CONCAT(a.firstname,' ',a.lastname) as Name,

CONCAT(DATE_FORMAT(b.date_in,'%b-%d-%Y'),' ',TIME_FORMAT(b.time_in,'%h:%i %p')) AS TimeIN,
CONCAT(DATE_FORMAT(b.date_out,'%b-%d-%Y'),' ',TIME_FORMAT(b.time_out,'%h:%i %p')) AS TimeOut,
TIMESTAMPDIFF(HOUR,CONCAT(b.date_in,' ',b.time_in),CONCAT(b.date_out,' ',b.time_out)) AS HoursRendered,
(SELECT IF(HoursRendered>=9, 8, (SELECT IF(HoursRendered > 4, (SELECT IF(e.fstatus = 'approved',(SELECT IF(HoursRendered = TIMESTAMPDIFF(HOUR,CONCAT(b.date_in,' ',e.start_time),CONCAT(b.date_out,' ',e.end_time)),0,HoursRendered)),HoursRendered - 1)) ,HoursRendered ))) ) AS PaidWorkHours,

(SELECT IF(e.fstatus = 'approved',TIMESTAMPDIFF(HOUR,CONCAT(b.date_in,' ',e.start_time),CONCAT(b.date_out,' ',e.end_time)),0)) AS PaidOThours,
e.fstatus AS FILED_OT_WITH_STATUS,CONCAT(d.shift_in,'-',d.shift_out) AS Shift,
a.level, b.NSD AS Night_Shift_differential, b.tasks
FROM users a

LEFT JOIN attendance b ON a.userid = b.userid 
LEFT JOIN schedule c ON a.userid = c.userid
LEFT JOIN shift d on c.shiftid = d.shiftid 
LEFT JOIN filed e ON b.attendanceid = e.attendanceid 

WHERE b.date_in  >= :srcdate_from AND b.date_out <= :srcdate_to AND b.date_in 
BETWEEN c.scheduled_date_start AND c.scheduled_date_end 

GROUP BY b.date_in,b.time_in 
ORDER BY a.firstname ASC,b.date_in ASC

