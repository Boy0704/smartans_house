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

		$params = ['external_id' => 'demo_147580196270',
		    'payer_email' => 'jualkoding@gmail.com',
		    'description' => 'Pembayaran Kos',
		    'amount' => 32000
		];

		$createInvoice = \Xendit\Invoice::create($params);
		// log_data($createInvoice);

		$id = $createInvoice['id'];

		$getInvoice = \Xendit\Invoice::retrieve($id);
		// log_data($getInvoice);
		$url_back = $getInvoice['invoice_url'];
		// log_data($url_back);
		redirect($url_back);

		// redirect($getInvoice['invoice_url'],'refresh');
		//header('Location: '.$getInvoice['invoice_url']);

		// $expireInvoice = \Xendit\Invoice::expireInvoice($id);
		// var_dump($expireInvoice);

		// $getAllInvoice = \Xendit\Invoice::retrieveAll();
		// var_dump(($getAllInvoice));


		
	}

}
