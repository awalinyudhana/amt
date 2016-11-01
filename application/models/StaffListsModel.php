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

        $limit = $this->input->get('per_page') == null ? 10 : $this->input->get('per_page') ;

        $page = $this->input->get('page') == null ? 0 : $this->input->get('page') ;

        $offset = $this->input->get('page') == null ? 0 : ($page) * $limit;

        $query_where = '';
        if ($this->input->get('name') !== null || $this->input->get('status') !== null) {
            $query_where = "where";

            $query_name = null ;
            if ($this->input->get('name') !== null)
                $query_name = " q.name like '%". $this->input->get('name') ."%'";

            if($query_name !== null)
                $query_where .= " and"." ".$query_name;

            if ($this->input->get('status') !== null)
                $query_where .= " q.status_available = '". $this->input->get('name') ."'";
        }

        $all_query = $this->db->query("select q.* from ( select s.*, (select o.outlet_id from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_id, (select o.name from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_name, if(( select count(*) from issue i where  i.staff_id = s.staff_id and i.status = 'open') > 0, 'on', 'off' ) as status_available from staff s ) as q $query_where");

        $total_record = $all_query->num_rows();
        $total_page = ceil($total_record / $limit);

        $query = $this->db->query("select q.* from ( select s.*, (select o.outlet_id from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_id, (select o.name from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_name, if(( select count(*) from issue i where  i.staff_id = s.staff_id and i.status = 'open') > 0, 'on', 'off' ) as status_available from staff s ) as q $query_where limit $offset, $limit");


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
        $limit = $this->input->get('per_page') == null ? 10 : $this->input->get('per_page') ;

        $page = $this->input->get('page') == null ? 0 : $this->input->get('page') ;

        $offset = $this->input->get('page') == null ? 0 : ($page) * $limit;

        $this->db
            ->select('s.*')
            ->from('staff s')
            ->join('issue i', 'i.staff_id = s.staff_id', 'left')
            ->where('i.status', "open")
            ->where('i.staff_id IS NULL', null, false);

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $limit);

        $this->db
            ->select('s.*')
            ->from('staff s')
            ->join('issue i', 'i.staff_id = s.staff_id', 'left')
            ->where('i.status', "open")
            ->where('i.staff_id IS NULL', null, false)
            ->limit($limit, $offset);

        $this->repository = $this->db->get()->result();

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
}
