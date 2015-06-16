<?php
// mengincludekan function untuk menyingkat URL
include 'connect.php';

//cari dulu referensi di dalam tabel format
$sql = mysql_query("select * from format_sms where status='Aktif' and format='SNACKIT'");
$r = mysql_fetch_array($sql);

//cek panjang karakter dari format
$pnjg = strlen($r['format']);

//cari sms yang didalam inbox yang depannya mengandung huruf tersebut 
$inbox = mysql_query("select * from inbox where upper(substring(TextDecoded,1,$pnjg))='".strtoupper($r['format'])."' and Processed='false'");
while($rinbox = mysql_fetch_array($inbox)){
	//cek jika pengirimnya tidak sama dengan null maka diberikan balasan
	if($rinbox[SenderNumber]!=null){
		//cari kode verifikasi
		$exp = explode($r[tanda],strtoupper($rinbox[TextDecoded]));
		if(($exp[0]<>'')||($exp[1]<>'')||($exp[2]<>'')){// jika semua data tidak kosong maka masukan ke tabel pelanggan dan email ke admin
			//jika nomor transaksinya sudah pernah ada maka diberi balasan salah
			$cek = mysql_query("select * from customer where notrans='$exp[2]'");
			$rcek = mysql_num_rows($cek);
			if($rcek>=1){
				$pesan = "Nomor transaksi: $exp[2] sudah pernah ada..!";
			}else{
				//simpan data di tabel customer
				mysql_query("insert into customer(promo,nama,hp,notrans,tgl_sms)values(
				            '$exp[0]','$exp[1]','$rinbox[SenderNumber]','$exp[2]',curdate())");
				
				//kirim email ke admin
				$to = "$r[email1]";
				$subject = "SNACKIT : $rinbox[SenderNumber]";
				$body = "There is SMS Claim from HP Number : $rinbox[SenderNumber] <br>Claim Date : $rinbox[ReceivingDateTime]<br><br>Message : <br><br>$rinbox[TextDecoded]";
				$headers = "From: SMS Gateway\r\n";
				$headers .= "Content-type: text/html\r\n";
				mail($to, $subject, $body, $headers);
				
				$name = $exp[1];
				$pesan = "Hi ".$name.", ".$r[sukses];
			}
		}else{
			$pesan = $r[error];
		}

		//kirim sms balasan kepengirim hadiah
		mysql_query("INSERT INTO temp_outbox(DestinationNumber, TextDecoded, CreatorID)
				    VALUES ('$rinbox[SenderNumber]', '$pesan', 'Gammu')");
		echo "INSERT INTO temp_outbox(DestinationNumber, TextDecoded, CreatorID)
				    VALUES ('$rinbox[SenderNumber]', '$pesan', 'Gammu')";
		
		//update inbox 
		mysql_query("update inbox set Processed='True' where ID='".$rinbox['ID']."'");

	}
}
?>