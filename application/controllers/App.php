<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Xendit\Xendit;

class App extends CI_Controller {

	public $image = '';
	
	public function index()
	{
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
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

    public function create_invoice()
	{
		require APPPATH.'vendor/autoload.php';

		Xendit::setApiKey('xnd_development_rtmixBGRRVkoWJefkiE63EFhHUp19mdMj5i4ZGmP5YdDAicvvDhD5MPh0SnUW');


		//ambil data user
		foreach ($this->db->get_where('smartans_user', array('LEVEL'=>'user'))->result() as $key => $value) {

			$no_invoice = 'INV'.create_random(8);
			$total_power_usage = total_power_usage($value->LOCATION_ID,$value->ROOM_ID);
			$total_water_usage = total_water_usage($value->LOCATION_ID,$value->ROOM_ID);
			$tarif_room = $this->db->get_where('smartans_tarif', array('LOCATION_ID'=>$value->LOCATION_ID,'ROOM_NO'=>$value->ROOM_ID))->row()->TARIF_ROOM;
			$tarif_listrik = $this->db->get_where('smartans_tarif', array('LOCATION_ID'=>$value->LOCATION_ID,'ROOM_NO'=>$value->ROOM_ID))->row()->TARIF_LISTRIK;
			$tarif_air = $this->db->get_where('smartans_tarif', array('LOCATION_ID'=>$value->LOCATION_ID,'ROOM_NO'=>$value->ROOM_ID))->row()->TARIF_AIR;

			$total_tagihan = ($total_water_usage*$tarif_air) + ($total_power_usage*$tarif_listrik) + $tarif_room;

			$params = ['external_id' => $no_invoice,
			    'payer_email' => $value->EMAIL,
			    'description' => 'Pembayaran Kos',
			    'amount' => $total_tagihan
			];

			$createInvoice = \Xendit\Invoice::create($params);
			$id = $createInvoice['id'];

			$getInvoice = \Xendit\Invoice::retrieve($id);
			// log_data($getInvoice);
			$url_back = $getInvoice['invoice_url'];

			//simpan ke data tagihan header
			$this->db->insert('smartans_tagihan_header', array(
				'id_user'=> $value->ID_USER,
				'no_invoice'=> $no_invoice,
				'date_create'=> get_waktu(),
				'total_tagihan'=> $total_tagihan,
				'invoice_url'=> $url_back,
				'invoice_id_xendit'=> $id,
			));

			$id_tagihan = $this->db->insert_id();

			//simpan ke data tagihan detail
			$this->db->insert('smartans_tagihan_detail', array(
				'id_tagihan'=> $id_tagihan,
				'detail_tagihan'=> 'Kamar',
				'jumlah'=> $tarif_room
			));

			$this->db->insert('smartans_tagihan_detail', array(
				'id_tagihan'=> $id_tagihan,
				'detail_tagihan'=> 'Listrik',
				'jumlah'=>$total_power_usage*$tarif_listrik
			));

			$this->db->insert('smartans_tagihan_detail', array(
				'id_tagihan'=> $id_tagihan,
				'detail_tagihan'=> 'Air',
				'jumlah'=>$total_water_usage*$tarif_air
			));

			

		}

		echo "invoice berhasil dibuat";

		
	}

    public function cek_pembayaran()
    {

	    if ($_SERVER["REQUEST_METHOD"] === "POST") {
	        $data = file_get_contents("php://input");
	        log_r("\n\$data contains the updated invoice data \n\n");
	        log_r($data);
	        log_r("\n\nUpdate your database with the invoice status \n\n");
	    } else {
	        log_r("Cannot ".$_SERVER["REQUEST_METHOD"]." ".$_SERVER["SCRIPT_NAME"]);
	    }

    }

   
	

	

	
}
