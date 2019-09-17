<?
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">";
ini_set("error_reporting",(~E_NOTICE) & ini_get("error_reporting"));

echo "<script src='./application/views/ajax.js' language='JavaScript' type='text/javascript'></script>";
echo "<link rel=stylesheet href='/ci/assets/css/integrated.css' type='text/css'>";
echo"
<div id='DB'>";

$uptimecmd="uptime | awk '{print \"CPU Load: \"$10}'";
$uptime=exec($uptimecmd);
$memcmd="free | grep Mem | awk '{print\"Mem used:\"$3 \" free:\" $4 \" cached:\" $7}'";
$mem=exec($memcmd);


echo "<table>
<div style='float:left; text-align:left; width:100%;'><font size=2><B>$uptime &nbsp&nbsp&nbsp&nbsp&nbsp $mem</B></font>
<div style='float:right; text-align:right; width:50%;'><font size=3><B>".date("Y-m-d H:i:s")."</B></font></div>
</table>";

echo "
<table id='Total' border=1>
	<td>
	<div style='float:left; text-align:left; width:100%;'><font size=3><B>count: mysql(m) queue(q) pop(p) web(w) swift(s) couch(c) null(n)</B></font></div>
	</td>
	<td>
	<div style='float:left; text-align:right; width:100%;'><font size=3><B>HOST COUNT</div>
	</td>
	<td>
	<div style='float:left; text-align:right; width:100%;'><b><font size=3>".$host_cnt."</b></div>
	</td>
	<td>
	<font size=3><B><a href=/nominion.php target=\"_blank\">salt_ping No response List</a></B>
	</td>
	<td>
	<b><font size=5 color=red>".$nominion_cnt."</b>
	</td>
	</a></b>
	<td>
	<font size=3><B><a href=/nores.php target=\"_blank\">Gabia_module No response List</a></B>
	</td>
	<td>
	<b><font size=5 color=red>".$nores_cnt."</b>
	</td>
</table>
<br>";

echo '
<table id="Total"  border=0 style="table-layout:fixed">
<tr>
<thead id="Total">
<th width=150 scope="col"><B>host</B></th>
<th width=70 scope="col"><B><a href="javascript:OpenWindow(\'ret_index.php?service='.cpu.'\',\'1100\',\'700\')" style="color:white;" />cpu_load</B></th>
<th width=70 scope="col"><B><a href="javascript:OpenWindow(\'ret_index.php?service='.mem.'\',\'1100\',\'700\')" style="color:white;" />mem</a></B></th>
<th width=70 scope="col"><B><a href="javascript:OpenWindow(\'ret_index_count.php?service='.count.'\',\'1100\',\'700\')" style="color:white;" />count</B></th>
<th width=5 scope="col"><B></B></th>
<th width=150 scope="col"><B>host</B></th>
<th width=70 scope="col"><B><a href="javascript:OpenWindow(\'ret_index.php?service='.cpu.'\',\'1100\',\'700\')" style="color:white;" />cpu_load</B></th>
<th width=70 scope="col"><B><a href="javascript:OpenWindow(\'ret_index.php?service='.mem.'\',\'1100\',\'700\')" style="color:white;" />mem</a></B></th>
<th width=70 scope="col"><B><a href="javascript:OpenWindow(\'ret_index_count.php?service='.count.'\',\'1100\',\'700\')" style="color:white;" />count</B></th>
<th width=5 scope="col"><B></B></th>
<th width=150 scope="col"><B>host</B></th>
<th width=70 scope="col"><B><a href="javascript:OpenWindow(\'ret_index.php?service='.cpu.'\',\'1100\',\'700\')" style="color:white;" />cpu_load</B></th>
<th width=70 scope="col"><B><a href="javascript:OpenWindow(\'ret_index.php?service='.mem.'\',\'1100\',\'700\')" style="color:white;" />mem</a></B></th>
<th width=70 scope="col"><B><a href="javascript:OpenWindow(\'ret_index_count.php?service='.count.'\',\'1100\',\'700\')" style="color:white;" />count</B></th>
<th width=5 scope="col"><B></B></th>
</tr>
</thead>';

