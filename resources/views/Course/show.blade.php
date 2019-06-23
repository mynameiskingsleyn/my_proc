@extends('layouts.app')
@section('header')
  <script type="text/javascript">
     window.course = <?= json_encode($course) ?>
  </script>
@endsection
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(isset($course->name))
                    <course-show >

                    </course-show>
                    @elseif(isset($course->message))
                        <h3> {{ $course->message }} </h3>
                    @else
                        <h3> Item not found </h3>
                    @endif
                      <flash message="{{ session('flash') }}"></flash>
              </div>
            </div>
          </div>
      </div>
  </div>
@endsection
