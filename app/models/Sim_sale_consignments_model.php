<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_sale_consignments_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getGroupNames($term)
    {
        $this->db->select('name', FALSE)
        ->where("({$this->db->dbprefix('sim_groups')}.name LIKE '%" . $term . "%')");
        $q = $this->db->get('sim_groups');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
     public function getBranches()
    {
        $q = $this->db->get("sim_branches");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getShops(){
    	$q = $this->db->get("sim_shops");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getLocations(){
    	$this->db->select('sim_locations.id, sim_locations.name')
            ->join('sim_branches', 'sim_branches.use_sim_location_id=sim_locations.id');
        $q =  $this->db->get('sim_locations');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function addSaleConsignment($data, $groupIds)
    {
        if ($this->db->insert("Sim_sale_consignments", $data)) {
            $insertedId = $this->db->insert_id();

            //loop each group to perform add
            for ($i = 0; $i < count($groupIds); $i++) {
	            //Add sale consignment detail based on each group
	            $simsInGroup = $this->getSimInGroup($groupIds[$i]);
		        if ($simsInGroup->num_rows() > 0) {
		            foreach (($simsInGroup->result()) as $row) {
		                $dataConsignDetail = array(
			            	'use_group_id' => $groupIds[$i],
			            	'use_sim_id' => $row->id,
			            	'use_sale_consignment_id' => $insertedId,
			            	'is_sale' => 0,
	            		);
	            	$this->db->insert("sale_consignment_detail", $dataConsignDetail);
		            }
		        }
            }
            return true;
        }
        return false;
    }

    public function getSimInGroup($groupId){
        $this->db->where('sim.use_sim_group_id', $groupId);
        $simsInGroup = $this->db->get("sim");
        if($simsInGroup->num_rows() > 0){
			return $simsInGroup;
        }
        return false;
    }

    public function deleteSimGroupFromSlCongt($gId)
    {
        if ($this->db->delete('sale_consignment_detail', array('use_group_id' => $gId))) {
            return true;
        }
        return FALSE;
    }

    public function getSaleConsignents($id){
        $this->db->select("sale_consignment_detail.use_group_id as id, sim_sale_consignments.date_consign, sim_groups.name, sim_shops.shop, CONCAT(".$this->db->dbprefix('sim_locations').".name, ' (', ".$this->db->dbprefix('sim_branches').".branch_name, ')') as locationName, sim_branches.facebook_name, users.username, sim_sale_consignments.reference_note")
            ->join('sim_groups', 'sim_groups.id = sale_consignment_detail.use_group_id')
            ->join('sim_sale_consignments', 'sim_sale_consignments.id = sale_consignment_detail.use_sale_consignment_id')
            ->join('sim_branches', 'sim_branches.id = sim_sale_consignments.use_sim_branches_id')
            ->join('sim_shops', 'sim_shops.id = sim_branches.use_shop_id')
            ->join('sim_locations', 'sim_locations.id = sim_branches.use_sim_location_id')
            ->join('users', 'users.id = sim_sale_consignments.use_sale_man_id')
            ->where('users.id', $this->session->userdata('user_id'))
            ->where('sale_consignment_detail.use_group_id', $id)
            ->group_by('sale_consignment_detail.use_group_id', $id);
        $q =  $this->db->get('sale_consignment_detail');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

}