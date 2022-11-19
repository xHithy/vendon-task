$(window).ready(function(){
    setQuestionHeight();
});

$(window).resize(function() {
    setQuestionHeight();
});

// Function to find the tallest single-question element in the DOM
// Purpose of this function is to make all the question boxes the same height relative to the tallest box
// This removes the ability for boxes to be different height instead they will all be as big as the box with most content
function setQuestionHeight() {
    var tallest = 0;
    $(".quiz-answers__single").css("height", "auto");
    $(".quiz-answers__single").each(function() {
        var questionHeight = $(this).height();
        if(questionHeight > tallest) tallest = questionHeight;
    });
    $(".quiz-answers__single").css("height", tallest);
}


// When an answer is clicked, this function fires
$(".quiz-answers__single").click(function(event){
    // Before adding the answer class to the just clicked element, remove previous element that was clicked
    $(".quiz-answers__single").removeClass("answer")
    $(event.target).addClass("answer");
});



/*
* This function is required because a user could use inspect element, and mark every answer as the one he picked
* If a user does that, then his answer would always be correct
* This function prevents it, by registering which DOM element the user has selected
* If user clicks on a different element, previous element gets removed from the variable
* Thus removing the chance of tinkering with inspect element
*/
var selectedAnswer = null;
var questionID = $(".quiz-question").attr("data-id");

function selectAnswer(answer) {
    selectedAnswer = $(answer).attr("data-id");
}

function submitAnswer() {
    if(selectedAnswer === null) {
        console.error("No answer was chosen!");
    } else {
        // Send a post request to the registerAnswer controller with the users selected answer
        $.ajax({
            type: "POST",
            data: {answerID:selectedAnswer, questionID:questionID},
            url: "tests/registerAnswer",
            success: function() {
                // Refresh the test page, with the new data
                window.location.replace("test");
            }
        })
    }
}


// This function is called once the user presses "Try another test" in the result view
function exitResults() {
    window.location.replace("landing");
}

