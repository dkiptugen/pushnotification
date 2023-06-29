<!DOCTYPE HTML >
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $description }}">
    <meta name="author" content="{{ $author }}">
    <title>{{ $title }}</title>
    @include('frontend.includes.meta')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <div class="d-flex justify-content-around align-items-center">
        <button class="navbar-toggler mr-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand " href="https://www.kenyans.co.ke/prime">
            <img src="{{ asset('assets/img/logom.png') }}" alt="Kenyans.co.ke Logo" width="250" class="img-fluid">
        </a>
    </div>



    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.kenyans.co.ke/news">News</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.kenyans.co.ke/feel-good-stories">Feel-Good Stories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.kenyans.co.ke/media">Media</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.kenyans.co.ke/facts">Facts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.kenyans.co.ke/news/64678-top-100-politicians-2021">Top 100 Politicians</a>
            </li>
            <li class="nav-item">
                <a href="https://www.kenyans.co.ke/politicians" class="nav-link">Politicians</a>
            </li>
            <li class="nav-item">
                <a href="https://www.kenyans.co.ke/contact" class="nav-link">Contact</a>
            </li>

        </ul>

    </div>
</nav>

