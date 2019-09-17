<?

$base_URL=$_SERVER['HTTP_HOST'];

echo "
<link rel='stylesheet' href='http://$base_URL/ci/application/views/css/integrated.css' type='text/css'>
<center><b><font size=5>UNCHECKED PROCESS</font></b></center><br>
<table class='total' border=1>
<tr>
<th width=250><b>HOST</b></th>
<th width=100><b>DATE</b></th>
<th width=100><b>UNCHECKED PROCESS</b></th>
</tr>
";

foreach($prcess_data as $result) {
	$returns_json = str_replace(array("\n","\r")," ",$result['returns']);
	$returns_array = json_decode($returns_json,true);
	$process_array = explode (" ", $returns_array['processlist']);
	foreach ($process_array as $process) {
		
	}
	echo "<tr>";
	echo "<td>".$result['srv_id']."</td>";
	echo "<td>".$result['rec_date']."</td>";
	if ($returns_array['grains'] != "") {
		
	}
	echo "<td>".$returns_array['processlist']."</td>";
	echo "</tr>";
}
echo "</table>";


?>
