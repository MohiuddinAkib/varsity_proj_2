@props(["status", "message"])

@php
    $container_classes = "p-4 block rounded-md";
    $text_classes = "font-bold";

    switch ($status) {
        case "success": {
            $container_classes .= " bg-green-100";
            $text_classes .= " text-green-600";
            break;
        }

        case "error": {
            $container_classes .= " bg-red-100";
            $text_classes .= " text-green-600";
            break;
        }

        default: {
            $container_classes .= "";
            $text_classes .= "";
            break;
        }
    }
@endphp

<div class="{{ $container_classes }}">
    <h3 class="{{ $text_classes }}">
        {{ $message }}
    </h3>
</div>
