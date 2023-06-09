<?= $this->extend('/template/header') ?>

<?= $this->section('content') ?>
<!-- form login -->
<div class="md:mx-[20%] my-[10%] xs:mx-[4%]">
    <!-- alert -->
    <?php if (session()->has('error')): ?>
    <div class="bg-red-500 text-white my-2 rounded-lg p-2">
        <ul>
            <?php foreach (session()->error as $error): ?>
            <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php endif ?>
    <?php if (session()->has('success')): ?>
    <div class="bg-green-500 text-white my-2 rounded-lg p-2">
        <ul>
            <li><?= session()->success ?></li>
        </ul>
    </div>
    <?php endif ?>
    <div class="p-4 bg-slate-200 drop-shadow-md rounded-xl">
        <p class="font-bold text-[20px] text-center mb-[25px]">LOGIN</p>
        <form action="/user/login/auth" method="post">
            <?php csrf_token(); ?>
            <div class="flex flex-col justify-center">
                <div class="mb-4">
                    <div class="flex xl:flex-row lg:flex-row md:flex-row sm:flex-col xs:flex-col 2xs: flex-col justify-center items-center">
                        <label for="email" class="mx-4 block w-[80px]">Email</label>
                        <input type="text" name="email" id="email" class="border border-slate-300 rounded-lg p-1">
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex xl:flex-row lg:flex-row md:flex-row sm:flex-col xs:flex-col 2xs: flex-col items-center justify-center">
                        <label for="password" class="mx-4 block w-[80px]">Password</label>
                        <input type="password" name="password" id="password"
                            class="border border-slate-300 rounded-lg p-1">
                    </div>
                </div>
                <div class="flex flex-row justify-center items-center">
                    <button type="submit" class="bg-green-300 p-2 w-[150px] rounded-lg">Login</button>
                </div>
                <a href="/user/register" class="text-center mt-1 underline text-[14px] text-blue-500">Register New
                    User</a>
            </div>
        </form>

        <!-- login using google -->
        <?php if(isset($login_button)): ?>
        <div class="mx-4 mt-4 border-t-2 border-slate-300 flex flex-row justify-center items-center">
            <a href="<?= $login_button; ?>" class="bg-white my-3 p-2 rounded-lg flex flex-row justify-center items-center">
                <img src="https://www.google.com/images/branding/googleg/1x/googleg_standard_color_128dp.png"
                    alt="google_logo" class="mx-1" width="25">
                <p class="mx-1">Login</p>
            </a>
        </div>
        <?php endif;?>
    </div>

    <div class="text-center my-[20px]">
        <a href="/link/testing" class="underline text-blue-500">Testing Short URL</a>
    </div>
    
    <div class="flex items-center justify-center">
        <div class="text-center rounded-lg bg-white drop-shadow-lg p-[15px]">
            <p>Read <a href="/user/service" class="text-blue-500 underline underline-offset-1" target="_blank">Terms</a> & <a class="text-blue-500 underline underline-offset-1" href="/user/policy" target="_blank">Policy</a></p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
