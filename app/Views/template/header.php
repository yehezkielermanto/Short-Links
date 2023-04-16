<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/styles/output.css">
    <title>Shorten URL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&display=swap" rel="stylesheet">
    <style>
        html {
            font-family: 'Josefin Sans', sans-serif;
        }
    </style>
</head>
<body>
    <!-- navigation bar -->
    <div class="m-4 p-4 bg-purple-500 rounded-lg text-white text-[22px]">
        <div class="flex justify-between">
            <a href="#">Shorten Links</a>
            <a href="https://github.com/yehezkielermanto/Short-Links" target="_blank" class="mx-2">
                <i class="fa-brands fa-github fa-lg"></i>
            </a>
        </div>
    </div>

    <?= $this->renderSection('content'); ?>

    <!-- fontawesome script -->
    <script src="https://kit.fontawesome.com/26a7f3b810.js" crossorigin="anonymous"></script>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    
    <!-- clipboard js -->
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.10/dist/clipboard.min.js"></script>
</body>
</html>