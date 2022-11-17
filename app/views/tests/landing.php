<?php require_once APPROOT . '/views/inc/header.php';?>
    <div class="container max-w flex jc-c ai-c">
        <div class="quiz-start flex col ai-c gap-1 bg-white shadow">
            <div class="quiz-start__title flex col ai-c ph-1">
                <h1>Welcome, to my test</h1>
                <p>Please, follow the steps below to continue</p>
            </div>
            <div class="title-line mv-1 bg-accent"></div>
            <form action="<?=URLROOT . 'tests/test'?>" class="flex col ai-c gap-1 w-full" method="POST">
                <input class="w-250" placeholder="Enter your name..." name="user" type="text"  minlength="2" required>
                <select class="w-250" name="selectedTest" required>
                    <option value="" disabled selected hidden>Select a test...</option>
                    <?php foreach($data["tests"] as $test) { ?>
                        <option value="<?=$test->id?>"><?=$test->test_name?></option>
                    <?php } ?>
                </select>
                <button class="w-250 mt-1 pointer" type="submit" name="startQuiz">Start test &#8594;</button>
            </form>
        </div>
    </div> 
<?php require_once APPROOT . '/views/inc/footer.php';?>