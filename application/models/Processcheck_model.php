<?
class Processcheck_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
	public function get_process_data($today)
	{
		$sql="SELECT * from day_status WHERE rec_date like '$today 1%' order by srv_id";
		$query=$this->db->query($sql);
		$ret=$query->result_array();
		return $ret;
	}
	public function get_exclude_process()
	{
		$sql="SELECT * from exclude_process;";
		$query=$this->db->query($sql);
		$ret=$query->result_array();
                return $ret;
	}
}
?>
