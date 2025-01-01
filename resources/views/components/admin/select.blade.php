<div class="input-group-outline my-3 @if (isset($name) && old($name, $value ?? '') != '') is-filled @endif">
    <label class="form-label">{{ $labelName }}</label>
    <select class="form-control" name="{{ $name }}" aria-label="Default select example" {{ $attributesParam }}>
        <option selected>{{ $defaultOption }}</option>
        {{ $slot }}
    </select>
</div>
@if (isset($name) && $errors->has($name))
    <div class="d-inline-flex p-0 text-primary text-gradient text-sm mb-3">{{ $errors->first($name) }}</div>
@endif
