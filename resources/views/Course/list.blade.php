@forelse($courses as $course)
    <article>
      <div class="level">
        <div class="flex">
          <a href="{{ $course->path }}">
               <strong> <h3> {{ $course->name }}</h3>  </strong>
           </a>
        </div>

     </div>
      <div class="panel">
        <div class="panel-body">
          <div class="body">{{ $course->description }}</div>
          <a href="{{ $course->path }}" class="btn btn-primary">View Course</a>
        </div>
      </div>


    </article>
        <hr>
@empty
  <p>There are no Books available now</p>
@endforelse
