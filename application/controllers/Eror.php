<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eror extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('level') == '') {
            redirect('login');
        }
	}
	
	public function index()
	{
		$data = array(
			'konten' => 'page404',
            'judul_page' => 'Halaman Tidak ditemukan',
		);
		$this->load->view('v_index', $data);
		// echo "tira";
	}

}
