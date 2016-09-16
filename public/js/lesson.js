$(document).ready(function () {
    $('#nav-home').removeClass('active');
    $('#nav-lesson').addClass('active');

    $('#start-lesson').on('click', function() {
        $('#lesson-frame').empty();
        init();
    });

    var currentquestion = 0, score = 0, submt=true, picked;
    var result = [];
    var quiztitle = "Find the best description for the word below";

    var quiz = $('#data-lesson').data('questions');

    function htmlEncode(value) {
        return $('<div></div>').text(value).html();
    }

    /**
     * This will add the individual choices for each question to the ul#choice-block
     *
     * @param {choices} array The choices from each question
     */
    function addChoices(choices) {
        if (typeof choices !== "undefined" && $.type(choices) == "array") {
            $('#choice-block').empty();
            for (var i=0; i<choices.length;  i++) {
                $('<li></li>')
                    .addClass('choice choice-box')
                    .attr('data-index', i)
                    .text(choices[i])
                    .appendTo('#choice-block');
            }
        }
    }

    /**
     * Resets all of the fields to prepare for next question
     */
    function nextQuestion() {
        submt = true;
        $('#explanation').empty();
        $('#question').text(quiz[currentquestion]['question']);
        $('#pager').text('Question ' + Number(currentquestion + 1) + ' of ' + quiz.length);
        if (quiz[currentquestion].hasOwnProperty('image') && quiz[currentquestion]['image'] != "") {
            if ($('#question-image').length == 0) {
                $('<img>')
                    .addClass('question-image')
                    .attr('id', 'question-image')
                    .attr('src', quiz[currentquestion]['image'])
                    .attr('alt', htmlEncode(quiz[currentquestion]['question']))
                    .insertAfter('#question');
            } else {
                $('#question-image')
                    .attr('src', quiz[currentquestion]['image'])
                    .attr('alt', htmlEncode(quiz[currentquestion]['question']));
            }
        } else {
            $('#question-image').remove();
        }
        addChoices(quiz[currentquestion]['choices']);
        setupButtons();
    }

    /**
     * After a selection is submitted, checks if its the right answer
     *
     * @param {choice} number The li zero-based index of the choice picked
     */
    function processQuestion(choice) {
        if (quiz[currentquestion]['choices'][choice] == quiz[currentquestion]['correct']) {
            $('.choice')
                .eq(choice)
                .addClass('on-choice-correct');
                $('#explanation')
                .html('<strong>Correct!</strong> ' + htmlEncode(quiz[currentquestion]['explanation']));
                score++;
        } else {
            $('.choice')
                .eq(choice).addClass('on-choice-false');
                $('#explanation')
                .html('<strong>Incorrect.</strong> ' + htmlEncode(quiz[currentquestion]['explanation']));
        }
        result[currentquestion] = quiz[currentquestion]['answers'][choice];
        currentquestion++;
        $('#submitbutton').html('NEXT QUESTION &raquo; ').on('click', function() {
            if (currentquestion == quiz.length) {
                endQuiz();
            } else {
                $(this).text('Check Answer').addClass('check-answer').off('click');
                nextQuestion();
            }
        })
    }

    /**
     * Sets up the event listeners for each button.
     */
    function setupButtons() {
        $('.choice').on('mouseover', function() {
            $(this).removeClass('choice-on-mouseout');
            $(this).addClass('choice-on-mouseover');
        });
        $('.choice').on('mouseout', function() {
            $(this).removeClass('choice-on-mouseover');
            $(this).addClass('choice-on-mouseout');
        })
        $('.choice').on('click', function() {
            picked = $(this).attr('data-index');
            $('.choice').removeAttr('style').off('mouseout mouseover');
            $(this).addClass('choise.onclick');
            if (submt) {
                submt=false;
                $('#submitbutton').addClass('off-summit').on('click', function() {
                    $('.choice').off('click');
                    $(this).off('click');
                    processQuestion(picked);
                });
            }
        })
    }

    /**
     * Quiz ends, display a message.
     */
    function endQuiz() {
        $('#explanation').empty();
        $('#question').empty();
        $('#choice-block').empty();
        $('#submitbutton').remove();
        $('#saveButton').removeClass('hide');
        $('#question')
        .text("You got " + score + " out of " + quiz.length + " correct.");
        $('<h2></h2>')
            .addClass('end-quiz')
            .text(Math.round(score/quiz.length * 100) + '%')
            .insertAfter('#question');
        //AJAX to save result

        $('#saveButton').click(function(e) {
            e.preventDefault();
            var formData = new FormData();
            formData.append('result', result);
            formData.append('lesson_id', $('#data-lesson').data('lesson'));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/result',
                processData : false,
                cache: false,
                contentType: false,
                method:'POST',
                data : formData,
                success: function(data) {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert(data.message);
                        window.location.reload();
                    }
                },
                error: function() {}
            });
        });

    }

    function dump(obj) {
        var out = '';
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }

        alert(out);

        // or, if you wanted to avoid alerts...

        var pre = $('<pre></pre>');
        pre.innerHTML = out;
        $('body').append(pre)
    }

    /**
     * Runs the first time and creates all of the elements for the quiz
     */
    function init() {
        if (typeof quiztitle !== "undefined" && $.type(quiztitle) === "string") {
            $('<h1></h1>').addClass('text-center').text(quiztitle).appendTo('#lesson-frame');
        } else {
            $('<h1></h1>').text("Quiz").appendTo('#lesson-frame');
        }

        //add pager and questions
        if (typeof quiz !== "undefined" && $.type(quiz) === "array") {
            //add pager
            $('<p></p>')
                .addClass('pager')
                .attr('id','pager')
                .text('Question 1 of ' + quiz.length).appendTo('#lesson-frame');
            //add first question
            $('<h2></h2>')
                .addClass('question')
                .attr('id', 'question')
                .text(quiz[0]['question'])
                .appendTo('#lesson-frame');
            //add image if present
            if (quiz[0].hasOwnProperty('image') && quiz[0]['image'] != "") {
                $('<img>')
                    .addClass('question-image')
                    .attr('id', 'question-image')
                    .attr('src', quiz[0]['image'])
                    .attr('alt', htmlEncode(quiz[0]['question']))
                    .appendTo('#lesson-frame');
            }
            $('<p></p>').addClass('explanation').attr('id','explanation').html('&nbsp; ').appendTo('#lesson-frame');

            //questions holder
            $('<li></li>')
                .attr('id', 'choice-block')
                .appendTo('#lesson-frame');

            //add choices
            addChoices(quiz[0]['choices']);

            //add submit button
            $('<div></div>')
                .addClass('choice-box')
                .attr('id', 'submitbutton')
                .text('Check Answer')
                .addClass('choice-box-check')
                .appendTo('#lesson-frame');
            //add save button
            $('<div></div>')
                .addClass('choice-box')
                .attr('id', 'saveButton')
                .addClass('hide')
                .text('SAVE THIS RESULT')
                .addClass('choice-box-submit')
                .appendTo('#lesson-frame');

            setupButtons();
        }
    }
});
