<ul>
    <?php foreach($family_level_user as $row){ ?>

        <li><?= $row['username'] ?> Total Downline : <?= $row['total_downline'] ?></li>
    <?php } ?>

</ul>