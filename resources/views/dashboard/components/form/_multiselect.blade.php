<div class="form-group">
    <label for="{{ $name }}">{{ __(m_key_to_label($label ?? $name)) }}</label>
    <select class="form-control select2-multiselect" id="{{ $name }}" name="{{ $name }}[]" multiple="multiple">
        @foreach($options ?? [] as $key => $value)
            <option value="{{ $key }}" 
                @if(isset($model) && $model->categories->pluck('id')->contains($key))
                    selected
                @endif
                @if(old($name) && in_array($key, old($name)))
                    selected
                @endif
            >{{ $value }}</option>
        @endforeach
    </select>
    @error($name)
        <small class="form-text error-text">{{ $message }}</small>
    @enderror
</div>

