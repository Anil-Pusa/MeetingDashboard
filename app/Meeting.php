<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = ['event_name','country','state','city','temperature','weatherDes','name','mobile_number','key_note','meeting_slot','user_id'];
}
