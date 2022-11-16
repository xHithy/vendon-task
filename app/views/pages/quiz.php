<?php require_once APPROOT . '/views/inc/header.php';?>
    <div class="container max-w flex jc-c ai-c pv-2">
        <div class="quiz-container flex col bg-white shadow mv-2">
            <div class="quiz-content w-full flex col ai-c gap ph-2">
                <h1 class="quiz-question w-full ta-c pv-3">What is 2 + 2?</h1>
                <div class="quiz-answers flex wrap w-full s-e gap-2">
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">Lorem ipsum dolor sit amet consectetur adipisicing elit. A, magnam?</div>
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">2</div>
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">3</div>
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">Lorem ipsum dolor sit amet, consectetur adipisicing.</div>
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">5</div>
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">6</div>
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">Lorem ipsum dolor sit amet consectetur adipisicing elit. A, magnam?</div>
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">3</div>
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">Lorem ipsum dolor sit amet, consectetur adipisicing.</div>
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">5</div>
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">6</div>
                    <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray">5</div>
                </div>
                <div class="quiz-progress w-full flex mv-2 br-10">
                    <div class="progress-bar finished"></div>
                    <div class="progress-bar finished"></div>
                    <div class="progress-bar unfinished"></div>
                    <div class="progress-bar unfinished"></div>
                    <div class="progress-bar unfinished"></div>
                    <div class="progress-bar unfinished"></div>
                    <div class="progress-bar unfinished"></div>
                    <div class="progress-bar unfinished"></div>
                    <div class="progress-bar unfinished"></div>
                    <div class="progress-bar unfinished"></div>
                </div>
                <div class="next-button flex w-full jc-c mb-2">
                    <button class="pointer w-150">Next question &#8594;</button>
                </div>
            </div>
        </div>
    </div> 
<?php require_once APPROOT . '/views/inc/footer.php';?>