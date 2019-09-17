<?
class Hardware_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
	public function get_data()
	{
		$query=$this->db->query("SELECT rec_date, srv_id , returns FROM `all_new_salt`.`returns_gcm` a, (SELECT MAX(id) b_id FROM all_new_salt.`returns_gcm` WHERE rec_date > DATE_ADD(NOW(), INTERVAL - 48 HOUR) GROUP BY srv_id ORDER BY rec_date DESC ) b WHERE a.id=b.b_id ORDER BY srv_id");
		$ret=$query->result_array();
		return $ret;
	}
}
?>
