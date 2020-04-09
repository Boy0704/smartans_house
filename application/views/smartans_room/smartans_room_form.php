
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">LOCATION ID <?php echo form_error('LOCATION_ID') ?></label>
            <input type="text" class="form-control" name="LOCATION_ID" id="LOCATION_ID" placeholder="LOCATION ID" value="<?php echo $LOCATION_ID; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">ROOM ID <?php echo form_error('ROOM_ID') ?></label>
            <input type="text" class="form-control" name="ROOM_ID" id="ROOM_ID" placeholder="ROOM ID" value="<?php echo $ROOM_ID; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">ROOM NAME <?php echo form_error('ROOM_NAME') ?></label>
            <input type="text" class="form-control" name="ROOM_NAME" id="ROOM_NAME" placeholder="ROOM NAME" value="<?php echo $ROOM_NAME; ?>" />
        </div>
	    <input type="hidden" name="ID" value="<?php echo $ID; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('smartans_room') ?>" class="btn btn-default">Cancel</a>
	</form>
   