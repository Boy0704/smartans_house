
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('smartans_user/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('smartans_user/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('smartans_user'); ?>" class="btn btn-default">Reset</a>
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
		<th>EMAIL</th>
		<th>FIRST NAME</th>
		<th>LAST NAME</th>
		<th>MOBILE NO</th>
		<th>LOCATION ID</th>
		<th>ROOM ID</th>
		<th>ACTIVE FLAG</th>
		<th>LEVEL</th>
		<th>Action</th>
            </tr><?php
            foreach ($smartans_user_data as $smartans_user)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $smartans_user->EMAIL ?></td>
			<td><?php echo $smartans_user->FIRST_NAME ?></td>
			<td><?php echo $smartans_user->LAST_NAME ?></td>
			<td><?php echo $smartans_user->MOBILE_NO ?></td>
			<td><?php echo $retVal = ($smartans_user->LOCATION_ID == '0') ? 'ALL LOCATION' : $smartans_user->LOCATION_ID ; ?></td>
			<td><?php echo $retVal = ($smartans_user->ROOM_ID == '0') ? 'ALL ROOM' : $smartans_user->ROOM_ID ; ?></td>
			<td><?php echo $retVal = ($smartans_user->ACTIVE_FLAG == 'y') ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>' ; ?></td>
			<td><?php echo $smartans_user->LEVEL ?></td>
			<td style="text-align:center" width="100px">
                <?php 
                if ($smartans_user->ACTIVE_FLAG == 't') {
                    ?>
                    <a href="app/aktifkan_akun/<?php echo $smartans_user->ID_USER ?>" class="label label-success">Aktifkan</a>
                    <?php
                }
                 ?>
				<?php 
				echo anchor(site_url('smartans_user/update/'.$smartans_user->ID_USER),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('smartans_user/delete/'.$smartans_user->ID_USER),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
    