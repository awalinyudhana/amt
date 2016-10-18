<?php

/**
 * Class NotificationOutletModel
 */
class NotificationOutletModel extends CI_Model
{
    /**
     * NotificationOutletModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $params
     * @return array
     */
    public function all()
    {

        $this->db
            ->select('n.*, i.subject, o.name  as outlet_name, s.name as staff_name')
            ->from('notification n')
            ->join('issue i', 'i.issue_id = n.id', 'left')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = o.staff_id', 'left')
//            ->where('i.staff_id IS NULL', null, false)
            ->where('n.status_outlet', false)
            ->where('o.outlet_id', $this->input->get('outlet_id'));

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
            ->select('n.*, i.subject, o.name  as outlet_name, s.name as staff_name')
            ->from('notification n')
            ->join('issue i', 'i.issue_id = n.id', 'left')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = o.staff_id', 'left')
//            ->where('i.staff_id IS NULL', null, false)
            ->where('n.type', 'pending')
            ->where('n.status_outlet', false)
            ->where('o.outlet_id', $this->input->get('outlet_id'));

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
    public function checkin()
    {

        $this->db
            ->select('n.*, i.subject, o.name  as outlet_name, s.name as staff_name')
            ->from('notification n')
            ->join('issue i', 'i.issue_id = n.id', 'left')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = o.staff_id', 'left')
//            ->where('i.staff_id IS NULL', null, false)
            ->where('n.type', 'checkin')
            ->where('n.status_outlet', false)
            ->where('o.outlet_id', $this->input->get('outlet_id'));

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
    public function checkout()
    {

        $this->db
            ->select('n.*, i.subject, o.name  as outlet_name, s.name as staff_name')
            ->from('notification n')
            ->join('issue i', 'i.issue_id = n.id', 'left')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = o.staff_id', 'left')
//            ->where('i.staff_id IS NULL', null, false)
            ->where('n.type', 'checkout')
            ->where('n.status_outlet', false)
            ->where('o.outlet_id', $this->input->get('outlet_id'));

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