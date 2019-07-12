<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientes extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('genetic');
        $this->load->model('Model_Genetic');
        $this->load->model('Model_Customer');
    }

    function index()
    {

        $fecha = date('Y-m-d H:i:s');

        $user_data = $this->session->userdata();
        if (isset($user_data['login_date']) && strtotime($fecha) > strtotime($user_data['login_date'] . '+ 1 day')) {
            $unset_items = array('username', 'email', 'login_date');
            $this->session->unset_userdata($unset_items);
            redirect(base_url() . 'Login');
        }

        $header_data = array(
            'title' => 'BackSurface | Hewks',
            'description' => '',
            'keywords' => '',
            'author' => 'Hewks',
            'links' => ''
        );

        $section_data = array(
            'page_title' => 'Clientes',
            'section' => 'Clientes'
        );

        $footer_data = array(
            'scripts' => array(
                'vendor/md5.js',
                'js/components/pages/customersTableSection.js',
            )
        );

        $this->load->view('pages/layouts/header_3', $header_data);
        $this->load->view('pages/main/clientes', $section_data);
        $this->load->view('pages/layouts/footer_1', $footer_data);
    }

    function data_table()
    {
        header('Content-Type: application/json');

        $output = array();

        switch ($this->input->post('requestType')) {
            case 'all':
                $all_data = $this->Model_Customer->all('table');
                if (!($this->genetic->validate_data($all_data))) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No fue posible hallar los datos'
                    );
                } else {
                    $output[] = array(
                        'status' => true,
                        'response' => 'Los datos se hallaron correctamente'
                    );
                    $output[] = array(
                        'tableData' => $all_data
                    );
                }
                break;
            case 'one':
                $one_data = $this->Model_Customer->one($this->input->post('id'));
                if (!($this->genetic->validate_data($one_data))) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No fue posible hallar los datos'
                    );
                } else {
                    $output[] = array(
                        'status' => true,
                        'response' => 'Los datos se hallaron correctamente'
                    );
                    $output[] = array(
                        'tableData' => $one_data
                    );
                }
                break;
            case 'histories':
                $one_data = $this->Model_Customer->search_history_by_customer($this->input->post('id'));
                if ($one_data == false) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No hay historia clinica.'
                    );
                } else {
                    if (!($this->genetic->validate_data($one_data))) {
                        $output[] = array(
                            'status' => false,
                            'response' => 'No hay historia clinica.'
                        );
                    } else {
                        $output[] = array(
                            'status' => true,
                            'response' => 'Los datos se hallaron correctamente'
                        );
                        $output[] = array(
                            'modalData' => $one_data,
                            'id' => $this->input->post('id')
                        );
                    }
                }

                break;
        }

        echo json_encode($output);
        exit();
    }

    function create_pdf()
    {

        $this->load->library('Pdf');
        $pdf = $this->pdf->load();

        $customer_id = $this->input->get('customer_id');
        $history_id = $this->input->get('history_id');

        switch ($this->input->get('request')) {
            case 'history':
                $customer_data = $this->Model_Customer->customer_data($customer_id);
                $history_data = $this->Model_Customer->history_request($history_id);
                $pdf_table_body = '';
                $pdf_data = array(
                    'fecha' => date('Y-m-d H:i:s'),
                    'title' => 'Cliente',
                    'pdf_history' => array(
                        'customer_data' => $customer_data,
                        'history_data' => $history_data
                    )
                );
                $html = $this->genetic->create_html_to_pdf_history($pdf_data);
                $pdf->loadHtml($html);
                $pdf->setPaper('A4', 'landscape');
                $pdf->render();
                $pdf->stream();
                break;
            default:
                $table_data = $this->Model_Customer->all();
                $pdf_table_body = '';
                foreach ($table_data as $data) {
                    $pdf_table_body .= '<tr>';
                    $pdf_table_body .= '<th>' . $data->id . '</th>';
                    $pdf_table_body .= '<th>' . $data->nombres . '</th>';
                    $pdf_table_body .= '<th>' . $data->identificacion . '</th>';
                    $pdf_table_body .= '<th>' . $data->tipo_identificacion . '</th>';
                    $pdf_table_body .= '</tr>';
                }
                $pdf_data = array(
                    'fecha' => date('Y-m-d H:i:s'),
                    'title' => 'Clientes',
                    'thead' => array('ID', 'Nombre', 'Documento', 'Tipo'),
                    'tbody' => $pdf_table_body
                );
                $html = $this->genetic->create_html_to_pdf($pdf_data);
                $pdf->loadHtml($html);
                $pdf->setPaper('A4', 'landscape');
                $pdf->render();
                $pdf->stream();
                break;
        }
    }
}
