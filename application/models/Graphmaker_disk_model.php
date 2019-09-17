<?
class Graphmaker_disk_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }


	public function get_table_list($part,$graph_hour,$host)
	{
		
		$sql1="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'all_new_salt' AND table_name LIKE 'returns_daily_%' order by TABLE_NAME desc;";
		$query1=$this->db->query($sql1);
	

		$l=0;
		$table_list[]=date("Ymd");
                foreach ($query1 -> result() as $row){
                    $table_date=$row->TABLE_NAME;
                    $table_st=explode("_", $table_date);
                    $table_list[]=$table_st[2];
                    $l++;
                }

                return $table_list;

	}
        public function get_graph_disk($table,$part,$graph_hour,$host,$s_eth,$date)
        {
		
		$s_date = date("Y-m-d", strtotime($date));		
                $today = date("Ymd", mktime(date("m"), date("d"), date("Y")));
                switch($graph_hour) {
                        case 24 : $sql="select id, rec_date, srv_id, returns from $table where srv_id='$host'";
                                  break;
                        case 168 : $table="returns_weekly"; $sql="select id, rec_date, srv_id, returns from $table where srv_id='$host'";
                                   break;
                        case 720 : $table="returns_monthly"; $sql="select id, rec_date, srv_id, returns from $table where srv_id='$host'";
                                   break;
                        case 8760 : $table="returns_yearly"; $sql="select id, rec_date, srv_id, returns from $table where srv_id='$host'";
                                    break;
                        default : 

		  		  $sql="select id, rec_date, srv_id, returns from $table where rec_date between '$s_date $graph_hour:00:00' and '$s_date $graph_hour:59:59' and srv_id='$host'";
                                  break;

                }


                $query=$this->db->query($sql);

		function rec_date($query, $graph_hour){

			$l=0;
                        foreach ($query -> result() as $row){

				$rec_date[]=$row->rec_date;

				$l++;
			}
				
			return $rec_date;	

		}


		function main_part($query, $graph_hour){

			$l=0;
			foreach ($query -> result() as $row){

                       
				$rec_date=rec_date($query, $graph_hour);
				/*--
				if ($graph_hour = 1){
					$rec_date_explode=explode(" ", $row->rec_date);
					$rec_date_explode1=explode(":", $rec_date_explode[1]);
					$rec_date=$rec_date_explode1[0].":".$rec_date_explode1[1];

				}
				--*/
				
			        $arr_recdate[$l]=$rec_date[$l];

                                $arr_row=$row->returns;

						
				//print_r($arr_row);
			
				$arr_ex=explode("},",$arr_row);
				$arr_cpu=explode("{",$arr_ex[0]);


				$arr_str=str_replace('"', '', $arr_cpu[2]);
				$cpu_line_arr[]=$arr_str;
                                $l++;
                        }


			
			for($i=0; $i<count($cpu_line_arr); $i++){

				//echo rec_date($query, $graph_hour)[$i];
				//echo " ";
				//echo "$cpu_line_arr[$i]"."<br />\n";

				$arr_cpu_ex=explode(",",$cpu_line_arr[$i]);

				//echo $cpu_line_arr[$i];
	
				for($j=0; $j<count($arr_cpu_ex);$j++){
				
					$arr_cpu_ex1=explode(":",trim($arr_cpu_ex[$j]));
									
					$cpu_arr_key=$arr_cpu_ex1[0];
					$cpu_arr_value=$arr_cpu_ex1[1];
					
					//echo $cpu_arr_key."==>".$cpu_arr_value."<br />\n";
					//if ($cpu_arr_key == "loadavg"){
						
					//	$cpu_arr_key = "cpu_load";
					//}
						//echo $cpu_arr_key;				


					$cpu_arr[$cpu_arr_key]="$cpu_arr_value";

				}

					$cpu_part_total[$i]=$cpu_arr;
			}


			function key_main_array($cpu_part_total){

				$key_val=$cpu_part_total;
				

				
                                for ($i=0;$i<count($cpu_part_total);$i++){
                                        $key_array_value=array_merge($cpu_part_total[0], $cpu_part_total[$i]);
                                }
	
				//print_r($key_name_eth_arr);
				//$key_name=array_diff($key_name_arr);
	
		
                                foreach($key_array_value as $key => $value){

					if (trim($key) !== "sockstat"){
						//$arr_key=array(SORT_DESC, SORT_ASC);
						$arr_key[]=$key;
					}
					
                                }
                                        return array($arr_key,$cpu_part_total);
			}
		

			function main_key_arr($cpu_part_total, $arr_recdate) {


                                $key_result=key_main_array($cpu_part_total);

                                $key_list=$key_result[0];
                                $key_value_array=$key_result[1];

				//print_r($key_list);

                                for ($i=0; $i<count($key_list);$i++){

                                        $key_name=$key_list[$i];

                                        for($j=0; $j<count($key_value_array);$j++){

                                                $part_array['rec_date']=$arr_recdate[$j];
						if (array_key_exists($key_name, $key_value_array[$j])){
                                                	$part_array['value']=$key_value_array[$j][$key_name];
						}
                                                $part_array_total[$key_name][]=$part_array;

                                        }

                                                $part_arr['part']=$part_array_total;

                                }

                                                return $part_arr;

			}


			return main_key_arr($cpu_part_total, $arr_recdate);

		}

                function disk_part($query, $graph_hour){


                        $l=0;
                        foreach ($query -> result() as $row){

                                $rec_date=rec_date($query, $graph_hour);

                                $arr_recdate[$l]=$rec_date[$l];

                                $arr_row=$row->returns;

                                $arr_ex=explode("},",$arr_row);
				$disk_line_arr[]=$arr_ex[2];

				$l++;
			}

				//print_r($disk_line_arr);

			for($i=0; $i<count($disk_line_arr); $i++){
				
				$arr_disk_ex=explode("{",$disk_line_arr[$i]);
				$disk_part_arr=explode(",",$arr_disk_ex[1]);

				//print_r($disk_part_arr);

				$arr_str=str_replace('"','',$disk_part_arr);
				//$arr_disk_ex=explode(":", $arr_str);
				for($j=0; $j<count($arr_str); $j++){

					$disk_arr_ex1=explode(":", trim($arr_str[$j]));
					$disk_arr_key=$disk_arr_ex1[0];
					$disk_arr_value=trim($disk_arr_ex1[1]);


					$disk_arr[$disk_arr_key]="$disk_arr_value";
				}
					$disk_part_total[$i]=$disk_arr;
			}
		

			//print_r($disk_part_total);
			function key_disk_array($disk_part_total){
			
				for($i=0; $i<count($disk_part_total);$i++){
					$key_array_value=array_merge($disk_part_total[0], $disk_part_total[$i]);

			
					//print_r($key_array_value);
					//echo $disk_part_total[$i];
				}
				//print_r($key_array_value);
	

				//print_r(key_disk_array($disk_part_total));
				foreach($key_array_value as $key => $value){

					$arr_key[]=$key;
				}

				return array($arr_key, $disk_part_total);
			}

			//key_disk_array($disk_part_total);

			function disk_key_arr($disk_part_total, $arr_recdate){

				$key_result=key_disk_array($disk_part_total);

				$key_list=$key_result[0];
				$key_value_array=$key_result[1];
				//print_r($key_value_array);

				for ($i=0; $i<count($key_list);$i++){
					$key_name=$key_list[$i];
					for ($j=0; $j<count($key_value_array);$j++){

						$part_array['rec_date']=$arr_recdate[$j];
						if (array_key_exists($key_name, $key_value_array[$j])){
							$part_array['value']=$key_value_array[$j][$key_name];			
						}
						$part_array_total[$key_name][]=$part_array;

					}

						$part_arr['part']=$part_array_total;
				}

					return $part_arr;
			}

				return disk_key_arr($disk_part_total, $arr_recdate);

		}


        function traff_part($query, $graph_hour, $s_eth){


                        $l=0;
                        foreach ($query -> result() as $row){

                                $rec_date=rec_date($query, $graph_hour);

                                $arr_recdate[$l]=$rec_date[$l];

                                //$arr_row=$row->returns;
				$arr_row=str_replace('"','',$row->returns);
				$arr_ex=explode(":{",$arr_row);
				$arr_ex1=explode("}},",$arr_ex[4]);
				$eth_arr[]=$arr_ex1[0];

                                $l++;
                        }
			//$test=$row->returns['traffic'];
                        //print_r($eth_arr);
			
			//print_r($eth_arr);

                        for($i=0; $i<count($eth_arr); $i++){

                                $arr_eth_ex=explode("},",$eth_arr[$i]);
                                //$eth_part_arr=explode(",",$arr_eth_ex[1]);

				//print_r($arr_eth_ex);
                               for ($j=0; $j<count($arr_eth_ex); $j++){

					$eth_line_data_arr=explode(": {",trim($arr_eth_ex[$j]));

					//echo $eth_line_data_arr[1];
					$join_arr[$eth_line_data_arr[0]][]=$eth_line_data_arr[1];
		
					//print_r($eth_line_data_arr[1]);	

					$arr_join_eth[]=$eth_line_data_arr[0];
					//$arr_join_eth=$arr_join_eth.concat($eth_line_data_arr[0]);
					//echo $eth_line_data_arr[0];
					//echo $eth_line_data_arr[0];
			       }
					//print_r($eth_line_data_arr);
					 //print_r($arr_join_eth);

                        }

					//print_r($arr_join_eth);
					$eth_key_name=array_unique($arr_join_eth);

					//print_r($join_arr['eth9']);

			

			function key_traff_array_eth($join_arr, $s_eth){

				$join_arr_total=$join_arr["$s_eth"];
			
				//print_r($join_arr_total);
                                for($i=0; $i<count($join_arr_total);$i++){
			
					//for($j=0; $j<count($join_arr_total[$i]);$j++){

						$traff_ex=explode(",",$join_arr_total[$i]);
						for($j=0; $j<count($traff_ex); $j++){
						//print_r($traff_ex);
				
							$traff_ex1=explode(":",$traff_ex[$j]);
							$traff_arr_key=$traff_ex1[0];
							$traff_arr_value=trim($traff_ex1[1]);
						//$traff_part_total[]=$traff_ex[1];
		
					//}\
							$traff_arr[$traff_arr_key]=$traff_arr_value;

						}
					
							$traff_part_total1[$i]=$traff_arr;
                                        //$key_array_value=array_merge($traff_part_total[0], $traff_part_total[$i]);
                                }

					//print_r($traff_part_total1[0]);
					//echo "aaaaaaaaaaaaaaaaa";

                                return $traff_part_total1;

			}

			$traff_part_total=key_traff_array_eth($join_arr, $s_eth);
			//print_r($traff_part_total[0][1]);
			function key_traff_array($traff_part_total){

				for ($i=0; $i<count($traff_part_total);$i++){

					$key_array_value=array_merge($traff_part_total[0], $traff_part_total[$i]);
				}
			

				foreach($key_array_value as $key => $value){

					//print_r($key_array_value);
					$arr_key[]=$key;
				}
				return array($arr_key, $traff_part_total);
			}

			//print_r(key_traff_array($traff_part_total));

			
			function traff_key_arr($traff_part_total, $arr_recdate, $eth_key_name){

				$key_result=key_traff_array($traff_part_total);

				$key_list=$key_result[0];
				$key_value_array=$key_result[1];

				for ($i=0; $i<count($key_list);$i++){
					$key_name=$key_list[$i];

					//print_r($key_value_array[0]['eth0_sent']);
					for ($j=0; $j<count($key_value_array);$j++){
						$part_array['rec_date']=$arr_recdate[$j];
						if (array_key_exists($key_name, $key_value_array[$j])){
							$part_array['value']=$key_value_array[$j][$key_name];
						}
						$part_array_total[$key_name][]=$part_array;
				
					}

						$part_arr['part']=$part_array_total;
				}

					return array($part_arr, $eth_key_name);
			}

			//	$eth_key_name);

				return traff_key_arr($traff_part_total, $arr_recdate, $eth_key_name);

		}



                function count_part($query, $graph_hour){


                        $l=0;
                        foreach ($query -> result() as $row){

                                $rec_date=rec_date($query, $graph_hour);

                                $arr_recdate[$l]=$rec_date[$l];

                                $arr_row=$row->returns;

                                $arr_ex=explode("},",$arr_row);
                                $disk_line_arr[]=$arr_ex[3];

                                $l++;
                        }


                        for($i=0; $i<count($disk_line_arr); $i++){

                                $arr_disk_ex=explode("{",$disk_line_arr[$i]);
                                $disk_part_arr=explode(",",$arr_disk_ex[2]);

                                //print_r($disk_part_arr);

                                $arr_str=str_replace('"','',$disk_part_arr);
                                //$arr_disk_ex=explode(":", $arr_str);
                                for($j=0; $j<count($arr_str); $j++){

                                        $disk_arr_ex1=explode(":", trim($arr_str[$j]));
                                        $disk_arr_key=$disk_arr_ex1[0];
                                        $disk_arr_value=trim($disk_arr_ex1[1]);


                                        $disk_arr[$disk_arr_key]="$disk_arr_value";
                                }
                                        $traff_part_total[$i]=$disk_arr;
                        }
		}


		//count_part($query, $graph_hour);
		//print $table;
		//$ret=disk_key_arr($part_arr_total, $arr_recdate);
		//print_r(key_array($part_arr_total));

			$main_ret=main_part($query, $graph_hour, $s_eth);
			$disk_ret=disk_part($query, $graph_hour, $s_eth);
			$traff_ret=traff_part($query, $graph_hour, $s_eth);
                switch($part) {
                        case "disk" : return $disk_ret;
                                  break;
                        case "mem" : disk_part($query);
                                   break;
                        case "main" : return $main_ret;
                                   break;
                        case "traffic" : return $traff_ret;
                                    break;
                        default : return $traff_ret;
                                  break;
                }

	}


	public function get_graph_olddate()
	{
		$sql="SELECT table_name FROM information_schema.tables  WHERE  table_name LIKE 'returns_daily_%' ORDER BY 1 DESC";
		$query=$this->db->query($sql);
		$ret=$query->result_array();
                return $ret;
	}

}

?>
