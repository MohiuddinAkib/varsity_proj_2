<div>
    <h3 class="text-lg font-bold mb-5">Veterinary near your farm</h3>

    <div wire:offline>
        You are now offline.
    </div>

    @if($is_loading)
    Loading...
    @endif

    {!! Form::open(["wire:submit.prevent" => "fetchNearByVeterinaries"]) !!}
    {!! Form::label("Radius (in Km)") !!}
    {!! Form::number("radius", null, ["wire:model" => "radius", "min" => 1]) !!}

    {!! Form::submit("Search", ["wire:offline.attr" => "disabled"]) !!}
    {!! Form::close() !!}
</div>
