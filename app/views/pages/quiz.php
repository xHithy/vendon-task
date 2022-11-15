<?php require APPROOT . '/views/inc/header.php';?>
    <div class="container max-w flex jc-c ai-c bg-gray pv-2">
        <div class="quiz-container flex col bg-white shadow mv-2">
            <div class="quiz-progress w-full flex gap-1 p-2">
                <div class="progress-bar finished"></div>
                <div class="progress-bar unfinished"></div>
                <div class="progress-bar unfinished"></div>
                <div class="progress-bar unfinished"></div>
                <div class="progress-bar unfinished"></div>
                <div class="progress-bar unfinished"></div>
                <div class="progress-bar unfinished"></div>
                <div class="progress-bar unfinished"></div>
                <div class="progress-bar unfinished"></div>
                <div class="progress-bar unfinished"></div>
            </div>
            <div class="quiz-content w-full flex col gap ph-2">
                <h1 class="ta-l w-full">The Mathematics Test</h1>
                <h2 class="ta-l w-full bg-accent p-1 tc-white">What is 2 + 2</h2>
                <div class="quiz-questions flex col w-full gap-2 pv-2">
                    <div class="quiz-questions__single flex gap ai-c pointer bg-gray">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Enim, a.</div>
                    <div class="quiz-questions__single flex gap ai-c pointer bg-gray">Lorem ipsum dolor sit amet consectetur.</div>
                    <div class="quiz-questions__single flex gap ai-c pointer bg-gray">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Beatae, possimus quam!</div>
                    <div class="quiz-questions__single flex gap ai-c pointer bg-gray answer">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Enim, a.</div>
                    <div class="quiz-questions__single flex gap ai-c pointer bg-gray">Lorem ipsum dolor sit amet consectetur.</div>
                    <div class="quiz-questions__single flex gap ai-c pointer bg-gray">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Beatae, possimus quam!</div>
                </div>
                <div class="next-button flex w-full jc-r mb-2">
                    <button class="pointer w-150">Next question &#8594;</button>
                </div>
            </div>
        </div>
    </div> 
<?php require APPROOT . '/views/inc/footer.php';?>