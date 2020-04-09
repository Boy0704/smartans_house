
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">EMAIL <?php echo form_error('EMAIL') ?></label>
            <input type="text" class="form-control" name="EMAIL" id="EMAIL" placeholder="EMAIL" value="<?php echo $EMAIL; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">PASSWORD <?php echo form_error('PASSWORD') ?></label>
            <input type="text" class="form-control" name="PASSWORD" id="PASSWORD" placeholder="PASSWORD" value="<?php echo $PASSWORD; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">FIRST NAME <?php echo form_error('FIRST_NAME') ?></label>
            <input type="text" class="form-control" name="FIRST_NAME" id="FIRST_NAME" placeholder="FIRST NAME" value="<?php echo $FIRST_NAME; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">LAST NAME <?php echo form_error('LAST_NAME') ?></label>
            <input type="text" class="form-control" name="LAST_NAME" id="LAST_NAME" placeholder="LAST NAME" value="<?php echo $LAST_NAME; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">MOBILE NO <?php echo form_error('MOBILE_NO') ?></label>
            <input type="text" class="form-control" name="MOBILE_NO" id="MOBILE_NO" placeholder="MOBILE NO" value="<?php echo $MOBILE_NO; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">LOCATION ID <?php echo form_error('LOCATION_ID') ?></label>
            <!-- <input type="text" class="form-control" name="LOCATION_ID" id="LOCATION_ID" placeholder="LOCATION ID" value="<?php echo $LOCATION_ID; ?>" /> -->
            <select class="form-control select2" name="LOCATION_ID">
                <option value="<?php echo $LOCATION_ID ?>"><?php echo $LOCATION_ID ?></option>
                <option value="0">ALL LOCATION</option>
                <?php foreach ($this->db->get('smartans_location')->result() as $key => $value): ?>
                    <option value="<?php echo $value->LOCATION_ID ?>"><?php echo $value->LOCATION_ID ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">ROOM ID <?php echo form_error('ROOM_ID') ?></label>
            <!-- <input type="text" class="form-control" name="ROOM_ID" id="ROOM_ID" placeholder="ROOM ID" value="<?php echo $ROOM_ID; ?>" /> -->
            <select class="form-control select2" name="ROOM_ID">
                <option value="<?php echo $ROOM_ID ?>"><?php echo $ROOM_ID ?></option>
                <option value="0">ALL ROOM</option>
                <?php foreach ($this->db->get('smartans_room')->result() as $key => $value): ?>
                    <option value="<?php echo $value->ROOM_ID ?>"><?php echo $value->ROOM_ID ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">ACTIVE FLAG <?php echo form_error('ACTIVE_FLAG') ?></label>
            <!-- <input type="text" class="form-control" name="ACTIVE_FLAG" id="ACTIVE_FLAG" placeholder="ACTIVE FLAG" value="<?php echo $ACTIVE_FLAG; ?>" /> -->
            <select class="form-control" name="ACTIVE_FLAG">
                <option value="<?php echo $ACTIVE_FLAG ?>"><?php echo $ACTIVE_FLAG ?></option>
                <option value="y">AKTIF</option>
                <option value="t">TIDAK AKTIF</option>
            </select>
        </div>
	    <div class="form-group">
            <label for="enum">LEVEL <?php echo form_error('LEVEL') ?></label>
            <!-- <input type="text" class="form-control" name="LEVEL" id="LEVEL" placeholder="LEVEL" value="<?php echo $LEVEL; ?>" /> -->
            <select class="form-control" name="LEVEL">
                <option value="<?php echo $LEVEL ?>"><?php echo $LEVEL ?></option>
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
        </div>
	    <input type="hidden" name="ID_USER" value="<?php echo $ID_USER; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('smartans_user') ?>" class="btn btn-default">Cancel</a>
	</form>
   