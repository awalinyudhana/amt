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
                'status' => 'open'
            ));

        $staff_id = $this->is_available_staff_repository->num_rows() > 0 ? null : $this->outlet_repository->staff_id;

        $filename = null;

        if(!empty($_FILES['filename']['name'])) {
            $filesCount = count($_FILES['filename']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['filename']['name'] = $_FILES['filename']['name'][$i];
                $_FILES['filename']['type'] = $_FILES['filename']['type'][$i];
                $_FILES['filename']['tmp_name'] = $_FILES['filename']['tmp_name'][$i];
                $_FILES['filename']['error'] = $_FILES['filename']['error'][$i];
                $_FILES['filename']['size'] = $_FILES['filename']['size'][$i];

                $uploadPath = './uploads/issue';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['max_width'] = '1024';
                $config['max_height'] = '768';
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('filename')) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                }
            }
        }


        $status = $staff_id == null ? "pending" : "open";
        $data = [
            'staff_id' => $staff_id,
            'subject' => $this->input->post('subject'),
            'issue' => $this->input->post('issue'),
            'outlet_id' => $this->input->post('outlet_id'),
            'attachment' => implode(";", $uploadData),
            'status' => $status,
        ];

        $this->db->insert('issue', $data);

//        if ($this->db->affected_rows() > 0)
            return [
                'status' => true
            ];
    }
}