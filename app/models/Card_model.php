<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Card_model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    public function getCompanyInfor() 
    {
    	$this->db->select('*');
    	$this->db->from('sma_sim_companies');
        return $this->db->get()->result_array();
    }

    public function getBranchInfor() 
    {
    	$this->db->select('*');
    	$this->db->from('sma_sim_branches');
        return $this->db->get()->result_array();
    }

    public function add_card($data_card) {

       $this->db->insert('sma_card_item', $data_card);
       return  $this->db->insert_id();

    }

    public function getCardByID($id)
    {
        $q = $this->db->get_where('sma_card_item', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getCardInforById($id) 
    {
        $this->db->select('sma_sim_companies.name as company_name,sma_card_item.date_sale, sma_sim_branches.branch_name as branch_name,sma_card_item.price,sma_card_item.quality,sma_card_item.commission,
            sma_card_item.unit_price,sma_card_item.reference_note,sma_users.username as seller_name');
        $this->db->from('sma_card_item');
        $this->db->join('sma_sim_companies','sma_sim_companies.id = sma_card_item.company_id');
        $this->db->join('sma_sim_branches','sma_sim_branches.id = sma_card_item.branch_id');
        $this->db->join('sma_users','sma_users.id = sma_card_item.use_sale_man_id');
        $this->db->where('sma_card_item.id', $id);
        return $this->db->get()->result_array();
    }

    public function getCardInfor($id) 
    {
        $this->db->select('*');
        $this->db->from('sma_card_item');
        $this->db->where('id',$id);
        return $this->db->get()->result_array();
    }

    public function update_card($data,$card_id) 
    {
        return $this->db->update('sma_card_item', $data, array('id' => $card_id));
    }

    public function deleteCard($id)
    {
        if ($this->db->delete('sma_card_item', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

}