<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	
	public function index() 
	{
		$this->load->view('login');
	}

	public function aksi_login()
	{
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			// $hashed = '$2y$10$LO9IzV0KAbocIBLQdgy.oeNDFSpRidTCjXSQPK45ZLI9890g242SG';
			$cek_user = $this->db->query("SELECT * FROM smartans_user WHERE email='$username' and password='$password' and ACTIVE_FLAG='y' ");
			// if (password_verify($password, $hashed)) {
			if ($cek_user->num_rows() > 0) {
				foreach ($cek_user->result() as $row) {
					
                    $sess_data['id_user'] = $row->ID_USER;
					$sess_data['nama'] = $row->FIRST_NAME.' '.$row->LAST_NAME;
					$sess_data['username'] = $row->EMAIL;
					$sess_data['foto'] = 'default.png';
					$sess_data['level'] = $row->LEVEL;
					$sess_data['location_id'] = $row->LOCATION_ID;
					$sess_data['room_id'] = $row->ROOM_ID;
					$this->session->set_userdata($sess_data);
				}

				// define('FOTO', $this->session->userdata('foto'), TRUE);
				

				// print_r($this->session->userdata());
				// exit;
				// $sess_data['username'] = $username;
				// $this->session->set_userdata($sess_data);
				if ($this->session->userdata('level') == 'superadmin') {
					redirect('app','refresh');
				} elseif ($this->session->userdata('level') == 'admin') {
					redirect('app','refresh');
				} elseif ($this->session->userdata('level') == 'user') {
					redirect('app','refresh');
				}

				// redirect('app/index');
			} else {
				$this->session->set_flashdata('message', alert_biasa('Gagal Login!\n username atau password kamu salah','warning'));
				// $this->session->set_flashdata('message', alert_tunggu('Gagal Login!\n username atau password kamu salah','warning'));
				redirect('login','refresh');
			}
	}

	public function daftar()
	{
		$data = array(
			'FIRST_NAME' => $this->input->post('first_name'),
			'LAST_NAME' => $this->input->post('last_name'),
			'MOBILE_NO' => $this->input->post('mobile_no'),
			'EMAIL' => $this->input->post('email'),
			'PASSWORD' => md5($this->input->post('password')),
			'LOCATION_ID' => $this->input->post('location_id'),
			'ROOM_ID' => $this->input->post('room_id'),
			'ACTIVE_FLAG' => 't',
			'LEVEL' => 'user',
		);
		$this->db->insert('smartans_user', $data);
		$this->session->set_flashdata('message', alert_biasa('Pendaftaran berhasil, silahkan menunggu aktivasi by admin','success'));
		redirect('login','refresh');
	}

	

	function logout()
	{
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('level');
		session_destroy();
		redirect('login','refresh');
	}
}
