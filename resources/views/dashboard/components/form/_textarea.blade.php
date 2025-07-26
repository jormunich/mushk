<div class="form-group">
    <label for="{{ $name }}">{{ __(m_key_to_label($lable ?? $name)) }}</label>
    @if(isset($editor) && $editor)
        <input type="hidden" id="hidden_{{$id ?? $name}}" name="{{$name}}">
        <div id="toolbar_{{$id ?? $name}}"></div>
        <div id="{{ $id ?? $name }}">
            {!! old($name, $value ?? '') !!}
        </div>
    @else
        <textarea name="{{$name}}" id="{{$name}}" rows="{{$rows ?? 5}}" class="form-control" placeholder="{{__(ucfirst(str_replace('_', ' ', $name)))}}">{{ old($name) ?: $value ?? $model->$name ?? '' }}</textarea>
    @endif
    @error($name)
        <small class="form-text error-text">{{ $message }}</small>
    @enderror
</div>
@if(isset($editor) && $editor)
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/46.0.0/ckeditor5.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/46.0.0/ckeditor5.umd.js"></script>

    <script type="module">
        const {
            ClassicEditor,
            Essentials,
            Bold,
            Italic,
            Font,
            Paragraph
        } = CKEDITOR;

        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                licenseKey: '<YOUR_LICENSE_KEY>', // Create a free account on https://portal.ckeditor.com/checkout?plan=free
                plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
                toolbar: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                ]
            } )
            .then( editor => {
                window.editor = editor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endif
