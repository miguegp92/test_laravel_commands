<?php

namespace App\Console\Commands;

use App\Job;
use Illuminate\Console\Command;

class ImportJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'import-jobs:csv';
   

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import jobs from csv file';

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
		$file = "import/jobs.csv";
		
		if(file_exists($file)){
			$file = fopen($file, 'r');
			$jobs = 0;
			while($data = fgetcsv($file)){
				
				$this->import($data, $jobs);
			}
			fclose($file);
			rename("import/jobs.csv", 'import/imported/jobs.csv');
			$this->info("\n ".$jobs." Jobs has been imported");

		}else{
			$this->error("\n jobs.csv is not available in import folder. Please check the file or copy on imput folder to continue.");
		}
    }
	public function import($data, &$jobs){
		$job = new Job;
		$job->candidate_id = $data[1];
		$job->title = $data[2];
		$job->company = $data[3];
		$job->start_date = $this->convertFormatDateToSql($data[4]);
		$job->end_date = $this->convertFormatDateToSql($data[5]);
		
		if($job->save()){
			$this->info("\n {$job->title} {$job->company} has been imported correctly.");
			$jobs++;
		}else{
			$this->error("\n {$job->title} #id {$data[0]} for candidate {$job->candidate_id} has not saved. Please fix errors and try again");
		}
	}
	
	public function convertFormatDateToSql($date){
		
		$date = str_replace('.','-',$date);
		$date = date("Y-m-d H:i:s", strtotime($date));
		
		return $date;
	}
}
