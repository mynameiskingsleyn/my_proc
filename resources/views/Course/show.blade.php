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
                            <article>
                                <h4>{{ $course->name }}</h4>
                                <!-- check update capability -->

                                <!-- end can -->
                                <div class="body">{{ $course->description }}</div>
                                <div class="">

                                  <form class="" action="{{ route('course.delete',$course->uuid)}}" method="post">
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                      <button type="submit" name="button" class="btn btn-link">Delete Course</button>
                                  </form>

                                  <a href="{{ route('course.edit', $course->uuid)}} " class="btn btn-primary">Edit Course</a>

                                </div>
                            </article>
                            @else($course_err)
                              <h3> Nothing to display at this time </h3>
                            @endif

                    </div>

                </div>
                 @if(auth()->check())
                 @else
                 @endif
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>

@endsection
