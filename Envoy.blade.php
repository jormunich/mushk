@servers(['localhost' => '127.0.0.1'])
@setup
    $root = '/var/www/app';
    $storage_dir = $root . '/storage';
    $framework_dir = $storage_dir . '/framework';
    $cache_dir = $framework_dir . '/cache';
    $views_dir = $framework_dir . '/views';
    $sessions_dir = $framework_dir . '/sessions';
@endsetup

@story('live')
    storage
    writable
    composer
    migrate
    storage_link
@endstory

@story('dev')
    storage
    writable
    composer
    migrate
    seed
    storage_link
@endstory

@story('staging')
    storage
    writable
    composer
    migrate
    storage_link
    npm
@endstory

@task('storage')
    echo 'create storage link to {{ $storage_dir }} ...'
    [ -d {{ $storage_dir }} ] || mkdir {{ $storage_dir }}
    cd {{ $root }}
    mkdir {{ $framework_dir }}
    mkdir {{ $cache_dir }}
    mkdir {{ $views_dir }}
    mkdir {{ $sessions_dir }}
    chmod -R 777 {{ $storage_dir }}
@endtask

@task('writable')
    echo 'make bootstrap and lang folders writable ...'
    cd {{ $root }}
    chmod -R 777 bootstrap/
@endtask

@task('composer')
    echo "install composer dependencies ..."
    cd {{ $root }}
    composer install --prefer-dist -o
@endtask

@task('migrate')
    echo "migrate database ..."
    cd {{ $root }}
    php artisan migrate
@endtask

@task('seed')
    echo "seed database ..."
    cd {{ $root }}
    php artisan db:seed
@endtask

@task('storage_link')
    echo "storage link ..."
    cd {{ $root }}
    php artisan storage:link
@endtask


