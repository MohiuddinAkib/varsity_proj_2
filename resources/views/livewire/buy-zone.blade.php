<div>
    @forelse($cows as $cow)
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="ml-4 text-lg leading-7 font-semibold"><a href="#" class="underline text-gray-900 dark:text-white">Farm:{{ $cow->farm->name }}</a></div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            <ul class="list-none">
                                <li class="">Cow weight: {{ $cow->weight }} kg</li>
                                <li class="">Contact number: {{ $cow->farm->contact_number }}</li>
                            </ul>

                    </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse
            {{$cows->links()}}
</div>
