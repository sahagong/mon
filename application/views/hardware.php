<?

$base_URL=$_SERVER['HTTP_HOST'];

echo "
<body>
";

echo "<div style='float:right; text-align:right; width:100%;'><font size=2><B>".date("Y-m-d H:i:s")."</B></font></div>";
echo "
<link rel=stylesheet href='/ci/assets/css/integrated.css' type='text/css'>

<a href='http://$base_URL/ci/index.php/saltstack/hardware/1' target='_blank'>excel download</a>
<table border=1 id='hw'>
<tr id='hw'>
<th width=80 id='hw' scope='col'><B>regist_date</B></th>
<th width=50 id='hw' scope='col'><B>srv_id</B></th>
<th width=80 id='hw' scope='col'><B>bios_release_date</B></th>
<th width=50 id='hw' scope='col'><B>model</B></th>
<th width=50 id='hw' scope='col'><B>cpu</B></th>
<th width=50 id='hw' scope='col'><B>cpu_num</B></th>
<th width=50 id='hw' scope='col'><B>memory</B></th>
<th width=50 id='hw' scope='col'><B>disk_info</B></th>
</tr>
";
$today = date("Y");                       
foreach ($data as $server_value) {
	$body_name = "";
	$cpu_name = "";
	$cpu_number = "";
	$memory_usage = "";
	$disk_info = "";
	$bios_release_date = "";
	$bgcolor = "";
	$server_value_trim = trim($server_value['returns'], '"');
        $server_value_json = json_decode($server_value_trim,true);
        $regist_date = $server_value['rec_date'];
        $srv_id = $server_value['srv_id'];
        foreach( $server_value_json AS $key => $value){
        	switch($key){
                	case 'serverinfo':
                        	foreach( $value AS $key2 => $value2){
                                	switch($key2){
                                        	case 'body_name':
                                                	$body_name = $value2;
                                                        break;
                                                case 'cpu_name':
                                                        $cpu_name = $value2;
                                                        break;
                                                case 'cpu_number':
                                                        $cpu_number = $value2;
                                                        break;
                                                case 'memory_usage':
                                                        $memory_usage = $value2;
                                                        break;
                                                case 'disk_info':
                                                        $disk_info = $value2;
                                                        break;
						case 'bios_release_date':
							$biosrd = $value2;
							$biosrd_array = explode("/",$biosrd);
							$bios_release_date = $biosrd_array[2]."/".$biosrd_array[0]."/".$biosrd_array[1];
							if ( $today - $biosrd_array[2] > 4 ) {
							$bgcolor="bgcolor=red";
							}
							break;
                                        }
                		}
      		}
        }
        echo "<tr id='hw'>";
        echo "<td id='hw' align=center><B><font face='±¼¸²'>".$regist_date."</font></B></td>";
        echo "<td id='hw'><B><font face='±¼¸²'><a href=./server_info.php?server=".$srv_id." target='content1'>".$srv_id."</a></font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='±¼¸²'>".$bios_release_date."</font></B></td>";
        echo "<td id='hw' align=center><B><font face='±¼¸²'>".$body_name."</font></B></td>";
        echo "<td id='hw'><B><font face='±¼¸²'>".$cpu_name."</font></B></td>";
        echo "<td id='hw' align=center><B><font face='±¼¸²'>".$cpu_number."</font></B></td>";
        $memory_usage = round($memory_usage / 1024);
        echo "<td id='hw' align=center><B><font face='±¼¸²'>".$memory_usage."GB</font></B></td>";
        echo "<td id='hw'><B><font face='±¼¸²'>".$disk_info."</font></B></td>";
        echo "</tr>";
}
echo "</table>
</body>";

?>
