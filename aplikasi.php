<?php
session_start();
include "connect.php";

//cek lagi ke tabel user apakah session cocok dengan data user
$sql = mysql_query("select * from user where Name='$_SESSION[username]' and sandi='$_SESSION[password]'");
$r = mysql_num_rows($sql);
if($r>0){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PT. MORINAGA KINO INDONESIA - SMS GATEWAY</title>
	<link rel="stylesheet" type="text/css" href="themes/metro-green/easyui.css">
	<link rel="stylesheet" type="text/css" href="themes/icon.css">
	<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="jquery.easyui.min.js"></script>
	<script>
		$(function(){			
			$('#product_operator_id').combogrid({
				panelWidth:450,
				idField:'operator_id',
				textField:'operator_id',
				url:'master.php?operator',
				columns:[[
						{field:'operator_id',title:'Operator ID',width:100},
						{field:'operator_name',title:'Operator Name',width:100},
						{field:'smscenter1',title:'SMS Center 1',width:100},
						{field:'smscenter2',title:'SMS Center 2',width:100}
				]]			
			});
			
			$('#prefix_operator_id').combogrid({
				panelWidth:450,
				idField:'operator_id',
				textField:'operator_id',
				url:'master.php?operator',
				columns:[[
						{field:'operator_id',title:'Operator ID',width:100},
						{field:'operator_name',title:'Operator Name',width:100},
						{field:'smscenter1',title:'SMS Center 1',width:100},
						{field:'smscenter2',title:'SMS Center 2',width:100}
				]]			
			});
			
			
			$('#inbox').datagrid({
				title:'Inbox',
				width:950,
				height:150,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				url:'data.php?inbox',
				sortName: 'ReceivingDateTime',
				sortOrder: 'desc',
				idField:'ID',
				columns :[[
					{field:'ReceivingDateTime',title:'Receiving Date Time',width:120,sortable:true},
					{field:'SenderNumber',title:'Sender',width:120,rowspan:2},
					{field:'TextDecoded',title:'Message',width:500,rowspan:2}
				]],
				toolbar :[{
                                        text : 'Reply SMS',
                                        iconCls : 'icon-undo',
                                        handler : function(){
                                                var hp =  $('#inbox').datagrid('getSelected');
                                                if(hp){
                                                       $('#sms').dialog('open');
                                                       $('#hp').val(hp.SenderNumber);
                                                }
                                        }
                                },{
                                        text : 'Forward SMS',
                                        iconCls : 'icon-redo',
                                        handler : function(){
                                                var hp =  $('#inbox').datagrid('getSelected');
                                                if(hp){
                                                       $('#sms').dialog('open');
                                                       $('#sms_message').val(hp.TextDecoded);
                                                }
                                        }
                                }],
				pagination:true,
				rownumbers:true,
				onClickRow: function(rowIndex,rowData){
							var x = $(this).datagrid('getSelected');
							var pesan = 'Sender : '+x.SenderNumber+'\nTgl terima : '+x.ReceivingDateTime+'\n\n\n'+'Pesan : '+x.TextDecoded;
							$('#detail_pesan').val(pesan);
				}
			});
			

            $('#temp_outbox').datagrid({
				title:'Temp Outbox',
				width:950,
				height:350,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				url:'data.php?temp_outbox',
				sortName: 'SendingDateTime',
				sortOrder: 'desc',
				idField:'SendingDateTime',
				columns :[[
					{field:'SendingDateTime',title:'Sending Date Time',width:120,sortable:true},
					{field:'DestinationNumber',title:'Destination Number',width:120,rowspan:2},
					{field:'TextDecoded',title:'Message',width:500,rowspan:2}
				]],
				pagination:true,
				rownumbers:true
			});

			$('#outbox').datagrid({
				title:'Outbox',
				width:950,
				height:350,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				url:'data.php?outbox',
				sortName: 'SendingDateTime',
				sortOrder: 'desc',
				idField:'SendingDateTime',
				columns :[[
					{field:'SendingDateTime',title:'Sending Date Time',width:120,sortable:true},
					{field:'DestinationNumber',title:'Destination Number',width:120,rowspan:2},
					{field:'TextDecoded',title:'Message',width:500,rowspan:2}
				]],
				pagination:true,
				rownumbers:true
			});

			$('#senditem').datagrid({
				title:'Send Item',
				width:950,
				height:350,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				multiple : false,
				url:'data.php?senditem',
				sortName: 'SendingDateTime',
				sortOrder: 'desc',
				idField:'SendingDateTime',
				columns :[[
					{field:'SendingDateTime',title:'Sending Date Time',width:120,sortable:true},
					{field:'DeliveryDateTime',title:'Delivery Date Time',width:120},
					{field:'DestinationNumber',title:'Destination Number',width:120,rowspan:2},
					{field:'Name',title:'Name',width:170,rowspan:2},
					{field:'TextDecoded',title:'Message',width:400,rowspan:2},
					{field:'Status',title:'Status',width:120,rowspan:2}
				]],
				pagination:true,
				rownumbers:true
			});
			
			$('#format_sms').datagrid({
				title:'Format SMS',
				width:950,
				height:350,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				multiple : false,
				url:'data.php?format_sms',
				sortName: 'format',
				sortOrder: 'desc',
				idField:'format',
				columns :[[
					{field:'format',title:'Format',width:60,sortable:true},
					{field:'status',title:'Status',width:60,rowspan:2},
					{field:'tanda',title:'Tanda Pemisah',width:80,rowspan:2},
					{field:'email1',title:'email1',width:150,rowspan:2},
					{field:'email2',title:'email2',width:150,rowspan:2},
					{field:'sukses',title:'Reply Sukses',width:350,rowspan:2},
					{field:'error',title:'Reply Error',width:350,rowspan:2}
					
				]],
				toolbar :[{
                                        text : 'Add Format',
                                        iconCls : 'icon-add',
                                        handler : function(){
                                                $('#kode').val("");
                                                $('#status').val("");
                                                $('#tanda').val("");
												$('#email1').val("");
												$('#email2').val("");
                                                $('#sukses').val("");
                                                $('#error').val("");
                                                $('#dlg_format').dialog('open');
                                        }
                                },{
                                        text : 'Edit Format',
                                        iconCls : 'icon-edit',
                                        handler : function(){
                                                var x = $('#format_sms').datagrid('getSelected');
                                                if(x){
                                                      $('#dlg_format').dialog('open');
                                                      $('#kode').val(x.format);
                                                      $('#status').val(x.status);
                                                      $('#tanda').val(x.tanda);
													  $('#email1').val(x.email1);
													  $('#email2').val(x.email2);
                                                      $('#sukses').val(x.sukses);
                                                      $('#error').val(x.error);

                                                }
                                        }
                                },{
                                        text : 'Delete Format',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                                var x = $('#format_sms').datagrid('getSelected');
                                                $.post('proses.php?delete_format',{format : x.format },function(data){
                                                      if(data=='sukses'){
                                                                 //$.messager.alert("Message","Data Deleted..","info");
                                                                 $('#format_sms').datagrid('reload');
                                                      }else{
                                                                 $.messager.alert("Message","Deleted data Failed..","error");
                                                      }
                                                });
                                        }
                                }],
				pagination:true,
				rownumbers:true
			});
			
			$('#phonebook').datagrid({
				title:'Phonebook',
				width:950,
				height:350,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				multiple : false,
				url:'data.php?phonebook',
				sortName: 'GroupID',
				sortOrder: 'desc',
				idField:'GroupID',
				columns :[[
					{field:'GroupID',title:'Group ID',width:100,sortable:true},
					{field:'GroupName',title:'Group Name',width:200},
					{field:'Name',title:'Contact Name',width:300,rowspan:2},
					{field:'Number',title:'Handphone',width:200,rowspan:2}
				]],
				toolbar :[{
                                        text : 'Add Phonebook',
                                        iconCls : 'icon-add',
                                        handler : function(){
                                                $('#pbk_group').val("");
                                                $('#pbk_name').val("");
                                                $('#pbk_hp').val("");
                                                $('#pbk_phonebook').dialog('open');
                                        }
                                },{
                                        text : 'Edit Phonebook',
                                        iconCls : 'icon-edit',
                                        handler : function(){
                                                var x = $('#phonebook').datagrid('getSelected');
                                                if(x){
                                                      $('#pbk_phonebook').dialog('open');
                                                      $('#pbk_group').val(x.GroupID);
                                                      $('#pbk_name').val(x.Name);
                                                      $('#pbk_hp').numberbox('setValue',x.Number);
                                                }
                                        }
                                },{
                                        text : 'Delete Phonebook',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                                var x = $('#phonebook').datagrid('getSelected');
                                                $.post('proses.php?delete_phonebook',{pbk_name : x.Name, pbk_hp : x.Number},function(data){
                                                      if(data=='sukses'){
                                                                 //$.messager.alert("Message","Data Deleted..","info");
                                                                 $('#phonebook').datagrid('reload');
                                                      }else{
                                                                 $.messager.alert("Message","Deleted data Failed..","error");
                                                      }
                                                });
                                        }
                                }],
				pagination:true,
				rownumbers:true
			});
			
			$('#phone_group').datagrid({
				title:'Phonebook Group',
				width:950,
				height:350,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				multiple : false,
				url:'data.php?phone_groups',
				sortName: 'ID',
				sortOrder: 'desc',
				idField:'ID',
				columns :[[
					{field:'ID',title:'Group ID',width:100,sortable:true},
					{field:'Name',title:'Group Name',width:300,rowspan:2}
				]],
				toolbar :[{
                                        text : 'Add Group',
                                        iconCls : 'icon-add',
                                        handler : function(){
                                                $('#group_name').val("");
                                                $('#pbk_groups').dialog('open');
                                        }
                                },{
                                        text : 'Edit Group',
                                        iconCls : 'icon-edit',
                                        handler : function(){
                                                var x = $('#phone_group').datagrid('getSelected');
                                                if(x){
                                                      $('#pbk_groups').dialog('open');
                                                      $('#group_name').val(x.Name);
                                                }
                                        }
                                },{
                                        text : 'Delete Group',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                                var x = $('#phone_group').datagrid('getSelected');
                                                $.post('proses.php?delete_pbk_group',{ID:x.ID},function(data){
                                                         if(data=='sukses'){
                                                                  //$.messager.alert("Message","Data Deleted..","info");
                                                                  $('#phone_group').datagrid('reload');
                                                         }else{
                                                                  $.messager.alert("Message","Delete Failed..","error");
                                                         }
                                                });
                                        }
                                }],
				pagination:true,
				rownumbers:true
			});
			
			// halaman operator =======================================================================================================
			$('#operator').datagrid({
				title:'Operator',
				width:950,
				height:350,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				multiple : false,
				url:'data.php?operator',
				sortName: 'operator_id',
				sortOrder: 'operator_name',
				idField:'operator_id',
				columns :[[
					{field:'operator_id',title:'Operator ID',width:100,sortable:true},
					{field:'operator_name',title:'Operator Name',width:300,rowspan:2},
					{field:'smscenter1',title:'SMS Center 1',width:300,rowspan:2},
					{field:'smscenter2',title:'SMS Center 2',width:300,rowspan:2}
				]],
				toolbar :[{
                                        text : 'Add Operator',
                                        iconCls : 'icon-add',
                                        handler : function(){
                                                $('#operator_id').val("");
												$('#operator_name').val("");
												$('#smscenter1').val("");
												$('#smscenter2').val("");
                                                $('#dlg_operator').dialog('open');
                                        }
                                },{
                                        text : 'Edit Operator',
                                        iconCls : 'icon-edit',
                                        handler : function(){
                                                var x = $('#operator').datagrid('getSelected');
                                                if(x){
                                                      $('#dlg_operator').dialog('open');
                                                      $('#operator_id').val(x.operator_id);
													  $('#operator_name').val(x.operator_name);
													  $('#smscenter1').val(x.smscenter1);
													  $('#smscenter2').val(x.smscenter2);
                                                }
                                        }
                                },{
                                        text : 'Delete Operator',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                                var x = $('#operator').datagrid('getSelected');
                                                $.post('proses.php?delete_operator',{ID:x.operator_id},function(data){
                                                         if(data=='sukses'){
                                                                  //$.messager.alert("Message","Data Deleted..","info");
                                                                  $('#operator').datagrid('reload');
                                                         }else{
                                                                  $.messager.alert("Message","Delete Failed..","error");
                                                         }
                                                });
                                        }
                                }],
				pagination:true,
				rownumbers:true
			});

			// halaman product =======================================================================================================
			$('#operator_product').datagrid({
				title:'Operator Product',
				width:950,
				height:350,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				multiple : false,
				url:'data.php?operator_product',
				sortName: 'product_id',
				sortOrder: 'product_id',
				idField:'product_id',
				columns :[[
					{field:'product_id',title:'Product ID',width:100,sortable:true},
					{field:'operator_name',title:'Operator Name',width:300,rowspan:2},
					{field:'nominal',title:'Nominal',width:300,rowspan:2},
					{field:'harga',title:'Harga',width:300,rowspan:2}
				]],
				toolbar :[{
                                        text : 'Add Product',
                                        iconCls : 'icon-add',
                                        handler : function(){
                                                $('#product_product_id').val("");
												$('#product_operator_id').combogrid('setValue','');
												$('#product_nominal').val("");
												$('#product_harga').val("");
                                                $('#dlg_operator_product').dialog('open');
                                        }
                                },{
                                        text : 'Edit Product',
                                        iconCls : 'icon-edit',
                                        handler : function(){
                                                var x = $('#operator_product').datagrid('getSelected');
                                                if(x){
                                                      $('#dlg_operator_product').dialog('open');
                                                      $('#product_product_id').val(x.product_id);
													  $('#product_operator_id').combogrid('setValue',x.operator_id);
													  $('#product_nominal').val(x.nominal);
													  $('#product_harga').val(x.harga);
                                                }
                                        }
                                },{
                                        text : 'Delete Product',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                                var x = $('#operator_product').datagrid('getSelected');
                                                $.post('proses.php?delete_operator_product',{ID:x.product_id},function(data){
                                                         if(data=='sukses'){
                                                                  $.messager.alert("Message","Data Deleted..","info");
                                                                  $('#operator_product').datagrid('reload');
                                                         }else{
                                                                  $.messager.alert("Message","Delete Failed..","error");
                                                         }
                                                });
                                        }
                                }],
				pagination:true,
				rownumbers:true
			});
			
			// halaman prefix =======================================================================================================
			$('#prefix').datagrid({
				title:'Prefix',
				width:950,
				height:350,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				multiple : false,
				url:'data.php?prefix',
				sortName: 'prefix',
				sortOrder: 'operator_name',
				idField:'prefix',
				columns :[[
					{field:'prefix',title:'Prefix',width:100,sortable:true},
					{field:'operator_id',title:'Operator ID',width:300,rowspan:2},
					{field:'operator_name',title:'Operator Name',width:300,rowspan:2}
				]],
				toolbar :[{
                                        text : 'Add Prefix',
                                        iconCls : 'icon-add',
                                        handler : function(){
                                                $('#prefix_prefix').val("");
												$('#prefix_operator_id').combogrid('setValue','');
                                                $('#dlg_prefix').dialog('open');
                                        }
                                },{
                                        text : 'Edit Prefix',
                                        iconCls : 'icon-edit',
                                        handler : function(){
                                                var x = $('#prefix').datagrid('getSelected');
                                                if(x){
                                                      $('#dlg_prefix').dialog('open');
                                                      $('#prefix_prefix').val(x.prefix);
													  $('#prefix_operator_id').combogrid('setValue',x.operator_id);
                                                }
                                        }
                                },{
                                        text : 'Delete Prefix',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                                var x = $('#prefix').datagrid('getSelected');
                                                $.post('proses.php?delete_prefix',{ID:x.prefix},function(data){
                                                         if(data=='sukses'){
                                                                  $.messager.alert("Message","Data Deleted..","info");
                                                                  $('#prefix').datagrid('reload');
                                                         }else{
                                                                  $.messager.alert("Message","Delete Failed..","error");
                                                         }
                                                });
                                        }
                                }],
				pagination:true,
				rownumbers:true
			});
			
			
			// halaman verifikasi =======================================================================================================
			$('#verifikasi').datagrid({
				title:'Verifikasi',
				width:950,
				height:350,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				multiple : false,
				url:'data.php?verifikasi',
				sortName: 'no_verifikasi',
				sortOrder: 'no_verifikasi',
				idField:'no_verifikasi',
				columns :[[
					{field:'no_verifikasi',title:'No Verifikasi',width:100,sortable:true},
					{field:'nominal',title:'Nominal',width:300,rowspan:2},
					{field:'claim_date',title:'Claim Date',width:300,rowspan:2},
					{field:'hp',title:'HP',width:300,rowspan:2}
				]],
				toolbar :[{
                                        text : 'Add Verifikasi',
                                        iconCls : 'icon-add',
                                        handler : function(){
												$('#no_verifikasi').val("");
												$('#verifikasi_nominal').val("");
												$('#verifikasi_hp').val("");
                                                $('#dlg_verifikasi').dialog('open');
                                        }
                                },{
                                        text : 'Edit Verifikasi',
                                        iconCls : 'icon-edit',
                                        handler : function(){
                                                var x = $('#verifikasi').datagrid('getSelected');
                                                if(x){
                                                      $('#dlg_verifikasi').dialog('open');
                                                      $('#no_verifikasi').val(x.no_verifikasi);
													  $('#verifikasi_nominal').val(x.nominal);
													  $('#verifikasi_claim_date').numberbox('setValue',x.claim_date);
													  $('#verifikasi_hp').val(x.hp);
                                                }
                                        }
                                },{
                                        text : 'Delete Verifikasi',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                                var x = $('#verifikasi').datagrid('getSelected');
                                                $.post('proses.php?delete_verifikasi',{ID:x.no_verifikasi},function(data){
                                                         if(data=='sukses'){
                                                                  //$.messager.alert("Message","Data Deleted..","info");
                                                                  $('#verifikasi').datagrid('reload');
                                                         }else{
                                                                  $.messager.alert("Message","Delete Failed..","error");
                                                         }
                                                });
                                        }
                                }],
				pagination:true,
				rownumbers:true
			});
			
			
			
            $('#user').datagrid({
				title:'User',
				width:950,
				height:350,
				nowrap: false,
				striped: true,
				singleSelect : true,
				fit: true,
				multiple : false,
				url:'data.php?user',
				sortName: 'Name',
				sortOrder: 'desc',
				idField:'Name',
				columns :[[
					{field:'Name',title:'Username',width:200,sortable:true},
					{field:'HP',title:'Handphone',width:150,rowspan:2},
					{field:'email',title:'Email',width:250},
					{field:'sandi',title:'Password',width:300},
					{field:'level',title:'Level',width:100},
				]],
				toolbar :[{
                                        text : 'Add User',
                                        iconCls : 'icon-add',
                                        handler : function(){
                                                $('#username').val("");
                                                $('#user_hp').val("");
                                                $('#email').val("");
                                                $('#password').val("");
                                                $('#level').val("");
                                                $('#dlg_user').dialog('open');
                                        }
                                },{
                                        text : 'Edit User',
                                        iconCls : 'icon-edit',
                                        handler : function(){
                                                var x = $('#user').datagrid('getSelected');
                                                if(x){
                                                      $('#dlg_user').dialog('open');
                                                      $('#username').val(x.Name);
                                                      $('#user_hp').val(x.HP);
                                                      $('#email').val(x.email);
                                                }
                                        }
                                },{
                                        text : 'Delete User',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                                var x = $('#user').datagrid('getSelected');
                                                $.post('proses.php?delete_user',{username:x.Name,user_hp : x.HP},function(data){
                                                         if(data=='sukses'){
                                                                  //$.messager.alert("Message","Data Deleted..","info");
                                                                  $('#user').datagrid('reload');
                                                         }else{
                                                                  $.messager.alert("Message","Delete Failed..","error");
                                                         }
                                                });
                                        }
                                }],
				pagination:true,
				rownumbers:true
			});

		        $('#sms').dialog({
                               buttons : [{
                                        text : 'Send',
                                        iconCls : 'icon-ok',
                                        handler : function(){
                                             $.post('proses.php?reply_sms',{hp : $('#hp').val(),sms_message : $('#sms_message').val() },function(data){
                                                    if(data=='sukses'){
                                                             $.messager.alert("Message","Message Sent..","info");
                                                             $('#sms').dialog('close');
                                                             $('#outbox').datagrid('reload');
                                                    }else{
                                                             $.messager.alert("Message","Message Failed..","error");
                                                    }
                                             });
                                        }
                               },{
                                        text : 'Close',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                             $('#sms').dialog('close');
                                        }
                               }]
                        });
                        
                        $('#dlg_format').dialog({
                               buttons : [{
                                        text : 'Ok',
                                        iconCls : 'icon-ok',
                                        handler : function(){
                                             $.post('proses.php?save_format',{format : $('#kode').val(),status : $('#status').val(),tanda : $('#tanda').val(),email1 : $('#email1').val(),email2 : $('#email2').val(),sukses : $('#sukses').val(),error : $('#error').val() },function(data){
                                                    if(data=='sukses'){
                                                             $.messager.alert("Message","Data Saved..","info");
                                                             $('#dlg_format').dialog('close');
                                                             $('#format_sms').datagrid('reload');
                                                    }else{
                                                             $.messager.alert("Message","Data Failed..","error");
                                                    }
                                             });
                                        }
                               },{
                                        text : 'Close',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                             $('#dlg_format').dialog('close');
                                        }
                               }]
                        });
                        
                        $('#pbk_phonebook').dialog({
                               buttons : [{
                                        text : 'Ok',
                                        iconCls : 'icon-ok',
                                        handler : function(){
                                             $.post('proses.php?phonebook',{pbk_group : $('#pbk_group').val(),pbk_name : $('#pbk_name').val(),pbk_hp : $('#pbk_hp').numberbox('getValue') },function(data){
                                                    if(data=='sukses'){
                                                             //$.messager.alert("Message","Data Saved..","info");
                                                             $('#pbk_phonebook').dialog('close');
                                                             $('#phonebook').datagrid('reload');
                                                    }else{
                                                             $.messager.alert("Message","Saved Failed..","error");
                                                    }
                                             });
                                        }
                               },{
                                        text : 'Close',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                             $('#pbk_phonebook').dialog('close');
                                        }
                               }]
                        });
                        
                        $('#pbk_groups').dialog({
                               buttons : [{
                                        text : 'Ok',
                                        iconCls : 'icon-ok',
                                        handler : function(){
                                             var x = $('#phone_group').datagrid('getSelected');
                                             $.post('proses.php?pbk_groups',{ID:x.ID,group_name : $('#group_name').val() },function(data){
                                                    if(data=='sukses'){
                                                             $.messager.alert("Message","Data Saved..","info");
                                                             $('#pbk_groups').dialog('close');
                                                             $('#phone_group').datagrid('reload');
                                                    }else{
                                                             $.messager.alert("Message","Saved Failed..","error");
                                                    }
                                             });
                                        }
                               },{
                                        text : 'Close',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                             $('#pbk_groups').dialog('close');
                                        }
                               }]
                        });
						
						// dialog untuk operator ================================================================================================================================
						$('#dlg_operator').dialog({
                               buttons : [{
                                        text : 'Ok',
                                        iconCls : 'icon-ok',
                                        handler : function(){
                                             //var x = $('#operator').datagrid('getSelected');
                                             $.post('proses.php?operator',{ID:$('#operator_id').val(),operator_name : $('#operator_name').val(), smscenter1 : $('#smscenter1').val(),smscenter2 : $('#smscenter2').val() },function(data){
                                                    if(data=='sukses'){
                                                             $.messager.alert("Message","Data Saved..","info");
                                                             $('#dlg_operator').dialog('close');
                                                             $('#operator').datagrid('reload');
                                                    }else{
                                                             $.messager.alert("Message","Saved Failed..","error");
                                                    }
                                             });
                                        }
                               },{
                                        text : 'Close',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                             $('#dlg_operator').dialog('close');
                                        }
                               }]
                        });
						
						//dialog untuk product operator ==========================================================================================================================
						$('#dlg_operator_product').dialog({
                               buttons : [{
                                        text : 'Ok',
                                        iconCls : 'icon-ok',
                                        handler : function(){
                                             $.post('proses.php?operator_product',{product_id : $('#product_product_id').val() ,
                                                    operator_id : $('#product_operator_id').combogrid('getValue'),nominal : $('#product_nominal').val(),
                                                    harga : $('#product_harga').val() },function(data){
                                                    if(data=='sukses'){
                                                             $.messager.alert("Message","Data Saved..","info");
                                                             $('#dlg_operator_product').dialog('close');
                                                             $('#operator_product').datagrid('reload');
                                                    }else{
                                                             $.messager.alert("Message","Saved Failed..","error");
                                                    }
                                             });
                                        }
                               },{
                                        text : 'Close',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                             $('#dlg_operator_product').dialog('close');
                                        }
                               }]
                        });
						
						//dialog untuk prefix ==========================================================================================================================
						$('#dlg_prefix').dialog({
                               buttons : [{
                                        text : 'Ok',
                                        iconCls : 'icon-ok',
                                        handler : function(){
                                             $.post('proses.php?prefix',{prefix : $('#prefix_prefix').val() ,
                                                    operator_id : $('#prefix_operator_id').combogrid('getValue')},function(data){
                                                    if(data=='sukses'){
                                                             $.messager.alert("Message","Data Saved..","info");
                                                             $('#dlg_prefix').dialog('close');
                                                             $('#prefix').datagrid('reload');
                                                    }else{
                                                             $.messager.alert("Message","Saved Failed..","error");
                                                    }
                                             });
                                        }
                               },{
                                        text : 'Close',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                             $('#dlg_prefix').dialog('close');
                                        }
                               }]
                        });
						
						//dialog untuk verifikasi ==========================================================================================================================
						$('#dlg_verifikasi').dialog({
                               buttons : [{
                                        text : 'Ok',
                                        iconCls : 'icon-ok',
                                        handler : function(){
                                             $.post('proses.php?verifikasi',{no_verifikasi : $('#no_verifikasi').val() ,
                                                    nominal : $('#verifikasi_nominal').val(), 	claim_date : $('#verifikasi_claim_date').datebox('getValue'),
													hp : $('#verifikasi_hp').val()},function(data){
                                                    if(data=='sukses'){
                                                             $.messager.alert("Message","Data Saved..","info");
                                                             $('#dlg_verifikasi').dialog('close');
                                                             $('#verifikasi').datagrid('reload');
                                                    }else{
                                                             $.messager.alert("Message","Saved Failed..","error");
                                                    }
                                             });
                                        }
                               },{
                                        text : 'Close',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                             $('#dlg_verifikasi').dialog('close');
                                        }
                               }]
                        });
						
                        
                        $('#dlg_user').dialog({
                               buttons : [{
                                        text : 'Ok',
                                        iconCls : 'icon-ok',
                                        handler : function(){
                                             $.post('proses.php?user',{username : $('#username').val() ,
                                                    user_hp : $('#user_hp').numberbox('getValue'),email : $('#email').val(),
                                                    password : $('#password').val(),level : $('#level').val() },function(data){
                                                    if(data=='sukses'){
                                                             //$.messager.alert("Message","Data Saved..","info");
                                                             $('#dlg_user').dialog('close');
                                                             $('#user').datagrid('reload');
                                                    }else{
                                                             $.messager.alert("Message","Saved Failed..","error");
                                                    }
                                             });
                                        }
                               },{
                                        text : 'Close',
                                        iconCls : 'icon-cancel',
                                        handler : function(){
                                             $('#dlg_user').dialog('close');
                                        }
                               }]
                        });
                });
				
				function logout(){
					$.messager.confirm('Confirm','Keluar Aplikasi ?',function(r){
						if(r){
							window.location = 'logout.php';
						}
					});
				}
				

                function add_group(){
                      var tujuan = $('#group').val();
                      if($('#tujuan').val()==''){
                            $('#tujuan').val(tujuan)+';';
                      }else{
                            $('#tujuan').val($('#tujuan').val()+';'+tujuan);
                      }
                }


                function add_member(){
                      var tujuan = $('#member').val();
                      if($('#tujuan').val()==''){
                            $('#tujuan').val(tujuan)+';';
                      }else{
                            $('#tujuan').val($('#tujuan').val()+';'+tujuan);
                      }
                }

                function add_hp(){
                      var tujuan = '+62'+($('#handphone').numberbox('getValue'));
                      if($('#tujuan').val()==''){
                            $('#tujuan').val(tujuan)+';';
                      }else{
                            $('#tujuan').val($('#tujuan').val()+';'+tujuan);
                      }
                }

                function send(){
                         var x = $('#tujuan').val();
                         var y = $('#message').val();
                         if(x==''){
                           $.messager.alert("Message","Tujuan pengiriman sms masih kosong!!","warning");
                         }else{
                           if(y=='') {
                                $.messager.alert("Message","Pesan masih kosong!!","warning");
                           }else{
                               $.post('proses.php?kirim_sms',{tujuan : $('#tujuan').val(),message : $('#message').val()},
                                       function(return_data){
                                            $.messager.alert("Message","Message Sent..!!","info");
                                            $('#outbox').datagrid('reload');
	                               });
                           }
                         }
                }

                function cancel(){
                         $('#group').val("");
                         $('#member').val("");
                         $('#handphone').val("");
                         $('#tujuan').val("");
                         $('#message').val("");
                }
				
                
				/*function proses(){
                        if (window.XMLHttpRequest){
                               xmlhttp=new XMLHttpRequest();
                         }else{
                               xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                         }

                         xmlhttp.onreadystatechange=function()
                         {
                               if (xmlhttp.readyState==4 && xmlhttp.status==200){   }
                         }

                         xmlhttp.open("GET","autoreply.php");
                         xmlhttp.send();
                         setTimeout("proses()", 5000);
               }*/

	</script>
