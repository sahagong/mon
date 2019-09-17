<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saltstacklib {

        public function cnt_color($s_host, $data_array, $count_limit)
        {
		
	        foreach($data_array as $key => $value) {

                if(strpos($key, 'count') !== false){
                        if ( strpos($s_host, 'total') !== false && $key == "queue_count" && $value > $count_limit['total']['queue_count'])
                        {
                                $col="#660000";
                                $reponse .=$col;
                                return $reponse;

                        } else if (strpos($s_host, 'smtp') !== false && $key == "queue_count" && $value > $count_limit['smtp']['queue_count']) 
			{
                                $col="#660000";
                                $reponse .=$col;
                                return $reponse;

                        } else if (strpos($s_host, 'mail') !== false && $key == "queue_count" && $value > $count_limit['mail']['queue_count']) 
			{
                                $col="#660000";
                                $reponse .=$col;
                                return $reponse;

                        } else if ($key == "session_count" && $value > $count_limit['session_count']) {
                                $col="#660000";
                                $reponse .=$col;
                                return $reponse;

                        } else if ($key == "block_count" && $value > $count_limit['block_count']) {
                                $col="#660000";
                                $reponse .=$col;
                                return $reponse;

                        } else if ($key == "pop_count" && $value > $count_limit['pop_count']) {
                                $col="#660000";
                                $reponse .=$col;
                                return $reponse;

                        } else if ($key == "web_count" && $value > $count_limit['web_count']) {
                                $col="#660000";
                                $reponse .=$col;
                                return $reponse;

                        } else if ($key == "mysql_count" && $value > $count_limit['mysql_count']) {
                                $col="#660000";
                                $reponse .=$col;
                                return $reponse;

                        } else if ($key == "row_totaldb_count" && $value > $count_limit['row_totaldb_count']) {
                                $col="#660000";
                                $reponse .=$col;
                                return $reponse;

                        } else if ($value > $count_limit['else']) {
                                $col="#660000";
                                $reponse .=$col;
                                return $reponse;
                        }

                }
        	}
        }
	
	public function count_td($str,$cbg,$c_fco1){


                $data_v1 = json_decode($str, true);
                $data_v = $data_v1['count'];
                $data_v2 = $data_v1['service_count'];


                    if($data_v2){


                                echo "<td style='background-color:$cbg'>";
                            foreach($data_v2 as $key => $value)
                           {
                                if (strpos($key, "count") !== false){

                                        echo "<B><font color='$c_fco1' face='±¼¸²'>"."$key[0]"."("."$value".") "."</font></B>";

                                }
                           }

                                echo "</td>";

                   }else{
                                echo "<td>";

                                   $key="null";
                                   $value="0";

                                   echo "<B><font face='±¼¸²'>"."$key[0]"."("."$value".") "."</font></B>";


                                echo "</td>";

                    }
	}
}
?>
