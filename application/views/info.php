<?
$base_URL=$_SERVER['HTTP_HOST'];

echo "
<body>
";

echo "<div style='float:right; text-align:right; width:100%;'><font size=2><B>".date("Y-m-d H:i:s")."</B></font></div>";
echo "
<a href='http://$base_URL/ci/index.php/saltstack/info/1' target='_blank'>excel download</a>
<link rel=stylesheet href='/ci/assets/css/integrated.css' type='text/css'>

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
<th width=80 id='hw' scope='col'><B>id:0 user/group</B></th>
<th width=80 id='hw' scope='col'><B>login tmout</B></th>
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
	$line71 = "";
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
                switch($key){
                        case 'sess_time':
                                foreach( $value AS $key2 => $value2){
                                        $line71 = $line71 . "$value2" . "<br>";
                                }
                }
        }
        echo "<tr id='hw'>";
        echo "<td id='hw' align=center><B><font face='±¼¸²'>".$n."</font></B></td>";
        echo "<td id='hw' align=center><B><font face='±¼¸²'>".$regist_date."</font></B></td>";
        echo "<td id='hw'><B><font face='±¼¸²'><a href=http://$base_URL/index_graph.php?txt=".$srv_id." target='content1'>".$srv_id."</a></font></B></td>";
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line15."</font></B></td>";
	if (preg_match("/days/i","$line13")){
		$bgcolor="";
		$str=str_replace("days","","$line13");

		if ($str < 5 ) { 
			$bgcolor="purple";
		}
	}else{
		$bgcolor="purple";
	}
	
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line13."</font></B></td>";
	$bgcolor="";

	# system time 	
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line11."</font></B></td>";
	
	# One month login
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line12."</font></B></td>";

	# unknown user
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line4."</font></B></td>";

	# id:0 group 
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line41."</font></B></td>";

	# sess_time
	if (preg_match("/OFF/i","$line71")){ $bgcolor="red"; }else{ $bgcolor=""; }
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line71."</font></B></td>";
	$bgcolor="";

	# passwd complex 
	if (preg_match("/OFF/i","$line51")){ $bgcolor="red"; }else{ $bgcolor=""; }
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line51."</font></B></td>";
	$bgcolor="";

	# ldap setting 
	if (preg_match("/OFF/i","$line5")){ 
		if ( $srv_id == "backup8-251" or $srv_id == "backup_master" or $srv_id == "backup_media" or $srv_id == "gbackup_master" or $srv_id == "gbackup_media" or  $srv_id == "kbackup_master" or  $srv_id == "kbackup_media" or $srv_id == "netbackup5.gabia.com"or $srv_id == "netbackup6.gabia.com" ) { 
		$bgcolor="";
		} else { $bgcolor="red"; } 
	}else { $bgcolor=""; }
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line5."</font></B></td>";
	$bgcolor="";

	# otp setting 
	if (preg_match("/OFF/i","$line6")){ $bgcolor="red"; }else{ $bgcolor=""; }
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line6."</font></B></td>";
	$bgcolor="";

	# ssh root login
	if (preg_match("/ON/i","$line7")){ $bgcolor="red"; }else{ $bgcolor=""; }
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line7."</font></B></td>";
	$bgcolor="";

	# port_process 
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line."</font></B></td>";

	# firewall rule(any)
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line2."</font></B></td>";

	# iptables setting 
	if (preg_match("/OFF/i","$line3")){
		if ( $srv_id == "backup_master" or $srv_id == "backup_media" or $srv_id == "gbackup_master" or $srv_id == "gbackup_media" or  $srv_id == "kbackup_master" or  $srv_id == "kbackup_media" or $srv_id == "netbackup5.gabia.com"or $srv_id == "netbackup6.gabia.com" ) { 
		$bgcolor="";
		} else { $bgcolor="red"; } 
		
	}else{
		$bgcolor="";
	}
        echo "<td id='hw' align=center bgcolor=$bgcolor><B><font face='±¼¸²'>".$line3."</font></B></td>";
	$bgcolor="";
        echo "</tr>";
	$n = $n + 1 ; 
}
echo "</table>
</body>";

?>
