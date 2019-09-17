<?

$base_URL=$_SERVER['HTTP_HOST'];

echo "
<link rel='stylesheet' href='http://$base_URL/ci/application/views/css/integrated.css' type='text/css'>
<center><b><font size=5>".$minion_name."</font></b></center><br>
<table class='total' border=1>
<tr>
<th width=100><b>DATE</b></th>
<th width=100><b>NAME</b></th>
<th width=100><b>TYPE</b></th>
<th width=100><b>EVENT</b></th>
</tr>";
foreach($alert_data as $result) {
	echo "<tr>";
	echo "<td align=center>".$result['ipmi_date']." ".$result['ipmi_time']."</td>";
	echo "<td align=center>".$result['ipmi_name']."</td>";
	echo "<td align=center>".$result['ipmi_type']."</td>";
	echo "<td> ".$result['ipmi_event']."</td>";
	echo "</tr>";
}
echo "</table>";



?>
