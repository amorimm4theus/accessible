<?php
require_once "session.php";
terminaSessao();
session_start();
session_unset();
session_destroy();
header("Location: ../../");