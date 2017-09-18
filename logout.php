<?php
session_start();
$_SESSION['logged'] = false;
session_unset();
$_SESSION['loginerror'] = 'Wylogowano.';
header('Location:home');