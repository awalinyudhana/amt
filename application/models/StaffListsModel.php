<?php

/**
 * Class StaffListsModel
 */
class StaffListsModel extends CI_Model
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

        $limit = $this->input->get('per_page') == null ? 15 : $this->input->get('per_page') ;

        $page = $this->input->get('page') == null ? 0 : $this->input->get('page') ;

        $offset = $this->input->get('page') == null ? 0 : ($page - 1) * $limit;

        if ($this->input->get('key') !== null) {
            if (!$this->db->field_exists(strtolower($this->input->get('key')), 'staff'))
                return [
                    'status' => false,
                    'message' => 'parameter tidak cocok'
                ];

            $key = $this->input->get('key');
            $value = $this->input->get('value');
        }

        $all_query = $this->db->query("select q.* from ( select s.*, (select o.outlet_id from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_id, (select o.name from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_name, if(( select count(*) from issue i where  i.staff_id = s.staff_id and i.status = 'open') > 0, 'on', 'off' ) as status_available from staff s ) as q limit $offset, $limit");

        $total_record = $all_query->num_rows();
        $total_page = ceil($total_record / $limit);

        $query = $this->db->query("select q.* from ( select s.*, (select o.outlet_id from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_id, (select o.name from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_name, if(( select count(*) from issue i where  i.staff_id = s.staff_id and i.status = 'open') > 0, 'on', 'off' ) as status_available from staff s ) as q limit $offset, $limit");


        $this->repository = $query->result();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        $pagination = [
            'total_record' => $total_record,
            'total_page' => $total_page,
            'page' => $page,
            'per_page' => $limit
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
    public function available()
    {
//        $this->input->get('outlet_id');

        $this->db
            ->select('s.*')
            ->from('staff s')
            ->join('issue i', 'i.staff_id = s.staff_id', 'left')
            ->where('i.status', "open")
            ->where('i.staff_is IS NULL', null, false)
            ->

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
