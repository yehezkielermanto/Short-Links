<?= $this->extend('/template/header') ?>

<?= $this->section('content') ?>
<!-- content -->

<div class="m-4">
    <a href="/" class="underline text-blue-600">Back to Login Page</a>
</div>

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

<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<!-- ajax to shorten long url -->
<script type="text/javascript">
    function isValidURL(url) {
        try {
            new URL(url)
            return true
        } catch (error) {
            return false
        }
    }

    $('#btn_generate').on('click', function() {
        let query = document.getElementById('url').value
        if (isValidURL(query) == false) {
            return alert('Please enter valid URL')
        }
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
                $('#result').html('Your shorten url:  ' + '<a href =' + data.mergeUrl +
                    ' target="_blank" class="underline underline-offset-1" id="valueUrl">' +
                    data.mergeUrl + '</a>')
            }
        })

    })

    // copy to clipboard
    $('#btn_copy').on('click', function() {
        let UrlValue = $('#valueUrl').text()
        if (UrlValue) {
            new ClipboardJS('#btn_copy', {
                text: function() {
                    return UrlValue
                }
            })
            alert('Url copied to clipboard')
        } else {
            alert('Please enter valid URL')
        }
    })
</script>
<?= $this->endSection() ?>
