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
    protected $signature = 'import:csv_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'With this command, you can import candidates.csv and jobs.csv files from import folder, and then show a candidate list with their respective jobs sorted by the most recent ones';

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
		//Callind command import-candidates to import the candidates.csv file
		$this->call('import-candidates:csv');
		//Callind command import-jobs to import the jobs.csv file
		$this->call('import-jobs:csv');
		
		//Get Candidates and jobs data
		$collect = $this->list_jobs();
		
		if($collect){
			$this->info("\n######### LISTING CANDIDATES AND JOBS #########");
			//List candidates
			foreach($collect as $row){
				//Show candidates info
				$this->info("\n {$row['name']} {$row['surname']}, {$row['email']}");
				//List jobs info for candidate
				foreach($row['jobs'] as $job){
					$this->info("\n - {$job->title} in {$job->company} from {$job->start_date} to {$job->end_date} ");
				}
			}
		}else{
			$this->error("ERROR. DB has no data to list. Please put data from a csv file in the 'import' folder and try again.");
		}
		
		
    }
	/**
		List all candidates with their respective jobs
	*/
	public function list_jobs(){
			
			$collection = [];
			//Get all candidates
			$candidates = Candidate::all();
			
			//Set a collection info for every candidate and their jobs
			foreach($candidates as $candidate){
				$collection[] = [
					'name' => $candidate->name,
					'surname' => $candidate->surname,
					'email' => $candidate->email,
					'jobs' => Job::list_candidate_jobs($candidate->id)
				];
			}
			if(count($candidates) > 0){
				return $collection;
			}else{
				return false;
			}
			
			
	}
}
