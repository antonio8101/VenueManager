<?php

namespace App\Console\Commands;

use App\Facades\LoginTableFactory;
use App\Facades\UserFactory;
use App\GlobalConsts;
use App\Models\LoginTable;
use App\Models\Role;
use App\Models\RoleModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

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

		$this->confirm("This process will destroy the existing DB: do you want to proceed?", false);

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
		$role      = Role::find( RoleModel::where( 'name', $adminRole )->first()->id );

		$user      = UserFactory::get( $name, $lastName, $password, $email, $birthDate, $role );
		$userId    = User::create( $user );
		$user->id  = $userId;

		$loginTable = LoginTableFactory::get( $user );

		LoginTable::create( $loginTable, 0 );

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
