<?
	$kode = $_POST[kode];
	ini_set('max_execution_time', 300);
	 
	exec("gammu -c gammurc getussd $kode", $hasil);
	 
	// proses filter hasil output
	for ($i=0; $i<=count($hasil)-1; $i++)
	{
	   if (substr_count($hasil[$i], 'Service reply') > 0) $index = $i;
	}
	 
	// menampilkan sisa pulsa	 
	echo $hasil[$index];
?>