<?php
include "connect.php";


if(isset($_GET[inbox])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from inbox");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("select * from inbox order by ID desc limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

if(isset($_GET[temp_outbox])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from temp_outbox");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("select * from temp_outbox order by ID asc limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

if(isset($_GET[outbox])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from outbox");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("select * from outbox order by SendingDateTime desc limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}


if(isset($_GET[senditem])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from sentitems");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("select * from sentitems order by SendingDateTime desc limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

if(isset($_GET[format_sms])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from format_sms");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("select * from format_sms order by format limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

//modul phone book 
if(isset($_GET[phonebook])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from pbk");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("select a.GroupID,a.Name,a.Number,b.Name as GroupName from pbk a,pbk_groups b 
	                   where a.GroupID=b.ID order by a.Name asc limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

if(isset($_GET[phone_groups])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from pbk_groups");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("SELECT * FROM pbk_groups order by Name asc limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

if(isset($_GET[user])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from user");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("SELECT * FROM user order by Name asc limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

if(isset($_GET[operator])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from operator");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("SELECT * FROM operator order by operator_id asc limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

if(isset($_GET[operator_product])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from operator_product");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("SELECT a.*,b.operator_name FROM operator_product a,operator b where a.operator_id=b.operator_id limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

if(isset($_GET[prefix])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from prefix");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("SELECT a.*,b.operator_name FROM prefix a,operator b where a.operator_id=b.operator_id order by prefix asc limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

if(isset($_GET[verifikasi])){
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
    // ...
    $rs = mysql_query("select count(*) from validasi_pulsa");
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
     
    $rs = mysql_query("SELECT * FROM validasi_pulsa order by no_verifikasi asc limit $offset,$rows");	
     
    $items = array();
    while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
    }
    $result["rows"] = $items;
     
    echo json_encode($result);
}

?>
