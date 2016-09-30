<?php

/**
 * Class StaffReportModel
 */
class StaffReportModel extends CI_Model
{
    /**
     * StaffReportModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $params
     * @return array
     */
    public function pending()
    {
        $this->input->get('staff_id');

        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 'staff_id = i.staff_id', 'left')
            ->where('i.staff_id', $this->input->get('staff_id'))
            ->where('i.status', false);

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

    /**
     * @return array
     */
    public function history()
    {
        $this->input->get('outlet_id');

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 'staff_id = i.staff_id', 'left')
            ->where('i.staff_id', $this->input->get('staff_id'))
            ->where('i.status', true);

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