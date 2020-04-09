<?php 
$LOCATION = $_GET['LOCATION_ID'];
$ROOM = $_GET['ROOM_ID'];
$tgl1 = $_GET['tgl1'];
$tgl2 = $_GET['tgl2'];
$total_use = 0;
 ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
		  	<div class="panel-heading">LOCATION : <b><?php echo $LOCATION ?></b> | ROOM : <b><?php echo $ROOM ?></b></div>
		  	<div class="panel-body">
		  		<table class="table">
					<tr>
						<td>Dari Tanggal</td>
						<td><?php echo $tgl1 ?></td>
					</tr>
					<tr>
						<td>Sampai Tanggal</td>
						<td><?php echo $tgl2 ?></td>
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
		  				$sql = $this->db->query("SELECT * FROM smartans_water_meter where LOCATION_ID='$LOCATION' AND ROOM_ID='$ROOM' AND DATE_TIME BETWEEN '$tgl1' and '$tgl2' ");
		  				foreach ($sql->result() as $key => $value): ?>
		  				<tr>
		  					<td><?php echo $value->DATE_TIME ?></td>
		  					<td><?php echo $value->VOLUME; $total_use = $total_use + $value->VOLUME ?></td>
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