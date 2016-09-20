<?php

/**
 * Class OutletDetailModel
 */
class OutletDetailModel extends CI_Model
{
    /**
     * OutletDetailModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $params
     * @return array
     */
    public function detail()
    {
        $this->db
            ->select('*')
            ->from('outlet o')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 'staff_id = o.staff_id', 'left')
            ->where('o.outlet_id', $this->input->get('outlet_id'));

        $this->repository = $this->db->get()->row();

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