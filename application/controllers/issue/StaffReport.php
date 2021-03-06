<?php

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class StaffReport
 */
class StaffReport extends REST_Controller
{
    /**
     * StaffReport constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('StaffReportModel', 'model');
    }

    public function pending_get()
    {
        if(!$this->input->get('staff_id'))
            $this->set_response(
                [
                    'status' => false,
                    'message' => "data tidak ditemukan."
                ],
                REST_Controller::HTTP_BAD_REQUEST);

        $handler = $this->model->pending();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

    public function history_get()
    {
        if(!$this->input->get('staff_id'))
            $this->set_response(
                [
                    'status' => false,
                    'message' => "data tidak ditemukan."
                ],
                REST_Controller::HTTP_BAD_REQUEST);

        $handler = $this->model->history();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

    public function transaction_get()
    {
        $handler = $this->model->transaction();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }
}
