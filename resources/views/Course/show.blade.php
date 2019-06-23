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
                          <label><strong>Status</strong></label>-->
                          @if($course->isActive)
                          Active
                          @else
                          Not Active
                          @endif
                          <course-show @updated="refresh">

                          </course-show>
                      </article>
                      @else($course_err)
                        <h3> Nothing to display at this time </h3>
                      @endif
              </div>
            </div>
          </div>
      </div>
  </div>
@endsection
<script>
  function refresh(){
    alert('refreshing now');
  }
</script>
