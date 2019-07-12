<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        // Carga de modelos
        $this->load->model('Model_Genetic');
        $this->load->model('Model_History');
    }

    function index()
    {

        $header_data = array(
            'title' => 'Hewks | Main Page',
            'author' => '',
            'description' => '',
            'keywords' => '',
            'links' => '',
        );

        $footer_data = array(
            'scripts' => array(
                'js/components/charts.js'
            )
        );

        // Vistas
        $this->load->view('pages/layouts/header_2', $header_data);
        $this->load->view('pages/main/charts/AB-chart');
        $this->load->view('pages/layouts/footer_1', $footer_data);
    }

    function chart_request()
    {
        header('Content-Type: application/json');

        $output = array();

        switch ($this->input->post('requestType')) {
            case 'diagnosticCases':
                $diagnostics_data = $this->Model_History->all();
                $chart_data = array(
                    'labels' => array(),
                    'data' => array()
                );
                $localities_data = [];
                $codes_data = [];
                foreach ($diagnostics_data as $diagnostic) {
                    if (!in_array($diagnostic['locality'], $localities_data)) {
                        array_push($localities_data, $diagnostic['locality']);
                    }
                    if (!in_array($diagnostic['diagnosticCode'], $codes_data)) {
                        array_push($codes_data, $diagnostic['diagnosticCode']);
                    }
                }
                $chart_data['labels'] = $localities_data;
                $localities_and_codes = array();
                $temp_local = [];
                foreach ($localities_data as $locality) {
                    $temp_codes = [];
                    foreach ($diagnostics_data as $diagnostic) {
                        if (!in_array($locality, $temp_local) && $locality == $diagnostic['locality']) {
                            array_push($temp_codes, $diagnostic['diagnosticCode']);
                        }
                    }
                    array_push($temp_local, $locality);
                    $localities_and_codes[] = array(
                        'locality' => $locality,
                        'codes' => $temp_codes
                    );
                }
                foreach ($localities_and_codes as $key => $locality) {
                    $localities_and_codes[$key]['codes'] = array_count_values($locality['codes']);
                }
                $chart_data['data'] = $localities_and_codes;
                $request_status = ($diagnostics_data) ? true : false;
                $output = array(
                    'charts' => [
                        array(
                            'chart' => 'AB-Chart',
                            'data' => $chart_data['data'],
                            'labels' => $chart_data['labels']
                        )
                    ],
                    'status' => $request_status
                );
                break;
        };

        echo json_encode($output);
        exit();
    }
}
