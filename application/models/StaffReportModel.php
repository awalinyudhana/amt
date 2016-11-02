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

    public function transaction()
    {
        $limit = $this->input->get('per_page') == null ? 10 : $this->input->get('per_page') ;

        $page = $this->input->get('page') == null ? 0 : $this->input->get('page') ;

        $offset = $this->input->get('page') == null ? 0 : ($page) * $limit;

        if($this->input->get('subject') !== null) {
            switch($this->input->post('subject')) {
                case 'week':
                    $day = date('w');
                    $date_start = date('Y-m-d', strtotime('+'.(1-$day).' days'));
                    break;
                case 'month':
                    $date_start = date('Y-m-1');
                    break;
                case 'year':
                    $date_start = date('Y-1-1');
                    break;
                default:
                    $date_start = null;
            }

            $date_end = date('Y-m-d');
        } else if($this->input->get('from') !== null and $this->input->get('subject') !== to) {
            $date_start = $this->input->get('from');
            $date_end = $this->input->get('to');
        } else {
            $date_start = null;
            $date_end = date('Y-m-d');
        }

        $on_select_where = '';
        if ($date_start !== null) {
            $on_select_where = "AND i.date_request >=  '$date_start' AND i.date_request <=  '$date_end'";
        }

        $query_where = '';
        if ($this->input->get('name') !== null) {
            $query_where = "where";

            $query_name = null ;
            if ($this->input->get('name') !== null)
                $query_name = " s.name like '%". $this->input->get('name') ."%'";

            if($query_name !== null)
                $query_where .= " and"." ".$query_name;
        }

        $all_query = $this->db->query("SELECT * FROM staff s $query_where");

        $total_record = $all_query->num_rows();
        $total_page = ceil($total_record / $limit);
        $query = $this->db->query("SELECT s.*, (SELECT COUNT( i.issue_id ) FROM issue i WHERE i.staff_id = s.staff_id AND i.status =  'done' $on_select_where) AS total_issue FROM staff s $query_where limit $offset, $limit");

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
}