<?php
session_start();
unset($_SESSION['admin']);
header('Location: /blog/view/admin');
exit;