<?php
include "header.php";
include "CartFunctions.php";
session_start();
print_r(GetCart());
