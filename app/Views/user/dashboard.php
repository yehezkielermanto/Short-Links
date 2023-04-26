<?= $this->extend('/template/header') ?>

<?= $this->section('content') ?>

<!-- action bar -->
<div class="bg-white rounded-lg mx-[4%] mt-[40px] flex justify-between">
    <a href="#" class="rounded-lg bg-white drop-shadow-lg p-3">
        <i class="fa-regular fa-user fa-lg"></i>
    </a>
    <a href="/user/logout" class="rounded-lg bg-red-500 text-white drop-shadow-lg p-3">
        <i class="fa-solid fa-arrow-right-from-bracket fa-lg"></i>
    </a>
</div>

<div class="my-[35px]">
    <!-- new short link -->
    <button id="btn_new" class="mx-[4%] p-3 bg-blue-300 rounded-lg drop-shadow-md" onclick="newLink()">
        <i class="fa-solid fa-plus fa-lg mr-2"></i>
        New short URL
    </button>

    <!-- make new links -->
    <div class="" id="container_new">
        <div class="bg-slate-200 drop-shadow-lg rounded-md p-3 my-[30px] mx-[4%] flex flex-col">
            <!-- generate new short url -->
            <textarea class="border-2 rounded-lg border-slate-500 width-full p-2" name="long_url" id="long_url" cols="30" rows="3"></textarea>
            <button class="my-[8px] bg-green-300 rounded-lg p-2" id="generate_short" onclick="generateUrl()">Generate Short URL</button>
            
            <!-- result -->
            <p class="width-full p-2" id="result_generate"></p>
        </div>
    </div>  
</div>

<!-- alert -->
<?php if (session()->has('error')): ?>
    <div class="mx-[4%] bg-red-500 text-white my-2 rounded-lg p-2" id="alert">
        <div class="flex flex-row justify-between">
            <ul>
                <?php foreach (session()->error as $error): ?>
                <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
            <i class="fa-solid fa-xmark" id="close_alert" onclick="closeAlert()"></i>
        </div>
    </div>
<?php endif ?>

<?php if (session()->has('success')): ?>
    <div class="mx-[4%] bg-green-500 text-white my-2 rounded-lg p-2" id="alert">
        <div class="flex flex-row justify-between">
            <ul>
                <?php foreach (session()->success as $success): ?>
                <li><?= esc($success) ?></li>
                <?php endforeach ?>
            </ul>
            <i class="fa-solid fa-xmark" id="close_alert" onclick="closeAlert()"></i>
        </div>
    </div>
<?php endif ?>

<!-- custom name -->
<div id="box_custom" class="mx-[4%] p-3 hidden bg-slate-300 rounded-lg">
    <div class="flex justify-end">
        <i class="fa-solid fa-xmark fa-lg p-1" onclick="closeBoxCustom()"></i>
    </div>
    <div class="flex flex-col items-center justify-center mt-[20px]">
        <input type="text" id="url_short_now" class="w-full rounded-md" readonly>
        <input type="text" id="custom_url" class="border-b rounded-md border-slate-500 my-[8px] w-full p-1" placeholder="insert your custom name...">
    </div>
    <button class="w-full bg-blue-500 text-white rounded-md p-[5px]" onclick="submitChange()">Change Name</button>
</div>

<!-- button confirmation delete url -->
<div class="h-[140vh] w-screen hidden absolute top-0 bg-slate-700/60" id="box_confirm">
    <div class="bg-white absolute top-[30%] p-[20px] w-full">
        <input type="hidden" id="text_url">
        <p class="text-[20px]">Sure delete this URL?</p>
        <div class="flex flex-row justify-between mt-3 text-white">
            <button class="bg-slate-500 p-3 rounded-md" onclick="closeBox()">No</button>
            <button class="bg-red-600 p-3 rounded-md" onclick="submitDeleteUrl()">Yes</button>
        </div>
    </div>
</div>

