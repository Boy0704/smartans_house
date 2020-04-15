
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('smartans_room/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('smartans_room/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('smartans_room'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>LOCATION ID</th>
		<th>ROOM ID</th>
        <th>ROOM NAME</th>
		<th>ACTIVE</th>
		<th>Action</th>
            </tr><?php
            foreach ($smartans_room_data as $smartans_room)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $smartans_room->LOCATION_ID ?></td>
			<td><?php echo $smartans_room->ROOM_ID ?></td>
            <td><?php echo $smartans_room->ROOM_NAME ?></td>
			<td><?php echo $retVal = ($smartans_room->ACTIVE_FLAG == '1') ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>' ; ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('smartans_room/update/'.$smartans_room->ID),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('smartans_room/delete/'.$smartans_room->ID),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    