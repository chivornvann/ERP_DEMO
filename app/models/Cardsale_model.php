<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cardsale_model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    public function getCardBranchInfor() 
    {
    	$this->db->select('*');
    	$this->db->from('sma_card_branch');
        return $this->db->get()->result_array();

    }

    public function add_card_sale($data)
    {
    	$this->db->insert('sma_sale_card', $data);
        return  $this->db->insert_id();
    }

    public function getCardSaleInfor($id) 
    {
    	$this->db->select('*');
        $this->db->from('sma_sale_card');
        $this->db->where('id',$id);
        return $this->db->get()->result_array();
    }

    public function update_card_sale($data,$card_sale_id) 
    {
    	return $this->db->update('sma_sale_card', $data, array('id' => $card_sale_id));
    }

    public function deleteCardSale($id) 
    {
    	if ($this->db->delete('sma_sale_card', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function getCardSaleInforById($card_sale_id) 
    {
    	$this->db->select("sma_sale_card.title,sma_sale_card.date_sale,sma_card_branch.branch_name as card_branch_name,sma_users.username as username,sma_sale_card.reference_noted");
    	$this->db->from("sma_sale_card");
    	$this->db->join("sma_card_branch","sma_card_branch.id = sma_sale_card.use_card_branch_id");
    	$this->db->join('sma_users','sma_users.id = sma_sale_card.sale_man_id');
    	$this->db->where('sma_sale_card.id', $card_sale_id);
        return $this->db->get()->result_array();
    }

}