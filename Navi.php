<?php

class Navi
{
    public $logged = 0;
    public $name = 'NAME';

    public function menuItemsLogin() {
        echo '<a id="login" href="login">LOGIN</a> ';
        echo '<a id="register" href="register">REGISTER</a>';
    }
    public function menuItemsLogout() {
        echo '<a id="logout" href="logout">LOGOUT</a> ';
        echo '<a id="profile" href="profile">'.strtoupper($this->name).'</a>';
    }


    public function printNavi() {
        echo <<<EOD
    <nav>
        <div style="float: left;">
        <a href="threads" id="logo">
            <img src="img/miniforum.png"/>
        </a>
        </div>

        <div id="menu">
EOD;
        if($this->logged) $this->menuItemsLogout(); else $this->menuItemsLogin();
        echo <<<EOT
        </div>
	</nav>     
EOT;
    }

    public function printError($msg) {
        echo '<div class="errorMsg">';
        echo $msg;
        echo '</div>';
    }

    public function printSuccess($msg) {
        echo '<div class="errorMsg" style="background-color: green;">';
        echo $msg;
        echo '</div>';
    }
}

$navi = new Navi();