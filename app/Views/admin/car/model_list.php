<?php foreach($model as $row){ ?>
    <option value="<?= $row['model_id'] ?>" <?= $row['model_id'] == $selected_model ? 'selected' : '' ?>><?= $row['name'] ?></option>
<?php } ?>