<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
		  	<div class="panel-heading">Form Cari</div>
		  	<div class="panel-body">
		  		<form action="">
		  			<div class="form-group">
		  				<label>Location ID</label>
		  				<select class="form-control select2" name="LOCATION_ID">
			                <?php 
			               	if ($this->session->userdata('level') == 'admin') {
			                    $this->db->where_in('LOCATION_ID', $this->session->userdata('location_id'));
			                }
			                $this->db->where('ACTIVE_FLAG', '1');
			                foreach ($this->db->get('smartans_location')->result() as $key => $value): ?>
			                    <option value="<?php echo $value->LOCATION_ID ?>"><?php echo $value->LOCATION_ID ?></option>
			                <?php endforeach ?>
			            </select>
		  			</div>
		  			<div class="form-group">
		  				<label>Room ID</label>
		  				<select class="form-control select2" name="ROOM_ID">
		  					<?php 
			                if ($this->session->userdata('level') == 'admin') {
			                    $this->db->where_in('LOCATION_ID', $this->session->userdata('location_id'));
			                }
			                $this->db->where('ACTIVE_FLAG', '1');
			                foreach ($this->db->get('smartans_room')->result() as $key => $value): ?>
			                    <option value="<?php echo $value->ROOM_ID ?>"><?php echo $value->ROOM_ID ?></option>
			                <?php endforeach ?>
			            </select>
		  			</div>
		  			<div class="form-group">
		  				<label>Dari Tanggal</label>
		  				<input type="date" name="tgl1" class="form-control">
		  			</div>
		  			<div class="form-group">
		  				<label>Sampai Tanggal</label>
		  				<input type="date" name="tgl2" class="form-control">
		  			</div>
		  			<div class="form-group">
		  				<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI</button>
		  			</div>
		  		</form>
		  	</div>
		</div>
	</div>
</div>