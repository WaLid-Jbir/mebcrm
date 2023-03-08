<x-filament::page>
    <!-- Component Code -->
    <div class="relative shadow-sm bg-white rounded-lg py-8">
        <div class="max-w-3xl mb-10 overflow-hidden flex flex-col mx-auto text-center">
            <img class="w-full my-4" src="{{ Storage::url($record->banner) }}" alt="Sunset in the mountains">
        </div>
        <div class="max-w-3xl mx-auto">
            <div class="mt-3 lg:rounded-b-none lg:rounded-r flex flex-col justify-between leading-8">
                <div class="my-6">
                    <p class="text-gray-700 text-xl">
                        {!!html_entity_decode($record->content)!!}
                    </p>
                </div>
                <!-- <div class="text-gray-700 text-xs my-6 flex justify-between">
                    <div class="flex items-center">
                        <a><img class="w-12 h-12 rounded-full mr-2" src="https://tailwindcss.com/img/jonathan.jpg" alt="Avatar of Jonathan Reinink"></a>
                        <div class="text-sm">
                            <a class="text-gray-900 font-medium leading-none">Raoul Boucher</a>
                            <p class="text-gray-600 text-xs"></p>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</x-filament::page>