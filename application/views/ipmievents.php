<?

$file_handle = fopen($minion_list_file,"r");

$base_URL=$_SERVER['HTTP_HOST'];


echo "
<link rel='stylesheet' href='http://$base_URL/ci/application/views/css/integrated.css' type='text/css'>
<center><b><font size=5>IPMI EVENTS</font></b></center><br>
<table class='total' border=1>
<tr>
<th width=250><b>HOST</b></th>
<th width=100><b>STATUS</b></th>
<th width=100><b>DATE</b></th>
<th><b>EVENT</b></th>
</tr>
";

while(!feof($file_handle)) {

	$minion = fgets($file_handle);
	if ( $minion ){
	$minion = trim($minion);	
	echo "<tr>";
	echo "<td><a href='http://$base_URL/ci/index.php/saltstack/ipmievents/".$minion."' target='_blank'>".$minion."</td>";
	get_ipmi_status($minion,$alert_data);
	echo "</tr>";
	}

}

echo "</table>";

function get_ipmi_status($minion,$alert_data) {
	$checker=0;
	foreach($alert_data as $result) {
		if ( ($result['minion_name'] == $minion) && ($checker == 0) ) {
			$checker=1;
			echo "<td align=center><font color=red ><b>BAD</b></td>";
			echo "<td align=center>".$result['ipmi_date']."</td>";
			echo "<td>".$result['ipmi_event']."</td>";
			break;
		}
	}
	if ( $checker == 0 ) {
	echo "<td align=center><font color=green >GOOD</td>";
	echo "<td align=center>-</td>";
	echo "<td align=center>-</td>";
	}
}


?>
