@props(['name'])

@error($name)
    <div class="text-danger text-sm">{{ $message }}</div>
@enderror
