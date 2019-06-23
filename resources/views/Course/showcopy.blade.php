@extends('layouts.app')
@section('header')
  <script type="text/javascript">
     window.course = <?= json_encode($course) ?>
  </script>
@endsection
@section('content')
<course-view  courseId="{{ $course->uuid }}" inline-template>
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
                                      <button type="submit" name="button" class="btn btn-link" @click="deleteCourse">Delete Course</button>

                                    <button type="button" class="btn" @click="showModal">Edit course</button>

                                    <modal v-show="isModalVisible" @close="closeModal" courseId="{{ $course->uuid }}"/>



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
</course-view>
@endsection
