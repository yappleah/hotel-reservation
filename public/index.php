<?php
    require_once '../vendor/autoload.php';
    use Carbon\Carbon;
    $loader = new \Twig\Loader\FilesystemLoader('../templates'); 
    $twig = new \Twig\Environment($loader);
    $today = Carbon::today()->toDateString();
    echo $twig->render('index.twig', ['todayDate' => $today]);
?>