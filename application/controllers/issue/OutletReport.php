<?php

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class OutletReport
 */
class OutletReport extends REST_Controller
{
    /**
     * OutletReport constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('OutletReportModel', 'model');

        if(!$this->input->get('outlet_id'))
            $this->set_response(
                [
                    'status' => false,
                    'message' => "data tidak ditemukan."
                ],
                REST_Controller::HTTP_NO_CONTENT);
    }

    public function pending_get()
    {
        $handler = $this->model->pending();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

    public function history_get()
    {
        $handler = $this->model->history();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }
}
