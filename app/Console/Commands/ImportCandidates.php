<?php

namespace App\Console\Commands;

use App\Candidate;
use Illuminate\Console\Command;

class ImportCandidates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-candidates:csv';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import candidates from csv file';

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
		$file = "import/candidates.csv";

		if(file_exists($file)){
			$this->info("\n######### IMPORTING CANDIDATES ROWS #########");
			$file = fopen($file, 'r');
			$candidates = 0;
			while($data = fgetcsv($file)){
				
				$this->import($data, $candidates);
			}
			fclose($file);
			rename("import/candidates.csv", 'import/imported/candidates.csv');
			
			$this->info("\n {$candidates} Candidates has ready to import");
		}else{
			$this->error("\n candidates.csv is not available in import folder. Please check the file or copy on imput folder to continue.");
		}
		
    }
	public function import($data, &$candidates){
		$candidate = new Candidate;
		$candidate->name = $data[1];
		$candidate->surname = $data[2];
		$candidate->email = $data[3];
		if($candidate->save()){
			$this->info("\n {$candidate->name} {$candidate->surname} has been imported correctly.");
			$candidates++;
		}else{
			$this->error("\n Candidate with {$candidate->name} {$candidate->surname} has not saved. Please fix errors and try again");
		}
	}
}
