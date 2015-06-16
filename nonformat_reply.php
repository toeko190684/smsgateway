<?php
// mengincludekan function untuk menyingkat URL
include 'connect.php';

//cari dulu referensi di dalam tabel format
$sql = mysql_query("select * from format_sms where status='Aktif'");
while($r = mysql_fetch_array($sql)){
	//cek panjang karakter dari format
	$pnjg = strlen($r['format']);

	//cari sms yang didalam inbox yang depannya mengandung huruf tersebut 
	$inbox = mysql_query("select * from inbox where upper(substring(trim(TextDecoded),1,$pnjg))<>'".strtoupper($r['format'])."' and Processed='false'");
	while($rinbox = mysql_fetch_array($inbox)){
		//cek jika pengirimnya tidak sama dengan null maka diberikan balasan
		if($rinbox[SenderNumber]!=null){
			$pesan = "Format pengiriman SMS tidak dikenal..!";
			//kirim sms ke pengirim sms
			$query = "INSERT INTO temp_outbox(DestinationNumber, TextDecoded, CreatorID)
					  VALUES ('$rinbox[SenderNumber]', '$pesan', 'Gammu')";
			mysql_query($query);	

			//update inbox 
			mysql_query("update inbox set Processed='True' where ID='".$rinbox['ID']."'");
		}
	}
}
?>