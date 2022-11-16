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