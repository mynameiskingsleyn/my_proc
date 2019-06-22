<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class TestController extends Controller
{
    protected $helper;
    public function __construct()
    {
        $this->helper = new Helper();
    }
    public function tPoint()
    {
        $url = 'http://my_proc.test/login';
        $data = ['email'=>'king@yahoo.com','password'=>'password'];
        $method = 'post';
        $result = $this->helper->sendRequest($method, $url, $data);
    }
}
