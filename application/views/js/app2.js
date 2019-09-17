host='http://'+location.host;

$.ajax({
	        url:host+"/ci/index.php/saltstack/graphmaker_disk/arp-mon4-2/20180418/1",
      		data:'POST',
      		dataType:'json',
		cache: false,
		success : function(data){
			//console.log(data);
                 var items1 = [];
		 var data_arr= [];
                 var rec_date = [];
		 var key_name = [];
                 var value = [];

		 var data_arr_r = [];
		 var data_arr_v = [];
		 var data_arr_t_r = [];
		 var data_arr_t_v = [];

		 //var data = [];
                 $.each(data, function(key1,val1) {

			i=0;	
			for ( var key in val1 ) {

				data_arr[i] = val1[key];
				key_name[i]=key;
		
				var canvas_id = 'mycanvas'+i;
				$('.chart-container').append('<canvas id="'+canvas_id+'"></canvas>');


				i++;
				
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
				var ctx = [];
				var LineGraph = [];

                        	chartdata[k] = {
                                	labels: rec_date[k],
                                	datasets: [
                                        	{
                                                	label: key_name[k],
                                                	fill: false,
                                                	lineTension: 0.1,
                                                	backgroundColor: "rgba(59, 89, 152, 0.75)",
                                                	borderColor: "rgba(59, 89, 152, 1)",
                                                	pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
                                                	pointHoverBorderColor: "rgba(59, 89, 152, 1)",
                                                	data: value[k]
                                        	}
                                	]
                        	};

                        	ctx[k] = $("#mycanvas"+[k]);
			

                        	LineGraph[k] = new Chart(ctx[k], {
                                	type: 'line',
                                	data: chartdata[k]
                        	});

                        }





		},
		error : function(data) {

		}

	});


