<?
class Ipmievents_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
	public function get_alert_data($interval,$minion)
	{
		if ( $minion == "NONE" ) {
		$sql="SELECT minion_name, ipmi_date , ipmi_event FROM ipmi_events WHERE rec_date > DATE_ADD(NOW(), INTERVAL - ".$interval." DAY) ORDER BY rec_date;";
		} else {
		$sql="SELECT minion_name, ipmi_date , ipmi_time , ipmi_name , ipmi_type , ipmi_event FROM ipmi_events WHERE minion_name = '".$minion."';";
		}
		$query=$this->db->query($sql);
		$ret=$query->result_array();
		return $ret;
	}
}
?>