<!-- list all links -->
<div class="overflow-x-auto mx-[4%] mt-[50px]">
    <table class="w-full" id="list_url">
        <thead class="uppercase bg-gray-50">
            <tr>
                <th class="border-x p-3">No.</th>
                <th class="border-x p-3">URL Ori</th>
                <th class="border-x p-3">URL Short</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="table_body">
            <?php $i=1;?>
            <?php foreach($links as $link):?>
                <tr class="text-center border-b">
                    <td class="border-x"><?= $i++; ?></td>
                    <td class="border-x w-auto"><?= $link['url_ori']; ?></td>
                    <td class="border-x w-auto" id="rowData<?= $i?>">
                        <?= $link['url_short']; ?>
                    </td>
                    <td class="border-x">
                        <div class="flex flex-row justify-end">
                            <button class="mx-1 bg-purple-300 p-2 rounded-md" onclick="copyUrl('<?=$link["url_short"]?>')" id="btn_copy">
                                <i class="fa-solid fa-clipboard fa-lg"></i>
                            </button>
                            <button class="mx-1 bg-red-600 text-white p-2 rounded-md" onclick="deleteUrl('<?=$link["url_short"]?>')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <button class="mx-1 bg-slate-300 p-2 rounded-md" onclick="visitUrl('<?=$link["url_short"]?>')">
                                <i class="mx-2 fa-solid fa-up-right-from-square"></i>
                            </button>
                            <button class="mx-1 bg-blue-300 p-2 rounded-md" onclick="editUrl('<?=$link["url_short"]?>')">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<?= $pager->links('links','front_full') ?>

<!-- <div id="pager"></div> -->

<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<!-- page scripting -->
<script type="text/javascript">
    let btn_new = document.getElementById('btn_new')
    let container_new = document.getElementById('container_new')
    let boxConfirm = document.getElementById('box_confirm')
    let list_url = document.getElementById('list_url')

    function newLink(){
        container_new.classList.toggle('hidden')
    }

    function generateUrl(){
        let longUrl = document.getElementById('long_url').value.replaceAll(' ','')
        let url = validURL(longUrl)
        let resultGenerate = document.getElementById('result_generate')
        if(url == true){
            $.ajax({
                url: '/user/generate',
                method: 'POST',
                headers: {
                    'X-Requested-With' : 'XMLHttpRequest'
                },
                dataType: 'json',
                data: {
                    longUrl: longUrl
                },
                success: function(response){
                    resultGenerate.innerHTML = "Shorten URL: <a href='"+ response.merge_url +"' target='_blank' class='underline underline-offset-1 text-blue-600'>"+response.merge_url+"</a>"
    
                    // reload page
                    $("#list_url").load(window.location.href + " #list_url")
                }
            })
        }else{
            alert("Please insert valid url")
        }
    }

    function visitUrl(data){
        let base_url = "<?= base_url();?>"
        return window.open(`${base_url}/${data}`)
    }

    function editUrl(data){
        // show box custom url
        let boxChange = document.getElementById('box_custom')
        let url_now = document.getElementById('url_short_now')
        
        url_now.value = data
        boxChange.classList.remove('hidden')
    }

    function submitChange(){
        let url_now = document.getElementById('url_short_now').value
        let custom_url = document.getElementById('custom_url').value.replaceAll(' ','')

        // ajax change url
        $.ajax({
            url:'/user/change',
            method: 'POST',
            headers:{
                'X-Requested-With' : 'XMLHttpRequest'
            },
            dataType: 'json',
            data: { url_short: url_now, url_custom: custom_url },
            success: function(response){
                console.log(response)
                // reload page
                window.location.reload()
            },
            error: function(response){
                window.location.reload()
            } 
        })
    }

    function closeBoxCustom(){
        let boxChange = document.getElementById('box_custom')
        boxChange.classList.add('hidden')
    }
    function closeAlert(){
        let boxChange = document.getElementById('alert')
        boxChange.classList.add('hidden')
    }

    function closeBox(){
        let boxConfirm = document.getElementById('box_confirm')
        boxConfirm.classList.add('hidden')
    }

    function deleteUrl(data){
        // show box delete confirmation
        boxConfirm.classList.remove('hidden')

        let text_url = document.getElementById('text_url')
        text_url.value = data
    }

    function submitDeleteUrl(){
         boxConfirm.classList.add('hidden')
        let data = document.getElementById('text_url').value
        $.ajax({
            url: '/user/delete',
            method: 'POST',
            headers:{
                'X-Requested-With' : 'XMLHttpRequest'
            },
            dataType: 'json',
            data: {
                'url_short' : data
            },
            success: function(response){
                // console.log(response)
                window.location.reload()
            } 
        })
    }

    // copy url
    function copyUrl(data){
        let base_url = "<?=base_url();?>"
        new ClipboardJS('#btn_copy',{
            text: function(){
                return base_url+data
            }
        })

        alert('Url copied to clipboard')
    }


</script>

<?= $this->endSection() ?>
