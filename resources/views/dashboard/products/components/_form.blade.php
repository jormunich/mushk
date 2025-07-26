<div class="card-body">
    <div class="row">
        <div class="col-lg-6">
            @include('dashboard.components.form._text', ['name' => 'name'])
            @include('dashboard.components.form._text', ['name' => 'price', 'type' => 'number'])
            @include('dashboard.components.form._text', ['name' => 'old_price', 'type' => 'number'])
            @include('dashboard.components.form._text', ['name' => 'review_count', 'type' => 'number'])
            @include('dashboard.components.form._text', ['name' => 'review', 'type' => 'number'])
            @include('dashboard.components.form._checkbox', ['name' => 'is_popular', 'type' => 'number', 'value' => 1])
        </div>
        <div class="col-lg-6">
            @include('dashboard.components.form._file', ['name' => 'image', 'model' => $product ?? null])
        </div>
        <div class="col-lg-12">
            @include('dashboard.components.form._textarea', ['name' => 'description'])
        </div>
    </div>
</div>
