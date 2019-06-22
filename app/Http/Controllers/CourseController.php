<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Helpers\Helper;
use App\Course;
use Session;
use Auth;

class CourseController extends Controller
{
    private $helper;
    private $user;
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }
    //
    public function index()
    {
        $url = 'http://my_proc.test/api/course';
        //dd('here');
        //dd('we are here onn index controller');
        $this->user = Auth::user();
        $data = [];
        if ($this->user) {
            $data['api_token']=$this->user->api_token;
        }
        //dd($data);
        $method = 'get';

        $courses = $this->helper->sendRequest($method, $url, $data);

        //dd($courses);
        return view('Course.index', compact('courses'));
    }

    public function show($bid)
    {
        $uuid = $bid;
        $url = 'http://my_proc.test/api/course/show';
        $method = 'get';
        $data =['uuid'=>$uuid];
        $course_error=null;
        $this->user = Auth::user();
        if ($this->user) {
            $data['api_token']=$this->user->api_token;
        }
        $course = $this->helper->sendRequest($method, $url, $data);

        //dd($course->error);
        if ($course) {
            return view('Course.show', compact('course'));
        }

        return redirect()->back();
    }

    public function create()
    {
        return view('Course.create');
    }
    public function edit($bid)
    {
        $uuid = $bid;
        $url = 'http://my_proc.test/api/course/show';
        $method = 'get';
        $data =['uuid'=>$uuid];
        $this->user = Auth::user();
        if ($this->user) {
            $data['api_token']=$this->user->api_token;
        }
        //dd($bid);
        $course = $this->helper->sendRequest($method, $url, $data);
        //dd($course);
        if ($course) {
            return view('Course.edit', compact('course'));
        }

        return redirect()->back();
    }

    public function store(Request $request)
    {
        //dd($request->input());
        $this->user = Auth::user();
        if ($this->user) {
            $data['api_token']=$this->user->api_token;
        }
        foreach ($request->input() as $key=>$value) {
            $data[$key]=$value;
        }
        $method='put';
        $url = 'http://my_proc.test/api/course/save';
        $course = $this->helper->sendRequest($method, $url, $data);
        //dd($course);
        if (isset($course->name)) {
            Session::flash('success', 'Course saved');
        }
        return redirect()->route('course.home');
        //dd($course);
    }

    public function update(Request $request, $bid)
    {
        //dd($bid);
        $data = ['uuid'=>$bid];
        $this->user = Auth::user();
        if ($this->user) {
            $data['api_token']=$this->user->api_token;
        }
        foreach ($request->input() as $key=>$value) {
            $data[$key]=$value;
        }
        //dd($data);
        $method='put';
        $url = 'http://my_proc.test/api/course/update';
        $course = $this->helper->sendRequest($method, $url, $data);
        if (isset($course->name)) {
            Session::flash('success', 'Course is updated');
        }
        //dd($course);
        return redirect()->back()->withInput();
    }
    public function delete($uuid)
    {
        $data = ['uuid'=>$uuid];
        $method = 'delete';
        $url = 'http://my_proc.test/api/course/delete';
        $course = $this->helper->sendRequest($method, $url, $data);
        return redirect()->route('course.home');
    }
}
