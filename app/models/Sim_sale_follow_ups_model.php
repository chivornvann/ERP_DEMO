<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_sale_follow_ups_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function addSaleFollowUp($data,  $simIds){
    	 if ($this->db->insert("Sim_sale_follow_up", $data)) {
            $insertedId = $this->db->insert_id();

            $isInsertSuccess = true;
            //loop each sim to perform add
            for ($i = 0; $i < count($simIds); $i++) {
             
	                $dataFollowUp = array(
		            	'sim_id' => $simIds[$i],
		            	'use_sim_sale_follow_up_id' => $insertedId,
		            	'has_identity_card' => $this->hasIdentityCard($simIds[$i]),
            		);
	            	$satusInsert = $this->db->insert("sale_follow_up_detail",  $dataFollowUp);
                    $isInsertSuccess = $isInsertSuccess && $satusInsert;
                       if($isInsertSuccess){
                       $this->db->update("sim", array('is_saled' => 1), array('id' => $simIds[$i]));
                    }
            }

            if($isInsertSuccess){
                 return true;
            }
        }
        return false;
    }

    public function hasIdentityCard($simId){
    	$this->db->select('is_has_identify_card')->where('id', $simId);
        $q =  $this->db->get('sim');
        $result = $q->result();
        return $result[0]->is_has_identify_card;
    }

    public function getSimTotalPrice($simIds){
    	$this->db->select_sum('price', 'total')->where_in('id', $simIds);
        $query =  $this->db->get('sim');
        $result = $query->result();
        return $result[0]->total;
    }

    public function getSims(){
    	$this->db->select('id, sim_number')->where(array('is_saled'=> 0, 'is_in_stock'=>0));
        $q =  $this->db->get('sim');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function deleteSaleFollowUp($id)
    {
        $this->db->select('sim_id')
            ->where('use_sim_sale_follow_up_id',$id );
        $q =  $this->db->get('sale_follow_up_detail');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

           foreach ($data as $s) {
                $this->db->update("sim", array('is_saled' => 0), array('id' => $s->sim_id));
           }

            if ($this->db->delete('sale_follow_up_detail', array('use_sim_sale_follow_up_id' => $id))) {
                if($this->db->delete('Sim_sale_follow_up', array('id' => $id))){
                    return true;
                }
            }
        }

        return FALSE;
    }

    public function getSaleFollowUp($id){
    	 $this->db->select($this->db->dbprefix('sim_sale_follow_up') . ".id as id, sim_sale_follow_up.follow_up_date, sim_shops.shop, CONCAT(".$this->db->dbprefix('sim_locations').".name, ' (', ".$this->db->dbprefix('sim_branches').".branch_name, ')') as locationName, users.username, sim_sale_follow_up.qty, sim_sale_follow_up.total_price")
            ->join('sale_follow_up_detail', 'sale_follow_up_detail.use_sim_sale_follow_up_id = sim_sale_follow_up.id')
            ->join('sim_branches', 'sim_branches.id = sim_sale_follow_up.use_branch_id')
            ->join('sim_shops', 'sim_shops.id = sim_branches.use_shop_id')
            ->join('sim_locations', 'sim_locations.id = sim_branches.use_sim_location_id')
            ->join('users', 'users.id = sim_sale_follow_up.sale_man_id')
            ->where(array('users.id' => $this->session->userdata('user_id'), 'sim_sale_follow_up.id' => $id))
            ->group_by('sale_follow_up_detail.use_sim_sale_follow_up_id');
        $q =  $this->db->get('sim_sale_follow_up');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function addMoreSim($id,  $simIds){
       $isInsertSuccess = true;
        //loop each sim to perform add
        for ($i = 0; $i < count($simIds); $i++) {
         
                $dataFollowUp = array(
	            	'sim_id' => $simIds[$i],
	            	'use_sim_sale_follow_up_id' => $id,
	            	'has_identity_card' => $this->hasIdentityCard($simIds[$i]),
        		);
            	$satusInsert = $this->db->insert("sale_follow_up_detail",  $dataFollowUp);
                $isInsertSuccess = $isInsertSuccess && $satusInsert;
                if($isInsertSuccess){
                   $this->db->update("sim", array('is_saled' => 1), array('id' => $simIds[$i]));
                }
        }

        if($isInsertSuccess){
            return true;
        }

   		return false;
	}

    public function deleteSim($id){

        $this->db->select('sim_id')->where('id', $id);
        $q =  $this->db->get('sale_follow_up_detail');
        $result = $q->result();
        $sId = $result[0]->sim_id;

        if ($this->db->delete('sale_follow_up_detail', array('id' => $id))) {
            //Turn sim back to stock if user delete group from sale consignment

            if($this->db->update("sim", array('is_saled' => 0), array('id' => $sId))){
                return true;
            }
        }
        return FALSE;
    }
}