<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eror extends CI_Controller {

	
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
