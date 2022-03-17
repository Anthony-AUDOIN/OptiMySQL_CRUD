<?php
session_start();

$connection = new mysqli(
    'localhost',
    'admin',
    'admin',
    'mysqlopti'
);

mysqli_options($connection, MYSQLI_OPT_LOCAL_INFILE, true);
