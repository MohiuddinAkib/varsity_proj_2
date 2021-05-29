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
{{--                            https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=mongolian%20grill&inputtype=textquery&fields=photos,formatted_address,name,opening_hours,rating&locationbias=circle:2000@47.6918452,-122.2226413&key=YOUR_API_KEY--}}
{{--                            https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=-33.8670522,151.1957362&radius=1500&type=restaurant&keyword=cruise&key=YOUR_API_KEY--}}
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>No cows for sale</p>
    @endforelse
            {{ $cows->links() }}
</div>
