function loadPage(url, content) {
    $.ajax({
        url: url,
        beforeSend: function () {
            content.empty();
            content.html("<p align='center'>Wczytywanie..</p>").fadeIn(300);
        },
        success: function (obj) {
            content.html(obj);
            $(content).hide().appendTo(content).fadeIn();

        },
        error: function () {
            content.html("<p>Error.</p>")
        }
    });
    return false;
}

var topic_id;
var interval;

function myThings(topicid) {
    topic_id = topicid;
    loadPage('posts?id='+topicid, $('#content'));
    if ($("#status").text() === '1') {
        $("#threadForm").hide();
        $("#postForm").show();

    }
    $("#backbtn").fadeIn(300);

    interval = setInterval(function () {
        $.ajax({
            url: 'checkForNewPosts.php',
            success: function (obj) {
                if(obj === '1') {
                    loadPage('posts?id='+topicid, $('#content'));
                    setTimeout(scrollDown, 100);
                }
            }
        })
    }, 5000);


}


function scrollDown() {
    var objDiv = document.getElementById("mainsection");
    objDiv.scrollTop = objDiv.scrollHeight;
}



$(document).ready(
    function () {
        var logo = $("#logo");
        var login = $("#login");
        var register = $("#register");
        var content = $("#content");
        var info = $("#info");
        var send = $("#send");
        var profile = $("#profile");
        var backbtn = $("#backbtn");
        var threadForm = $('#threadForm');
        var postForm = $("#postForm");

        var errorMsg = "<p>Error.</p>";
        logo.click(function () {
            info.hide(1000);
            //loadPage('threadForm.php', send);
            // $("#threadForm").show();
            // $("#postForm").hide();
            //return loadPage(logo.attr('href'), content);
            clearInterval(interval);
            location.reload();
            return false;
        });
        login.click(function () {
            info.fadeIn();
            return loadPage(login.attr('href'), info);

        });
        register.click(function () {
            info.fadeIn();
            return loadPage(register.attr('href'), info);
        });

        profile.click(function () {
            info.fadeOut();
            send.fadeOut();
            backbtn.fadeIn();
            clearInterval(interval);
            return loadPage(profile.attr('href'), content);
        });


        backbtn.click(function () {
            backbtn.hide();
            if ($("#status").text() === '1') {
                send.fadeIn();
            }
            clearInterval(interval);
            return loadPage(logo.attr('href'), content);
        });


        threadForm.on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url : 'threads',
                type: "POST",
                data: $(this).serialize(),
                success: function (obj) {
                    loadPage(logo.attr('href'), content);
                },
                error: function () {
                    content.html(errorMsg);
                }
            });
            $(".input").val("");
        });


        postForm.on('submit', function(e) {
            e.preventDefault();
            var url2 = 'posts?id=' + topic_id;
            $.ajax({
                url : url2,
                type: "POST",
                data: $(this).serialize(),
                success: function (obj) {
                    loadPage(url2, content);
                },
                error: function () {
                    content.html(errorMsg);
                }
            });
            setTimeout(scrollDown, 100);
            $(".input").val("");
        });



        loadPage(logo.attr('href'), content);
        postForm.hide();
        threadForm.hide();
        send.hide();
        if ($("#status").text() === '1') {
            threadForm.show();
            send.show();
        } else {
            threadForm.hide();
            send.hide();
        }


        info.hide(1000);
        backbtn.hide();


        $(".errorMsg").fadeIn(1000);
        setTimeout(function () {
            $(".errorMsg").fadeOut(1000);
        }, 3000);
    }
);


