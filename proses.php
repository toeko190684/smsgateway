<?php
include "connect.php";

mysql_connect($host,$username,$password) or die("tidak terkoneksi keserver mysql");
mysql_select_db($database) or die ("tidak terkoneksi ke datatabase smsgateway");

if(isset($_GET[kirim_sms])){
     $tujuan = explode(";", $_POST[tujuan]);
     $i =0;
     for($i=0;$i<=20;$i++){
         if($tujuan[$i]<>''){
                  if(is_numeric($tujuan[$i])){     //cek apakah tujuan termasuk angka nomor atau bukan
                       mysql_query("insert into temp_outbox(DestinationNumber,TextDecoded)values('$tujuan[$i]','$_POST[message]')");
                  }else{
					   //cek di pbk apakah tujuanya itu ada atau tidak 
					   $pbk = mysql_query("select * from pbk where Name='$tujuan[$i]'");
					   $cek_pbk = mysql_num_rows($pbk);
					   $rpbk = mysql_fetch_array($pbk);
					   
					   //jika namanya ada didalam tabel pbk maka dikirimkan sms ke nomor tersebut
					   if($cek_pbk>0){
							mysql_query("insert into temp_outbox(DestinationNumber,TextDecoded)values('$rpbk[Number]','$_POST[message]')");
					   }else{  
						   $sql = mysql_query("SELECT a.GroupID, b.Name as group_name, a.Name, a.Number FROM pbk a, pbk_groups b
											   WHERE a.GroupID = b.ID and b.Name ='$tujuan[$i]'");
						   
						   while($rsql = mysql_fetch_array($sql))
						   {
								mysql_query("insert into temp_outbox(DestinationNumber,TextDecoded)values('$rsql[Number]','$_POST[message]')");
						   }
					   }
                  }
         }
     }
}

if(isset($_GET[delete_sms])){
      $sql = mysql_query("delete from inbox where ID='$_POST[ID]'");
      if($sql){ echo "$_POST[ID]"; }

}

if(isset($_GET[reply_sms])){
      $sql = mysql_query("insert into temp_outbox(DestinationNumber,TextDecoded)values('$_POST[hp]','$_POST[sms_message]')");
      if($sql){ echo "sukses"; }

}

if(isset($_GET[phonebook])){
      $phone = "+62".substr($_POST[pbk_hp],0,12);
      $sql = mysql_query("select count(*)as jml from pbk where Number='$phone'");
      $rsql = mysql_fetch_array($sql);
      if($rsql[jml]>0){
            $sql = mysql_query("update pbk set GroupID='$_POST[pbk_group]',Name='$_POST[pbk_name]' where Number='$phone' ");
            if($sql){ echo "sukses"; }
      }else{
            $sql = mysql_query("insert into pbk(GroupID,Name,Number)values('$_POST[pbk_group]','$_POST[pbk_name]','$phone')");
            if($sql){ echo "sukses"; }  
      }

}

if(isset($_GET[save_format])){
      $sql = mysql_query("select count(*)as jml from format_sms where format='$_POST[format]'");
      $rsql = mysql_fetch_array($sql);
      if($rsql[jml]>0){
            $sql = mysql_query("update format_sms set status='$_POST[status]',tanda='$_POST[tanda]',email1='$_POST[email1]',email2='$_POST[email2]',sukses='$_POST[sukses]',error='$_POST[error]' where format='$_POST[format]'");
            if($sql){ echo "sukses"; }
      }else{
            $sql = mysql_query("insert into format_sms(format,status,tanda,email1,email2,sukses,error)values('$_POST[format]','$_POST[status]','$_POST[tanda]','$_POST[email1]','$_POST[email2]','$_POST[sukses]','$_POST[error]')");
            if($sql){ echo "sukses"; }
      }
}

if(isset($_GET[delete_format])){
      $sql = mysql_query("delete from format_sms where format='$_POST[format]'");
      if($sql){ echo "sukses"; }

}

if(isset($_GET[delete_phonebook])){
      $sql = mysql_query("delete from pbk where Number='$_POST[pbk_hp]'");
      if($sql){ echo "sukses"; }

}

if(isset($_GET[pbk_groups])){
      $sql = mysql_query("select count(*) as jml from pbk_groups where ID='$_POST[ID]'");
      $rsql = mysql_fetch_array($sql);
      if($rsql[jml]>0){
            $sql = mysql_query("update pbk_groups set Name='$_POST[group_name]' where ID='$_POST[ID]'");
            if($sql){ echo "sukses";}
      }else{
            $sql = mysql_query("insert into pbk_groups(Name)values('$_POST[group_name]')");
            if($sql){ echo "sukses"; }
      }
}

if(isset($_GET[delete_pbk_group])){
      $sql = mysql_query("delete from pbk_groups where ID='$_POST[ID]'");
      if($sql){ echo "sukses"; }

}

if(isset($_GET[user])){
      $password = md5($_POST[password]);
      $sql = mysql_query("select count(*)as jml from user where Name='$_POST[username]' and  HP='$_POST[user_hp]'");
      $rsql = mysql_fetch_array($sql);
      if($rsql[jml]>0){
                       if($_POST[password]==''){
                                                $sql = mysql_query("update user set Name='$_POST[username]',HP='$_POST[user_hp]',email='$_POST[email]',level='$_POST[level]' where Name='$_POST[username]' and HP='$_POST[user_hp]'");
                       }else{
                                                $sql = mysql_query("update user set Name='$_POST[username]',HP='$_POST[user_hp]',email='$_POST[email]',sandi='$password',level='$_POST[level]' where Name='$_POST[username]' and HP='$_POST[user_hp]'");
                       }
                       if($sql){ echo "sukses"; }
      }else{
                       $sql = mysql_query("insert into user values('$_POST[username]','$_POST[user_hp]','$_POST[email]','$password','$_POST[level]')");
                       if($sql){ echo "sukses"; }
      }

}

if(isset($_GET[delete_user])){
      $sql = mysql_query("delete from user where Name='$_POST[username]' and  HP='$_POST[user_hp]'");
      if($sql){ echo "sukses"; }

}

if(isset($_GET[operator])){
      $sql = mysql_query("select count(*) as jml from operator where operator_id='$_POST[ID]'");
      $rsql = mysql_fetch_array($sql);
      if($rsql[jml]>0){
            $sql = mysql_query("update operator set operator_name='$_POST[operator_name]', smscenter1 = '$_POST[smscenter1]', smscenter2 = '$_POST[smscenter2]' where operator_id='$_POST[ID]'");
            if($sql){ echo "sukses";}
      }else{
            $sql = mysql_query("insert into operator(operator_name,smscenter1,smscenter2)
			                   values('$_POST[operator_name]','$_POST[smscenter1]','$_POST[smscenter2]')");
            if($sql){ echo "sukses"; }
      }
}

if(isset($_GET[delete_operator])){
      $sql = mysql_query("delete from operator where operator_id='$_POST[ID]'");
      if($sql){ echo "sukses"; }

}

if(isset($_GET[operator_product])){
      $sql = mysql_query("select count(*) as jml from operator_product where product_id='$_POST[product_id]'");
      $rsql = mysql_fetch_array($sql);
      if($rsql[jml]>0){
            $sql = mysql_query("update operator_product set operator_id='$_POST[operator_id]', nominal = '$_POST[nominal]', harga = '$_POST[harga]' where product_id='$_POST[product_id]'");
            if($sql){ echo "sukses";}
      }else{
            $sql = mysql_query("insert into operator_product(product_id,operator_id,nominal,harga)
			                   values('$_POST[product_id]','$_POST[operator_id]','$_POST[nominal]','$_POST[harga]')");
            if($sql){ echo "sukses"; }
      }
}

if(isset($_GET[delete_operator_product])){
      $sql = mysql_query("delete from operator_product where product_id='$_POST[ID]'");
      if($sql){ echo "sukses"; }

}

if(isset($_GET[prefix])){
      $sql = mysql_query("select count(*) as jml from prefix where prefix='$_POST[prefix]'");
      $rsql = mysql_fetch_array($sql);
      if($rsql[jml]>0){
            $sql = mysql_query("update prefix set operator_id='$_POST[operator_id]'  where prefix ='$_POST[prefix]'");
            if($sql){ echo "sukses";}
      }else{
            $sql = mysql_query("insert into prefix(prefix,operator_id)
			                   values('$_POST[prefix]','$_POST[operator_id]')");
            if($sql){ echo "sukses"; }
      }
}

if(isset($_GET[delete_prefix])){
      $sql = mysql_query("delete from prefix where prefix='$_POST[ID]'");
      if($sql){ echo "sukses"; }

}

if(isset($_GET[verifikasi])){
      $sql = mysql_query("select count(*) as jml from validasi_pulsa where no_verifikasi='$_POST[no_verifikasi]'");
      $rsql = mysql_fetch_array($sql);
      if($rsql[jml]>0){
            $sql = mysql_query("update validasi_pulsa set nominal='$_POST[nominal]',claim_date='$_POST[claim_date]', hp = '$_POST[hp]'  where no_verifikasi ='$_POST[no_verifikasi]'");
            if($sql){ echo "sukses";}
      }else{
            $sql = mysql_query("insert into validasi_pulsa(no_verifikasi,nominal,claim_date,hp)
			                   values('$_POST[no_verifikasi]','$_POST[nominal]','$_POST[claim_date]','$_POST[hp]')");
            if($sql){ echo "sukses"; }
      }
}

if(isset($_GET[delete_verifikasi])){
      $sql = mysql_query("delete from validasi_pulsa where no_verifikasi='$_POST[ID]'");
      if($sql){ echo "sukses"; }

}

?>