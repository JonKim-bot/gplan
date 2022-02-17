<?php foreach($area as $row){ ?>
    <option value="<?= $row['area_id'] ?>" <?= $row['area_id'] == $selected_area ? 'selected' : '' ?>><?= $row['name'] ?></option>
<?php } ?>