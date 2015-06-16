<?php
// mengincludekan function untuk menyingkat URL
include 'connect.php';

//cari dulu referensi di dalam tabel format
$sql = mysql_query("select * from format_sms where status='Aktif'");
while($r = mysql_fetch_array($sql)){
	//cek panjang karakter dari format
	$pnjg = strlen($r['format']);

	//cari sms yang didalam inbox yang depannya mengandung huruf tersebut 
	$inbox = mysql_query("select * from inbox where upper(substring(trim(TextDecoded),1,$pnjg))='".strtoupper($r['format'])."' and Processed='false'");
	while($rinbox = mysql_fetch_array($inbox)){
		//cek jika pengirimnya tidak sama dengan null maka diberikan balasan
		if($rinbox[SenderNumber]!=null){
			//cari kode verifikasi
			$exp = explode("_",$rinbox[TextDecoded]);
			
			//cari nilai $exp[1] ke tabel verifikasi
			$validasi = mysql_query("select * from validasi_pulsa where no_verifikasi='$exp[1]'");
			$rvalidasi = mysql_fetch_array($validasi);
			$cek = mysql_num_rows($validasi);
			
			if($cek>0){
				if(($rvalidasi[claim_date]!='') and ($rvalidasi[hp]!='')){
					$pesan = "Nomor Verifikasi tidak valid..!";
				}else{
					$pesan = $r[sukses];					
					
					//kirim email 
					$to = "$r[email1],$r[email2]";
					$subject = "PPC : $rinbox[SenderNumber]";
					$body = "SMS Claim HP Number : $rinbox[SenderNumber] <br>Claim Date : $rinbox[ReceivingDateTime]<br><br>Message : <br><br>$rinbox[TextDecoded]";
					$headers = "From: SMS Gateway\r\n";
					$headers .= "Content-type: text/html\r\n";
					mail($to, $subject, $body, $headers);
					
					//update tabel transaksi validasi data 
					$tgl = date('d M Y H:m:s');
					$update = mysql_query("update validasi_pulsa set claim_date='$tgl' ,hp='$rinbox[SenderNumber]' where no_verifikasi='$exp[1]'");
					
					//kirim pulsa sesuai dengan format operator masing masing=======================================================================================================
					//1. cari prefix nomor handphone 
					$prefix = substr($rinbox[SenderNumber],0,6);
					
					//cari prefix dan nominal di v_undian_pulsa
					$undian = mysql_query("select * from v_undian_pulsa where prefix='$prefix' and nominal='$rvalidasi[nominal]'");
					$rundian = mysql_fetch_array($undian);
					
					//kirim sms pengisian pulsa
					$format_pengisian = $rundian[product_id].".".str_replace("+62","0",$rinbox[SenderNumber]).".1234";
					
					$query = "INSERT INTO temp_outbox(DestinationNumber, TextDecoded, CreatorID)
							 VALUES ('$rundian[smscenter1]', '$format_pengisian', 'Gammu')";
					mysql_query($query);	
					
					
					
					//==============================================================================================================================================================
				}
			}else{
				$pesan = "$r[error]";	
			}
						
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