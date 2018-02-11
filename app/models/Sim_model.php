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
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getLocationByID($id)
    {
        $q = $this->db->get_where("sim_locations", array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getLocationByCode($code)
    {
        $q = $this->db->get_where('sim_locations', array('code' => $code), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addLocation($data)
    {
        if ($this->db->insert("sim_locations", $data)) {
            return true;
        }
        return false;
    }

    public function addLocations($data)
    {
        if ($this->db->insert_batch('sim_locations', $data)) {
            return true;
        }
        return false;
    }

    public function updateLocation($id, $data = array())
    {
        if ($this->db->update("sim_locations", $data, array('id' => $id))) {
            return true;
        }
        return false;
    }

    public function deleteLocation($id)
    {
        if ($this->db->delete("sim_locations", array('id' => $id))) {
            return true;
        }
        return FALSE;
    }
	
	
	
	
	
	public function addSimCompany($data)
    {
        if ($this->db->insert('sim_companies', $data)) {
            return true;
        }
        return false;
    }

    public function updateSimCompany($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('sim_companies', $data)) {
            return true;
        }
        return false;
    }

    public function getAllSimCompanies()
    {
        $q = $this->db->get('sim_companies');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSimCompanyByID($id)
    {
        $q = $this->db->get_where('sim_companies', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteSimCompany($id)
    {
        if ($this->db->delete('sim_companies', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }
	
	
	
	
	
	
	public function addSimType($data)
    {
        if ($this->db->insert('sim_types', $data)) {
            return true;
        }
        return false;
    }

    public function updateSimType($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('sim_types', $data)) {
            return true;
        }
        return false;
    }

    public function getAllSimTypes()
    {
        $q = $this->db->get('sim_types');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSimTypeByID($id)
    {
        $q = $this->db->get_where('sim_types', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteSimType($id)
    {
        if ($this->db->delete('sim_types', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }
	
	
	
	
	
	public function addSimStockType($data)
    {
        if ($this->db->insert('sim_stock_types', $data)) {
            return true;
        }
        return false;
    }

    public function updateSimStockType($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('sim_stock_types', $data)) {
            return true;
        }
        return false;
    }

    public function getAllSimStockTypes()
    {
        $q = $this->db->get('sim_stock_types');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSimStockTypeByID($id)
    {
        $q = $this->db->get_where('sim_stock_types', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteSimStockType($id)
    {
        if ($this->db->delete('sim_stock_types', array('id' => $id))) {
            return true;
        }
        return FALSE;
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

    public function addSimShop($data)
    {
        if ($this->db->insert("sim_shops", $data)) {
            return true;
        }
        return false;
    }

    public function updateSimShop($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update("sim_shops", $data)) {
            return true;
        }
        return false;
    }

    public function deleteSimShop($id)
    {
        if ($this->db->delete("sim_shops", array('id' => $id))) {
            return true;
        }
        return FALSE;
    }





    public function addSimGroup($data)
    {
        if ($this->db->insert('sim_groups', $data)) {
            return true;
        }
        return false;
    }

    public function updateSimGroup($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('sim_groups', $data)) {
            return true;
        }
        return false;
    }

    public function getAllSimGroups()
    {
        $q = $this->db->get('sim_groups');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSimGroupByID($id)
    {
        $q = $this->db->get_where('sim_groups', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteSimGroup($id)
    {
        if ($this->db->delete('sim_groups', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }
}
