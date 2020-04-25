<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Xendit\Xendit;

class Web extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('level') == '') {
            redirect('login');
        }
	}
	public function tes()
	{

		$tgl = '2020-04';
		$location = 'VERDANT';
		$room = 'R11';
		foreach ($this->db->get_where('smartans_tarif',array('LOCATION_ID'=>$location,'ROOM_NO'=>$room))->result() as $rw) {

			// jk bulan bulan yg di input == bulan berjalan
			// maka ambil start date nya diatas yg di atas tgl buat tagihan

			// jika bulan bulan yg di input == bulan lalu
			// dan jika ada 3 macam maka ambil yg terakhir dari bulan tersebut
			if (strtotime($tgl) == strtotime(date('Y-m'))) {
				if ( ( strtotime($rw->START_DATE) < strtotime(date('Y-m-d')) or strtotime($rw->START_DATE) == strtotime(date('Y-m-d')) ) && strtotime($rw->END_DATE) > strtotime(date('Y-m-d'))  ) {
					log_data($rw->ID_TARIF);
					log_data('kondisi 1');
				} elseif ( ( strtotime($rw->START_DATE) < strtotime(date('Y-m-d')) or strtotime($rw->START_DATE) == strtotime(date('Y-m-d')) ) && ( strtotime($rw->END_DATE) <= strtotime(date('Y-m-d')) && strtotime(substr($rw->END_DATE, 0,7)) == strtotime($tgl) ) ) {
					log_data($rw->ID_TARIF) ;
					log_data('kondisi 2');
				}
			} elseif (strtotime($tgl) < strtotime(date('Y-m'))) {
				if ( strtotime(substr($rw->START_DATE, 0,7)) <= strtotime($tgl) && strtotime(substr($rw->END_DATE, 0,7)) >= strtotime($tgl)  ) {
					log_data($rw->ID_TARIF);
					log_data('kondisi 3');
				} 
			} else {
				// tgl yg di pilih > dari tanggal berjalan
				log_data('gagal') ;
			}

			
		}

		exit();

		log_r(cek_tarif('2020-04','RATA','R24'));
		echo date("Y-m-d", strtotime('-1 second', strtotime('+1 month',strtotime('02' . '/01/' . '2020'. ' 00:00:00'))));
		exit();

		$tgl1 = strtotime('2019-02');
		$tgl2 = strtotime('2002-02');

		if ($tgl1 > $tgl2) {
			echo 'tgl1';
		} elseif ($tgl1 == $tgl2) {
			echo 'sama';
		} else {
			echo 'tgl2';
		}
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
		$this->db->where('ACTIVE_FLAG', 'y');

		//cek bulan bukan bulan saat ini
		// $bln_now = date('m');
		// $thn_now = date('Y');
		// if (intval($bln_now) < $BULAN && $thn_now == $TAHUN) {
		// 	$this->session->set_flashdata('message', alert_biasa('ada kesalahan silahkan ulangi lagi !','info'));
		// 	redirect('app/send_inv','refresh');
		// 	exit;
		// }

		if ($ROOM_ID != '0') {
			$this->db->where('ROOM_ID', $ROOM_ID);
			
		}
		$a = $this->db->get('smartans_user');
		if ($a->num_rows() == 0) {
			$this->session->set_flashdata('message', alert_biasa('Tagihan gagal di buat, tidak ada user terdaftar di room ini!','info'));
			redirect('app/send_inv','refresh');
			exit;
		}

		$total_dt = 0;

		foreach ($a->result() as $key => $value) {
			$type = 'full';
			$send_email = '';
			// if ($ROOM_ID != '0') {
			// 	if (intval($bln_now) == $BULAN && $thn_now == $TAHUN) {
			// 		$type ='cut_off';
			// 	}
			// }

			$cek_str = strlen($BULAN);
			if ($cek_str == 1) {
				$bln_tgh = '0'.$BULAN;
			} else {
				$bln_tgh = $BULAN;
			}

			$no_invoice = create_random(8);

			$total_power_usage = total_power_usage($value->LOCATION_ID,$value->ROOM_ID,$BULAN,$TAHUN);
			$total_water_usage = total_water_usage($value->LOCATION_ID,$value->ROOM_ID,$BULAN,$TAHUN);

			//ambil start date
			//$this->db->where('LOCATION_ID', $value->LOCATION_ID);
			//$this->db->where('ROOM_NO', $value->ROOM_ID);
			// $id_tarif = cek_tarif($TAHUN.'-'.$bln_tgh,$value->LOCATION_ID,$value->ROOM_ID);
			$id_tarif = '';
			foreach ($this->db->get_where('smartans_tarif',array('LOCATION_ID'=>$value->LOCATION_ID,'ROOM_NO'=>$value->ROOM_ID))->result() as $rw) {

				// jk bulan bulan yg di input == bulan berjalan
				// maka ambil start date nya diatas yg di atas tgl buat tagihan

				// jika bulan bulan yg di input == bulan lalu
				// dan jika ada 3 macam maka ambil yg terakhir dari bulan tersebut
				$tgl = $TAHUN.'-'.$bln_tgh;
				if (strtotime($tgl) == strtotime(date('Y-m'))) {
					if ( ( strtotime($rw->START_DATE) < strtotime(date('Y-m-d')) or strtotime($rw->START_DATE) == strtotime(date('Y-m-d')) ) && strtotime($rw->END_DATE) > strtotime(date('Y-m-d'))  ) {
						// log_data($rw->ID_TARIF);
						$id_tarif = $rw->ID_TARIF;


					} elseif ( ( strtotime($rw->START_DATE) < strtotime(date('Y-m-d')) or strtotime($rw->START_DATE) == strtotime(date('Y-m-d')) ) && ( strtotime($rw->END_DATE) <= strtotime(date('Y-m-d')) && strtotime(substr($rw->END_DATE, 0,7)) == strtotime($tgl) ) ) {
						// log_data($rw->ID_TARIF) ;

						$id_tarif = $rw->ID_TARIF;


					}
				} elseif (strtotime($tgl) < strtotime(date('Y-m'))) {
					if ( strtotime(substr($rw->START_DATE, 0,7)) <= strtotime($tgl) && strtotime(substr($rw->END_DATE, 0,7)) >= strtotime($tgl)  ) {
						// log_data($rw->ID_TARIF) ;

						$id_tarif = $rw->ID_TARIF;


					}
				} else {
					// tgl yg di pilih > dari tanggal berjalan
					// log_data('gagal') ;

					$id_tarif = 'gagal';

				}

			//hitung tarif 

				if ($id_tarif == 'gagal') {
					$this->session->set_flashdata('message', alert_biasa('Tagihan gagal di buat, bulan yg di pilih di atas bulan berjalan!','info'));
					redirect('app/send_inv','refresh');
					exit;
				}

				if ($id_tarif == '') {
					$total_dt = $total_dt + 0 ;
					// $this->session->set_flashdata('message', alert_biasa('Tagihan gagal di buat, tarif tidak di temukan di ROOM '.$value->ROOM_ID.' di bulan '.$bln_tgh.' '.$TAHUN.'!','info'));
					// redirect('app/send_inv','refresh');
					// exit;
				} else {

					$total_dt = $total_dt + 1 ;

					$this->db->where('ID_TARIF', $id_tarif);
					$d = $this->db->get('smartans_tarif')->row();
					$start_tgl = $d->START_DATE;
					$end_tgl = $d->END_DATE;

					

					if ($type == 'cut_off' && substr($d->START_DATE, 0,7) == substr($d->END_DATE, 0,7)) {
						//log_data('kondisi 1');
						
						$total_power_usage = $this->db->query("SELECT sum(POWER_USAGE) as total FROM smartans_daily_power_usage where LOCATION_ID='$value->LOCATION_ID' AND ROOM_ID='$value->ROOM_ID' AND USAGE_DATE BETWEEN '$start_tgl' AND '$d->END_DATE' ")->row()->total;
						$total_water_usage = $this->db->query("SELECT sum(WATER_USAGE) AS total FROM SMARTANS_WATER_METER_V where location_id='$value->LOCATION_ID' AND room_id='$value->ROOM_ID' AND MDATE BETWEEN '$start_tgl' AND '$d->END_DATE' ")->row()->total;

					}elseif ($type == 'cut_off' && substr($d->START_DATE, 0,7) != substr($d->END_DATE, 0,7)) {


						//log_data('kondisi 2');

						if ( strtotime(substr($d->START_DATE, 0,7)) < strtotime($TAHUN.'-'.$bln_tgh) && strtotime($TAHUN.'-'.$bln_tgh) < strtotime(substr($d->END_DATE, 0,7))  ) {

							$type = 'full';

							$total_power_usage = total_power_usage($value->LOCATION_ID,$value->ROOM_ID,$BULAN,$TAHUN);
							$total_water_usage = total_water_usage($value->LOCATION_ID,$value->ROOM_ID,$BULAN,$TAHUN);

						} elseif ( strtotime(substr($d->START_DATE, 0,7)) < strtotime($TAHUN.'-'.$bln_tgh) && strtotime($TAHUN.'-'.$bln_tgh) == strtotime(substr($d->END_DATE, 0,7)) ) {

							$start_tgl = substr($d->END_DATE, 0,7).'-01';
							$end_tgl = $d->END_DATE;

							$total_power_usage = $this->db->query("SELECT sum(POWER_USAGE) as total FROM smartans_daily_power_usage where LOCATION_ID='$value->LOCATION_ID' AND ROOM_ID='$value->ROOM_ID' AND USAGE_DATE BETWEEN '$start_tgl' AND '$d->END_DATE' ")->row()->total;
							$total_water_usage = $this->db->query("SELECT sum(WATER_USAGE) AS total FROM SMARTANS_WATER_METER_V where location_id='$value->LOCATION_ID' AND room_id='$value->ROOM_ID' AND MDATE BETWEEN '$start_tgl' AND '$d->END_DATE' ")->row()->total;

						} elseif ( strtotime(substr($d->START_DATE, 0,7)) == strtotime($TAHUN.'-'.$bln_tgh) && strtotime($TAHUN.'-'.$bln_tgh) < strtotime(substr($d->END_DATE, 0,7)) ) {
							

							$end_tgl = date('Y-m-d');

							$total_power_usage = $this->db->query("SELECT sum(POWER_USAGE) as total FROM smartans_daily_power_usage where LOCATION_ID='$value->LOCATION_ID' AND ROOM_ID='$value->ROOM_ID' AND USAGE_DATE BETWEEN '$start_tgl' AND '$d->END_DATE' ")->row()->total;
							$total_water_usage = $this->db->query("SELECT sum(WATER_USAGE) AS total FROM SMARTANS_WATER_METER_V where location_id='$value->LOCATION_ID' AND room_id='$value->ROOM_ID' AND MDATE BETWEEN '$start_tgl' AND '$end_tgl' ")->row()->total;

						}

						
					} elseif ( $type == 'full' && strtotime($TAHUN.'-'.$bln_tgh) == strtotime(substr($d->END_DATE, 0,7)) && strtotime(substr($d->START_DATE, 0,7)) < strtotime($TAHUN.'-'.$bln_tgh) ) {

						//log_data('kondisi 3');

						$type='cut_off';
						$start_tgl = substr($d->END_DATE, 0,7).'-01';

						$total_power_usage = $this->db->query("SELECT sum(POWER_USAGE) as total FROM smartans_daily_power_usage where LOCATION_ID='$value->LOCATION_ID' AND ROOM_ID='$value->ROOM_ID' AND USAGE_DATE BETWEEN '$start_tgl' AND '$d->END_DATE' ")->row()->total;
						$total_water_usage = $this->db->query("SELECT sum(WATER_USAGE) AS total FROM SMARTANS_WATER_METER_V where location_id='$value->LOCATION_ID' AND room_id='$value->ROOM_ID' AND MDATE BETWEEN '$start_tgl' AND '$d->END_DATE' ")->row()->total;

					} elseif ( $type == 'full' && strtotime($TAHUN.'-'.$bln_tgh) < strtotime(substr($d->END_DATE, 0,7)) && strtotime(substr($d->START_DATE, 0,7)) < strtotime($TAHUN.'-'.$bln_tgh) ) {

						//log_data('kondisi 4');

						$total_power_usage = total_power_usage($value->LOCATION_ID,$value->ROOM_ID,$BULAN,$TAHUN);
						$total_water_usage = total_water_usage($value->LOCATION_ID,$value->ROOM_ID,$BULAN,$TAHUN);

					} elseif ( $type == 'full' && substr($d->START_DATE, 0,7) == substr($d->END_DATE, 0,7) ) {

						//log_data('kondisi 5');

						$type='cut_off';

						$total_power_usage = $this->db->query("SELECT sum(POWER_USAGE) as total FROM smartans_daily_power_usage where LOCATION_ID='$value->LOCATION_ID' AND ROOM_ID='$value->ROOM_ID' AND USAGE_DATE BETWEEN '$start_tgl' AND '$d->END_DATE' ")->row()->total;
						$total_water_usage = $this->db->query("SELECT sum(WATER_USAGE) AS total FROM SMARTANS_WATER_METER_V where location_id='$value->LOCATION_ID' AND room_id='$value->ROOM_ID' AND MDATE BETWEEN '$start_tgl' AND '$d->END_DATE' ")->row()->total;

					} elseif ( $type == 'full' && strtotime($TAHUN.'-'.$bln_tgh) < strtotime(substr($d->END_DATE, 0,7)) && strtotime(substr($d->START_DATE, 0,7)) == strtotime($TAHUN.'-'.$bln_tgh) ) {

						//log_data('kondisi 6');

						$type='cut_off';
						$start_tgl = $d->START_DATE;
						$end_tgl = akhir_tgl($TAHUN,$bln_tgh);

						//jika jumlah hari lbih dari 28 maka full
						// jika di bawah 28 hari maka cut off

						if (durasi_tgl($start_tgl,$end_tgl) > 28) {
							$type = 'full';
						} 


						$total_power_usage = $this->db->query("SELECT sum(POWER_USAGE) as total FROM smartans_daily_power_usage where LOCATION_ID='$value->LOCATION_ID' AND ROOM_ID='$value->ROOM_ID' AND USAGE_DATE BETWEEN '$start_tgl' AND '$end_tgl' ")->row()->total;
						$total_water_usage = $this->db->query("SELECT sum(WATER_USAGE) AS total FROM SMARTANS_WATER_METER_V where location_id='$value->LOCATION_ID' AND room_id='$value->ROOM_ID' AND MDATE BETWEEN '$start_tgl' AND '$end_tgl' ")->row()->total;
					} elseif ( strtotime($TAHUN.'-'.$bln_tgh) > strtotime(substr($d->END_DATE, 0,7) )) {
						//log_data('kondisi 7');
						// $this->session->set_flashdata('message', alert_biasa('Tagihan gagal di buat, ROOM '.$value->ROOM_ID.' END DATE < bulan yang dipilih  !','info'));
						// redirect('app/send_inv','refresh');
					}

					if (strtotime($TAHUN.'-'.$bln_tgh) == strtotime(substr($d->END_DATE, 0,7))) {
						$send_email = 'admin';
					} else {
						$send_email = 'user';
					}

					// log_data($value->ROOM_ID);
					// log_data($type);
					// log_data($TAHUN.'-'.$bln_tgh);
					// log_data(substr($d->END_DATE, 0,7));
					// log_data($send_email);
					// log_data($start_tgl);
					// log_data($end_tgl);

					// echo "<hr>";

					

					// exit();

					$this->db->where('LOCATION_ID', $value->LOCATION_ID);
					$this->db->where('ROOM_NO', $value->ROOM_ID);
					$this->db->where('ID_TARIF', $id_tarif);
					$tarif_s = $this->db->get('smartans_tarif');
					if ($tarif_s->num_rows() == 0) {
						$this->session->set_flashdata('message', alert_biasa('Tagihan gagal di buat, tarif di ROOM '.$value->ROOM_ID.' belum di set!','info'));
						redirect('app/send_inv','refresh');
						exit;
					}
					$tarif_room = $tarif_s->row()->TARIF_ROOM;


					$this->db->where('LOCATION_ID', $value->LOCATION_ID);
					$this->db->where('ROOM_NO', $value->ROOM_ID);
					$this->db->order_by('END_DATE', 'desc');
					$tarif_listrik = $this->db->get('smartans_tarif')->row()->TARIF_LISTRIK;
					$this->db->where('LOCATION_ID', $value->LOCATION_ID);
					$this->db->where('ROOM_NO', $value->ROOM_ID);
					$this->db->order_by('END_DATE', 'desc');
					$tarif_air = $this->db->get('smartans_tarif')->row()->TARIF_AIR;
					
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

					$cek_ = $this->db->get_where('smartans_tagihan_header', array(
						'bulan'=>$BULAN,
						'tahun'=>$TAHUN,
						'lokasi'=>$value->LOCATION_ID
						'room'=>$value->ROOM_ID
					));
					if ($cek_->num_rows() > 0) {
						// $this->db->where('id_user', $value->ID_USER);
						$this->db->where('bulan', $BULAN);
						$this->db->where('tahun', $TAHUN);
						$this->db->where('lokasi', $value->LOCATION_ID);
						$this->db->where('room', $value->ROOM_ID);
						$this->db->delete('smartans_tagihan_header');
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
						'tahun' => $TAHUN,
						'type'=>$type,
						'tgl1'=>$start_tgl,
						'tgl2'=>$end_tgl,
						'lokasi'=>$value->LOCATION_ID,
						'room'=>$value->ROOM_ID,
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
						$this->kirim_email($no_invoice,$send_email);
					}

				}

			//hitung tarif end
			}
			
			

		}
		// exit();
		if ($total_dt == 0) {
			// $this->session->set_flashdata('message', alert_biasa('tidak ada tarif di bulan '.$bln_tgh.' '.$TAHUN.' !','info'));
			$this->session->set_flashdata('message', alert_biasa('tidak ada tarif yang bisa di pilih !','info'));
			redirect('app/billing_list','refresh');
		} else {
			$this->session->set_flashdata('message', alert_biasa('Tagihan Berhasil dibuat !','success'));
			redirect('app/billing_list','refresh');
		}
		

		

	}

	public function proses_tagihan()
	{
		//data input
		$LOCATION_ID = $this->input->post('LOCATION_ID');
		$ROOM_ID = $this->input->post('ROOM_ID');
		$EMAIL = $this->input->post('email');
		$BULAN = $this->input->post('bulan');
		$TAHUN = $this->input->post('tahun');

		$cek_str = strlen($BULAN);
		if ($cek_str == 1) {
			$bln_tgh = '0'.$BULAN;
		}

		$data = $this->db->query("SELECT LOCATION_ID,ROOM_NO FROM smartans_tarif WHERE LOCATION_ID='$LOCATION_ID' GROUP BY ROOM_NO ");
		foreach ($data->result() as $key => $value) {
			



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


	    private function kirim_email($no_invoice,$status_send)
	    {

	    	$data_tagihan = $this->db->get_where('smartans_tagihan_header', array('no_invoice'=>$no_invoice))->row();

	    	$email = get_data('smartans_user','id_user',$data_tagihan->id_user,'EMAIL');
	    	if ($status_send == 'admin') {
	    		//di kirim ke user admin
	    		$email = $this->db->get_where('smartans_user', array('LOCATION_ID'=>get_data('smartans_user','id_user',$data_tagihan->id_user,'LOCATION_ID'),'LEVEL'=>'admin','ACTIVE_FLAG'=>'y'))->row()->EMAIL;
	    	}

	    	
	    	$email_saya = "admin@smartanhouse.com";
		    $pass_saya  = "smartans2020";
			//konfigurasi email
    		$config = array();
    		$config['charset'] = 'utf-8';
    		$config['useragent'] = 'smartanhouse.com';
    		$config['protocol']= "smtp";
    		$config['mailtype']= "html";
    		$config['smtp_host']= "ssl://mail.smartanhouse.com";
    		$config['smtp_port']= "465";
    		$config['smtp_timeout']= "465";
    		$config['smtp_user']= "$email_saya";
    		$config['smtp_pass']= "$pass_saya";
    		$config['crlf']="\r\n";
    		$config['newline']="\r\n";
    
    		$config['wordwrap'] = TRUE;

	        // Load library email dan konfigurasinya
	        $this->load->library('email', $config);

	        // Email dan nama pengirim
	        $data = array(
    			'inv' => $no_invoice
    		);
	        $messageEmail = $this->load->view('template_mail',$data,TRUE);
	        $this->email->set_header('Content-Type', 'text/html');
	        $this->email->from('admin@smartanhouse.com', 'Smartans House');

	        // Email penerima
	        $this->email->to($email); // Ganti dengan email tujuan

	        // Lampiran email, isi dengan url/path file
	        // $this->email->attach(base_url().'upload/'.$value->file1);
	        // $this->email->attach(base_url().'upload/'.$value->file2);
	        // $this->email->attach(base_url().'upload/'.$value->file3);

	        // Subject email
	        $this->email->subject('Tagihan - Invoice No. '.$no_invoice.'');

	        // Isi email
	        
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
