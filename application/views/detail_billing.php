<?php 

$inv = $this->uri->segment(3);
$data = $this->db->get_where('smartans_tagihan_header', array('no_invoice'=>$inv))->row();

 ?>
<div class="row">
	<div class="col-md-12">
		<table class="table table-havored">
			<tr>
				<td>Nama</td>
				<td>
					<b><?php echo get_data('smartans_user','id_user',$data->id_user,'FIRST_NAME').' '.get_data('smartans_user','id_user',$data->id_user,'LAST_NAME') ?></b>
				</td>
			</tr>
			<tr>
				<td>Location</td>
				<td><?php echo get_data('smartans_user','id_user',$data->id_user,'LOCATION_ID') ?></td>
			</tr>
			<tr>
				<td>Room No</td>
				<td><?php echo get_data('smartans_user','id_user',$data->id_user,'ROOM_ID') ?></td>
			</tr>
			<tr>
				<td>Month</td>
				<td><?php echo bulan_indo($data->bulan).' '.$data->tahun ?></td>
			</tr>
			<tr>
				<td>Electricity Usage</td>
				<td>
					<?php 
					echo $this->db->query("SELECT smartans_tagihan_detail.usage FROM smartans_tagihan_detail where id_tagihan='$data->id_tagihan' and detail_tagihan='Listrik' ")->row()->usage;
					?> KWH 
					<?php 
					if ($data->type == 'cut_off') {
					 ?>
					<a href="app/power_usage?LOCATION_ID=<?php echo get_data('smartans_user','id_user',$data->id_user,'LOCATION_ID') ?>&ROOM_ID=<?php echo get_data('smartans_user','id_user',$data->id_user,'ROOM_ID') ?>&tgl1=<?php echo $data->$tgl1 ?>&tgl2=<?php echo $data->$tgl2 ?>" class="label label-info">Lihat Detail</a>
					<?php } else { ?>
					<a href="app/detail_listrik/<?php echo $data->bulan.'/'.$data->tahun ?>?LOCATION_ID=<?php echo get_data('smartans_user','id_user',$data->id_user,'LOCATION_ID') ?>&ROOM_ID=<?php echo get_data('smartans_user','id_user',$data->id_user,'ROOM_ID') ?>" class="label label-info">Lihat Detail</a>
				<?php } ?>
				</td>
			</tr>
			<tr>
				<td>Electricity Fee</td>
				<td>
					<?php 
					$listrik = $this->db->query("SELECT smartans_tagihan_detail.jumlah FROM smartans_tagihan_detail where id_tagihan='$data->id_tagihan' and detail_tagihan='Listrik' ")->row()->jumlah;
					echo number_format($listrik,2);
					?>
				</td>
			</tr>
			<tr>
				<td>Water Usage</td>
				<td>
					<?php 
					echo $this->db->query("SELECT smartans_tagihan_detail.usage FROM smartans_tagihan_detail where id_tagihan='$data->id_tagihan' and detail_tagihan='Air' ")->row()->usage;
					?> M3 
					<?php 
					if ($data->type == 'cut_off') {
					 ?>
					<a href="app/water_usage?LOCATION_ID=<?php echo get_data('smartans_user','id_user',$data->id_user,'LOCATION_ID') ?>&ROOM_ID=<?php echo get_data('smartans_user','id_user',$data->id_user,'ROOM_ID') ?>&tgl1=<?php echo $data->$tgl1 ?>&tgl2=<?php echo $data->$tgl2 ?>" class="label label-info">Lihat Detail</a>
					<?php } else { ?>
					<a href="app/detail_air/<?php echo $data->bulan.'/'.$data->tahun ?>?LOCATION_ID=<?php echo get_data('smartans_user','id_user',$data->id_user,'LOCATION_ID') ?>&ROOM_ID=<?php echo get_data('smartans_user','id_user',$data->id_user,'ROOM_ID') ?>" class="label label-info">Lihat Detail</a>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>Water Fee</td>
				<td>
					<?php 
					$water = $this->db->query("SELECT smartans_tagihan_detail.jumlah FROM smartans_tagihan_detail where id_tagihan='$data->id_tagihan' and detail_tagihan='Air' ")->row()->jumlah;
					echo number_format($water,2);
					?>
				</td>
			</tr>
			<tr>
				<td>Total Utility Fee</td>
				<td>
					<?php 
					$total = $listrik + $water;
					echo number_format($total,2)
					 ?>
				</td>
			</tr>
			<tr>
				<td>Room Charge</td>
				<td>
					<?php 
					$room = $this->db->query("SELECT smartans_tagihan_detail.jumlah FROM smartans_tagihan_detail where id_tagihan='$data->id_tagihan' and detail_tagihan='Kamar' ")->row()->jumlah;
					echo number_format($room,2);
					?>
				</td>
			</tr>
			<tr>
				<td>Total Bill</td>
				<td>
					<?php 
					$tot = $room + $total;
					echo number_format($tot,2)
					 ?>
				</td>
			</tr>
		</table>
	</div>
</div>