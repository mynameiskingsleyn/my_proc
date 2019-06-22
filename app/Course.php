<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $table="courses";
    protected $primaryKey = 'uuid';
    public $fillable =['name','description','code','status'];
    public $incrementing = false;
    protected $appends=['path','isActive'];


    use Traits\Uuids;

    public function path()
    {
        //return "/threads/{$this->channel->slug}/{$this->id}";
        //('/threads/'.$this->channel->slug.'/'.$this->id);
        return '/course/'.$this->uuid;
    }

    public function getPathAttribute()
    {
        return $this->path();
    }

    public function getIsActiveAttribute()
    {
        return $this->status==1;
    }
}
