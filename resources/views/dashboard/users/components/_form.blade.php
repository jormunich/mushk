<div class="card-body">
    <div class="row">
        <div class="col-lg-6">
            @include('dashboard.components.form._text', ['name' => 'name'])
            @include('dashboard.components.form._text', ['name' => 'email', 'type' => 'email'])
        </div>
        <div class="col-lg-6">
            @include('dashboard.components.form._select', ['name' => 'role', 'options' => $roles])
        </div>
    </div>
</div>
