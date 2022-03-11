<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    /* font-family: Verdana, Geneva, Tahoma, sans-serif; */
}

html, body {
    width: 100%;
    height: 100%;
}

.container {
    width: 100%;
    margin: 0 auto;
    position: relative;
    text-align: center;
}

.container::before {
    position: absolute;
    left: 50%;
    content: '';
    width: 5px;
    height: 100%;
    background-color: rgb(231, 230, 230);
    border-radius: 5px;
}

.entry {
    margin: 50px 10px;
    position: relative;
}

.indicator {
    position: absolute;
    top: -5px;
    left: calc(50% - 5px);
    width: 15px;
    height: 15px;
    background: linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important;
    border-radius: 50%;
}

.indicator span {
    position: relative;
    top: -5px;
    width: 7px;
    height: 7px;
    display: inline-block;
    background: linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important;
    border-radius: 50%;
}

.content {
    width: 150px;
    margin: 0 auto;
    transform: translate(-58%, -9px);
    font-size: 14px;
    text-align: right;
}

.entry:nth-child(odd) .content {
    text-align: left;
    transform: translate(60%, -9px);
}

.content span {
    font-weight: 500;
    font-size: 16px;
    display: block;
    color: black;
}

.time {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translate(-130%, -48%);
    font-size: 14px;
    padding: 5px 10px;
    border-radius: 25px;
    background: linear-gradient(to right top, #2e8dab, #1980a7, #0972a2, #0e649b, #1d5592, #22528f, #274f8d, #2b4c8a, #29538e, #295b92, #2b6295, #2f6998)!important;

    box-shadow: 0 3px 6px 0 rgba(250, 113, 49, 0.658);
    color: white;
    display: inline-block;
}

.entry:nth-child(even) .time {
    transform: translate(40%, -48%);
}

@media only screen and (max-width: 600px) {
    .container {
        margin: 0;
    }

    .entry:nth-child(even) .content, .entry:nth-child(odd) .content {
        text-align: left;
        transform: translate(60%, -9px);
    }

    .entry:nth-child(even) .time, .entry:nth-child(odd) .time {
        transform: translate(-130%, -48%);
    }
}
</style>

<div class="container">
        <?php for ($x = 1; $x <= $level ; $x++) { ?>
        <div class="entry">
            <div class="indicator">
                <span></span>
            </div>
            <p class="content">
                <span><?= $x ?></span>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, pariatur.
            </p>
            <div class="time">Level <?= $x ?></div>
        </div>
        <?php } ?>
       
    </div>