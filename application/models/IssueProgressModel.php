<?php

/**
 * Class IssueProgressModel
 */
class IssueProgressModel extends CI_Model
{

    /**
     * IssueDoneModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function save()
    {

        $this->repository = $this->db->get_where(
            'issue', array('issue_id' => $this->input->post('issue_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        if($this->repository->status != 'open')
            return [
                'status' => false,
                'message' => 'data tidak dapat diubah'
            ];


        $data = [
            'date_checkin' => date('Y-m-d h:i:s'),
            'status' => 'progress'
        ];

        $this->db
            ->where('issue_id', $this->input->post('issue_id'))
            ->update('issue', $data);

//        if ($this->db->affected_rows() > 0)
            return [
                'status' => true
            ];
    }
}