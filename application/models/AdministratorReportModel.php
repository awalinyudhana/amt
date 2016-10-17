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

        $this->limit = $this->input->get('per_page') == null ? 10 : $this->input->get('per_page') ;

        $this->page = $this->input->get('page') == null ? 0 : $this->input->get('page') ;

        $this->offset = $this->input->get('page') == null ? 0 : ($this->page) * $this->limit;
    }

    /**
     * @param $params
     * @return array
     */
    public function all()
    {
        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('staff s', 'staff_id = i.staff_id', 'left');

        if ($this->input->get('status') !== null)
            $this->db->where('i.status', $this->input->get('status'));

        if ($this->input->get('staff') !== null)
            $this->db->like('s.name', $this->input->get('staff'), 'both');

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 'staff_id = i.staff_id', 'left')
//            ->where('i.staff_id IS NULL', null, false)
            ->limit($this->limit, $this->offset);

        if ($this->input->get('status') !== null)
            $this->db->where('i.status', $this->input->get('status'));

        if ($this->input->get('staff') !== null)
            $this->db->like('s.name', $this->input->get('staff'), 'both');

        $this->repository = $this->db->get()->result();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        $pagination = [
            'total_record' => $total_record,
            'total_page' => $total_page,
            'page' => $this->page,
            'per_page' => $this->limit
        ];

        return [
            'status' => true,
            'pagination' => $pagination,
            'data' => (array) $this->repository
        ];
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
//            ->where('i.staff_id IS NULL', null, false)
            ->where('i.status', "open");

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 'staff_id = i.staff_id', 'left')
//            ->where('i.staff_id IS NULL', null, false)
            ->where('i.status', "open")
            ->limit($this->limit, $this->offset);

        $this->repository = $this->db->get()->result();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        $pagination = [
            'total_record' => $total_record,
            'total_page' => $total_page,
            'page' => $this->page,
            'per_page' => $this->limit
        ];

        return [
            'status' => true,
            'pagination' => $pagination,
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
//            ->join('staff s', 'staff_id = i.staff_id', 'left')
//            ->where('i.staff_id IS NOT NULL', null, false)
            ->where('i.status', "pending");

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
//            ->join('staff s', 'staff_id = i.staff_id', 'left')
//            ->where('i.staff_id IS NOT NULL', null, false)
            ->where('i.status', "pending")
            ->limit($this->limit, $this->offset);

        $this->repository = $this->db->get()->result();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        $pagination = [
            'total_record' => $total_record,
            'total_page' => $total_page,
            'page' => $this->page,
            'per_page' => $this->limit
        ];

        return [
            'status' => true,
            'pagination' => $pagination,
            'data' => (array) $this->repository
        ];

    }

    /**
     * @param $params
     * @return array
     */
    public function progress()
    {
        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
//            ->join('staff s', 'staff_id = i.staff_id', 'left')
//            ->where('i.staff_id IS NOT NULL', null, false)
            ->where('i.status', "progress");

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
//            ->join('staff s', 'staff_id = i.staff_id', 'left')
//            ->where('i.staff_id IS NOT NULL', null, false)
            ->where('i.status', "progress")
            ->limit($this->limit, $this->offset);

        $this->repository = $this->db->get()->result();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        $pagination = [
            'total_record' => $total_record,
            'total_page' => $total_page,
            'page' => $this->page,
            'per_page' => $this->limit
        ];

        return [
            'status' => true,
            'pagination' => $pagination,
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
//            ->join('building b', 'b.building_id = o.building_id', 'left')
//            ->join('staff s', 'staff_id = i.staff_id', 'left')
            ->where('i.status', "done");

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
//            ->join('staff s', 'staff_id = i.staff_id', 'left')
            ->where('i.status', "done")
            ->limit($this->limit, $this->offset);

        $this->repository = $this->db->get()->result();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        $pagination = [
            'total_record' => $total_record,
            'total_page' => $total_page,
            'page' => $this->page,
            'per_page' => $this->limit
        ];

        return [
            'status' => true,
            'pagination' => $pagination,
            'data' => (array) $this->repository
        ];
    }
}