<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
	public $timestamps = false;
	
	/**
		List all jobs of a candidate
	*/
	static function list_candidate_jobs($candidate)
    {
			
		return Job::where('candidate_id', $candidate)->orderBy('start_date', 'desc')->get();
        //return $this->belongsTo('App\Candidate');
       
    }
	
}
