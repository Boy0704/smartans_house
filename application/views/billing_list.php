<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
		<table class="table table-bordered" id="example1">
			<thead>
				<tr>
					<th>No Invoice</th>
					<th>Nama User</th>
					<th>Location ID</th>
					<th>Room ID</th>
					<th>Total Tagihan</th>
					<th>Date Create</th>
					<th>Status</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if ($this->session->userdata('level') == 'user') {
					$this->db->where('id_user', $this->session->userdata('id_user'));
				}
				$data = $this->db->get('smartans_tagihan_header');
				foreach ($data->result() as $key => $value) {
				 ?>
				<tr>
					<td><?php echo $value->no_invoice ?></td>
					<td><?php echo get_data('smartans_user','ID_USER',$value->id_user,'FIRST_NAME').' '.get_data('smartans_user','ID_USER',$value->id_user,'LAST_NAME') ?></td>
					<td><?php echo get_data('smartans_user','ID_USER',$value->id_user,'LOCATION_ID') ?></td>
					<td><?php echo get_data('smartans_user','ID_USER',$value->id_user,'ROOM_ID') ?></td>
					<td><?php echo number_format($value->total_tagihan) ?></td>
					<td><?php echo $value->date_create ?></td>
					<td>
						<?php 
						if ($value->status == 'PAID') {
							?>
							<span class="label label-success">PAID</span>
							<?php
						} elseif ($value->status == 'UNPAID') {
							?>
							<span class="label label-warning">UNPAID</span>
							<?php
						} else {

						 ?>
						 	<span class="label label-danger">EXPRIED</span>
						<?php } ?>

					</td>
					
					<td>
						<a href="app/detail_inv/<?php echo $value->no_invoice ?>" class="label label-info">Detail</a>

						<?php 
						if (($value->status == 'UNPAID' || $value->status == 'EXPRIED') and $this->session->userdata('level') == 'admin'  ) {
							?>
							<a href="app/add_pembayaran/<?php echo $value->no_invoice.'/'.$value->total_tagihan ?>" class="label label-success">ADD PAYMENT</a>
							<?php
						} ?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
</div>