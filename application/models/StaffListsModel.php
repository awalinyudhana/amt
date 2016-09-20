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
        $offset = $this->input->get('page') == null ? 0 : $this->input->get('page') * $limit ;

        $result = $this->db->list_fields('staff');

        if ($this->input->get('key') !== null) {
            if (!in_array($this->input->get('key'), (array) $result)) {
                return [
                    'status' => false,
                    'message' => 'parameter tidak cocok'
                ];
            }

            $key = $this->input->get('key');
            $value = $this->input->get('value');
        }

        $query = $this->db->get('staff');

        $num_rows = ceil($query->num_rows() / $limit);

        if ($this->input->get('key') !== null and $this->input->get('value') !== null) {
            $query->db->where($key, $value);
        }

        $this->repository = $query->db->limit($limit, $offset)->result();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        $pagination = [
            'total_page' => $num_rows,
            'page' => $offset,
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
            ->where('i.status', false)
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
