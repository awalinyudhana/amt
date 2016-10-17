<?php
require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Insert
 */
class Insert extends REST_Controller
{
    /**
     * Insert constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('IssueInsertModel', 'model');
    }

    public function index_post()
    {
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'trim|required|integer');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('issue', 'Issue', 'trim|required');

        if ($this->form_validation->run() == FALSE)
            $this->set_response(
                [
                    'status' => false,
                    'message' => validation_errors()
                ],
                REST_Controller::HTTP_BAD_REQUEST);

        $handler = $this->model->save();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_CREATED);
    }
}