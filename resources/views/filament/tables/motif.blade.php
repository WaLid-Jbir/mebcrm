<form wire:submit.prevent="livewireSubmitMethodHere">
    <x-filament::modal width="4xl" class="whitespace-normal">
        <x-slot name="trigger">
            <?php
                if(!empty($getState())):
                    ?>
                        <button type="button" class="bg-primary-500 text-white text-sm px-2 py-1 rounded" x-on:click="isOpen = true">
                            Voir motif
                        </button>
                    <?php else: echo 'aucun'?>
                <?php endif ?>
        </x-slot>
        
        <x-filament::modal.heading>
            Motif
        </x-filament::modal.heading>

        <x-filament::hr></x-filament::hr>

        <div class="text-md">
            <?= $getState() ?>
        </div>

    </x-filament::modal>
</form>