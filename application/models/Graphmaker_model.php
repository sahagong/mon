<?
class Graphmaker_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
	public function get_graph_data($table,$graph_hour,$host)
	{
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
			default : $sql="select id, rec_date, srv_id, returns from $table where rec_date >= DATE_ADD(now(),interval -$graph_hour hour) and rec_date < now() and srv_id='$host'";
				  break;
		}
		$query=$this->db->query($sql);
		$ret=$query->result_array();
		return $ret;
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
