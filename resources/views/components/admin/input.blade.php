<div
    class="position-relative flex-column input-group-outline my-3 mb-4 @if (isset($name) && old($name, $value ?? '') != '') is-filled @endif">
    <label class="form-label">{!! $labelName !!}</label>

    <input {{ $attributesParam }} class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"
        @if (isset($name)) name="{{ $name }}" value="{{ old($name, $value ?? '') }}" @endif>
    {{ $slot }}
</div>

@if (isset($name) && $errors->has($name))
    <div class="d-inline-flex p-0 text-primary text-gradient text-sm mb-3">{{ $errors->first($name) }}</div>
@endif
