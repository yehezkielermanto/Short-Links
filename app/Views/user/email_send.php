<?= $this->extend('/template/header') ?>

<?= $this->section('content') ?>

<!-- email validation send successfully -->

<div class="relative w-screen h-screen">
    <div class="absolute w-full top-[15%] overflow-hidden">
        <div class="mx-[4%] bg-green-300 flex flex-col text-center rounded-lg p-4 drop-shadow-lg">
            <i class="fa-solid fa-circle-check text-[40px]"></i>
            <p class="my-[10px] text-[18px]">verification your account here ... </p>
            <div class="my-[20px]">
                <?= $temp; ?>
            </div>
            <!-- <p class="my-[10px] mx-[20px] p-2 bg-yellow-300 rounded-lg drop-shadow-lg">
            </p> -->
            <a href="/" class="text-blue-600 underline mt-2">back to login</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>