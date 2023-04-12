<!doctype html>
<html lang="en" dir="en">

<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="A website that helps you to take Attendance" />
    <meta name="keywords" content="Attendance, mawjood, take" />
    <meta name="author" content="Hassan Khalaf, Rania Kharnoub" />
    <meta property="og:title" content="Mawjood | موجود">
    <meta property="og:site_name" content="Mawjood | موجود">
    <meta name="og:description" content="A website that helps you to take Attendance" />
    <meta property="og:type" content="website">
    <!-- <meta property="og:image" content="imgs/logo.png"> -->


    <!-- CSS -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" crossorigin="anonymous" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('extraCss')

    <!-- other -->
    <!-- <link rel="icon" href="imgs/icon.png"> -->

    <title>| Mawjood | Welcome</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body id="body-hight">
    <noscript>Your browser does not support JavaScript!</noscript>
