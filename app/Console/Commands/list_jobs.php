<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class list_jobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list_jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List Jobs per candidate order by recently first';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
		$jobs = $this->list_jobs();
		
		//$this->info( print_r($jobs[0]) );
		
		foreach($jobs as $row){
			$this->info("\n\n\n {$row->name} {$row->surname} {$row->email} {$row->title} {$row->start_date} to {$row->end_date}");
		}
		
		//$this->info( $this->list_jobs() );
    }
	
	public function list_jobs(){
			$candidates = DB::table('candidates')
            ->join('jobs', 'candidates.id', '=', 'jobs.candidate_id')
            ->select('candidates.*', 'jobs.title', 'jobs.company', 'jobs.start_date', 'jobs.end_date')
			//->where('candidates.id', 1)
			->orderBy('candidates.id', 'asc')
			->orderBy('jobs.start_date', 'desc')
            ->get()->toArray();
			
			return $candidates;
	}
}
