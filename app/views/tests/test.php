<?php require_once APPROOT . '/views/inc/header.php';?>
    <div class="container max-w flex jc-c ai-c pv-2">
        <div class="quiz-container w-500 flex col bg-white shadow mv-2">
            <div class="quiz-content w-full flex col ai-c gap ph-2">
                <h1 class="quiz-question w-full ta-c pv-3" data-id="<?=$data["question"]->id?>"><?=$data["question"]->question?></h1>
                <div class="quiz-answers flex wrap w-full s-e gap-2">
                    <?php foreach($data["options"] as $option) { ?>
                        <div class="quiz-answers__single flex ai-c jc-c pointer bg-gray" onclick="selectAnswer(this)" data-id="<?=$option->id?>"><?=$option->answer?></div>
                    <?php } ?>
                </div>
                <div class="quiz-progress w-250 flex mv-2 br-10">
                    <?php for($i = 0; $i < $data["question_nr"]+1; $i++) { ?>
                        <div class="progress-bar finished"></div>
                    <?php }?>
                    <?php for($i = 1; $i < $data["question_count"] - $data["question_nr"]+1; $i++) { ?>
                        <div class="progress-bar unfinished"></div>
                    <?php }?>
                </div>
                <div class="next-button flex w-full jc-c mb-2">
                    <button class="pointer w-150 flex gap jc-c" onclick="submitAnswer()">Next question <span>&#8594;</span></button>
                </div>
            </div>
        </div>
    </div> 
<?php require_once APPROOT . '/views/inc/footer.php';?>