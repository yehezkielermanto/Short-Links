<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/styles/output.css">
    <title>Admin</title>
</head>
<body class="bg-white">
    <!-- form login -->
    <div class="mx-[20%] my-[10%]">
        <div class="p-4 bg-slate-200 drop-shadow-md rounded-xl">
            <p class="font-bold text-[20px] text-center mb-[40px]">Shorten URL</p>
            <form action="/admin/login/auth" method="post">
                <?php csrf_token(); ?>
                <div class="flex flex-col justify-center">
                    <div class="mb-4">
                        <div class="flex flex-row justify-center items-center">
                            <label for="email" class="mx-4 block w-[80px]">Email</label>
                            <input type="text" name="email" id="email" class="border border-slate-300 rounded-lg">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="flex flex-row items-center justify-center">
                            <label for="password" class="mx-4 block w-[80px]">Password</label>
                            <input type="password" name="password" id="password" class="border border-slate-300 rounded-lg">
                        </div>
                    </div>
                    <div class="flex flex-row justify-center items-center">
                        <button type="submit" class="bg-green-300 p-2 w-[150px] rounded-lg">Login</button>
                    </div>
                    <a href="/admin/register" class="text-center mt-1 underline text-[14px] text-blue-500">Register New User</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>