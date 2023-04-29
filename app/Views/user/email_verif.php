<?= $this->extend('/template/header') ?>

<?= $this->section('content') ?>

<div class="relative w-screen h-screen overflow-hidden">
    <div class="absolute w-full top-[15%]">
        <div class="mx-[4%] <?= $alert; ?> flex flex-col text-center rounded-lg p-4 drop-shadow-lg">
            <p class="my-[10px] text-[18px]">
                <?= $state; ?>
            </p>
            <a href="/" class="text-blue-600 underline mt-2">back to login</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>