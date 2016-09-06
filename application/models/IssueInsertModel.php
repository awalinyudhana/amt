<?php

/**
 * Class IssueInsertModel
 */
class IssueInsertModel extends CI_Model
{

    /**
     * IssueInsertModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function save()
    {
        $this->outlet_repository = $this->db->get_where(
            'outlet', array('outlet_id' => $this->input->post('outlet_id')))->row();

        if($this->outlet_repository === null)
            return [
                'status' => false,
                'message' => 'data outlet tidak ditemukan'
            ];

        $this->is_available_staff_repository = $this->db->get_where(
            'issue',
            array(
                'staff_id' => $this->outlet_repository->staff_id,
                'status' => false
            ))->result();

        $staff_id = $this->is_available_staff_repository->num_rows() > 0 ? null : $this->outlet_repository->staff_id;

        $filename = null;

        if (isset($_FILES['filename']['size']) && ($_FILES['filename']['size'] > 0)) {
            $upload_path = './uploads/issue';

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2048';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file') === false)
                return [
                    'status' => false,
                    'message' => $this->upload->display_errors()
                ];

            $filename = $this->upload->data()['file_name'];
        }

        $data = [
            'staff_id' => $staff_id,
            'subject' => $this->input->post('subject'),
            'issue' => $this->input->post('issue'),
            'outlet_id' => $this->input->post('outlet_id'),
            'attachment' => $filename,
            'status' => false,
        ];

        $this->db->insert('issue', $data);

        if ($this->db->affected_rows > 0)
            return [
                'status' => true
            ];
    }
}