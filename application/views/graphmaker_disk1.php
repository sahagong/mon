<html>
        <head>


		<script>local_host=location.host;</script>
                <script type='text/javascript' src="http://<?=$_SERVER['HTTP_HOST']?>/js/Chart.bundle.js"></script>
                <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/js/jquery.js"></script>




                <title>ChartJS - LineGraph</title>
                <style>
                        .chart-container {
                                width: 900px;
				height: 280px
                        }
                </style>

        </head>


        <body><br>&nbsp
		
		Search Type: <input type="radio" name="r_dis" id="r_date" value="r_date" checked>Date Seach
	   		     <input type="radio" name="r_dis" id="d_play" value="d_play" >Period Search
		

<br><br>
&nbsp Date: <select id="select_date" onchange="graph(this.value, s_time)"></select>&nbsp
Time: <select id="select_time" onchange="graph('sel_date', this.value)" ></select>&nbsp
Display: <select id="select_dis" onchange="graph('sel_date', this.value)" disabled></select>&nbsp

<div id='traffic_div' style="visibility:hidden;">
<br>&nbsp Ethernet_list: <select id="select_eth" onchange="graph('sel_date',s_time, this.value)"></select></div>
<br><br>

                <div class='chart-container' >
                </div>

<!****************************여기서 부터 javascript 시작 ************************************  >
<script type="text/javascript">

var r_date_arr=<?php echo json_encode($tablelist);?>;			//날짜단위 table 리스트가 배열로 저장된 변수
var v_host="<?php echo $graphhost;?>";					//각 서버별 호스트 명
var sbox_date="<?php echo $graphdate;?>";				//selebox에 선택된 date 값
var d = new Date();							
var s_hour=d.getHours();
var part ="<?echo($graphpart);?>";
today=d.getFullYear()+""+"0"+(d.getMonth()+1)+""+d.getDate();		//오늘 날짜 구하기.


if ( part == "traffic"){
//var eth_opts=new Array('all','eth0');
var eth_opts=<?php echo json_encode($graph_eth);?>;
//$("#select_eth").text(setTag);
	traffic_div.style.visibility = "visible";
	for (j=0; j<Object.keys(eth_opts).length; j++){

		$('#select_eth').append("<option value='" + eth_opts[j] + "'>" + eth_opts[j] + "</option>");

	}
}


for (i=0; i< Object.keys(r_date_arr).length; i++){			//테이블 리스트의 날짜를 selectbox로 구현

	$('#select_date').append("<option value='" + r_date_arr[i] + "'>" + r_date_arr[i] + "</option>");
}



function today_select(start_time, end_time){	//0부터 24시까지 select_box 시간 구하기.
var j=start_time;
	//alert($('#select_date').val());
	if ( today == $('#select_date').val()){
		var e=s_hour;

	}else{

		var e=end_time;
	}

	//alert("j="+s);
	//alert("j<"+e);
	for ( j; j<=e; j++){

		if (j == s_hour) {

			$('#select_time').append("<option value='" + j + "' selected>" + j + "</option>");

		}else{
	        	$('#select_time').append("<option value='" + j + "'>" + j + "</option>");
		}

	}
}

$('#select_dis').append("<option value='" + '24' + "' selected>" + '1 day' + "</option>");
$('#select_dis').append("<option value='" + '168' + "'>" + '1 week' + "</option>");
$('#select_dis').append("<option value='" + '720' + "'>" + '1 mouth' + "</option>");
$('#select_dis').append("<option value='" + '8760' + "'>" + '1 year' + "</option>");

var sel = $('#select_date').find('option:selected').val();
$("input[name=r_dis]").change(function(){
	var radioValue = $(this).val();

	if ( radioValue == "r_date" ){
		$('#select_dis').attr('disabled', 'false');
		$('#select_time').removeAttr('disabled');
		s_time=d.getHours();
		//alert(s_time);
		$("#select_time").find('option').remove().append("<option value='1' selected>1</option>").val();
		today_select(0, s_time);
		//$('#select_time').append(app_sel); 
		//today_select(0, s_time);
		graph(sel, s_time);
	}else if ( radioValue == "d_play" ) {
		$('#select_time').attr('disabled', 'true');
		$('#select_dis').removeAttr('disabled');
		s_time='24';
		graph(sel, s_time);
	}

});

today_select(0, 24);
var s_time = $('#select_time').find('option:selected').val();
graph(sel, s_time);

