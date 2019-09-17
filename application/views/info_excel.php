<?
header( "Content-type: application/vnd.ms-excel; charset=euc-kr" );
header( "Expires: 0" );
header( "Cache-Control: must-revalidate, post-check=0,pre-check=0" );
header( "Pragma: public" );
header( "Content-Disposition: attachment; filename=hardware.xls" );

echo "
<body>
";

echo "<div style='float:right; text-align:right; width:100%;'><font size=2><B>".date("Y-m-d H:i:s")."</B></font></div>";
echo "

<table border=1 id='hw'>
<tr id='hw'>
<th width=10 id='hw' scope='col'><B>num</B></th>
<th width=80 id='hw' scope='col'><B>regist_date</B></th>
<th width=50 id='hw' scope='col'><B>srv_id</B></th>
<th width=50 id='hw' scope='col'><B>ip</B></th>
<th width=50 id='hw' scope='col'><B>uptime</B></th>
<th width=50 id='hw' scope='col'><B>system(time)</B></th>
<th width=50 id='hw' scope='col'><B>One month login</B></th>
<th width=80 id='hw' scope='col'><B>unknown user</B></th>
<th width=80 id='hw' scope='col'><B>id:0 group</B></th>
<th width=80 id='hw' scope='col'><B>passwd complex</B></th>
<th width=80 id='hw' scope='col'><B>ldap</B></th>
<th width=80 id='hw' scope='col'><B>otp</B></th>
<th width=80 id='hw' scope='col'><B>ssh rootlogin</B></th>
<th width=80 id='hw' scope='col'><B>port:process</B></th>
<th width=80 id='hw' scope='col'><B>firewall rule(any open)</B></th>
<th width=80 id='hw' scope='col'><B>iptables(ON/OFF)</B></th>
</tr>
";
$today = date("Y");                       
$n = 1 ; 
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
	$line = "";
	$line11 = "";
	$line12 = "";
	$line13 = "";
	$line14 = "";
	$line15 = "";
	$line2 = "";
	$line3 = "";
	$line4 = "";
	$line41 = "";
	$line5 = "";
	$line51 = "";
	$line6 = "";
	$line7 = "";
	#$port_process_info = $server_value['port_process_info'];
        foreach( $server_value_json AS $key => $value){
                #echo "$key" ;
                switch($key){
                        case 'port_process_info':
                                foreach( $value AS $key2 => $value2){
                                        if($line){
                                        $line = $line . "," . "$key2" . ":" . "$value2" . "<br>";
                                        }
                                        else{
                                        $line = $line . "$key2" . ":" . "$value2" . "<br>";
                                        }
                                        #$line = ;
                                }
                }
                #echo "$key" ;
                switch($key){
                        case 'firewall_rule_check':
                                foreach( $value AS $key2 => $value2){
                                        $line2 = $line2 . "$value2" . "<br>";
                                }
                }
                switch($key){
                        case 'date':
                                #foreach( $value AS $key2 ){
                                foreach( $value AS $key2 => $value2){
                                        $line11 = $line11 . "$value2" . "<br>";
                                }
                                #}
                }
                switch($key){
                        case 'update':
                                #foreach( $value AS $key2 ){
                                foreach( $value AS $key2 => $value2){
                                        $line13 = $line13 . "$value2" . "<br>";
                                }
                                #}
                }
                switch($key){
                        case 'last_login':
                                #foreach( $value AS $key2 ){
                                foreach( $value AS $key2 => $value2){
                                        $line12 = $line12 . "$value2" . "<br>";
                                }
                                #}
                }
                switch($key){
                        case 'ipaddr':
                                foreach( $value AS $key2 => $value2){
                                        $line15 = $line15 . "$value2" . "<br>";
                                }
                }
                switch($key){
                        case 'iptables_check':
                                foreach( $value AS $key2 => $value2){
                                        $line3 = $line3 . "$value2" . "<br>";
                                }
                }
                switch($key){
                        case 'user_check':
                                foreach( $value AS $key2 => $value2){
                                        if($line4){
                                        $line4 = $line4 . ", " . "$value2" ;
                                        }
                                        else{
                                        $line4 = $line4 . "$value2" ;
                                        }
                                }
                }
                switch($key){
                        case 'group_check':
                                foreach( $value AS $key2 => $value2){
                                        if($line41){
                                        $line41 = $line41 . ", " . "$value2" ;
                                        }
                                        else{
                                        $line41 = $line41 . $value2 ;
                                        }
                                }
                }
                switch($key){
                        case 'passwd_complex_check':
                                foreach( $value AS $key2 => $value2){
                                        $line51 = $line51 . "$value2" . "<br>";
                                }
                }
                switch($key){
                        case 'ldap_check':
                                foreach( $value AS $key2 => $value2){
                                        $line5 = $line5 . "$value2" . "<br>";
                                }
                }
                switch($key){
                        case 'otp_check':
                                foreach( $value AS $key2 => $value2){
                                        $line6 = $line6 . "$value2" . "<br>";
                                }
                }
                switch($key){
                        case 'ssh_root_check':
                                foreach( $value AS $key2 => $value2){
                                        $line7 = $line7 . "$value2" . "<br>";
                                }
                }
        }
        echo "<tr id='hw'>";
        echo "<td id='hw' align=center><B><font face='����'>".$n."</font></B></td>";
        echo "<td id='hw' align=center><B><font face='����'>".$regist_date."</font></B></td>";
        echo "<td id='hw'><B><font face='����'>".$srv_id."</a></font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line15."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line13."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line11."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line12."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line4."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line41."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line51."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line5."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line6."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line7."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line2."</font></B></td>";
        echo "<td id='hw' align=center ".$bgcolor." ><B><font face='����'>".$line3."</font></B></td>";
        echo "</tr>";
	$n = $n + 1 ; 
}
echo "</table>
</body>";

?>
