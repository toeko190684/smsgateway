<?php
include "connect.php";


if(isset($_GET[operator])){
    $rs = mysql_query("select * from operator order by operator_id");     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

?>