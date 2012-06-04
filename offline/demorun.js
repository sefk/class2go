var updateVideoContent = function (event) {

    event.preventDefault();
    var thisLink = event.currentTarget;

    $('#importer').attr('src', $(thisLink).attr('href'));

    $('.video-title').text(': ' + $(thisLink).text());

};

$(function() {
    var currentObj = {title: 'Arithmetic Algorithms',
                        type: 'lecture',
                        videoId: '',
                        contentUrl: 'Arithmetic%20algorithms%20(13%20min)/index.html'};

    var nextList = [
                    [{title: 'Attacking non-atomic decryption', 
                        type: 'lecture',
                        videoId:'',
                        contentUrl:'Attacking%20non-atomic%20decryption%20(10%20min)/index.html'},
                     {title: 'Problem Set 1: Stream Ciphers', 
                        type: 'ps',
                        contentUrl:'demoQuestion/index.html'},
                     {title: 'Problem Set 2', 
                        type: 'ps',
                        contentUrl:'demoQuestion2/index.html'}
                    ],
                    [{title: 'Active attacks on CPA-secure encryption',
                        type: 'lecture',
                        videoId: '',
                        contentUrl:'Active%20attacks%20on%20CPA-secure%20encryption%20(13%20min)/index.html'},
                     {title: 'Attacks on stream ciphers and the one time pad',
                        type: 'lecture',
                        videoId: '',
                        contentUrl:'Attacks%20on%20stream%20ciphers%20and%20the%20one%20time%20pad%20(24%20min)/index.html'}],
                    ];

    $('#import-container').append('<div id="toc"></div>');
    $('#toc').append('<h4>Syllabus</h4><h5>Week 1</h5><ul id="list-0" class="toc-list"></ul>');
    $('#list-0').append('<li><a href="Arithmetic%20algorithms%20(13%20min)/index.html" id="wk0_0" class="lecture">Arithmetic Algorithms</a></li>');
    $('#toc').append('<h5>Week 2</h5><ul id="list-1" class="toc-list"></ul>');

    for (var i = 0; i < nextList[0].length; i += 1) {
        $('#list-0').append('<li><a href="' + nextList[0][i]["contentUrl"] + '" id="wk0_' + i + '" class="' + nextList[0][i]["type"] + '">' + nextList[0][i]["title"] + '</a></li>');
    }
    for (var i = 0; i < nextList[1].length; i += 1) {
        $('#list-1').append('<li><a href="' + nextList[1][i]["contentUrl"] + '" id="wk1_' + i + '" class="'+ nextList[1][i]["type"] + '">' + nextList[1][i]["title"] + '</a></li>');
    }

    $('.toc-list').children('li').mouseover(function () {$(this).addClass('hover');});
    $('.toc-list').children('li').mouseout(function () {$(this).removeClass('hover');});

    //$('#toc').append('<div class="addendum"><a href="http://cware-dev2.stanford.edu/demo/crypto_wks12.zip" class="download-link">Download Offline Version</a></div>');

    $('.header-text').append('<span class="video-title">: Arithmetic Algorithms</span>');
    window.setTimeout(function() {$('#toc').show('slide'); }, 2000);
});

$(document).ready(function () {
    $('#importer').attr('src', 'Arithmetic%20algorithms%20(13%20min)/index.html');
    $('#toc').find('a').click(updateVideoContent);
});
