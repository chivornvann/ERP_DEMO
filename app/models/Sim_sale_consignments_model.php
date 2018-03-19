<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_sale_consignments_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    function GetAutocomplete($term)
    {
        $this->db->select('id, name', FALSE);
        $this->db->where("{$this->db->dbprefix('sim_groups')}.name LIKE '%" . $term . "%");
        
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

     public function getGroups(){
        $q = $this->db->get("sim_groups");
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
                $isInsertSuccess = true;
		        if ($simsInGroup->num_rows() > 0) {
		            foreach (($simsInGroup->result()) as $row) {
		                $dataConsignDetail = array(
			            	'use_group_id' => $groupIds[$i],
			            	'use_sim_id' => $row->id,
			            	'use_sale_consignment_id' => $insertedId,
			            	'is_sale' => 0,
	            		);
    	            	$satusInsert = $this->db->insert("sale_consignment_detail", $dataConsignDetail);
                        $isInsertSuccess = $isInsertSuccess && $satusInsert;
		            }

                    //Update sim status to out stock after add sale consignment
                    if($isInsertSuccess){
                        foreach (($simsInGroup->result()) as $row) {
                           $this->db->update("sim", array('is_in_stock' => 0), array('id' => $row->id));
                        }
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
        $this->db->where(array('use_group_id' => $gId,'is_sale'=> 1));
        $simsInGroup = $this->db->get("sale_consignment_detail");
        if($simsInGroup->num_rows() > 0){
            return FALSE;
        }

        if ($this->db->delete('sale_consignment_detail', array('use_group_id' => $gId))) {
            //Turn sim back to stock if user delete group from sale consignment
            if($this->db->update("sim", array('is_in_stock' => 1), array('use_sim_group_id' => $gId))){
                 return true;
            }
        }
        return FALSE;
    }

    public function deleteSaleCognt($id)
    {
         $this->db->select("sale_consignment_detail.*")
            ->where(array('is_sale'=> 1, 'use_sale_consignment_id'=> $id));
        $q =  $this->db->get('sale_consignment_detail');

        if($q->num_rows() > 0){
            return FALSE;
        }


        $this->db->select('use_group_id')
            ->where('use_sale_consignment_id',$id );
        $q =  $this->db->get('sale_consignment_detail');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

           foreach ($data as $g) {
                $this->db->update("sim", array('is_in_stock' => 1), array('use_sim_group_id' => $g->use_group_id));
           }

            if ($this->db->delete('sale_consignment_detail', array('use_sale_consignment_id' => $id))) {
                if($this->db->delete('sim_sale_consignments', array('id' => $id))){
                    return true;
                }
            }
        }

        return FALSE;
    }

    public function getSaleConsignents($id){
       $this->db->select($this->db->dbprefix('sim_sale_consignments') . ".id as id, sim_sale_consignments.date_consign, sim_shops.shop, CONCAT(".$this->db->dbprefix('sim_locations').".name, ' (', ".$this->db->dbprefix('sim_branches').".branch_name, ')') as locationName, sim_branches.facebook_name, users.username, sim_sale_consignments.reference_note")
            ->join('sale_consignment_detail', 'sale_consignment_detail.use_sale_consignment_id = sim_sale_consignments.id')
            ->join('sim_branches', 'sim_branches.id = sim_sale_consignments.use_sim_branches_id')
            ->join('sim_shops', 'sim_shops.id = sim_branches.use_shop_id')
            ->join('sim_locations', 'sim_locations.id = sim_branches.use_sim_location_id')
            ->join('users', 'users.id = sim_sale_consignments.use_sale_man_id')
            ->where(array('users.id' => $this->session->userdata('user_id'), 'sim_sale_consignments.id' => $id))
            ->group_by('sale_consignment_detail.use_sale_consignment_id');
        $q =  $this->db->get('sim_sale_consignments');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getGroupById($id)
    {
     $this->db->select("id, name")
            ->where('sim_groups.id', $id);
        $q =  $this->db->get('sim_groups');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function updateGroupOnSaleConsign($id, $data = array())
    {
        $this->db->where('use_group_id', $id);
        if ($this->db->update('sale_consignment_detail', $data)) 
        {
            return true;
        }
        return false;
    }

    public function getSimInGroups()
    {
        $q = $this->db->get("sim_groups");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function addGroupToShop($saleConId, $gId){
         $isGroupExist =  $this->db->get_where("sale_consignment_detail", array('use_group_id' => $gId,'use_sale_consignment_id' => $saleConId), 1);
        if($isGroupExist->num_rows() > 0){
            return false;
        }

        $sims = $this->db->get("sim", array('use_sim_group_id'=> $gId));
        if ($sims->num_rows() > 0) {
            $success = true;
            foreach (($sims->result()) as $row) {
            $data = array(
                'use_group_id' => $gId,
                'use_sim_id' => $row->id,
                'use_sale_consignment_id' => $saleConId,
                'is_sale' => 0
            );

            $status = $this->db->insert("sale_consignment_detail", $data);
            $success = $success && $status;
            }

            if($success){
                return true;
            }
       }

       return false;
    }
}