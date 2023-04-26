<?= $this->extend('template/header')?>

<?= $this->section('content')?>
    <!-- form register -->
    <div class="mx-[20%] my-[10%]">
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
            <p class="font-bold text-[20px] text-center mb-[40px]">Register New User</p>
            <form action="/user/register/store" method="post">
                <?php csrf_token(); ?>
                <div class="flex flex-col justify-center">
                    <div class="mb-4">
                        <div class="flex xl:flex-row lg:flex-row md:flex-row sm:flex-col xs:flex-col 2xs: flex-col justify-center items-center">
                            <label for="email" class="mx-4 block w-[80px]">Email</label>
                            <input type="text" name="email" id="email"
                                class="border border-slate-300 rounded-lg w-[auto] p-1" value="<?= old('email') ?>">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="flex xl:flex-row lg:flex-row md:flex-row sm:flex-col xs:flex-col 2xs: flex-col items-center justify-center">
                            <label for="password" class="mx-4 block w-[80px]">Password</label>
                            <div class="flex flex-row items-center">
                                <input type="password" name="password" id="password"
                                    class="border border-slate-300 rounded-l-lg p-1" value="<?= old('password') ?>">
                                <i class="fa-solid fa-eye p-2 bg-white rounded-r-lg cursor-pointer"
                                    id="show_password"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="flex xl:flex-row lg:flex-row md:flex-row sm:flex-col xs:flex-col 2xs: flex-col items-center justify-center">
                            <label for="re_password" class="mx-4 block w-[80px]">Re-type Password</label>
                            <div class="flex flex-row items-center">
                                <input type="password" name="re_password" id="re_password"
                                    class="border border-slate-300 rounded-l-lg p-1" value="<?= old('re_password') ?>">
                                <i class="fa-solid fa-eye p-2 bg-white rounded-r-lg cursor-pointer"
                                    id="show_password1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row justify-center items-center">
                        <button type="submit" class="bg-blue-300 p-2 w-[150px] rounded-lg">Register</button>
                    </div>
                    <a href="/" class="text-center mt-1 underline text-[14px] text-blue-500">Login Here</a>
                </div>
            </form>
        </div>
    </div>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <!-- custom script -->
    <script type="text/javascript">
        $('#show_password').on('click', function() {
            let password = document.getElementById('password')

            if (password.type === 'password') {
                password.type = 'text'
            } else {
                password.type = 'password'
            }
        })

        $('#show_password1').on('click', function() {
            let re_password = document.getElementById('re_password')
            if (re_password.type === 'password') {
                re_password.type = 'text'
            } else {
                re_password.type = 'password'
            }
        })
    </script>
<?= $this->endSection()?>