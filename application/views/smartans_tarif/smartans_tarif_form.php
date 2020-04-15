
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">LOCATION ID <?php echo form_error('LOCATION_ID') ?></label>
            <!-- <input type="text" class="form-control" name="LOCATION_ID" id="LOCATION_ID" placeholder="LOCATION ID" value="<?php echo $LOCATION_ID; ?>" /> -->
            <select class="form-control select2" name="LOCATION_ID">
                <option value="<?php echo $LOCATION_ID ?>"><?php echo $LOCATION_ID ?></option>
                <?php 
                $this->db->where('ACTIVE_FLAG', '1');
                foreach ($this->db->get('smartans_location')->result() as $key => $value): ?>
                    <option value="<?php echo $value->LOCATION_ID ?>"><?php echo $value->LOCATION_ID ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">ROOM NO <?php echo form_error('ROOM_NO') ?></label>
            <!-- <input type="text" class="form-control" name="ROOM_NO" id="ROOM_NO" placeholder="ROOM NO" value="<?php echo $ROOM_NO; ?>" /> -->
            <select class="form-control select2" name="ROOM_NO">
                <option value="<?php echo $ROOM_NO ?>"><?php echo $ROOM_NO ?></option>
                <?php 
                $this->db->where('ACTIVE_FLAG', '1');
                foreach ($this->db->get('smartans_room')->result() as $key => $value): ?>
                    <option value="<?php echo $value->ROOM_ID ?>"><?php echo $value->ROOM_ID ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">TARIF ROOM <?php echo form_error('TARIF_ROOM') ?></label>
            <input type="text" class="form-control" name="TARIF_ROOM" id="TARIF_ROOM" placeholder="TARIF ROOM" value="<?php echo $TARIF_ROOM; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">TARIF LISTRIK <?php echo form_error('TARIF_LISTRIK') ?></label>
            <input type="text" class="form-control" name="TARIF_LISTRIK" id="TARIF_LISTRIK" placeholder="TARIF LISTRIK" value="<?php echo $TARIF_LISTRIK; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">TARIF AIR <?php echo form_error('TARIF_AIR') ?></label>
            <input type="text" class="form-control" name="TARIF_AIR" id="TARIF_AIR" placeholder="TARIF AIR" value="<?php echo $TARIF_AIR; ?>" />
        </div>

        <div class="form-group">
            <label for="int">START DATE</label>
            <input type="date" class="form-control" name="START_DATE" id="START_DATE"  value="<?php echo $START_DATE; ?>" required/>
        </div>
        <div class="form-group">
            <label for="int">END DATE</label>
            <input type="date" class="form-control" name="END_DATE" id="END_DATE"  value="<?php echo $END_DATE; ?>" required/>
        </div>
	    <input type="hidden" name="ID_TARIF" value="<?php echo $ID_TARIF; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('smartans_tarif') ?>" class="btn btn-default">Cancel</a>
	</form>
   