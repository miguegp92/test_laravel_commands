<?php

namespace App\Console\Commands;

use App\Candidate;
use App\Job;
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
		
		//$this->info( print_r($jobs) );
		
		foreach($jobs as $row){
			$this->info("\n\n\n {$row['name']} {$row['surname']}, {$row['email']}");
			foreach($row['jobs'] as $job){
				$this->info("\n - {$job->title} in {$job->company} from {$job->start_date} to {$job->end_date} ");
			}
		}
		
		//$this->info( $this->list_jobs() );
    }
	/**
		List all candidates with their respective jobs
	*/
	public function list_jobs(){
			
			$collection = [];
			$candidates = Candidate::all();
			
			foreach($candidates as $candidate){
				$collection[] = [
					'name' => $candidate->name,
					'surname' => $candidate->surname,
					'email' => $candidate->email,
					'jobs' => Job::list_candidate_jobs($candidate->id)
				];
			}
			return $collection;
			
	}
}
