<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Xendit\Xendit;

class Web extends CI_Controller {

	
	public function index()
	{
		$this->load->view('f_home');
	}

	public function create_invoice()
	{
		require APPPATH.'vendor/autoload.php';

		Xendit::setApiKey('xnd_development_rtmixBGRRVkoWJefkiE63EFhHUp19mdMj5i4ZGmP5YdDAicvvDhD5MPh0SnUW');


		//ambil data user
		$LOCATION_ID = $this->input->post('LOCATION_ID');
		$ROOM_ID = $this->input->post('ROOM_ID');
		$EMAIL = $this->input->post('email');
		$BULAN = $this->input->post('bulan');
		$TAHUN = $this->input->post('tahun');
		
		$this->db->where('LEVEL', 'user');
		$this->db->where('LOCATION_ID', $LOCATION_ID);
		if ($ROOM_ID != '0') {
			$this->db->where('ROOM_ID', $ROOM_ID);
		}
		foreach ($this->db->get('smartans_user')->result() as $key => $value) {

			$no_invoice = create_random(8);
			$total_power_usage = total_power_usage($value->LOCATION_ID,$value->ROOM_ID,$BULAN);
			$total_water_usage = total_water_usage($value->LOCATION_ID,$value->ROOM_ID,$BULAN);
			$tarif_room = $this->db->get_where('smartans_tarif', array('LOCATION_ID'=>$value->LOCATION_ID,'ROOM_NO'=>$value->ROOM_ID))->row()->TARIF_ROOM;
			$tarif_listrik = $this->db->get_where('smartans_tarif', array('LOCATION_ID'=>$value->LOCATION_ID,'ROOM_NO'=>$value->ROOM_ID))->row()->TARIF_LISTRIK;
			$tarif_air = $this->db->get_where('smartans_tarif', array('LOCATION_ID'=>$value->LOCATION_ID,'ROOM_NO'=>$value->ROOM_ID))->row()->TARIF_AIR;

			$total_tagihan = ($total_water_usage*$tarif_air) + ($total_power_usage*$tarif_listrik) + $tarif_room;

			$params = ['external_id' => $no_invoice,
			    'payer_email' => $value->EMAIL,
			    'description' => 'Pembayaran Kos',
			    'amount' => $total_tagihan
			];
			$url_back = '';
			$paygate_status = $this->db->get_where('smartans_location', array('LOCATION_ID'=>$LOCATION_ID))->row()->PAYGATE_FLAG;
	        if ($paygate_status == '0') {
	          # code...
	        }else{

				$createInvoice = \Xendit\Invoice::create($params);
				$id = $createInvoice['id'];

				$getInvoice = \Xendit\Invoice::retrieve($id);
				// log_data($getInvoice);
				$url_back = $getInvoice['invoice_url'];
			}
			//simpan ke data tagihan header
			$this->db->insert('smartans_tagihan_header', array(
				'id_user'=> $value->ID_USER,
				'no_invoice'=> $no_invoice,
				'date_create'=> get_waktu(),
				'total_tagihan'=> $total_tagihan,
				'invoice_url'=> $url_back,
				'invoice_id_xendit'=> $id,
				'bulan' => $BULAN,
				'tahun' => $TAHUN
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
				'jumlah'=>$total_power_usage*$tarif_listrik,
				'usage' => $total_power_usage
			));

			$this->db->insert('smartans_tagihan_detail', array(
				'id_tagihan'=> $id_tagihan,
				'detail_tagihan'=> 'Air',
				'jumlah'=>$total_water_usage*$tarif_air,
				'usage' => $total_water_usage
			));

			if ($EMAIL == '1') {
				$this->kirim_email($no_invoice);
			}
			$this->session->set_flashdata('message', alert_biasa('Tagihan Berhasil dibuat !','success'));
			redirect('app/billing_list','refresh');
			

		}

		

		}

		public function cek_pembayaran()
	    {

		    if ($_SERVER["REQUEST_METHOD"] === "POST") {
		        $data = file_get_contents("php://input");
		        log_data("\n\$data contains the updated invoice data \n\n");
		        log_data($data);
		        $d = json_decode($data);
		        $this->db->where('no_invoice', $d->external_id);
		        $this->db->update('smartans_tagihan_header', array('status'=>$d->status));
		        // log_r($d);
		        $this->db->insert('smartans_paygate', $d);
		        log_data("\n\nUpdate your database with the invoice status \n\n");
		    } else {
		        log_r("Cannot ".$_SERVER["REQUEST_METHOD"]." ".$_SERVER["SCRIPT_NAME"]);
		    }

	    }

	    public function email_theme()
	    {
	    	$this->load->view('template_mail');
	    }


	    private function kirim_email($no_invoice)
	    {
	    	$data_tagihan = $this->db->get_where('smartans_tagihan_header', array('no_invoice'=>$no_invoice))->row();
	    	$email = get_data('smartans_user','id_user',$data_tagihan->id_user,'EMAIL');
	    	$email_saya = "noreplay@hexindo-tbk.co.id";
			$pass_saya  = "";
			//konfigurasi email
			$config = array();
			$config['charset'] = 'iso-8859-1';
			// $config['useragent'] = '10.87.200.12';
			$config['protocol']= "smtp";
			$config['mailtype']= "html";
			$config['smtp_host']= "10.87.200.12";
			$config['smtp_port']= "25";
			$config['smtp_timeout']= "25";
			$config['smtp_user']= "$email_saya";
			$config['smtp_pass']= "$pass_saya";
			// $config['crlf']="\r\n";
			// $config['newline']="\r\n";
			// $config['wordwrap'] = TRUE;

	        // Load library email dan konfigurasinya
	        $this->load->library('email', $config);

	        // Email dan nama pengirim
	        $this->email->from('noreplay@hexindo-tbk.co.id', 'AR Reminder - Invoice No. '.$invoice.'');

	        // Email penerima
	        $this->email->to($email); // Ganti dengan email tujuan

	        // Lampiran email, isi dengan url/path file
	        // $this->email->attach(base_url().'upload/'.$value->file1);
	        // $this->email->attach(base_url().'upload/'.$value->file2);
	        // $this->email->attach(base_url().'upload/'.$value->file3);

	        // Subject email
	        $this->email->subject('AR Reminder - Invoice No. '.$invoice.'');

	        // Isi email
	        $messageEmail = $this->load->view('template_mail');
	        $this->email->message($messageEmail);

	        // Tampilkan pesan sukses atau error
	        if ($this->email->send()) {
	            echo 'Sukses! email berhasil dikirim.<br>';

	        } else {
	            echo 'Error! email tidak dapat dikirim.<br>';
	            echo $this->email->print_debugger();
	        }
	    }
		
		
	

}
