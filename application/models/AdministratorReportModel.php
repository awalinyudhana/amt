<?php

/**
 * Class AdministratorReportModel
 */
class AdministratorReportModel extends CI_Model
{
    /**
     * AdministratorReportModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $params
     * @return array
     */
    public function queue()
    {
        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 'staff_id = i.staff_id', 'left')
            ->where('i.staff_id IS NULL', null, false)
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
     * @param $params
     * @return array
     */
    public function pending()
    {
        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 'staff_id = i.staff_id', 'left')
            ->where('i.staff_id IS NOT NULL', null, false)
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

        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 'staff_id = i.staff_id', 'left')
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