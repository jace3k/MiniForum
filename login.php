<script type="text/javascript" >
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url : 'scriptLogin',
            type: "POST",
            data: $(this).serialize(),
            success: function (obj) {
                location.reload();
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
        $(".input").val("");
    });
</script>

<article class="thread" style="cursor:default;" >
    <header>LOGIN</header>
    <form method="post" id="loginForm">

        <p><input type="text" name="login" placeholder=" login" class="input"/></p>

        <p><input type="password" name="password" placeholder=" hasło" class="input"/></p>

        <p><input type="submit" value="Login" class="submit"/></p>
    </form>
</article>