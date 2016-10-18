<?php

/**
 * Class NotificationReadModel
 */
class NotificationReadModel extends CI_Model
{

    /**
     * NotificationReadModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function staff()
    {

        $this->repository = $this->db->get_where(
            'notification', array('notification_id' => $this->input->post('notification_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];


        $data = [
            'staff_status' => true
        ];

        $this->db
            ->where('notification_id', $this->input->post('notification_id'))
            ->update('notification', $data);

//        if ($this->db->affected_rows() > 0)
        return [
            'status' => true
        ];
    }

    public function outlet()
    {

        $this->repository = $this->db->get_where(
            'notification', array('notification_id' => $this->input->post('notification_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];


        $data = [
            'outlet_status' => true
        ];

        $this->db
            ->where('notification_id', $this->input->post('notification_id'))
            ->update('notification', $data);

//        if ($this->db->affected_rows() > 0)
        return [
            'status' => true
        ];
    }

    public function administrator()
    {

        $this->repository = $this->db->get_where(
            'notification', array('notification_id' => $this->input->post('notification_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];


        $data = [
            'administrator_status' => true
        ];

        $this->db
            ->where('notification_id', $this->input->post('notification_id'))
            ->update('notification', $data);

//        if ($this->db->affected_rows() > 0)
        return [
            'status' => true
        ];
    }
}