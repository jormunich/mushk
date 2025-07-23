<div class="form-group">
    <label for="{{ $name }}">{{ __(m_key_to_label($lable ?? $name)) }}</label>
    <input type="{{ $type ?? 'text' }}"
           class="form-control" id="{{ $name }}"
           name="{{ $name }}"
           value="{{ old($name) ?: $value ?? $model->$name ?? '' }}"
           placeholder="{{ __(m_key_to_label($placeholder ?? $name)) }}">
    @error($name)
        <small class="form-text error-text">{{ $message }}</small>
    @enderror
</div>
