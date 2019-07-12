<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('genetic');
		$this->load->model('Model_Genetic');
		$this->load->model('Model_User');
	}

	function index()
	{

		$fecha = date('Y-m-d H:i:s');

		$user_data = $this->session->userdata();
		if (isset($user_data['login_date']) && strtotime($user_data['login_date'] . '+ 1 day') < strtotime($fecha)) {
				redirect(base_url().'Back/Administradores');		
		}

		$header_data = array(
			'title' => 'BackSurface | Hewks',
			'description' => '',
			'keywords' => '',
			'author' => 'Hewks',
			'links' => ''
		);

		$footer_data = array(
            'scripts' => array(
                'js/components/loginForm.js',
                'vendor/md5.js',
            )
        );


		$this->load->view('pages/layouts/header_2', $header_data);
		$this->load->view('pages/components/loginForm');
		$this->load->view('pages/layouts/footer_1', $footer_data);
	}

	function register()
	{
		$header_data = array(
			'title' => 'BackSurface | Hewks',
			'description' => '',
			'keywords' => '',
			'author' => 'Hewks',
			'links' => ''
		);

		$footer_data = array(
            'scripts' => array(
                'js/components/registerForm.js',
                'vendor/md5.js',
            )
        );

		$this->load->view('pages/layouts/header_2', $header_data);
		$this->load->view('pages/components/registerForm');
		$this->load->view('pages/layouts/footer_1', $footer_data);
	}

	function validate()
	{

		header('Content-Type: application/json');

		$output = array();
		$fecha = date('Y-m-d H:i:s');

		$login_data = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password')
		);

		if (!$this->genetic->validate_data($login_data)) {
			$output[] = array(
				'status' => false,
				'response' => 'No fue posible validar los datos.'
			);
		} else {
			if (!$this->Model_User->search_by('username', $login_data['username'])) {
				$output[] = array(
					'status' => false,
					'response' => 'El usuario no existe.'
				);
			} else {
				if (!$this->Model_User->validate($login_data)) {
					$output[] = array(
						'status' => false,
						'response' => 'Contraseña incorrecta.'
					);
				} else {
					$user_data = $this->Model_User->search_data_where(
						'username,email',
						array('username' => $login_data['username'])
					);
					if (!$this->genetic->validate_data($user_data)) {
						$output[] = array(
							'status' => false,
							'response' => 'Hubo un error en el servidor.'
						);
					} else {
						$output[] = array(
							'status' => true,
							'response' => 'El usuario se valido correctamente.'
						);
						$output[] = array(
							'status' => true,
							'response' => $user_data
						);
						$user_data = (array)$user_data;
						$user_data['login_date'] = $fecha;
						$this->session->set_userdata($user_data);
					}
				}
			}
		}

		echo json_encode($output);
		exit();
	}

	// CRUD

	function create()
	{

		header('Content-Type: application/json');

		$output = array();
		$fecha = date('Y-m-d H:i:s');

		$new_data = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'email' => $this->input->post('email'),
			'created_at' => $fecha,
			'updated_at' => $fecha
		);

		if (!$this->genetic->validate_data($new_data)) {
			$output[] = array(
				'status' => false,
				'response' => 'No fue posible validar los datos.'
			);
		} else {
			if ($this->Model_User->search_by('username', $new_data['username'])) {
				$output[] = array(
					'status' => false,
					'response' => 'El nombre de usuario ya esta en uso.'
				);
			} else {
				if ($this->Model_User->search_by('email', $new_data['email'])) {
					$output[] = array(
						'status' => false,
						'response' => 'El Correo electronico ya esta en uso.'
					);
				} else {
					if (!$this->Model_User->create($new_data)) {
						$output[] = array(
							'status' => false,
							'response' => 'Hubo un error en el servidor.'
						);
					} else {
						$output[] = array(
							'status' => true,
							'response' => 'El usuario se registro correctamente.'
						);
					}
				}
			}
		}

		echo json_encode($output);
		exit();
	}
}
