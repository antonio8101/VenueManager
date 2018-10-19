<?php

namespace App\Console\Commands;

use App\GlobalConsts;
use App\Models\RoleModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class InstallApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will run all the necessary steps to install the db';

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
	public function handle() {

		$adminRole = GlobalConsts::__ADMIN_ROLE__;

		$this->comment( "Installing application..." );

		#$this->confirm("This process will destroy the existing DB: do you want to proceed?", false);

		Artisan::call( 'migrate:refresh', [
			'--force' => true,
		] );

		$this->warn( "Database Installed" );

		Artisan::call( 'db:seed' );

		$this->info( "Creating the Application Admin" );

		$this->warn( "Please Ask the Following Question" );

		$email     = $this->askDataToInstallerClient( 'Give Email' );
		$password  = $this->askDataToInstallerClient( 'Give Password' );
		$name      = $this->askDataToInstallerClient( 'Give FirstName' );
		$lastName  = $this->askDataToInstallerClient( 'Give LastName' );
		$birthDate = Carbon::create( 1970, 01, 01 );
		$roleId    = RoleModel::where( 'name', $adminRole )->first()->id;

		DB::table( 'users' )->insert( [
			'firstName'         => $name,
			'lastName'          => $lastName,
			'birth_date'        => $birthDate,
			'email'             => $email,
			'role_id'           => $roleId,
			'password'          => $password,
			'password_to_reset' => true
		] );

		$this->info( "Application installed successfully" );

		return;
	}

	/**
	 * @param string $question
	 *
	 * @return string
	 */
	protected function askDataToInstallerClient( string $question ): string {

		$answer = $this->ask( $question );

		if ( is_null( $answer ) ) {

			$this->error( "Please provide the required information" );

			$this->askDataToInstallerClient( $question );
		}

		return $answer;

	}
}
