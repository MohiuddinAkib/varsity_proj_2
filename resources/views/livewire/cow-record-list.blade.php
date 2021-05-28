<div>
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="font-semibold uppercase text-2xl">{{ $page_title }}</h2>
        </div>

        <div>
            @role("localadmin")
                <a
                    href="{{ route("cow.create") }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Create New</a>
            @endrole
        </div>
    </div>

    <livewire:cow-record-table/>
</div>
