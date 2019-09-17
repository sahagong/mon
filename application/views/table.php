<?

header("Content-Type: text/html; charset=euc-kr");

echo "<tr><td><font color=green size=5><B>".date("Y-m-d H:i:s")."</B></font></td>
<link rel=stylesheet href='/home/idcmon/ci/application/views/css/integrated.css' type='text/css'>
<table  border=0>
<tr>";
foreach ($table_header as $headers) { 
	echo "<th id='fn' scope='col'><B>".$headers."</B></th>";
}
echo "</tr>";

$counter=0;
$status=0;
$startlist=$cur_page;
$lastlist=$cur_page + $config['per_page'];
foreach ($alert_data as $row) 
{
        $s_host=$row['srv_id'];
        $date=$row['rec_date'];

        $data = json_decode($row['returns'],true);

        foreach($data as $mon_key => $mon_app) {
		if ($status==1) {
			break;
                }
                if (is_array($mon_app)) {
                        foreach ($mon_app as $key => $value_array) {
			if ($status==1) {
				break;
			}
                                foreach($value_array as $app => $value) {
                                $key_data = $mon_key."(".$key." ".$app.")";
                                if ($mon_key == "cm") {
                                        $key_data = $mon_key."(".$key.")";
                                }
				if ($startlist <= $counter) {
                                echo "<tr align=center>";
                                echo "<td><B><font face='±¼¸²'>".$s_host."</a></font></B></td>";
                                echo "<td><B><font face='±¼¸²'>".$date."s</a></font></B></td>";
                                echo "<td><B><font face='±¼¸²'>".$key_data."</a></font></B></td>";
                                echo "<td><B><font face='±¼¸²'>".$value."</a></font></B></td>";
                                echo "</tr>";
				}
				$counter=$counter+1;
				if ($counter == $lastlist) {
					$status=1;
					break;
				}
                                }
                        }
                }
        }
}
echo "</table>";

$config['num_links'] = 4;
$config['full_tag_open'] = '<tr>';
$config['full_tag_close'] = '</tr>';
$config['first_tag_open'] = '<td width=50>';
$config['first_tag_close'] = '</td>';
$config['last_tag_open'] = '<td width=50>';
$config['last_tag_close'] = '</td>';
$config['num_tag_open'] = '<td width=50>';
$config['num_tag_close'] = '</td>';
$config['cur_tag_open'] = '<td width=50><b>';
$config['cur_tag_close'] = '<b></td>';
$config['next_link'] = FALSE;
$config['prev_link'] = FALSE;

$this->pagination->initialize($config);
echo "<table class='cmevents' border=0>";
echo $this->pagination->create_links();
echo "</table>";

?>
