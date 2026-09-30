<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/controllers.php';

(new AdminController($pdo))->showScan();
