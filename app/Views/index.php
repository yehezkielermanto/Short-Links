<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shorten Links</title>
    <link rel="stylesheet" href="<?php echo base_url('/public/styles/output.css'); ?>">
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

    <!-- content -->
    <div class="mt-[60px] mb-[20px] mx-[20px] p-[20px] bg-white drop-shadow-xl rounded-lg">
        <div class="flex flex-col mx-[10%]">
            <textarea id="url" placeholder="input long url here" class="p-2 border border-black-1 rounded-md" cols="40"
                rows="4"></textarea>
            <!-- result  -->
            <div class="flex flex-col my-[10px]">
                <p id="result"></p>
            </div>

            <div class="flex flex-row justify-center my-3 text-white">
                <button type="button" id="btn_generate"
                    class="mx-3 bg-[#00A18C] p-4 rounded-lg shadow-[0_9px_#999] active:shadow-[0_6px_#666] active:translate-y-[4px]">Generate
                    Url</button>
                <button type="button" id="btn_copy"
                    class="mx-3 bg-[#00A18C] p-4 rounded-lg shadow-[0_9px_#999] active:shadow-[0_6px_#666] active:translate-y-[4px]">Copy
                    Shorten Url</button>
            </div>
        </div>
    </div>



    <!-- fontawesome script -->
    <script src="https://kit.fontawesome.com/26a7f3b810.js" crossorigin="anonymous"></script>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <!-- ajax to shorten long url -->
    <script type="text/javascript">
        $('#btn_generate').on('click', function() {
            let query = document.getElementById('url').value
            $.ajax({
                url: '/generate',
                method: "post",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                dataType: 'json',
                data: {
                    long_url: query
                },
                success: function(data) { 
                    $('#result').html('Your shorten url:  ' + '<a href ='+data.mergeUrl+' target="_blank" class="underline underline-offset-1" id="valueUrl">'+ data.mergeUrl +'</a>' )
                }
            })
        })

        // copy to clipboard
        $('#btn_copy').on('click', function(){
            let UrlValue = $('#valueUrl').text()
            navigator.clipboard.writeText(UrlValue)
            alert('Url copied to clipboard')
        })
    </script>
</body>

</html>
