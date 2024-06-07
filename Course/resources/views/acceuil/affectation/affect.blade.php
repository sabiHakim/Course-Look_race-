@extends('base.base')
@section('title','acceuil')
@section('content')
    <link href="{{asset('assets/css/select2.min.css')}} " rel="stylesheet">
    <div class="pagetitle">
        <h1>Team</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('accequipe')}}">Home</a></li>
                <li class="breadcrumb-item active">Team</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Sales Card -->
                    <div class="">
                        <div class="card info-card sales-card">
                            <div class="card-body pt-3">
                                <div class="d-flex align-items-center ">
                                    <h5 class="card-title">Team : {{ session('equipe')[0]->nom}}</h5>
                                </div>
                                @if(isset($c))
                                    <form action="{{url('traitAffect')}}" method="get">
                                        @csrf
                                        <input type="hidden" value="{{$etape}}" name="etape">
                                        <label for="team_members">Select Team Members:</label>
                                        <select id="team_members" name="team_members[]" class="form-select" multiple="multiple" aria-label="Select team members">
                                            @foreach($c as $cc)
                                                <option value="{{ $cc->id }}">{{ $cc->nom }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-outline-info mt-3" type="submit">Affecter</button>
                                    </form>
                                @endif
                                @if(session('sup'))
                                    <div class=" text-center alert alert-danger mt-3" >
                                        {{session('sup')}} veuillez choisir seulement {{session('coureur')}} coureur
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
    <script src="{{asset('assets/js/jquery-3.7.1.js')}}"></script>
    <script src="{{asset('assets/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#team_members').select2({
                placeholder: "Select team members"
            });
        });
    </script>
@endsection
