<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cardsaledetail_model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    public function getCardItemInfor()
    {
    	$this->db->select('*');
    	$this->db->from('sma_card_item');
        return $this->db->get()->result_array();
    }

    public function getCardSaleInfor()
    {
    	$this->db->select('*');
    	$this->db->from('sma_sale_card');
        return $this->db->get()->result_array();
    }

    public function add_card_sale_detail($data) 
    {
    	$this->db->insert('sma_sale_card_detail', $data);
        return  $this->db->insert_id();
    }

    public function getCardSaleDetailInfor($id) 
    {
    	$this->db->select('*');
        $this->db->from('sma_sale_card_detail');
        $this->db->where('id',$id);
        return $this->db->get()->result_array();
    }

    public function udpate_card_sale_detail($data,$id) 
    {
    	return $this->db->update('sma_sale_card_detail', $data, array('id' => $id));
    }

    public function deleteCardSaleDetail($id)
    {
        if ($this->db->delete('sma_sale_card_detail', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function getCardSaleDetailInforById($id) 
    {
        $this->db->select("sma_sale_card_detail.quality,sma_card_item.code as code,sma_sale_card.title as title");
        $this->db->from("sma_sale_card_detail");
        $this->db->join('sma_card_item','sma_card_item.id = sma_sale_card_detail.use_card_item_id');
        $this->db->join('sma_sale_card','sma_sale_card.id = sma_sale_card_detail.use_sale_card_id');
        $this->db->where('sma_sale_card_detail.id', $id);
        return $this->db->get()->result_array();
    }


}