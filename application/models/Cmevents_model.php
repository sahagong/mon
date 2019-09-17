<?
class Cmevents_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
	public function list_count()
	{
		$result=$this->db->count_all('cm_status');
		return $result;
	}
	
	public function get_alert_data()
	{
		$query=$this->db->query("SELECT srv_id , rec_date , returns FROM all_new_salt.cm_status");
		$ret=$query->result_array();
		return $ret;
	}
}
?>
