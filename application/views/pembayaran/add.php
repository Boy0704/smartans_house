<form action="app/simpan_pembayaran" method="POST">
	<div class="form-group">
		<label>No Invoice</label>
		<input type="text" name="no_invoice" class="form-control" id="no_invoice" value="<?php echo $no_invoice ?>" readonly>
		<!-- <select class="form-control select2" name="no_invoice" required="">
			<?php foreach ($this->db->get('smartans_tagihan_header')->result() as $key => $value): ?>
				<option value="<?php echo $value->no_invoice ?>"><?php echo $value->no_invoice.' - '.get_data('smartans_user','id_user',$value->id_user,'LOCATION_ID').' - '.get_data('smartans_user','id_user',$value->id_user,'ROOM_ID') ?></option>
			<?php endforeach ?>
		</select> -->
	</div>
	<div class="form-group">
		<label>Total Pembayaran</label>
		<input type="number" name="total_pembayaran" class="form-control" value="<?php echo $total_tagihan ?>" required="" readonly>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary">SIMPAN</button>
	</div>

</form>