<?
class Total_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
	
	public function count_list()
	{
		$query=$this->db->query("SELECT COUNT(*) FROM (SELECT srv_id FROM all_new_salt.returns WHERE rec_date > DATE_ADD(NOW(), INTERVAL - 60 SECOND) GROUP BY srv_id) AS A");
		$query2=$this->db->query("SELECT COUNT(*) FROM (SELECT srv_id FROM all_new_salt.remotecheck_returns WHERE rec_date > DATE_ADD(NOW(), INTERVAL - 60 SECOND) AND RETURNS LIKE '%0%' GROUP BY srv_id) AS A");
		
		$full_minion_list=file('./saltkey-list');
                $full_minion_cnt=count($full_minion_list);
                $full_list=file('./saltkey-list-result');
                $full_cnt=count($full_list);

                $ret['host_cnt'] = $query->row(0)->{'COUNT(*)'};
                $ret['nores_cnt'] = $full_cnt - $query->row(0)->{'COUNT(*)'};
                $ret['nominion_cnt'] = $full_minion_cnt - $query2->row(0)->{'COUNT(*)'};

		return $ret;
	}

	public function returns_data($interval=120)
	{
		$query=$this->db->query("SELECT a.rec_date,a.srv_id,a.returns FROM `all_new_salt`.`returns` a, (SELECT MAX(id) b_id FROM all_new_salt.`returns` WHERE rec_date > DATE_ADD(NOW(), INTERVAL - $interval SECOND) GROUP BY srv_id ORDER BY rec_date DESC ) b WHERE a.id=b.b_id ORDER BY srv_id");
		$ret = $query->result();
		
		return $ret;
	}
}
?>
