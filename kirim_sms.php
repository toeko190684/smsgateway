<?php
include "connect.php";

//mencari selisih menit sentitem dengan waktu sekrang, jika lebih besar dari 2 menit maka akan dikirim sms dari temp_outbox 
$sql = mysql_query("SELECT minute(timediff(current_timestamp(),max(SendingDateTime)))as menit FROM  sentitems");
$r = mysql_fetch_array($sql);

//jika selisih menitnya lebih besar atau sama dengan 2 maka dikirim sms ke outbox dan di temp_outbox di hapus
if($r[menit]>=1){
	$tmp = mysql_query("select * from temp_outbox limit 0,2");
	while($rtmp = mysql_fetch_array($tmp)){
		//masukan kedalam outbox atau krim sms
		$query = mysql_query("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID)
					         VALUES ('$rtmp[DestinationNumber]', '$rtmp[TextDecoded]', '$rtmp[CreatorID]')");
		
		if($query){
			//jika berhasil dipindahkan maka hapus yang ditemporary outbox
			mysql_query("delete from temp_outbox where ID = $rtmp[ID]");
		}		
	}
}

?>