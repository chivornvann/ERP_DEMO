<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_sale_returns_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteSaleReturn($id)
    {
        if ($this->db->delete('sim_sale_return_detail', array('use_sim_sale_return_id' => $id))) {
            if($this->db->delete('sim_sale_returns', array('id' => $id))){
                return true;
            }
        }
        return FALSE;
    }

    public function addSaleReturn($data, $groupIds)
    {
        if ($this->db->insert("Sim_sale_returns", $data)) {
            $insertedId = $this->db->insert_id();

            //loop each group to perform add
            for ($i = 0; $i < count($groupIds); $i++) {
	            //Add sale consignment detail based on each group
	            $simsInGroup = $this->Sim_sale_consignments_model->getSimInGroup($groupIds[$i]);
		        if ($simsInGroup->num_rows() > 0) {
		            foreach (($simsInGroup->result()) as $row) {
		                $dataReturnDetail = array(
			            	'use_sim_group_id' => $groupIds[$i],
			            	'use_sim_id' => $row->id,
			            	'use_sim_sale_return_id' => $insertedId,
	            		);
	            	$this->db->insert("sim_sale_return_detail", $dataReturnDetail);
		            }
		        }
            }
            return true;
        }
        return false;
    }

     public function getSaleReturn($id){
       $this->db->select($this->db->dbprefix('sim_sale_returns') . ".id as id, sim_sale_returns.date_return, sim_shops.shop, CONCAT(".$this->db->dbprefix('sim_locations').".name, ' (', ".$this->db->dbprefix('sim_branches').".branch_name, ')') as locationName, users.username")
            ->join('sim_sale_return_detail', 'sim_sale_return_detail.use_sim_sale_return_id = sim_sale_returns.id')
            ->join('sim_branches', 'sim_branches.id = sim_sale_returns.use_sim_branches_id')
            ->join('sim_shops', 'sim_shops.id = sim_branches.use_shop_id')
            ->join('sim_locations', 'sim_locations.id = sim_branches.use_sim_location_id')
            ->join('users', 'users.id = sim_sale_returns.use_sale_man_id')
            ->where(array('users.id' => $this->session->userdata('user_id'), 'sim_sale_returns.id' => $id))
            ->group_by('sim_sale_return_detail.use_sim_sale_return_id');
        $q =  $this->db->get('sim_sale_returns');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        } 
        return FALSE;
    }

    public function addGroupToSaleReturn($saleReturnId, $gId){
        $isGroupExist =  $this->db->get_where("sim_sale_return_detail", array('use_sim_group_id' => $gId,'use_sim_sale_return_id' => $saleReturnId), 1);
    
        if($isGroupExist->num_rows() > 0){
            return false;
        }

        $sims = $this->db->get("sim", array('use_sim_group_id'=> $gId));
        if ($sims->num_rows() > 0) {
            $success = true;
            foreach (($sims->result()) as $row) {
            $data = array(
                'use_sim_group_id' => $gId,
                'use_sim_id' => $row->id,
                'use_sim_sale_return_id' => $saleReturnId,
            );

            $status = $this->db->insert("sim_sale_return_detail", $data);
            $success = $success && $status;
            }

            if($success){
                return true;
            }
       }

       return false;
    }

    public function deleteSimGroupFromSaleReturn($gId){
        if ($this->db->delete('sim_sale_return_detail', array('use_sim_group_id' => $gId))) {
            //Turn sim back to stock if user delete group from sale consignment
            if($this->db->update("sim", array('is_in_stock' => 0), array('use_sim_group_id' => $gId))){
                 return true;
            }
        }
        return FALSE;
    }

}
