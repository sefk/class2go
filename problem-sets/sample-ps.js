$(document).ready(function () {
var psQuestions = null;
$.get('quizzes/Information-Retrieval/question.json', 
        '', 
        function (data, textStatus, jqXHR) {
            psQuestions = data;
            console.log('data');
            console.log(psQuestions["data"]["question_groups"]);
        }, 
        'json');
});

