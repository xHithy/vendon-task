<?php require_once APPROOT . '/views/inc/header.php';?>
    <div class="container max-w flex jc-c ai-c pv-2">
        <div class="result-container flex col ai-c bg-white shadow mv-2 gap-2">
            <div class="result-content w-full flex col ai-c">
                <h1 class="ta-c">Congratulations, <?=ucfirst($data["username"])?>!</h1>
                <div class="title-line mv-1 bg-accent ta-c"></div>
                <p class="ta-c">You have answered correctly to <b><?=$data["correct_questions"]?></b> out of <b><?=$data["total_questions"]?></b> questions!</p>
            </div>
            <div class="next-button">
                <button class="pointer w-250" onclick="exitTest()">Try another test &#8594;</button>
            </div>
        </div>
    </div> 
<?php require_once APPROOT . '/views/inc/footer.php';?>