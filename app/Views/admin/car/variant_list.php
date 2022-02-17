<?php foreach($variant as $row){ ?>
    <option value="<?= $row['variant_id'] ?>" <?= $row['variant_id'] == $selected_variant ? 'selected' : '' ?>><?= $row['variant'] ?></option>
<?php } ?>