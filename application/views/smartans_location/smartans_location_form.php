
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">LOCATION ID <?php echo form_error('LOCATION_ID') ?></label>
            <input type="text" class="form-control" name="LOCATION_ID" id="LOCATION_ID" placeholder="LOCATION ID" value="<?php echo $LOCATION_ID; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">LOCATION NAME <?php echo form_error('LOCATION_NAME') ?></label>
            <input type="text" class="form-control" name="LOCATION_NAME" id="LOCATION_NAME" placeholder="LOCATION NAME" value="<?php echo $LOCATION_NAME; ?>" />
        </div>
	    <input type="hidden" name="ID" value="<?php echo $ID; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('smartans_location') ?>" class="btn btn-default">Cancel</a>
	</form>
   