var a_i;
function graph(sel, s_time){
	function u_time(time_val){
		var unit_time;
	 	if ( time_val == "24" ){	
			unit_time = "hour";
		}else if ( time_val == "168" ){
			unit_time = "day";
		}else if ( time_val == "720"){
			unit_time = "mouth";
		}else if ( time_val == "8760"){
			unit_time = "year";
		}else{
			unit_time = "Minute";
		}
	}
		var s_date;
		var s_dis;
		//var part ="<?echo($graphpart);?>";
		var LineGraph = [];

                for (var c_i=0; c_i< a_i;c_i++){

                        var canvas_id = 'mycanvas'+c_i;
                        $("canvas#mycanvas"+c_i).remove();

                }
		
                   if ( sel = 'select_date' )
                   {
                        sel1=$('#select_date').val();


                   }

		   if ( s_time == 'sel_time' )
		   {
                        s_time1=$('#sel_time').val();
			unit_time=u_time(s_time1);
                   }else if ( s_time == 'sel_dis' ) {

			s_time1=$('#sel_dis').val();
			unit_time=u_time(s_time1);
		   }else{

			s_time1=s_time;
			unit_time=u_time(s_time1);
			
		   }

	
		  if ( part == 'traffic' ){	

			var s_eth = $('#select_eth').find('option:selected').val();
		  }else{
			var s_eth='eth0';

		  }	
		
		$.ajax({
                	url:"http://<?=$_SERVER['HTTP_HOST']?>/ci/index.php/saltstack/graphmaker_json/"+v_host+"/"+part+"/"+sel1+"/"+s_time1+"/"+s_eth,
			//url:g_url,
                	type:'GET',
			data:{'sel': sel},
                	dataType:'json',
                	cache: false,
                	success : function(data){

				var items1 = [];
				var data_arr= [];
				var rec_date = [];
		 		var key_name = [];
				var value = [];

		 		var data_arr_r = [];
		 		var data_arr_v = [];
		 		var data_arr_t_r = [];
		 		var data_arr_t_v = [];


				$.each(data, function(key1,val1) {

					$('.chart-container').find('br').remove();

					a_i=0;
					for ( var key in val1 ) {
		
						data_arr[a_i] = val1[key];
						key_name[a_i]=key;

						var canvas_id = 'mycanvas'+a_i;
						var newElem = document.createElement('BR');   
						
						$("canvas#mycanvas"+a_i).remove();
						$('.chart-container').append('<canvas id="'+canvas_id+'"></canvas><br><br>');
						a_i++;
	
					}


                 		});

				for ( j=0; j< Object.keys(data_arr).length; j++){

					rec_date[j]=new Array();
					value[j]=new Array();
			
                   	     		for(var i in data_arr[j]) {

						rec_date[j].push(data_arr[j][i].rec_date);
						value[j].push(data_arr[j][i].value);
					
			     		}

				}



				for ( var k=0; k< Object.keys(key_name).length; k++){
				
					var chartdata = [];
					var chartopt = [];
					var ctx = [];

                        		chartdata[k] = {
                                		labels: rec_date[k], 
                                		datasets: [
                                        		{
                                                		label: key_name[k],
                                                		lineTension: 0.1,
                                                		backgroundColor: "rgba(59, 89, 152, 0.3)",
                                                		borderColor: "rgba(59, 89, 152, 1)",
                                                		pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
                                                		pointHoverBorderColor: "rgba(59, 89, 152, 1)",
                                                		data: value[k]
                                        		}
                                		]
                        		};
					
					chartopt[k]={
						elements: {
						point: {
						radius: 0.5
                                                },
						line: {
							tension: 0.3,
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
							text:''
                                                 },
						scales: {
							xAxes: [{
								scaleLabel: {
								display: false,
								fontSize: 14,
								fontStyle: 'italic',
								labelString:''
                                                                },
								type: 'time',
								time: {
									//format: "HH",
									unit: unit_time,
									displayFormats: {
												minute: 'HH:mm'
											}									
/*

          displayFormats: {
	    'minute':'HH:mm',
            'hour': 'HH:mm',
            'day': 'HH:mm',
            'week': 'MM-DD',
            'month': 'MM-DD HH:mm',
            'year': 'YYYY-MM-DD HH:mm',
          }
          unitStepSize: 1,
          unit: 'day',
*/	
							},
								distribution: 'linear',
										ticks: {
											autoSkip: true,
											stepSize: 25
											
										}
							}],
							yAxes: [{
								stacked: true,
								scaleLabel: {
									display: true,
									labelString:'' 
								},
								ticks: {
									autoSkip: true,
									min: 0,
									max: 100,
									stepSize: 25
								}
							}]

						}


					};


					if(LineGraph[k] != null){
    						LineGraph[k].destroy();
					}
		
                        		ctx[k] = $('#mycanvas'+[k]);


                        		LineGraph[k] = new Chart(ctx[k], {
                                		type: 'line',
                                		data: chartdata[k],
						options: chartopt[k]
                        		});


                        	}
                	},
                	error : function(data) {

                	}

		});
};


</script>

</body>
</html>

