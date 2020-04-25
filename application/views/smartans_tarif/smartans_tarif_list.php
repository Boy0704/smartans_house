
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('smartans_tarif/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <!-- <form action="<?php echo site_url('smartans_tarif/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('smartans_tarif'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form> -->
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px" id="example1">
            <thead>
            <tr>
                <th>No</th>
		<th>LOCATION ID</th>
		<th>ROOM NO</th>
		<th>TARIF ROOM</th>
		<th>TARIF LISTRIK</th>
        <th>TARIF AIR</th>
        <th>START DATE</th>
		<th>END DATE</th>
		<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $start = 0;
            if ($this->session->userdata('level') == 'admin') {
                $this->db->where_in('LOCATION_ID', $this->session->userdata('location_id'));
            }
            $this->db->order_by('ID_TARIF', 'desc');
            $smartans_tarif_data = $this->db->get('smartans_tarif');
            foreach ($smartans_tarif_data->result() as $smartans_tarif)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $smartans_tarif->LOCATION_ID ?></td>
			<td><?php echo $smartans_tarif->ROOM_NO ?></td>
			<td><?php echo number_format($smartans_tarif->TARIF_ROOM) ?></td>
			<td><?php echo number_format($smartans_tarif->TARIF_LISTRIK) ?></td>
			<td><?php echo number_format($smartans_tarif->TARIF_AIR) ?></td>
            <td><?php echo $smartans_tarif->START_DATE ?></td>
            <td><?php echo $smartans_tarif->END_DATE ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('smartans_tarif/update/'.$smartans_tarif->ID_TARIF),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('smartans_tarif/delete/'.$smartans_tarif->ID_TARIF),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        </div>
        <!-- <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div> -->
    