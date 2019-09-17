<?

ini_set("error_reporting",(~E_NOTICE) & ini_get("error_reporting"));
header("Content-Type: text/html; charset=euc-kr");

$date=date('Y-m-d', strtotime($graphdate));
$ipcmd="grep '$graphhost:' /home/idcmon/iplist";
$uptimecmd="grep '$graphhost|' /home/idcmon/uptime | sed -e 's/$graphhost|//g'";
$uptimecmd2="grep '$graphhost|' /home/idcmon/uptime | sed -e 's/$graphhost|//g' | awk '{print $1}'";
$ip=exec($ipcmd);
$uptime=exec($uptimecmd);
if (strpos($uptime,'users') !== false){
	$uptime=exec($uptimecmd2);
}

$count = 0;
foreach($graphdata as $row){

        $data_list = json_decode($row['returns'], true);  // 하나의 returns 결과물을 배열형식으로 저장
        $rec_date = $row['rec_date']; // 이 returns 값의 시간
        $rec_date = str_replace("-", "/", $rec_date);
        foreach( $data_list as $key_division => $value_division ) {
                if($key_division == "count"){
                        ksort($value_division);
                                foreach ( $value_division as $key => $value ) {
                                                $graph_data[$key]['date'][] = $rec_date;
                                                $graph_data[$key]['data'][] = $value;
                                }
                }

        }
        $count = $count + 1;
}

echo "
<html>
        <head>
                <script type='text/javascript' language='javascript' src='/node_modules/chart.js/dist/Chart.bundle.js'></script>
                <script type='text/javascript' language='javascript' src='/node_modules/chart.js/samples/utils.js'></script>
        </head>


<body>
";

$base_URL=$_SERVER['HTTP_HOST'];

echo '<br><caption><font size=3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$date.' &nbsp; &nbsp;'.$graphhour.' Graph</b></font><br></caption>';
echo '<br><caption><font size=3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$ip.'&nbsp; &nbsp; uptime : &nbsp;'.$uptime.'</b></font><br></caption>';
$dt=date("Ymd",time());
echo "<br><table border=0>";
echo "<div style='text-align: left;'><font size='3'><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;date: </B></font><select name='daily' id='daily' onChange=\"var thelocation=this.options[this.selectedIndex].value; if (thelocation != '') window.open(value,'_self');\" onsubmit='parse(this); return false;'>";
echo "<option value=''>Date Search</option>";
echo "<option value='http://$base_URL/ci/index.php/saltstack/graphmaker/$graphhost/$dt/24'>".$dt."</option>";

foreach ( $grapholddate as $olddate ) {
        $olddatetoken=explode("_",$olddate['table_name']);
        $old_date=$olddatetoken[2];
        echo "<option value='http://$base_URL/ci/index.php/saltstack/graphmaker/$graphhost/$old_date/24'>".$old_date."</option>";
}

echo "</select>";

echo "<font size='3'><B>&nbsp;&nbsp;&nbsp;&nbsp;Display: </B></font><select name='g_tim' id='g_tim' onChange=\"var thelocation=this.options[this.selectedIndex].value; if (thelocation != '') window.open(value,'_self');\" onsubmit='parse(this); return false;'>
<option value='1'>TYPE</option>
<option value='http://$base_URL/ci/index.php/saltstack/graphmaker/$graphhost/".date("Ymd")."/2'>2 hours</option>
<option value='http://$base_URL/ci/index.php/saltstack/graphmaker/$graphhost/".date("Ymd")."/24'>1 day</option>
<option value='http://$base_URL/ci/index.php/saltstack/graphmaker/$graphhost/".date("Ymd")."/168'>1 week</option>
<option value='http://$base_URL/ci/index.php/saltstack/graphmaker/$graphhost/".date("Ymd")."/720'>1 month</option>
<option value='http://$base_URL/ci/index.php/saltstack/graphmaker/$graphhost/".date("Ymd")."/8760'>1 year</option>
</select>
</caption>
</table>
<br>
<br>
";

$k=0;

if(!empty($graph_data)){

	foreach ( $graph_data as $key => $category ) {

		$k=$k+1;

		$valuecount = count($category['data']);

						echo "
                                                <div style='width: 900px; height: 280px;'>
                                                        <canvas id='canvas_$k' style='width: 900px; height: 280px;'></canvas>
                                                </div>
                                                <br>

						<script type='text/javascript' language='javascript'>
							var config_$k = {
								type: 'line',
								data: {
									labels: [";
		                	                                         for ( $arraynum = 0; $arraynum<=$valuecount-1;$arraynum++){
                		        	                                        echo "'".$category['date'][$arraynum]."', ";
                                                				 }
                                                                        echo "],
									datasets: [{
										borderColor: window.chartColors.blue,
										backgroundColor: window.chartColors.orange,
										data: [";
											for ( $arraynum = 0; $arraynum<=$valuecount-1;$arraynum++){
        		                                                                        echo $category['data'][$arraynum].", ";
                        		                                                }
										 echo "],
											label: ";
						                                        if ( $key == "cpu_iowait" || $key == "cpu_idle" || $key == "cpu_user" ||  $key == "cpu_system" ||  $key == "cpu_percent") {
						                                        echo "'$key : %'";
						                                        } else {
							                                echo "'$key'";
											}

		                                                        echo "
									}]
								},
								options: {
									elements: {
										point: {
											radius: 0.1
										},
                                                                                line: {
                                                                                        tension: 0,
                                                                                        spanGaps: false,
                                                                                        showLine: false,
                                                                                        steppedLine: false,
                                                                                },
									},
                                                                        legend: {
                                                                                display: true,
										labels: {
											fontSize: 15,
											fontStyle: 'bold',
											fontStyle: 'italic',
										},
                        	                                                position: 'bottom',
                                                                        },
									title: {
										display: true,
										fontSize: 15,	
										fontStyle: 'bold',
										position: 'right',
										text: ";
										print("''");
										echo "
									}, 
								scales: {
									xAxes: [{
				                                               scaleLabel: {
       					                                		display: false,
                                        				                fontSize: 14,
				                                                        fontStyle: 'italic',
                                				                        labelString: ";
											print("''");
										echo "
				                                                },
										type: 'time',
										time: {
											displayFormats: {
											";
                        	                                                        	if ($graphhour == 1 || $graphhour == 2){
			        	                                                        echo "minute: 'HH:mm'";
												}elseif ($graphhour == 24){
												echo "hour: 'HH:mm'";
                                        	                        	                }elseif ($graphhour == 168 || $graphhour == 720){
                                                	                        	        echo "day: 'MM/DD'";
                                                        	                        	}elseif ($graphhour == 8760){
	                                                                	                echo "month: 'YYYY/MM/DD'";
                                                                        		        }
											echo "
											}
										},
										distribution: 'linear',
										ticks: {
											autoSkip: true
										}
									}],
									yAxes: [{
										stacked: true,
										scaleLabel: {
											display: true,
											labelString: ''
										},
										ticks: {
											autoSkip: true,
                                                                                        <!-- stepSize: 25 -->
										}
									}]
								}
				                        }
				                };

			                	var ctx_$k = document.getElementById('canvas_$k').getContext('2d');
			                	window.myLine = new Chart(ctx_$k, config_$k);

					        </script>
						<br>";
			}


		}

echo "
</body>
</html>
";

?>
