<?php

/**
 * Class OutletListsModel
 */
class OutletListsModel extends CI_Model
{
    /**
     * StaffDetailModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $params
     * @return array
     */
    public function index()
    {

        $this->db
            ->select('s.staff_id as staff_id, s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.outlet_id as outlet_id, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region o.contact as outlet_contact,, o.note as outlet_note')
            ->from('outlet o')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 'staff_id = o.staff_id', 'left');

        $this->repository = $this->db->get()->result();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        return [
            'status' => true,
            'data' => (array) $this->repository
        ];

    }
}