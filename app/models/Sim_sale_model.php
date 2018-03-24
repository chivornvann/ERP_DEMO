<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_sale_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    
    public function getSimNumber($number, $limit = 5)
    {
        $this->db->select('s.sim_number,s.id, t.name as sim_type, c.name as sim_company, s.price');
        $this->db->from('sim s');
        $this->db->join('sim_types t', 't.id = s.use_sim_type_id');
        $this->db->join('sim_companies c', 'c.id = s.use_sim_company_id');
    	$this->db->like('sim_number', $number);
        $this->db->limit($limit);
        $this->db->where('s.is_saled', 0);
		$q = $this->db->get();
		
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function search($date, $biller_id){
        $this->db->select('d.name as sim_company, SUM(c.price) as price');
        $this->db->from('sim_sale_pos a');
        $this->db->join('sim_sale_pos_detail b', 'a.id = b.sim_sale_id');
        $this->db->join('sim c', 'c.id = b.sim_id');
        $this->db->join('sim_companies d', 'c.use_sim_company_id = d.id');
        $this->db->like('a.sale_date',$date);
        $this->db->where('a.biller_id',$biller_id);
        $this->db->group_by('d.id');
        $q = $this->db->get();
        if ($q->num_rows() > 0) 
        {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;

    }

    public function addSaleSim($sale,$sim) {
        if ($this->db->insert("sim_sale_pos", $sale)) 
        {
            $sale_id = $this->db->insert_id();
            $data = array();
            foreach ($sim['sim_id'] as $value) {
                $new_add = array('sim_sale_id' => $sale_id, 'sim_id' => $value, 'discount' => $sim['discount']);
                array_push($data,$new_add);
            }
            
            if ($this->db->insert_batch("sim_sale_pos_detail", $data)) {
                $this->db->where_in('id',$sim['sim_id']);
                $is_saled = array('is_saled' => 1,'is_in_stock' => 1, 'is_has_identify_card' => $sim['is_has_image'], 'identify_card_picture' => $sim['image']);
                if ($this->db->update('sim',$is_saled)) 
                {
                    return true;
                }
            }

            return false;
        }
        return false;
    }

}