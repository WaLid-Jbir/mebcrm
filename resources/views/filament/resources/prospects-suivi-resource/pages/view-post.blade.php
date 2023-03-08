<x-filament::page>
    <!-- <div class="max-w-full rounded-lg overflow-hidden shadow-sm bg-white mx-auto my-8 px-8 py-8">
        <div class="mb-5 max-w-2xl mx-auto">
            <img class="w-9/12 mb-2" src="{{ Storage::url($record->banner) }}">
            <h1 href="#" class="text-gray-900 font-bold text-3xl mb-2">{{$record->title}}</h1>
            <p class="text-gray-700">{{ $record->content }}</p>
            <div class="text-gray-700 text-xs my-6 flex justify-between">
                <div class="flex items-center">
                    <a href="#"><img class="w-12 h-12 rounded-full mr-2" src="https://tailwindcss.com/img/jonathan.jpg" alt="Avatar of Jonathan Reinink"></a>
                    <div class="text-sm">
                        <a href="#" class="text-gray-900 font-medium leading-none hover:text-indigo-600 transition duration-500 ease-in-out">Jonathan Reinink</a>
                        <p class="text-gray-600 text-xs">Aug 18</p>
                    </div>
                </div>
            </div>
        </div> -->
    <!-- Component Code -->
    <div class="relative shadow-sm bg-white rounded-lg py-8">
        <div class="max-w-3xl mb-10 overflow-hidden flex flex-col mx-auto text-center">
            <!-- <h1 class="max-w-3xl mx-auto font-bold text-3xl inline-block mb-6">
                {{ $record->title }}
            </h1> -->
            <img class="w-full my-4" src="{{ Storage::url($record->banner) }}" alt="Sunset in the mountains">
        </div>
        <div class="max-w-3xl mx-auto">
            <div class="mt-3 lg:rounded-b-none lg:rounded-r flex flex-col justify-between leading-8">
                <div class="my-6">
                    <p class="text-gray-700 text-xl">
                        {!! $record->content !!}
                    </p>
                </div>
                <div class="text-gray-700 text-xs my-6 flex justify-between">
                    <div class="flex items-center">
                        <a><img class="w-12 h-12 rounded-full mr-2" src="https://tailwindcss.com/img/jonathan.jpg" alt="Avatar of Jonathan Reinink"></a>
                        <div class="text-sm">
                            <a class="text-gray-900 font-medium leading-none">Raoul Boucher</a>
                            <p class="text-gray-600 text-xs">{{$record->published_at->format("d-m-Y")}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-filament::page>