foreach ($returns_data as $row) {

	global $key;
        global $value;
	
	$s_host=$row->srv_id;
	$str=$row->returns;

	$data_v1 = json_decode($row->returns, true);  // 데이터 json형식으로 배열로 받음
        $data_v = $data_v1['count']; //count 필드에 값만 저장.
        $data_v2 = $data_v1['service_count']; //count 필드에 값만 저장.

	$fco=$this->saltstacklib->cnt_color($s_host, $data_v2, $count_limit); // 카운트의 경우 제한수치 이상일 경우 경고가 표시되며, 제한수치가 동일하지 않아 별도로 처리

	if( $data_v['mem_info'] > 98 ){  //메모리 수치가 98이상이면 색깔 표시.
		$sbg="#FF9999";
		$mbg="#660000"; 
		$m_fco="#FFFFFF";
		$lbg="#FF9999";
		$cbg="#FF9999";

		if ( $data_v['loadavg'] > 10 ) {  // 메모리 수치가 98 이상일때 load 값 체크
	               	$lbg="#660000"; $l_fco="#FFFFFF";
			if ( $c_fco == "#660000" ) {
				$cbg="#660000"; 
				$c_fco1="#FFFFFF";
                        } else {
                                $cbg="#FF9999"; 
				$c_fco1="";
                        }
                }else{
                        $lbg="#FF9999"; 
			$l_fco="";
			if ( $c_fco == "#660000" ) {
				$cbg="#660000"; 
				$c_fco1="#FFFFFF";
                        } else {
                                $cbg="#FF9999"; 
				$c_fco1="";
                        }
		}
	} else {
		if ( $data_v['loadavg'] > 10 ) { // 메모리가 98이상이지 않을때 load 체크
			$sbg="#FF9999";
                        $lbg="#660000"; 
			$l_fco="#FFFFFF";
                        $mbg="#FF9999";
                        $cbg="#FF9999";
                        if ( $c_fco == "#660000" ) {
				$cbg="#660000"; 
				$c_fco1="#FFFFFF";
                        } else {
				$cbg="#FF9999"; 
				$c_fco1="";
                        }
		} else {
			$lbg="";
                        if ( $c_fco == "#660000" ) {
				$sbg="#FF9999";
                                $mbg="#FF9999";
                                $lbg="#FF9999";
                                $cbg="#660000"; 
				$c_fco1="#FFFFFF";
                        } else {
				$sbg=""; $lbg=""; $l_fco=""; $mbg=""; $m_fco=""; $cbg=""; $c_fco1="";
                        }
              	}
	}
        //색깔 및 returns의 값을 받아 테이블 형식으로 출력
        echo "<td style='background-color:$sbg'><B><font color='$s_fco' face='굴림'><a href='/index_graph.php?txt=".$s_host."' target='_blank'>".$s_host."</font></a></B></td>"; //HOST 클릭시 2시간전 데이터 새창으로 나오도록 수정 20150204 by psy
        echo "<td style='background-color:$lbg'><B><font color='$l_fco' face='굴림'>".$data_v['loadavg']."</font></B></td>";
        echo "<td style='background-color:$mbg'><B><font color='$m_fco' face='굴림'>".$data_v['mem_info']."</font></B></td>";
        $count_check=$this->saltstacklib->count_td($str,$cbg,$c_fco1);       // 카운트쪽에서 처리된 내용 변수에 저장.
        if($count_check) {      // 해당 변수에 값이 있을 경우 출력.
		echo $count_check;
	        echo "<td align=center></td>";
                $x++;                                   // 2개의 필드로 출력
                if($x%3==0){                     // 2로 나눴을때 0이면 tr태그 붙임
			echo "</tr></tbody><tbody><tr>";
                }
        }else{                  // 없으면 공란으로 출력.
                $count_check=" ";
                echo "<td align=center></td>";
                $x++;
	        if($x%3==0){                     // 2로 나눴을때 0이면 tr태그 붙임
			echo "</tr></tbody><tbody><tr>";
                }
	}
}

$base_URL=$_SERVER['HTTP_HOST'];

echo "</div>
<script> new Ajax.PeriodicalUpdater('DB','http://$base_URL/ci/index.php/saltstack/total',{method: 'post', frequency: 2, decay: 2})</script>
";

?>

