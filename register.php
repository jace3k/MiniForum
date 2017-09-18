<script type="text/javascript" >
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url : 'scriptRegister',
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

    var password = document.getElementById("password")
        , confirm_password = document.getElementById("confirm_password");

    function validatePassword(){
        if(password.value !== confirm_password.value) {
            confirm_password.setCustomValidity("Hasła się nie zgadzają.");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;



</script>
<article class="thread" style="cursor:default;" >
    <header>REJESTRACJA</header>
    <form method="post" id="registerForm">

        <p><input type="text" name="login" placeholder=" login" class="input" required></p>
        <p><input type="password" name="password" placeholder=" hasło" class="input" id="password" required></p>
        <p><input type="password" name="password2" placeholder=" powtórz hasło" class="input" id="confirm_password" required></p>
        <p><input type="email" name="email" placeholder=" email" class="input" required></p>
        <p><label style="font-size: 0.7em;">
                Akceptuję nieistniejący regulamin <input type="checkbox" name="regulamin" required>
            </label></p>
        <p><input type="submit" value="Rejestruj" class="submit"/></p>
    </form>
</article>