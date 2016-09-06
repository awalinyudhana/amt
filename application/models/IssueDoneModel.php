<?php

/**
 * Class IssueDoneModel
 */
class IssueDoneModel extends CI_Model
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

        if($this->repository->status === true)
            return [
                'status' => false,
                'message' => 'data tidak dapat diubah'
            ];

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
            'date_checkout' => date('Y-m-d h:i:s'),
            'note' => $this->input->post('note'),
            'attachment_checkout' => $filename
        ];

        $this->db
            ->where('issue_id', $this->input->post('issue_id'))
            ->update('issue', $data);

        if ($this->db->affected_rows > 0)
            return [
                'status' => true
            ];
    }
}