<style>
label{
      width : 100px;
      float :left;
}
</style>
</head>
<body class="easyui-layout" onLoad="proses()">
        <div region="east" iconCls="icon-reload" title="Tree Menu" split="true" style="width:180px;">
		<textarea cols=17 rows=30 id='detail_pesan'></textarea>
		<p align = 'center' ><a href='#' id='logout' onclick='logout()' class='easyui-linkbutton' iconCLS='icon-cancel'>Logout</a></p>
	</div>

	<div region="center" id="main" title="PT MORINAGA KINO INDONESIA - SMS GATEWAY" style="overflow:hidden;">
			<div class="easyui-tabs" fit="true" border="false">
            <div title="MAIN"  style="padding:150px;">
                <center><img src="images/smsgateway.jpg" width=400px heigh=400px></center>
			</div>

			<div title="SMS"  style="padding:20px;">			         
                             <div class="easyui-tabs" fit="true" border="true">
                                      <div title="Kirim SMS" style="padding:20px">
                                                        <h3>SMS BROADCAST</h3><br>
                                                        <form style='width:500px'>
                                                        <label>Group :</label><select name=group id=group><option selected></option>
                                                        <?php
                                                             $sql = mysql_query("select * from pbk_groups");
                                                             while($rsql = mysql_fetch_array($sql))
                                                             {
                                                                   echo "<option value='$rsql[Name]'>$rsql[Name]</option>";
                                                             }
                                                        ?>
                                                        </select>&nbsp<a class="easyui-linkbutton" onclick="add_group()">+</a><br><Br>
                                                        <label>Member :</label><select name=member id=member><option selected></option>
                                                        <?php
                                                             $sql = mysql_query("select * from pbk");
                                                             while($rsql = mysql_fetch_array($sql))
                                                             {
                                                                   echo "<option value='$rsql[Name]'>$rsql[Name]</option>";
                                                             }
                                                        ?>
                                                        </select>&nbsp<a class="easyui-linkbutton" onclick="add_member()">+</a><br><br>
                                                        <label>Handphone :</label><input type="text" class="easyui-numberbox" id="handphone"></input>&nbsp
                                                        <a class="easyui-linkbutton" onclick="add_hp()">+</a><Br><Br> Contoh Penulisan Nomor HP : 087883654211<br><br>
                                                        <textarea rows=2 cols=20 name=tujuan id="tujuan" style='width:400px;height:100px'></textarea><br>Message :<br>
                                                        <textarea name=message id="message" style='width:400px;height:100px'></textarea><br><br>
                                                        <a class="easyui-linkbutton" iconCls="icon-ok" onclick="send()">Send</a>
                                                        <a class="easyui-linkbutton" iconCls="icon-cancel" onclick="cancel()">Cancel</a>
                                                        </form>
                                      </div>
                                      <div title="Inbox"  style="padding:20px">
									  <table id="inbox"></table>
                                      </div>
                                      <div title="Temp Outbox"  style="padding:20px">
									  <table id="temp_outbox"></table>
                                      </div>
                                      <div title="Outbox"  style="padding:20px">
									  <table id="outbox"></table>
                                      </div>
                                      <div title="Send Item"   style="padding:20px">
									  <table id="senditem"></table>
                                      </div>
                             </div>
                        </div>
                        
                        <div title="REFERENSI"  style="padding:20px;">
                             <div class="easyui-tabs" fit="true" border="true">
                                      <div title="Format SMS" style="padding:20px">
                                                         <table id="format_sms"></table>
                                      </div>
                             </div>
                        </div>

			<div title="CONTACT"  style="padding:20px;">
				<div class="easyui-tabs" fit="true" border="true">
					<div title="Phonebook"  style="padding:20px">
						  <table id="phonebook"></table>
					</div>
					<div title="Phonebook Group"  style="padding:20px">
						  <table id="phone_group"></table>
					</div>
				</div>
			</div>
			
            <div title="DATA"  style="padding:20px;">
                <div class="easyui-tabs" fit="true" border="true">
                    <div title="Upload Data" style="padding:20px">
                           <table>
                                <tR><td>Pilih Data Upload  :</td><td></td><tD><input type="file" id="file"></td></tr>
                                <tR><td>Pilih Format Undian  :</td><td></td><tD><select id="format">
                                <option selected></option>
                                <?php
                                  $sql = mysql_query("select format from format_sms");
                                  while($rsql = mysql_fetch_array($sql)){
                                              echo "<option value='$rsql[format]'>$rsql[format]</option>"; 
                                   }
                                ?>
                                </format></td></tr>
                                <tr><td colspan="3" ><a href="#" class="easyui-linkbutton" iconCls="icon-ok" >Upload</a></td></tr>
                            </table>
                     </div>
                     <div title="Kupon Undian" style="padding:20px">
                      </div>
                </div>
            </div>
			
			<div title="SETTING" style="padding:20px;">
				<div class="easyui-tabs" fit="true" border="true">
					<div title="Operator"  style="padding:20px">
						  <table id="operator"></table>
					</div>
					<div title="Product"  style="padding:20px">
						  <table id="operator_product"></table>
					</div>
					<div title="Prefix"  style="padding:20px">
						  <table id="prefix"></table>
					</div>
					<div title="Verifikasi"  style="padding:20px">
						  <table id="verifikasi"></table>
					</div>
				</div>
			</div>

			<div title="USERS" style="padding:20px;">
                <table id="user"></table>
			</div>
		</div>
        </div>
        
        <div class="easyui-dialog" id="sms" title="SMS" closed="true" style="padding:20px;width:400px;height:300px">
             <table>
             <tr><td>Handphone : </td><td></td><td><input type="text" id="hp"></td></tr>
             <tr><td>Message : </td><td></td><td><textarea style="width:250px;height:100px" id="sms_message"></textarea></td></tr>
             </table>
        </div>
        
        <div class="easyui-dialog" id="dlg_format" title="Format SMS" closed="true" style="padding:20px;width:450px;height:450px">
             <table>
             <tr><td>Format : </td><td></td><td><input type="text" id="kode"></td></tr>
             <tr><td>Status : </td><td></td><td><select id="status"><option selected></option>
             <option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select></td></tr>
             <tr><td>Tanda : </td><td></td><td><input type="text" id="tanda"></td></tr>
			 <tr><td>Email1 : </td><td></td><td><input type="text" id="email1"></td></tr>
			 <tr><td>Email2 : </td><td></td><td><input type="text" id="email2"></td></tr>
             <tr><td>Reply Sukses : </td><td></td><td><textarea style="width:250px;height:100px" id="sukses"></textarea></td></tr>
             <tr><td>Reply Error : </td><td></td><td><textarea style="width:250px;height:100px" id="error"></textarea></td></tr>
             </table>
        </div>

        <div class="easyui-dialog" id="pbk_phonebook" title="Phonebook" closed="true" style="padding:20px;width:400px;height:200px">
             <table>
             <tr><td>Group  : </td><td></td><td><select id="pbk_group">
             <?php
             $sql = mysql_query("select * from pbk_groups");
             while($rsql = mysql_fetch_array($sql))
             {
                         echo "<option value='$rsql[ID]'>$rsql[Name]</option>";
             }
             ?>
             </select></td></tr>
             <tr><td>Contact Name : </td><td></td><td><input type="text" id="pbk_name"></td></tr>
             <tr><td>Handphone  : </td><td></td><td><input class="easyui-numberbox" type="text" id="pbk_hp"></td></tr>
             <tr><td colspan="3">Selain nomor HP ditulis kode areanya</td></tr>
             </table>
        </div>
        
        <div class="easyui-dialog" id="pbk_groups" title="Groups" closed="true" style="padding:20px;width:400px;height:150px">
             <table>
             <Tr><td>Group Name</td><td></td><td><input type="text" id="group_name"></td></tr>
             </table>
        </div>
		
		<div class="easyui-dialog" id="dlg_operator" title="Operator" closed="true" style="padding:20px;width:350px;height:200px">
             <table>
             <Tr><td>Operator Name</td><td></td><td><input type="hidden" id="operator_id"><input type="text" id="operator_name"></td></tr>
			 <Tr><td>SMS Center 1</td><td></td><td><input type="text" id="smscenter1"></td></tr>
			 <Tr><td>SMS Center 2</td><td></td><td><input type="text" id="smscenter2"></td></tr>
             </table>
        </div>
		
		<div class="easyui-dialog" id="dlg_prefix" title="Prefix" closed="true" style="padding:20px;width:400px;height:200px">
             <table>
             <Tr><td>Prefix</td><td></td><td><input type="text" id="prefix_prefix"></td></tr>
			 <Tr><td>Operator ID</td><td></td><td><input type='text' id='prefix_operator_id'></td></tr>
             </table>
        </div>
		
		<div class="easyui-dialog" id="dlg_operator_product" title="Operator Product" closed="true" style="padding:20px;width:400px;height:250px">
             <table>
             <Tr><td>Product ID</td><td></td><td><input type="text" id="product_product_id"></td></tr>
			 <Tr><td>Operator ID</td><td></td><td><input type='text' id='product_operator_id'></td></tr>
			 <Tr><td>Nominal</td><td></td><td><input type="text" id="product_nominal"></td></tr>
			 <Tr><td>Harga</td><td></td><td><input type="text" id="product_harga"></td></tr>
             </table>
        </div>
		
		<div class="easyui-dialog" id="dlg_verifikasi" title="Verifikasi" closed="true" style="padding:20px;width:400px;height:250px">
             <table>
             <Tr><td>No. Verifikasi</td><td></td><td><input type="text" id="no_verifikasi"></td></tr>
			 <Tr><td>Nominal</td><td></td><td><input type='text' id='verifikasi_nominal'></td></tr>
			 <Tr><td>Claim Date</td><td></td><td><input type="text" id="verifikasi_claim_date" class='easyui-datebox'></td></tr>
			 <Tr><td>Handphone</td><td></td><td><input type="text" id="verifikasi_hp"></td></tr>
             </table>
        </div>
        
        <div class="easyui-dialog" id="dlg_user" title="User" closed="true" style="padding:20px;width:430px;height:270px">
        <table>
        <tr><td>Username</td><td></td><td><input type="text" id="username"></td></tr>
        <tr><td>Handphone</td><td></td><td><input class="easyui-numberbox" id="user_hp"></td></tr>
        <tr><td>Email</td><td></td><td><input type="text" id="email" style="width:300px"></td></tr>
        <tr><td>Password</td><td></td><td><input type="password" id="password"></td></tr>
        <tr><td>Level</td><td></td><td><select id="level"><option></option><option value="admin">Admin</option>
        <option value="user">User</option></select></td></tr>
        </table>
        </div>

</body>
</html>
<?php
}else{
	header('location:login.php');
}
?>