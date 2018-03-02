<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getParentLocations()
    {
        $this->db->where('parent_id', NULL)->or_where('parent_id', 0);
        $q = $this->db->get("sim_locations");
        if ($q->num_rows() > 0) 
        {
            foreach (($q->result()) as $row) 
            {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getLocationByID($id)
    {
        $q = $this->db->get_where("sim_locations", array('id' => $id), 1);
        if ($q->num_rows() > 0) 
        {
            return $q->row();
        }
        return FALSE;
    }

    public function getLocationByCode($code)
    {
        $q = $this->db->get_where('sim_locations', array('code' => $code), 1);
        if ($q->num_rows() > 0) 
        {
            return $q->row();
        }
        return FALSE;
    }

    public function addSim($data)
    {
        if ($this->db->insert("sim", $data)) 
        {
            return true;
        }
        return false;
    }

    public function add_sims($sims = array())
    {
        if (!empty($sims)) 
        {
            foreach ($sims as $sim) 
            {
                $this->db->insert('sim', $sim);
            }
            return true;
        }
        return false;
    }

    public function deleteSim($id)
    {
        if ($this->db->delete('sim', array('id' => $id))) 
        {
            return true;
        }
        return FALSE;
    }

    public function getSimByID($id)
    {
        $q = $this->db->get_where('sim', array('id' => $id), 1);
        if ($q->num_rows() > 0) 
        {
            return $q->row();
        }
        return FALSE;
    }

    public function getSimNumber($sim_number)
    {
        $q = $this->db->get_where('sim', array('sim_number' => $sim_number), 1);
        if ($q->num_rows() > 0) 
        {
            return $q->row();
        }
        return FALSE;
    }

    public function getSimGroupID($group_name)
    {
        $q = $this->db->get_where('sim_groups', array('name' => $group_name), 1);
        if ($q->num_rows() > 0) 
        {
            $sim_group = $q->row();
            return $sim_group->id;
        }
        return 0;
    }

    public function getSimTypeID($type_name)
    {
        $q = $this->db->get_where('sim_types', array('name' => $type_name), 1);
        if ($q->num_rows() > 0) 
        {
            $sim_type = $q->row();
            return $sim_type->id;
        }
        return 0;
    }  

    public function getSimCompanyID($company_name)
    {
        $q = $this->db->get_where('sim_companies', array('name' => $company_name), 1);
        if ($q->num_rows() > 0) {
            $sim_company = $q->row();
            return $sim_company->id;
        }
        return 0;
    }

    public function getSimInforByID($id)
    {
        $this->db->select('s.sim_number, g.name as sim_group, t.name as sim_type, c.name as sim_company, s.is_saled, s.is_has_identify_card, s.identify_card_picture, s.is_in_stock, s.price');
        $this->db->from('sim s');
        $this->db->join('sim_groups g', 'g.id = s.use_sim_group_id');
        $this->db->join('sim_types t', 't.id = s.use_sim_type_id');
        $this->db->join('sim_companies c', 'c.id = s.use_sim_company_id');
        $this->db->where('s.id', $id);
       
        $q = $this->db->get();
        if ($q->num_rows() > 0) 
        {
            return $q->row() ;
        }
        return FALSE;
    }

    public function updateSim($data,$id)
    {
        if ($this->db->update("sim", $data, array('id' => $id))) 
        {
            return true;
        }
        return false;
    }

    public function addLocation($data)
    {
        if ($this->db->insert("sim_locations", $data)) 
        {
            return true;
        }
        return false;
    }

    public function addLocations($data)
    {
        if ($this->db->insert_batch('sim_locations', $data)) 
        {
            return true;
        }
        return false;
    }

    public function updateLocation($id, $data = array())
    {
        if ($this->db->update("sim_locations", $data, array('id' => $id))) 
        {
            return true;
        }
        return false;
    }

    public function deleteLocation($id)
    {
        if ($this->db->delete("sim_locations", array('id' => $id))) 
        {
            return true;
        }
        return FALSE;
    }
	
	public function addSimCompany($data)
    {
        if ($this->db->insert('sim_companies', $data)) 
        {
            return true;
        }
        return false;
    }

    public function updateSimCompany($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('sim_companies', $data)) 
        {
            return true;
        }
        return false;
    }

    public function getAllSimCompanies()
    {
        $q = $this->db->get('sim_companies');
        if ($q->num_rows() > 0) 
        {
            foreach (($q->result()) as $row) 
            {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSimCompanyByID($id)
    {
        $q = $this->db->get_where('sim_companies', array('id' => $id), 1);
        if ($q->num_rows() > 0) 
        {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteSimCompany($id)
    {
        if ($this->db->delete('sim_companies', array('id' => $id))) 
        {
            return true;
        }
        return FALSE;
    }
	
	public function addSimType($data)
    {
        if ($this->db->insert('sim_types', $data)) 
        {
            return true;
        }
        return false;
    }

    public function updateSimType($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('sim_types', $data)) 
        {
            return true;
        }
        return false;
    }

    public function getAllSimTypes()
    {
        $q = $this->db->get('sim_types');
        if ($q->num_rows() > 0) 
        {
            foreach (($q->result()) as $row) 
            {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSimTypeByID($id)
    {
        $q = $this->db->get_where('sim_types', array('id' => $id), 1);
        if ($q->num_rows() > 0) 
        {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteSimType($id)
    {
        if ($this->db->delete('sim_types', array('id' => $id))) 
        {
            return true;
        }
        return FALSE;
    }
	
	public function addSimStockType($data)
    {
        if ($this->db->insert('sim_stock_types', $data)) 
        {
            return true;
        }
        return false;
    }

    public function updateSimStockType($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('sim_stock_types', $data)) 
        {
            return true;
        }
        return false;
    }

    public function getAllSimStockTypes()
    {
        $q = $this->db->get('sim_stock_types');
        if ($q->num_rows() > 0) 
        {
            foreach (($q->result()) as $row) 
            {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSimStockTypeByID($id)
    {
        $q = $this->db->get_where('sim_stock_types', array('id' => $id), 1);
        if ($q->num_rows() > 0) 
        {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteSimStockType($id)
    {
        if ($this->db->delete('sim_stock_types', array('id' => $id))) 
        {
            return true;
        }
        return FALSE;
    }








    public function getAllSimBranches()
    {
        $q = $this->db->get('sim_branches');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSimBranchByID($id)
    {

        $q = $this->db->get_where('sim_branches', array('id' => $id), 1);
        if ($q->num_rows() > 0) {

            return $q->row();
        }
        return FALSE;
    }

    public function addSimBranch($data)
    {

        if ($this->db->insert("sim_branches", $data)) {

            return true;
        }
        return false;
    }

    public function updateSimBranch($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update("sim_branches", $data)) {

            return true;
        }
        return false;
    }

    public function deleteSimBranch($id)
    {

        if ($this->db->delete("sim_branches", array('id' => $id))) {

            return true;
        }
        return FALSE;
    }





    public function addSimGroup($data)
    {
        if ($this->db->insert('sim_groups', $data)) 
        {
            return true;
        }
        return false;
    }

    public function updateSimGroup($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('sim_groups', $data))
         {
            return true;
        }
        return false;
    }

    public function getAllSimGroups()
    {
        $q = $this->db->get('sim_groups');
        if ($q->num_rows() > 0) 
        {
            foreach (($q->result()) as $row) 
            {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSimGroupByID($id)
    {
        $q = $this->db->get_where('sim_groups', array('id' => $id), 1);
        if ($q->num_rows() > 0) 
        {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteSimGroup($id)
    {
        if ($this->db->delete('sim_groups', array('id' => $id))) 
        {
            return true;
        }
        return FALSE;
    }













    public function addSimShop($data)
    {
        if ($this->db->insert('sim_shops', $data)) {
            return true;
        }
        return false;
    }

    public function updateSimShop($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('sim_shops', $data)) {
            return true;
        }
        return false;
    }

    public function getAllSimShops()
    {
        $q = $this->db->get('sim_shops');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSimShopByID($id)
    {
        $q = $this->db->get_where('sim_shops', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteSimShop($id)
    {
        if ($this->db->delete('sim_shops', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }
}
