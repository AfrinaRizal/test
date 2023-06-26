<?php
session_start();
include "include/checkaccess.php";
include "config.php";
if($_GET['doc']=='11') $table = "sebutharga";
else $table = "tender";
$sql = "SELECT nama as custname,norujuk as icno,xbayaran.rujukan,bil_".$table.",tcidb,tpkk,tkkm,dbill,".$table.".kodbidang FROM xbayaran
INNER JOIN sip_mbjb.bill ON xbayaran.noakaun = bill.cRujukan AND SUBSTR(bill.dbill FROM 1 FOR 4) = '".$_GET['tahun']."'
LEFT JOIN sip_mbjb.lesen ON lesen.FK_pelanggan = bill.FK_pelanggan
INNER JOIN spm_mbjb.daftar ON daftar.rujukan = xbayaran.FK_pelanggan
INNER JOIN ".$table." ON ".$table."_id = FK_dokumen
WHERE noakaun = '".$_GET['noakaun']."' AND xbayaran.tahun = '".$_GET['tahun']."' AND xbayaran.statusbil <> 'BATAL'
ORDER BY rujukan ASC";
//echo $sql;
$query = mysqli_query($con,$sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" media="print">
.dontprint
{ display: none; padding-left:5px; }
</style>

<style type="text/css">
body {
	margin: 0; 	padding: 0;
	/*font: normal .60em/1.6em Verdana, Tahoma, sans-serif;*/
	font: normal .60em/1.6em  Arial, Helvetica, sans-serif;
	color: #000000;
	background: #FFFFFF;
	text-align: LEFT;	
}

.button{
	font-size:11px;
	padding: 0 5px;
	margin: 0 3px;
	border:2px solid #09F;
	background:#FFF;
	height:30px;
	color:#09F;
	border-radius: 10px;
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
	box-shadow: 1px 1px 5px #333;
}
.button:hover{
	font-size:11px;
	font-weight:bold;	
	border:2px solid #F60;
	background:#FFFFFF;
	color:#F60;
	cursor:pointer;
}

#tag{
	 background:#CCC;
	 text-align:center;
}
#content{
	/*border:1px solid #333333;*/
	float:left;
	margin-top:7px;
	margin-left:5px;
	margin-bottom:45px;
	width:300px;
	height:80px;
}
#content1{
	/*border:1px solid #333333;*/
	float:right;
	margin-top:7px;
	margin-bottom:45px;
	width:300px;
	height:80px;
}
#blank{
	/*border:1px solid #FFFFFF;*/
	float:left;
	margin-left:7px;
	margin-bottom:45px;
	width:300px;
	height:80px;
}
#content p{
	padding:0 3px;
}
#tcontent td,th{
	border-top:#000 solid 1px;
}
#tcontent th{
	text-align:center;
}
</style>

<title>Sticker i-Perolehan</title>
</head>

<body>
<div class="dontprint">
<p style=" padding-left: 10px;"><span><input type="button" name="print" value="Cetak" onclick="print()" class="button" /></span>
<span><input type="button" name="close" value="Kembali" onclick="window.close()" class="button" /></span></p>
<p style=" padding-left: 10px; font-size:12px;"><strong>Kedudukan Stiker Pertama : </strong>
<select name="nombor" id="nombor" onchange="window.location.href ='sticker.php?noakaun=<?php echo $_GET['noakaun']; ?>&tahun=<?php echo $_GET['tahun']; ?>&num='+this.value+'&doc=<?php echo $_GET['doc']; ?>'">
<option <?php if($_GET['num'] == 1) echo 'selected'; ?> value="1">KIRI</option>
<option <?php if($_GET['num'] == 2) echo 'selected'; ?>  value="2">KANAN</option>
</select></p>
</div>
<?php
$num = $_GET['num'];
if($num == 2){
?>
<div id="blank">
</div>
<?php	
}
$bil = 1;
$stop = "";
while($row = mysqli_fetch_array($query)){
	if($num == 3) $num = 1;
	
	
	if($num % 2 != 0) $div = "content";
	else $div = "content1";
	
	if($bil == 9){
		$stop = '<div style="page-break-after:always;"></div>';
	}
	else $stop = "";
	
	$num++;
	$bil++;
	
?>
<?php echo $stop; ?>
<div id="<?php echo $div; ?>" >
<table style="text-transform:uppercase;"><tr><td>
<strong><?php echo $row['custname']; ?> - <?php echo $row['icno']; ?></strong>
<br />
<?php if($row['kodbidang'] == '' || $row['kodbidang'] == '-'){ ?>
T/LESEN : [ <strong><?php echo date('d-m-Y',strtotime($row['tcidb'])); ?></strong> ]  T/TARAF B/PUTRA : [ <strong><?php echo date('d-m-Y',strtotime($row['tpkk'])); ?></strong> ]
<?php } 
else{ ?>
T/LESEN : [ <strong><?php echo date('d-m-Y',strtotime($row['tkkm'])); ?></strong> ]  T/TARAF B/PUTRA : [ <strong><?php echo date('d-m-Y',strtotime($row['tkkm'])); ?></strong> ]
<?php } ?>
<br />
T/DOKUMEN :[ <strong><?php echo date('d-m-Y',strtotime($row['dbill'])); ?></strong> ]  [ <strong><?php echo $row['bil_'.$table]; ?></strong> ]<br />
<img style="padding-top:3px;" src="barcode.php?text=<?php echo $row['rujukan']; ?>" height="15" width="130" /><?php echo "KOD: ".$row['rujukan']; ?>
</td></tr>
</table>
</div>
<?php
}
?>

</body>
</html>