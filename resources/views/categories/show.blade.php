<x-guest-layout>
    <section class="mt-8 bg-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($category->menus as $menu)
                <div class="max-w-xs mx-auto mb-2 rounded-lg shadow-lg">
                    <img class="w-full h-48 rounded" src="{{ Storage::url($menu->image) }}" alt="Image" />
                    <div class="px-6 py-4">
                        <h4 class="mb-3 text-xl font-semibold tracking-tight text-green-600 uppercase">{{ $menu->name }}</h4>
                        <p class="leading-normal text-gray-700">{{ $menu->description }}</p>
                    </div>
                    <div class="flex items-center justify-between p-4">
                        <span class="text-xl text-green-600">{{ $menu->price }} FDJ</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-guest-layout>
