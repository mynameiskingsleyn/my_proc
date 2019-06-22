@extends('layouts.app')
@section('header')
  <script type="text/javascript">
     window.course = <?= json_encode($course) ?>
  </script>
@endsection
@section('content')

<div class="row">
  <div class="col-2">
  </div>
  <div class="col-8">
    @if(isset($course->uuid))
    <form action="{{ route('course.update',$course->uuid) }}" method="post">
        <div class="form">
              {{csrf_field()}}
              <input type="hidden" name="_method" value="PUT">
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name') ?? $course->name }}" required minlength=
                  "4" >
              </div>
              <div class="form-group">
                  <label for="name">Code</label>
                  <input type="text" name="code" class="form-control" value="{{ old('code') ?? $course->code }}" required minlength=
                  "4" >
              </div>
              <div class="form-group">
                  <label for="name">Code</label>
                  <textarea class="form-control" name="description" rows="8" cols="80">{{ old('description') ?? $course->description }}</textarea>
              </div>
              <div class="form-group">
                <label for="active">Active</label>
                <select class="" name="status">
                  <option value="1" @if($course->status ==1) selected @endif >yes</option>
                  <option value="0" @if($course->status ==0) selected @endif >No</option>
                </select>
              </div>

              <input type="submit" class="btn btn-success" value="Update">
      </div>
    </form>
    @else
      <h4> Item not found or authorization required</h4>
      @endif
  </div>

</div>

@endsection
