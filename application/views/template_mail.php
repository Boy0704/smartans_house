<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Email Send</title>
<?php 

$inv = $this->uri->segment(3);
$data = $this->db->get_where('smartans_tagihan_header', array('no_invoice'=>$inv))->row();

 ?>
<body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
  <table style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
    <thead>
      <tr>
        <th style="text-align:left;"><img style="max-width: 150px;" src="<?php echo base_url() ?>/image/logo.jpeg" alt="Smartans House"></th>
        <th style="text-align:right;font-weight:400;"><?php echo date_indo(substr($data->date_create, 0,10)) ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:150px">Order status</span><b <?php echo $retVal = ($data->status == 'PAID') ? 'style="color:green;font-weight:normal;margin:0"' :'style="color:red;font-weight:normal;margin:0"'  ?>><?php echo $data->status ?></b></p>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Transaction ID</span><?php echo $data->no_invoice ?></p>
          <p style="font-size:14px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Order amount</span> Rp. <?php echo number_format($data->total_tagihan,2) ?></p>
        </td>
      </tr>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Name</span> <?php echo get_data('smartans_user','id_user',$data->id_user,'FIRST_NAME').' '.get_data('smartans_user','id_user',$data->id_user,'LAST_NAME') ?></p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Email</span> <?php echo get_data('smartans_user','id_user',$data->id_user,'EMAIL') ?></p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Phone</span> <?php echo get_data('smartans_user','id_user',$data->id_user,'MOBILE_NO') ?></p>
          
        </td>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Location ID</span> <?php echo get_data('smartans_user','id_user',$data->id_user,'LOCATION_ID') ?></p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Room ID</span> <?php echo get_data('smartans_user','id_user',$data->id_user,'ROOM_ID') ?></p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Month</span> <?php echo bulan_indo($data->bulan).' '.$data->tahun ?> </p>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Detail</td>
      </tr>
      <tr>
        <td colspan="2" style="padding:15px;">
          <?php 
          foreach ($this->db->get_where('smartans_tagihan_detail', array('id_tagihan'=>$data->id_tagihan))->result() as $rw) {
           ?>
          <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;">
            <span style="display:block;font-size:13px;font-weight:normal;"><?php echo $rw->detail_tagihan ?></span> Rp. <?php echo number_format($rw->jumlah,2) ?> <b style="font-size:12px;font-weight:300;"> </b>
          </p>
          <?php } ?>
          <?php 
          $paygate_status = $this->db->get_where('smartans_location', array('LOCATION_ID'=>get_data('smartans_user','id_user',$data->id_user,'LOCATION_ID')))->row()->PAYGATE_FLAG;
        if ($paygate_status == '0') {
          # code...
        }else{
         ?>
          <center>
            <a href="<?php echo $data->invoice_url ?>" target="_blank" style="background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;"> BAYAR SEKARANG</a>
            
          </center>
        <?php } ?>
        </td>
      </tr>
    </tbody>
    <tfooter>
      <tr>
        <!-- <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
          <strong style="display:block;margin:0 0 10px 0;">Regards</strong> Bachana Tours<br> Gorubathan, Pin/Zip - 735221, Darjeeling, West bengal, India<br><br>
          <b>Phone:</b> 03552-222011<br>
          <b>Email:</b> contact@bachanatours.in
        </td> -->

      </tr>
    </tfooter>
  </table>
</body>

</html>