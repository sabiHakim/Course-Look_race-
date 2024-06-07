@extends('base_login.base_log')
@section('title','login')
{{--@section('title')--}}
{{--    Login--}}
{{--@endsection--}}
<style>
    .carda {
        opacity: 0.7; /* Ajustez la valeur ici pour la transparence désirée */
    }
</style>
@section('content')
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4 ">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="card mb-3  ">
                        <div class="card-body">
                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="d-flex align-items-center w-auto">
                                    <img  class="rounded"  src="{{asset('assets/img/log.png')}}" alt="" style="width: 150px; height: 150px">
                                    {{--                            <span class="d-none d-lg-block">##</span>--}}
                                </a>
                            </div><!-- End Logo -->
                            <div class="pt-4 pb-2 ">
                                <h5 class="card-title text-center pb-0 fs-4">Marathon</h5>
                                <p class="text-center small">Enter your username & password to login</p>
                            </div>
                                    <form class="row g-3 needs-validation"  action="{{ url('traitLoginEquipe') }} "method="post">
                                        @csrf
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">  <i class="bi bi-person"></i></span>
                                                <input type="text" name="name" class="form-control" id="yourUsername" required>
                                            </div>
                                        </div>
                                        @error('name')
                                        <div class=" mt-2 alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="col-12">
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"> <i class="bi bi-unlock"> </i> </span>
                                                <input type="password" name="mdp" class="form-control" id="yourUsername" required>
                                            </div>
                                        </div>
                                        @error('mdp')
                                        <div class=" mt-2 alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="col-12">
                                            <button class="btn btn-outline-dark w-100" type="submit">Login</button>
                                        </div>
                                        @if(session('inconito'))
                                            <div class=" text-center mt-2 alert alert-danger">{{ session('inconito') }}</div>
                                        @endif
                                        @if(session('error'))
                                            <div class=" text-center mt-2 alert alert-danger">{{ session('error') }}</div>
                                        @endif

                                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
