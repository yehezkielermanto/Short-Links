<?= $this->extend('template/header')?>

<?= $this->section('content')?>
    <!-- form register -->
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
                        <button type="submit" class="bg-blue-300 p-2 w-[150px] rounded-lg text-center" id="btn_regis">Register</button>
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

        $('#btn_regis').on('click', function(){
            $('#btn_regis').html('<svg aria-hidden="true" class="w-full h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>')
        })
    </script>
<?= $this->endSection()?>