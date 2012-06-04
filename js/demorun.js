var updateVideoContent = function (event) {

    event.preventDefault();
    var thisLink = event.currentTarget;

    $('#importer').attr('src', $(thisLink).attr('href'));

    $('.video-title').text(': ' + $(thisLink).text());

};

$(function() {
    var currentObj = {title: 'Course Introduction',
                        type: 'lecture',
                        videoId: '',
                        contentUrl: 'week1/Course-Introduction/'};

    var nextList = [
                    [{title: 'Regular Expressions', 
                        type: 'lecture',
                        videoId:'',
                        contentUrl:'week1/Regular-Expressions/'},
                     {title: 'Regular Expressions in Practical NLP', 
                        type: 'lecture',
                        videoId:'',
                        contentUrl:'week1/Regular-Expressions-In-Practical-NLP/'},
                     {title: 'Word Tokenization', 
                        type: 'lecture',
                        contentUrl:'week1/Word-Tokenization/'},
                     {title: 'Word Normalization and Stemming', 
                        type: 'lecture',
                        contentUrl:'week1/Word-Normalization-And-Stemming/'},
                     {title: 'Sentence Segmentation', 
                        type: 'lecture',
                        contentUrl:'week1/Sentence-Segmentation/'},
                     {title: 'Problem Set 1: Text Processing and Edit Distance', 
                        type: 'ps',
                        contentUrl:'problem-sets/index.html?ps=Text-Processing-And-Edit-Distance'}],

                     [{title: 'Defining Minimum Edit Distance', 
                        type: 'lecture',
                        contentUrl:'week1/Defining-Minimum-Edit-Distance/'},
                     {title: 'Computing Minimum Edit Distance', 
                        type: 'lecture',
                        contentUrl:'week1/Computing-Minimum-Edit-Distance/'},
                     {title: 'Backtrace for Computing Alignments', 
                        type: 'lecture',
                        contentUrl:'week1/Backtrace-For-Computing-Alignments/'},
                     {title: 'Weighted Minimum Edit Distance', 
                        type: 'lecture',
                        contentUrl:'week1/Weighted-Minimum-Edit-Distance/'},
                     {title: 'Minimum Edit Distance in Computational Biology', 
                        type: 'lecture',
                        contentUrl:'week1/Minimum-Edit-Distance-In-Computational-Biology/'}
                    ],
                    [{title: 'Introduction to N-grams',
                        type: 'lecture',
                        videoId: '',
                        contentUrl:'week2/Introduction-To-N-Grams/'},
                     {title: 'Estimating N-gram Probabilities',
                        type: 'lecture',
                        videoId: '',
                        contentUrl:'week2/Estimating-N-Gram-Probabilities/'},
                    {title: ''}],
                    [{title: 'The Spelling Correction Task',
                        type: 'lecture',
                        videoId: '',
                        contentUrl:'week2/The-Spelling-Correction-Task/'},
                     {title: 'The Noisy Channel Model of Spelling',
                        type: 'lecture',
                        videoId: '',
                        contentUrl:'week2/The-Noisy-Channel-Model-Of-Spelling/'},
                     {title: 'Real-Word Spelling Correction',
                        type: 'lecture',
                        videoId: '',
                        contentUrl:'week2/Real-Word-Spelling-Correction/'},
                     {title: 'State of the Art Systems',
                        type: 'lecture',
                        videoId: '',
                        contentUrl:'week2/State-Of-The-Art-Systems/'},
                     {title: 'Problem Set 2: Language Modeling And Spelling Correction', 
                        type: 'ps',
                        contentUrl:'problem-sets/index.html?ps=Language-Modeling-And-Spelling-Correction'}],
                    [{title: 'Attacks on stream ciphers and the one time pad',
                        type: 'lecture',
                        videoId: '',
                        contentUrl:'http://cware-dev2.stanford.edu/demo/Attacks%20on%20stream%20ciphers%20and%20the%20one%20time%20pad%20(24%20min)/'}],
                    ];

    $('#import-container').prepend('<div id="toc"></div>');
    $('#toc').append('<h4>Syllabus</h4><div class="scrollable"><h5 class="collapsed head"><span></span>Week 1 - Course Introduction</h5><ul id="list-0" class="toc-list"></ul></div>');
    $('#list-0').append('<li class="watching"><a href="' + currentObj["contentUrl"] + '" id="wk0_0" class="lecture">' + currentObj["title"] + '</a></li>');
    $('#toc').find('div.scrollable').append('<h5 class="collapsed head"><span></span>Week 1 - Basic Text Processing</h5><ul id="list-1" class="toc-list"></ul>');
    $('#toc').find('div.scrollable').append('<h5 class="collapsed head"><span></span>Week 1 - Edit Distance</h5><ul id="list-2" class="toc-list"></ul>');
    $('#toc').find('div.scrollable').append('<h5 class="collapsed head"><span></span>Week 2 - Language Modeling</h5><ul id="list-3" class="toc-list"></ul>');
    $('#toc').find('div.scrollable').append('<h5 class="collapsed head"><span></span>Week 2 - Spelling Correction</h5><ul id="list-4" class="toc-list"></ul>');

    for (var L1 = 0; L1 < nextList.length; L1 += 1) {
        for (var L2 = 0; L2 < nextList[L1].length; L2 += 1) {
            $('#list-' + (L1 + 1)).append('<li><a href="' + nextList[L1][L2]["contentUrl"] + '" id="wk0_' + L1 + '_' + L2 + '" class="' + nextList[L1][L2]["type"] + '">' + nextList[L1][L2]["title"] + '</a></li>');
        }
    }

    $('.toc-list').children('li').mouseover(function () {$(this).addClass('hover');});
    $('.toc-list').children('li').mouseout(function () {$(this).removeClass('hover');});
    $('.toc-list').children('li').click(function () {
        $('.toc-list').children('li.watching').removeClass('watching');
        $(this).addClass('watching');
    });    

    $('h5.head').click(function () {
        if ($(this).hasClass('collapsed')) {
            $(this).removeClass('collapsed').addClass('expanded');
        } else {
            $(this).removeClass('expanded').addClass('collapsed');
        }
        $(this).next().toggle();
        return false;
    }).next().hide();
    $('h5.head').first().click();

    $('#toc').append('<div class="addendum"><a href="http://cware-dev2.stanford.edu/demo/crypto_wks12.zip" class="download-link">Download Offline Version</a></div>');

    $('.header-text').append('<span class="video-title">: Course Introduction</span>');
    window.setTimeout(function() {$('#toc').show('slide', {direction:'right'}); }, 2000);
});

$(document).ready(function () {
    $('#importer').attr('src', 'http://class2go.stanford.edu/NLP/week1/Course-Introduction/');
    $('#toc').find('a').click(updateVideoContent);
});
