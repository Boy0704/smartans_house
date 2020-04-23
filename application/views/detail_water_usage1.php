<?php 
$LOCATION = $_GET['LOCATION_ID'];
$ROOM = $_GET['ROOM_ID'];
$total_use = 0;
 ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
		  	<div class="panel-heading">LOCATION : <b><?php echo $LOCATION ?></b> | ROOM : <b><?php echo $ROOM ?></b></div>
		  	<div class="panel-body">
		  		<table class="table">
					<tr>
						<td>Periode</td>
						<td> <?php echo bulan_indo($bulan).' '.$tahun ?></td>
					</tr>
				</table>


		  		<div class="alert alert-success">
		  			Total Power Usage : <b id="total_use"></b>
		  		</div>
		  		<table class="table table-striped">
		  			<thead>
		  				<tr>
		  					<th>Usage Date</th>
		  					<th>WATER Usage</th>
		  				</tr>
		  			</thead>
		  			<tbody>
		  				<?php 
		  				$cek_str = strlen($bulan);
				        if ($cek_str == 1) {
				            $bulan = '0'.$bulan;
				        }
		  				$sql = $this->db->query("SELECT * FROM SMARTANS_WATER_METER_V where location_id='$LOCATION' AND room_id='$ROOM' AND MDATE LIKE '$tahun-$bulan%' ");
		  				foreach ($sql->result() as $key => $value): ?>
		  				<tr>
		  					<td><?php echo $value->MDATE ?></td>
		  					<td><?php echo $value->WATER_USAGE; $total_use = $total_use + $value->WATER_USAGE ?></td>
		  				</tr>
		  				<?php endforeach ?>
		  			</tbody>
		  		</table>

		  	</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#total_use').html(<?php echo $total_use; ?>);
	});
</script>