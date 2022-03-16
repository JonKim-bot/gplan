<ul>
    <?php foreach ($family_level_user as $row) { ?>
        <div class="theUserList">

            <div class="theBIcon mr-2">
                <img src="<?= base_url() ?>/assets/img/Group 104.png">
            </div>
            <div>
                <p>Name : <?= $row['username'] ?></p>
                <p>Total Downline : <?= $row['total_downline'] ?></p>
            </div>

        </div>
    <?php } ?>

</ul>