<?php

namespace App\Http\Controllers\CourseApi;

use App\Http\Controllers\Controller;
use App\Course;
use Illuminate\Http\Request;
use DB;
use Log;
use Illuminate\Support\Facades\Validator;

class CourseApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('course.api')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $selected = 'All';
        if ($request->has('selected')) {
            $selected = $request->get('selected');
        }
        DB::enableQueryLog();
        if ($selected =='active') {
            $courses = Course::where('status', '=', 1)->get();
        } elseif ($selected == 'noneactive') {
            $courses = Course::where('status', '=', 0)->get();
        } else {
            $courses = Course::All();
        }
        Log::info(DB::getQueryLog());
        //dd($selected);

        return response()->json($courses, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //return response()->json($request->input());
        $rules = [
                'name'=>'required|max:20',
                'code'=>'required|max:20',
                'status'=>'required',
                'description'=>'required|min:10'
                ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error'=>'bad request'], 400);
        }
        $data =[
          'name'=>$request->input('name'),
          'code'=>$request->input('code'),
          'status'=>(int)$request->input('status'),
          'description'=>$request->input('description'),
        ];
        //DB::enableQueryLog();
        $course = Course::create($data);
        //  Log::info(DB::getQueryLog());
        return response()->json($course, 201);
    }

    public function show(Request $request)
    {
        //
        $uuid = $request->get('uuid');

        $course = Course::find($uuid);
        if (!$course) {
            return response()->json(['error'=>'resource not found'], 404);
        }
        return response()->json($course, 200);
    }

    public function update(Request $request)
    {
        $rules = [
                'name'=>'required|max:20',
                'code'=>'required|max:20',
                'status'=>'required',
                'description'=>'required|min:10'
                ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error'=>'bad request'], 400);
        }
        $uuid = $request->input('uuid');
        $course = Course::find($uuid);
        $data =[
        'name'=>$request->input('name'),
        'code'=>$request->input('code'),
        'status'=>(int)$request->input('status'),
        'dectription'=>$request->input('description'),
        ];

        //return response($data);
        if ($course) {
            $course->update($data);
        }

        return response()->json($course, 200);
    }

    public function destroy(Request $request)
    {
        $uuid = $request->get('uuid');
        $course = Course::find($uuid);
        // return response()->json($course);
        if ($course instanceof Course) {
            $course->delete();
        }
        //return response()->json(['not'=>'instance']);
        return response()->json(['success'=>'deleted course'], 204);
    }
}
