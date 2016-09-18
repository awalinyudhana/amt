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
            ->select('*')
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