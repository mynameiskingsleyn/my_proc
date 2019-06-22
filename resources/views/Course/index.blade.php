@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Courses</h3></div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if(is_array($courses))
                          @include('Course.list')
                        @else
                          <p>{{ $course->error?? 'nothing to display, token required' }} </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>

@endsection
