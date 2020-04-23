<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public $image = '';

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
			'konten' => 'home_admin',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function admin()
	{
        // if ($this->session->userdata('username') == '') {
        //     redirect('app/login');
        // }
		$data = array(
			'konten' => 'home_admin',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function ubah_profil($id_user)
    {
        if ($_POST) {
            if ($_POST['pass_new1'] != $_POST['pass_new2']) {
                $this->session->set_flashdata('message', alert_biasa('Password tidak sama, silahkan ulangi lagi !','info'));
                redirect('app/ubah_profil/'.$id_user,'refresh');
                exit();
            }
            $this->db->where('id_user', $id_user);
            $this->db->update('smartans_user', array(
                'password' => md5($_POST['pass_new1'])
            ));
            $this->session->set_flashdata('message', alert_biasa('Password berhasil dirubah, silahkan login lagi !','success'));
            redirect('login','refresh');
        } else {
            $data = array(
                'konten' => 'ubah_profil',
                'judul_page' => 'Ubah Password',
            );
            $this->load->view('v_index', $data);
        }
    }

    public function detail_air($bulan,$tahun)
    {
        
        $data = array(
            'konten' => 'detail_water_usage1',
            'judul_page' => 'Water Usage',
            'bulan'=>$bulan,
            'tahun'=>$tahun,
        );
        $this->load->view('v_index', $data);
    }

    public function detail_listrik($bulan,$tahun)
    {
        
        $data = array(
            'konten' => 'detail_power_usage1',
            'judul_page' => 'Power Usage',
            'bulan'=>$bulan,
            'tahun'=>$tahun,
        );
        $this->load->view('v_index', $data);
    }

    public function detail_inv($id)
    {
        $data = array(
            'konten' => 'detail_billing',
            'judul_page' => 'Detail Billing',
        );
        $this->load->view('v_index', $data);
    }

    public function power_usage()
    {
    	if ($_GET) {
    		$data = array(
				'konten' => 'detail_power_usage',
	            'judul_page' => 'Power Usage',
			);
			$this->load->view('v_index', $data);
    	}else{
    		$data = array(
				'konten' => 'power_usage',
	            'judul_page' => 'Power Usage',
			);
			$this->load->view('v_index', $data);
    	}
    }

    public function aktifkan_akun($id_user)
    {
    	$this->db->where('ID_USER', $id_user);
    	$this->db->update('smartans_user', array('ACTIVE_FLAG'=>'y'));
    	redirect('smartans_user','refresh');
    }

    public function add_pembayaran($no_invoice,$total_tagihan)
    {
    	$data = array(
			'konten' => 'pembayaran/add',
            'judul_page' => 'Tambah Pembayaran',
            'no_invoice'=>$no_invoice,
            'total_tagihan'=>$total_tagihan,
		);
		$this->load->view('v_index', $data);
    }

    public function simpan_pembayaran()
    {
    	$_POST['date_create']=get_waktu();
    	$this->db->insert('smartans_pembayaran', $_POST);
    	$this->db->where('no_invoice', $_POST['no_invoice']);
    	$this->db->update('smartans_tagihan_header', array('status'=>'PAID'));
    	$this->session->set_flashdata('message', alert_biasa('Pembayaran berhasil disimpan !','success'));
		redirect('app/billing_list','refresh');
    }

    public function send_inv()
    {
    	$data = array(
			'konten' => 'kirim_invoice',
            'judul_page' => 'Create Invoice',
		);
		$this->load->view('v_index', $data);
    }

    public function water_usage()
    {
    	if ($_GET) {
    		$data = array(
				'konten' => 'detail_water_usage',
	            'judul_page' => 'Water Usage',
			);
			$this->load->view('v_index', $data);
    	}else{
    		$data = array(
				'konten' => 'water_usage',
	            'judul_page' => 'Water Usage',
			);
			$this->load->view('v_index', $data);
    	}
    }

    public function billing_list()
    {
    	$data = array(
			'konten' => 'billing_list',
            'judul_page' => 'Billing List',
		);
		$this->load->view('v_index', $data);
    }

    

   
	

	

	
}
