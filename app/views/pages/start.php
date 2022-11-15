<?php require APPROOT . '/views/inc/header.php';?>
    <div class="container max-w flex jc-c ai-c bg-gray">
        <div class="quiz-start flex col ai-c gap-1 bg-white shadow">
            <div class="quiz-start__title flex col ai-c ph-1">
                <h1>Welcome, to my test</h1>
                <p>Please, follow the steps below to continue</p>
            </div>
            <div class="title-line mv-1"></div>
            <form class="flex col ai-c gap-1 w-full" method="POST">
                <input class="w-250" placeholder="Enter your name..." name="user" type="text"  minlength="2" required>
                <select class="w-250" name="selectedQuiz" required>
                    <option value="" disabled selected hidden>Select a test...</option>
                    <option>Test 1</option>
                    <option>Test 2</option>
                </select>
                <button class="w-250 mt-1 pointer" type="submit" name="startQuiz">Start test &#8594;</button>
            </form>
        </div>
    </div> 
<?php require APPROOT . '/views/inc/footer.php';?>