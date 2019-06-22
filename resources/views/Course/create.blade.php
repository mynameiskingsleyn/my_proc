@extends('layouts.app')
@section('header')

@endsection
@section('content')

<div class="row">
  <div class="col-2">
  </div>
  <div class="col-8">
    <form action="{{ route('course.save') }}" method="post">
        <div class="form">
              {{csrf_field()}}
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name') ?? 'enter name' }}" required minlength=
                  "4" >
              </div>
              <div class="form-group">
                  <label for="name">Code</label>
                  <input type="text" name="code" class="form-control" value="{{ old('code') ?? 'enter code' }}" required minlength=
                  "4" >
              </div>
              <div class="form-group">
                  <label for="name">Description</label>
                  <textarea class="form-control" name="description" rows="8" cols="80">{{ old('description') ?? 'Enter Description' }}</textarea>
              </div>
              <div class="form-group">
                <label for="status">Active</label>
                <select class="" name="status">
                  <option value="1" {{ old('status')==1 ? 'selected':''}}>yes</option>
                  <option value="0" {{ old('status')==0 ? 'selected':''}}>No</option>
                </select>
              </div>
              @if(Auth::user())
                <input type="hidden" name="api_token" value="{{ Auth::user()->api_token }}">
                @else
                <div class="form-group">
                    <label for="name">Api token</label>
                    <input type="text" class="form-control" name="api_token" value="{{ old('api_token')}}">
                </div>
              @endif

              <input type="submit" class="btn btn-success" value="Save">

      </div>
    </form>
  </div>

</div>

@endsection
