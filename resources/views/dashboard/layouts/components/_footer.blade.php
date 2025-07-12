<footer class="footer">
    <div class="container-fluid d-flex justify-content-between">
        <nav class="pull-left">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home')}}">
                        {{config('app.name')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> {{__('Help')}} </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> {{__('Licenses')}} </a>
                </li>
            </ul>
        </nav>
        <div class="copyright">
            {{date('Y')}}, {{__('made with')}} <i class="fa fa-heart heart text-danger"></i> {{__('by')}}
            <a href="https://munich.ventures" target="_blank">{{__('Munich Ventures')}}</a>
        </div>
        <div>
            {{__('Distributed by')}}
            <a target="_blank" href="https://munich.ventures">{{__('Munich Ventures')}}</a>.
        </div>
    </div>
</footer>
