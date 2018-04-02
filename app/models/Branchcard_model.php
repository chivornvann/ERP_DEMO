<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Branchcard_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getBranchCardShop() 
    {
    	$this->db->select('*');
    	$this->db->from('sma_sim_shops');
        return $this->db->get()->result_array();
    }
    public function getBranchCardLocation() 
    {
    	$this->db->select('*');
    	$this->db->from('sma_sim_locations');
        return $this->db->get()->result_array();
    }

    public function add_branch_card($data_branch_card) {
        $this->db->insert('sma_card_branch', $data_branch_card);
        return  $this->db->insert_id();
    }

    public function deleteBranchCard($branch_card_id) {
        if ($this->db->delete('sma_card_branch', array('id' => $branch_card_id))) {
            return true;
        }
        return FALSE;
    }

    public function update_branch_card($data,$branch_card_id) {
        return $this->db->update('sma_card_branch', $data, array('id' => $branch_card_id));
    }

    public function getBranchCardInfor($id) {
        $this->db->select('*');
        $this->db->from('sma_card_branch');
        $this->db->where('id',$id);
        return $this->db->get()->result_array();
    }

    public function getBranchCardInforById($id) {
        $this->db->select("sma_card_branch.branch_name,sma_card_branch.phone,sma_card_branch.contact_name,sma_card_branch.facebook_name, sma_card_branch.is_has_special_book as special_book,sma_card_branch.is_has_stamp_shop as stamp_shop,sma_sim_shops.shop as shop,sma_sim_locations.location as location ");
        $this->db->from('sma_card_branch');
        $this->db->join('sma_sim_shops','sma_sim_shops.id = sma_card_branch.use_card_shop_id');
        $this->db->join('sma_sim_locations','sma_sim_locations.id = sma_card_branch.use_card_location_id');
        $this->db->where('sma_card_branch.id', $id);
        return $this->db->get()->result_array();
    }

}