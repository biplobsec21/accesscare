<?php

namespace App\Console\Commands;

use App\RidGroup;
use App\Support\GenerateID;
use App\UserGroup;
use Config;
use DB;
use App\Ability;
use App\Address;
use App\Company;
use App\ConcentrationUnit;
use App\Country;
use App\DenialReason;
use App\Depot;
use App\DEVUPDATESCRIPTTABLE;
use App\DocumentType;
use App\Dosage;
use App\DosageForm;
use App\DosageRoute;
use App\DosageStrength;
use App\DosageUnit;
use App\Drug;
use App\DrugComponent;
use App\DrugDocument;
use App\DrugLot;
use App\DrugUser;
use App\Email;
use App\File as FileModel;
use App\Mailer;
use App\MergeData;
use App\Note;
use App\Notification;
use App\Page;
use App\Pharmacist;
use App\Pharmacy;
use App\Phone;
use App\Resource;
use App\Rid;
use App\RidDocument;
use App\RidRegimen;
use App\RidShipment;
use App\RidStatus;
use App\RidVisitStatus;
use App\RidUser;
use App\RidVisit;
use App\Role;
use App\ShippingCourier;
use App\State;
use App\Traits\GeneratesIDTraits;
use App\Traits\GeneratesStrings;
use App\Traits\Hashable;
use App\User;
use App\UserCertificate;
use App\UserType;
use File;
use Hash;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Propaganistas\LaravelPhone\PhoneNumber;
use Rinvex\Country\CountryLoaderException;
use Storage;
use Illuminate\Http\File as HttpFile;

/**
 * Class DBMigrate
 * @package App\Console\Commands
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DBMigrate extends Command
{
    use GeneratesStrings, Hashable;

    //Command Shortcut: php artisan qis:m

    /**
     * The name and signature of the console command.
     * @var string
     */

    protected $signature = 'qis:migrate 
                         {--y|yes : Pre-confirm all prompts (TO BE IMPLEMENTED)}
                         {--p|no-progress : Do not display any progress bars (TO BE IMPLEMENTED)}
                         {to=mysql : Connection to receive the data} 
                         {from=mysql_src : Connection to send the data}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var boolean Whether the user has pre confirmed with the "-y" flag
     */
    protected $isPreConfirm = false;

    protected $failed;
    /**
     * @var DB The DB we are migrating from
     */
    protected $from;

    /**
     * @var DB The DB we are migrating to
     */
    protected $to;

    /**
     * CreateRequest a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        if (!$this->confirmInProduction()) {
            return false;
        }

        $this->assignArguments();
        $this->clearLocalDB();
        $this->resetStorage();

        $this->info('Database reseting...');
        $this->db_reset();
        $this->info('Database reseting done !');

        $this->info('Retrieving Companies...');
        $this->handleCompanies();
        $this->info('Companies Migrated!');

        $this->info('Retrieving Users...');
        $this->handleUsers();
        $this->info('Users Migrated!');

        $this->info('Retrieving Drug Document Types...');
        $this->handleDrugDocumentType();
        $this->info('Drug Document Types Migrated!');

        $this->info('Retrieving Drugs...');
        $this->handleDrugs();
        $this->info('Drugs Migrated!');

        $this->info('Retrieving Resource Types...');
        $this->handleResourceTypes();
        $this->info('Resource Types Migrated!');

        $this->info('Retrieving Drug Resources...');
        $this->handleDrugResource();
        $this->info('Drug Resources Migrated!');

        $this->info('Retrieving Drug Documents...');
        $this->handleDrugDocument();
        $this->info('Drug Documents Migrated!');

        $this->info('Retrieving Drug Dosages...');
        $this->handleDrugDosage();
        $this->info('Drug Dosages Migrated!');

        $this->info('Retrieving RIDs...');
        $this->handleRID();
        $this->info('RIDs Migrated!');

        $this->info('Retrieving RID Shipments...');
        $this->handleRidShipments();
        $this->info('RID Shipments Migrated!');

        $this->info('Retrieving RID Users...');
        $this->handleRIDUsers();
        $this->info('RID Users Migrated!');

        $this->info('Retrieving Drug Users...');
        $this->handleDrugUsers();
        $this->info('Drug Users Migrated!');

        $this->info('Retrieving Rid Document...');
        $this->handleRidDocuments();
        $this->info('Rid Document Migrated!');

        $this->info('Retrieving RID Notes...');
        $this->handleNotes();
        $this->info('RID Notes Migrated!');

        //$this->info('Retrieving Notifications...');
        //$this->handleNotifications();
        //$this->info('Notifications Migrated!');

//        $this->info('Retrieving User Certificate...');
//        $this->handleUserCertificates();
//        $this->info('User Certificate Migrated!');

//        $this->info('Sync depot merge data');
//        $this->handleDepotMerge();
//        $this->info('Sync depot merge data done !');
//
//        $this->info('Sync pharmacy merge data');
//        $this->handlePharmacyMerge();
//        $this->info('Sync pharmacy merge data done !');
//
//        $this->info('Sync pharmacist merge data');
//        $this->handlePharmacistMerge();
//        $this->info('Sync pharmacist merge data done !');
//
//        $this->info('Sync druglot merge data');
//        $this->handleDrugLotMerge();
//        $this->info('Sync druglot merge data done !');
//
//		$this->info('Physician user with no role id data');
//		$this->handlePhysicianUserWithNoRole();
//		$this->info('Physician user set physician delegate type done !');

        $this->info('Migration successful!');

        if (!empty($failed)) {
            $this->warn('There were errors.');
            Storage::put('failed.txt', json_encode($this->failed));
            $this->warn('The errors are saved in ' . storage_path('failed.txt'));
        }
    }

    public static function newID(string $model = null)
    {
        return GenerateID::run(10);
    }

    public function getNewID($old_id, $old = null, $new = null)
    {
        $devscript = DEVUPDATESCRIPTTABLE::where('id_old', $old_id)->first();
        if ($devscript)
            return $devscript->new_id;

        if ($old == null || $new == null)
            return null;

        $old_value = DB::connection($this->from['name'])->table($old[0])->where($old[0] . '_id', $old_id)->first();
        if ($old_value)
            $old_value = $old_value->{$old[1]};
        else
            return null;

        $new_value = DB::connection($this->to['name'])->table($new[0])->where($new[1], $old_value)->first();
        if ($new_value)
            return $new_value->id;
        else
            return null;
    }

    /**
     * Confirm whether the user wants to commit this command in production
     * @return bool
     */
    public function confirmInProduction(): bool
    {
        if (config('app.env') == 'production') {
            if ($this->isPreConfirm) {
                $this->warn('Running in production with bypass flag.');
            }
            $this->alert("Application In Production!");
            if (!$this->confirm("Do you really wish to run this command?", true)) {
                $this->warn('Exiting...');
                return false;
            }
            return true;
        }
        return true;
    }

    /**
     * Assign class arguments
     */
    public function assignArguments()
    {
        $this->from['name'] = $this->argument('from');
        $this->to['name'] = $this->argument('to');

        //	$this->verifyConnection("mysql -u php -h eac.earlyaccesscare.com -p'qUaSaRs' -P 3306 v2adev_db");
        //	exit;

        $this->verifyConnection($this->from['name']);
        $this->verifyConnection($this->to['name']);

        $this->from['tables'] = $this->describeDatabase($this->from['name']);
        $this->to['tables'] = $this->describeDatabase($this->to['name']);
    }

    public function getFile($file_name, $old_folder, $type)
    {
        $file = new FileModel();
        $file->id = $this::newID(FileModel::class);

        $url = "https://www.earlyaccesscare.com/uploads/" . $old_folder . "/" . $file_name;
        $url = str_replace(' ', '%20', $url);
        $filename = config('eac.storage.name.' . $type) . $file->id . '.pdf';
        $dir = config('eac.storage.file.' . $type);
        $contents = file_get_contents($url);
        Storage::put('public' . $dir . '/' . $filename, $contents);

        $file->name = $filename;
        $file->path = $dir;
        $file->saveOrFail();
        return $file;
    }

    public function db_reset()
    {
        //$tables = DB::connection('mysql')->select('SHOW TABLES');
        $tables = [
            'companies', 'DO_NOT_TOUCH_DEV_UPDATE_SCRIPT_TABLE_DO_NOT_TOUCH',
            'users', 'user_groups', 'user_certifications', 'rid_user_group', 'drug_user_group', 'company_user_group', 'notifications',
            'rids', 'rid_records', 'rid_documents', 'rid_regimens', 'rid_shipments',
            'drug', 'drug_components', 'drug_documents', 'drug_supply', 'dosages', 'resources', 'drug_lots',
            'depots', 'pharmacies', 'pharmacists', 'document_types', 'addresses', 'log', 'rid_not_approved_reasons', 'files',
        ];
        $colname = 'Tables_in_' . env('DB_DATABASE');
        try {
            foreach ($tables as $table) {
                DB::connection('mysql')->table($table)->truncate();
            }
        } catch (\Exception $e) {
            die ($e);
        }
        return true;
    }

    /**
     * Verify the DB connection to the supplied connection
     * @param $connection string
     */
    public function verifyConnection(string $connection)
    {
        try {
            DB::connection($connection)->getPdo();
        } catch (\Exception $e) {
            $this->alert("Could not connect to the database connection '{$connection}'.  Please check your configuration.");
            $this->error($e->getTraceAsString());
        }
    }

    /**
     * Describe the given DB
     * @param $connection
     * @return Collection
     */
    protected function describeDatabase($connection)
    {
        $db = Config::get('database.connections.' . $connection . '.database');
        $tables = DB::connection($connection)->select('SHOW TABLES');
        $combine = "Tables_in_" . $db;
        $collection = new Collection;
        foreach ($tables as $table) {
            $tableName = null;
            foreach ($table as $tableName) {
                if ($this->filterTables($tableName)) {
                    continue 2;
                }
            }

            $columns = \Db::connection($connection)->select(\DB::raw("SHOW COLUMNS FROM {$tableName}"));
            $neatColumns = [];
            $cols = null;
            foreach ($columns as $column) {
                $neatColumns[$column->Field] = ['type' => $this->parseColumnType($column->Type), 'length' => $this->parseColumnLength($column->Type), 'key' => $this->parseColumnKey($column->Key), 'null' => ($column->Null == 'Yes') ? true : false, 'default' => $column->Default,];
            }
            $collection->put($table->$combine, json_decode(json_encode($neatColumns), true));
        }
        return json_decode(json_encode($collection), true);
    }

    /**
     * Determine whether we need to skip the current iteration based on filters
     * @param $tableName string The given table name
     * @return bool
     */
    protected function filterTables(string $tableName): bool
    {
        if (strpos($tableName, '-')) {
            return true;
        }
        return false;
    }

    /**
     * Parse the type for the column
     * @param $columnTypeString
     * @return string Type of the column
     */
    protected function parseColumnType($columnTypeString): string
    {
        return strtolower(explode("(", $columnTypeString)[0]);
    }

    /**
     * Parse the column length
     * @param $columnTypeString
     * @return int|null
     */
    protected function parseColumnLength($columnTypeString)
    {
        switch (strtolower(explode("(", $columnTypeString)[0])) {
            case('int'):
                preg_match('!\d+!', $columnTypeString, $matches)[0];
                return $matches[0];
                break;
            case('varchar'):
                preg_match('!\d+!', $columnTypeString, $matches)[0];
                return $matches[0];
                break;
            case('tinyint'):
                preg_match('!\d+!', $columnTypeString, $matches)[0];
                return $matches[0];
                break;
            case('bigint'):
                preg_match('!\d+!', $columnTypeString, $matches)[0];
                return $matches[0];
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * Parse the column key
     * @param $key
     * @return string|null
     */
    protected function parseColumnKey($key)
    {
        switch (strtolower($key)) {
            case('mul'):
                return 'index';
                break;
            case('uni'):
                return 'unique';
                break;
            case('pri'):
                return 'primary';
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * Reset the DB
     */
    public function clearLocalDB()
    {
        $this->warn("Rolling back target database...");
        $this->callSilent("migrate:reset");

        $this->warn("Deleting database backups...");
        File::delete(File::glob(config('app.backup_dir', base_path('/storage/framework/maint_mode_db_backup')) . '/*.saved_db'));
        $this->warn("Migrating target database...");
        //$this->callSilent('migrate');
    }

    protected function resetStorage()
    {
        Storage::deleteDirectory('public/drug');
        Storage::deleteDirectory('public/user');
        Storage::deleteDirectory('public/rid');
    }

    public function handleCountries()
    {
        $countries = DB::connection($this->from['name'])->table('country')->orderBy('country_name')->get();

        $bar = $this->output->createProgressBar(count($countries));
        $bar->setBarWidth(2000);

        $bar->start();

        $index = 1;

        $failed = [];

        foreach ($countries as $country) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $__IDLOGGER->table_name = 'country';
            $__IDLOGGER->id_old = $country->country_id;
            $countryModel = new Country();
            $countryModel->id = $__IDLOGGER->id_new = $this::newID(Country::class);
            $countryModel->name = trim($country->country_name);

            try {
                $countryModel->abbr = country($country->country_abbr)->getIsoAlpha2();
            } catch (CountryLoaderException $countryLoaderException) {
                $failed[count($failed)] = $country;
                $__IDLOGGER->did_fail = true;
                $countryModel->abbr = $country->country_abbr;
            }
            $countryModel->haa_info = $country->country_haa_info;
            $countryModel->haa_prereq = $country->country_haa_prereq;
            $countryModel->ethics_req = (!is_null($country->country_ethics_req)) ? $country->country_ethics_req : 0;
            $countryModel->notes = $country->country_notes;
            $countryModel->active = $country->country_active;
            $countryModel->index = $index++;
            $countryModel->created_at = $country->country_added;
            $countryModel->updated_at = $country->country_updated;

            $countryModel->saveOrFail();
            $__IDLOGGER->saveOrFail();
            $bar->advance();
        }
        $bar->finish();

        $this->failed['country'] = $failed;
    }

    protected function handleStates()
    {
        $states = DB::connection($this->from['name'])->table('state')->orderBy('state_name');

        $bar = $this->output->createProgressBar(count($states));
        $bar->setBarWidth(2000);
        $bar->start();
        $index = 1;
        foreach ($states as $state) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $__IDLOGGER->table_name = 'states';
            $__IDLOGGER->id_old = $state->state_id;
            $stateModel = new State();
            $stateModel->id = $__IDLOGGER->id_new = $this::newID(State::class);
            $stateModel->country_id = Country::where('id', '=', (DEVUPDATESCRIPTTABLE::where(['id_old' => $state->country_id, 'table_name' => 'country'])->firstOrFail())->id_new)->firstOrFail()->id;

            $stateModel->name = $state->state_name;
            $stateModel->abbr = $state->state_abbr;
            $stateModel->active = $state->state_active;
            $stateModel->index = $index++;
            $stateModel->created_at = $state->state_added;
            $stateModel->updated_at = $state->state_updated;
            $stateModel->saveOrFail();
            $__IDLOGGER->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handlePages()
    {
        $oldTable = 'page';
        $pages = DB::connection($this->from['name'])->table($oldTable);

        $bar = $this->output->createProgressBar(count($pages));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($pages as $page) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $page->page_id;
            $pageModel = new Page();

            if (strtolower($page->page_title) == 'test') continue;

            $pageModel->id = $__IDLOGGER->id_new = $this::newID(Page::class);
            $pageModel->name = explode('.', strtolower($page->page_name))[0];
            $pageModel->title = $page->page_title;
            $pageModel->content = $page->page_body;
            $pageModel->meta_desc = $page->page_mdesc;
            $pageModel->meta_keywords = $page->page_mdesc;
            $pageModel->active = 1;
            $pageModel->created_at = $page->page_added;
            $pageModel->updated_at = $page->page_updated;
            $pageModel->saveOrFail();
            $__IDLOGGER->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    /**
     * Migrate the companies table
     * Depends on country and state
     */
    protected function handleCompanies()
    {
        $companies = DB::connection($this->from['name'])->table('company')->get();
        $bar = $this->output->createProgressBar(count($companies));
        $bar->setBarWidth(2000);
        $bar->start();
        $index = 1;

        foreach ($companies as $company) {
            $desc = DB::connection($this->from['name'])->table('company_content')->where('company_id', '=', $company->company_id)->first();
            if (!is_null($desc)) {
                $description = $desc->company_content_desc;
            } else {
                $description = " ";
            }

            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $companyModel = new Company();
            $companyID = $this::newID(Company::class);

            if (!is_null($company->company_phone_main)) {
                $companyMainPhone = trim($company->company_phone_main);

                try {
                    $preCompanyPhoneMainQuery = Phone::where('number', '=', $companyMainPhone)->firstOrFail();
                    $companyModel->phone_main = $preCompanyPhoneMainQuery->id;
                } catch (ModelNotFoundException $modelNotFoundException) {
                    $companyPhoneMain = new Phone();
                    $companyPhoneMain->id = $companyModel->phone_main = $this::newID(Phone::class);
                    // $companyPhoneMain->company_id = $companyID;
                    $companyPhoneMain->country_id = $this->getNewID($company->country_id, ['country', 'country_name'], ['countries', 'name']);
                    $companyPhoneMain->number = $companyMainPhone;
                    $companyPhoneMain->is_primary = 1;
                    $companyPhoneMain->created_at = null;
                    $companyPhoneMain->updated_at = null;
                    $companyPhoneMain->saveOrFail();
                }
            }

            /**
             * Company Address
             */
            if (is_null($company->company_addr_1) && $company->company_addr_1 == 'TBD' || $company->company_addr_1 == 'unknown') {
                $companyModel->address_id = null;
            } else {
                try {
                    $userAddr = Address::where(['addr1' => $company->company_addr_1, 'city' => $company->company_city])->firstOrFail();
                    $companyModel->address_id = $userAddr->id;
                } catch (ModelNotFoundException $modelNotFoundException) {
                    $companyAddress = new Address();
                    $companyModel->address_id = $companyAddress->id = $this::newID(Address::class);
                    $companyAddress->addr1 = $company->company_addr_1;
                    $companyAddress->addr2 = $company->company_addr_2 ?? null;
                    $companyAddress->city = $company->company_city;
                    if (strlen($company->company_state) == 2) {
                        $companyAddress->state_province = State::where('abbr', '=', $company->company_state)->firstOrFail()->id;
                    } elseif ($company->company_state) {
                        $companyAddress->state_province = $this->getNewID($company->company_state, ['state', 'state_name'], ['states', 'name']);;
                    }
                    $companyAddress->country_id = $this->getNewID($company->country_id, ['country', 'country_name'], ['countries', 'name']);
                    $companyAddress->zipcode = $company->company_zip;
                    $companyAddress->created_at = null;
                    $companyAddress->updated_at = null;
                    if ($companyAddress->addr1 != null && $companyAddress->addr1 != 'TBD') {
                        $companyAddress->saveOrFail();
                    }
                }
            }

            $__IDLOGGER->table_name = 'company';
            $__IDLOGGER->id_old = $company->company_id;
            $companyModel->id = $__IDLOGGER->id_new = $companyID;
            $companyModel->country_id = $this->getNewID($company->country_id, ['country', 'country_name'], ['countries', 'name']);;
            $companyModel->name = $company->company_name;
            $companyModel->abbr = $company->company_abbr;
            $companyModel->desc = $description;//$description; //$description;substr($description, 0, 100);
            $companyModel->site = $company->company_website;
            $companyModel->active = $company->company_active;
            // $companyModel->phone_main = $company->company_phone_main ? $company->company_phone_main : ' ' ;
            $companyModel->email_main = $company->company_email_main ? $company->company_email_main : ' ';
            $companyModel->created_at = $company->company_added;
            $companyModel->updated_at = $company->company_updated;

            $companyModel->status = $company->company_active == 1 ? 'Approved' : 'Pending';

            $companyModel->saveOrFail();
            $__IDLOGGER->saveOrFail();
            $bar->advance();
        }

        $bar->finish();
    }

    /**
     * Migrate log table
     */
    protected function handleUsers()
    {
        $users = $this->fetchAndNormalizeUsers();
        $bar = $this->output->createProgressBar(count($users) + 1);
        $bar->setBarWidth(2000);
        $bar->start();
        $index = 1;

        foreach (json_decode(json_encode($users)) as $user) {
            $userModel = new User();
            $USERID = $this::newID(User::class);
            switch (strtolower($user->type)) {
                case 'phy':
                    $__IDLOGGER__PHY = new DEVUPDATESCRIPTTABLE();
                    $__IDLOGGER__PHY->table_name = 'physician_user';
                    $__IDLOGGER__PHY->id_old = $user->id;
                    $__IDLOGGER__PHY->id_new = $USERID;
                    $userModel->type_id = UserType::where('name', 'Physician')->first()->id;
                    $__IDLOGGER__PHY->saveOrFail();
                    break;
                case 'com':
                    $__IDLOGGER__COM = new DEVUPDATESCRIPTTABLE();
                    $__IDLOGGER__COM->table_name = 'company_user';
                    $__IDLOGGER__COM->id_old = $user->id;
                    $__IDLOGGER__COM->id_new = $USERID;
                    $userModel->type_id = UserType::where('name', 'Pharmaceutical')->first()->id;
                    $__IDLOGGER__COM->saveOrFail();
                    break;
                case 'eac':
                    $__IDLOGGER__EAC = new DEVUPDATESCRIPTTABLE();
                    $__IDLOGGER__EAC->table_name = 'eac_user';
                    $__IDLOGGER__EAC->id_old = $user->id;
                    $__IDLOGGER__EAC->id_new = $USERID;
                    $userModel->type_id = UserType::where('name', 'Early Access Care')->first()->id;
                    $__IDLOGGER__EAC->saveOrFail();
                    break;
            }

            $userModel->id = $USERID;
            $userModel->status = $user->status;

            if (!is_null($user->phone)) {
                try {
                    $userPhone = Phone::where('number', '=', $user->phone->number)->firstOrFail();
                    $userModel->phone_id = $userPhone->id;
                } catch (ModelNotFoundException $modelNotFoundException) {
                    $phoneModel = new Phone();
                    $phoneModel->id = $userModel->phone_id = $this::newID(Phone::class);
                    // $phoneModel->user_id = $USERID;
                    $phoneModel->country_id = $user->phone->country->id ?? null;
                    $phoneModel->number = $user->phone->number;
                    $phoneModel->is_primary = $user->phone->primary;
                    $phoneModel->created_at = null;
                    $phoneModel->updated_at = null;

                    $phoneModel->saveOrFail();
                }
            }

            if (is_null($user->address->addr1) && $user->address->addr1 == 'TBD' || $user->address->addr1 == 'unknown') {
                $userModel->address_id = null;
            } else {
                try {
                    $userAddr = Address::where('addr1', '=', $user->address->addr1)->firstOrFail();
                    $userModel->address_id = $userAddr->id;
                } catch (ModelNotFoundException $modelNotFoundException) {
                    $addressModel = new Address();
                    $addressModel->id = $userModel->address_id = $this::newID(Address::class);
                    $addressModel->addr1 = $user->address->addr1 ?? null;
                    $addressModel->addr2 = $user->address->addr2 ?? null;
                    $addressModel->city = $user->address->city ?? null;
                    $addressModel->state_province = $user->address->state ?? null;

                    $addressModel->created_at = null;
                    $addressModel->updated_at = null;
                    $addressModel->country_id = $user->address->country ?? null;
                    $addressModel->zipcode = $user->address->zipcode ?? null;
                    $addressModel->created_at = null;
                    $addressModel->updated_at = null;
                    if ($addressModel->addr1 != null && $addressModel->addr1 != 'TBD') {
                        $addressModel->saveOrFail();
                    }
                }
            }

            if ($user->is_company) {
                if (!$user->company_id) {
                    continue;
                }
                $userModel->company_id = $this->getNewID($user->company_id, ['company', 'company_name'], ['companies', 'name']);
            }

            if (!($user->first_name)) continue;
            $userModel->first_name = $user->first_name;
            $userModel->last_name = $user->last_name;
            $userModel->email = $user->email;
            $userModel->password = $user->password;
            $userModel->created_at = $user->created_at;
            $userModel->updated_at = $user->updated_at;

            $userModel->saveOrFail();
            $bar->advance();
        }

        $userModel = new User();
        $userModel->id = $this::newID(User::class);
        $userModel->first_name = 'Andrew';
        $userModel->last_name = 'Mellor';
        $userModel->status = 'Approved';
        $userModel->type_id = UserType::where('name', 'Early Access Care')->first()->id;
        $userModel->email = 'andrew@quasars.com';
        $userModel->password = '$2y$10$r0D/F9JFVKj9.KsgGUG1qunuQMaGZA7RMpSFYr1rYz/9hagp.b1WS';
        $userModel->is_developer = 1;
        $userModel->saveOrFail();

        $userModel = new User();
        $userModel->id = $this::newID(User::class);
        $userModel->first_name = 'Developer';
        $userModel->last_name = 'Account';
        $userModel->status = 'Approved';
        $userModel->type_id = UserType::where('name', 'Early Access Care')->first()->id;
        $userModel->email = 'developer@quasars.com';
        $userModel->password = '$2y$10$sM2eRN8/fTQybkvvicVEWeNtCkENGZl5kGNF/i06fww2zsH46oSC6';
        $userModel->is_developer = 1;
        $userModel->saveOrFail();

        $bar->advance();
        $bar->finish();
    }

    /*
     * Fetch and normalize a user array
     * @return array
     */
    protected function fetchAndNormalizeUsers()
    {
        $eacUser = DB::connection($this->from['name'])->table('eac_user')->get();
        $physicianUser = DB::connection($this->from['name'])->table('physician_user')->get();
        $companyUser = DB::connection($this->from['name'])->table('company_user')->get();

        $normalized = [];
        foreach ($eacUser as $user) {
            $normalized[count($normalized)] = ['id' => $user->eac_user_id, 'type' => 'eac', 'title' => null, 'first_name' => trim($user->eac_user_fname), 'last_name' => trim($user->eac_user_lname), 'phone' => $this->normalizePhone($user->eac_user_phone), 'email' => strtolower($user->eac_user_email), 'role' => $user->eac_user_role_id, 'address' => ['addr1' => $user->eac_user_addr_1, 'addr2' => $user->eac_user_addr_2, 'city' => $user->eac_user_city,
                'state' => $this->getNewID($user->eac_user_state, ['state', 'state_name'], ['states', 'name']), 'zipcode' => $user->eac_user_zip, 'country' => null,], 'is_company' => 0, 'status' => 'Approved', 'is_active' => ($user->eac_user_active == 1) ? 1 : 0, 'created_at' => $user->eac_user_added, 'updated_at' => $user->eac_user_updated,
                'password' => $user->eac_user_password];
        }

        foreach ($physicianUser as $user) {
            $normalized[count($normalized)] = ['id' => $user->physician_user_id, 'type' => 'phy', 'parent_id' => $user->physician_user_title, 'title' => $user->physician_user_title, 'first_name' => trim($user->physician_user_fname), 'last_name' => trim($user->physician_user_lname), 'phone' => $this->normalizePhone($user->physician_user_phone), 'email' => strtolower($user->physician_user_email), 'role' => $user->physician_user_type_id, 'address' => ['addr1' => $user->physician_user_addr_1, 'addr2' => $user->physician_user_addr_2, 'city' => $user->physician_user_city,
                'state' => $this->getNewID($user->physician_user_state, ['state', 'state_name'], ['states', 'name']), 'zipcode' => $user->physician_user_zip,
                'country' => $this->getNewID($user->physician_user_country, ['country', 'country_name'], ['countries', 'name']),], 'is_company' => 0, 'status' => $user->physician_user_status, 'is_active' => $user->physician_user_active, 'created_at' => $user->physician_user_added, 'updated_at' => $user->physician_user_updated,
                'password' => $user->physician_user_password];
        }

        foreach ($companyUser as $user) {
            $normalized[count($normalized)] = ['id' => $user->company_user_id, 'type' => 'com', 'title' => $user->company_user_title, 'first_name' => trim($user->company_user_fname), 'last_name' => trim($user->company_user_lname), 'phone' => $this->normalizePhone($user->company_user_phone), 'email' => strtolower($user->company_user_email), 'role' => $user->company_user_type_id, 'address' => ['addr1' => $user->company_user_addr_1, 'addr2' => $user->company_user_addr_2, 'city' => $user->company_user_city,
                'state' => $this->getNewID($user->company_user_state, ['state', 'state_name'], ['states', 'name']), 'zipcode' => $user->company_user_zip,
                'country' => $this->getNewID($user->company_user_country, ['country', 'country_name'], ['countries', 'name']),], 'is_company' => 1, 'company_id' => $user->company_id, 'status' => 'Approved', 'is_active' => $user->company_user_active, 'created_at' => $user->company_user_added, 'updated_at' => $user->company_user_updated,
                'password' => $user->company_user_password];
        }
        return $normalized;
    }

    /**
     * Normalize phone numbers
     * @param $phone
     * @return mixed
     * @throws \Throwable
     */
    protected function normalizePhone($phone)
    {
        return ['number' => trim($phone), 'primary' => 1, 'country' => Country::where('abbr', 'US')->firstOrFail()->id];
        if ($this->validatePhone($phone) == true) {
            $parsedNumber = PhoneNumberUtil::getInstance()->parse(str_replace('-', '', $phone), "US");

            $country = PhoneNumber::make($phone, 'US')->getCountry();

            return ['country' => Country::where('abbr', '=', $country)->firstOrFail()->id, 'number' => PhoneNumberUtil::getInstance()->format($parsedNumber, PhoneNumberFormat::E164), 'primary' => 1,];
        } else {
            return null;
        }
    }

    protected function validatePhone($phone): bool
    {
        $libPhone = PhoneNumberUtil::getInstance();
        try {
            $phoneNum = $libPhone->parse($phone, "US");
            if ($libPhone->isPossibleNumber($phoneNum) && $libPhone->isValidNumber($phoneNum)) {
                return true;
            }
            return false;
        } catch (NumberParseException $e) {
            if ($phone == null) {
                return false;
            }
            return false;
        }
    }

    /**
     * Migrate the `email` table
     */
    protected function handleMailers()
    {
        $oldTable = 'email';
        $mailers = DB::connection($this->from['name'])->table($oldTable);

        $bar = $this->output->createProgressBar(count($mailers));
        $bar->setBarWidth(2000);

        $bar->start();
        foreach ($mailers as $mailer) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $mailerModel = new Mailer();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $mailer->email_id;

            $mailerModel->id = $__IDLOGGER->id_new = $this::newID(Mailer::class);
            $mailerModel->name = $mailer->email_name;
            $mailerModel->subject = $mailer->email_subject;
            $mailerModel->from_email = $mailer->email_from;
            $mailerModel->from_name = $mailer->email_from_label;
            $mailerModel->reply_to = $mailer->email_reply_to;
            $mailerModel->cc = $mailer->email_cc;
            $mailerModel->bcc = $mailer->email_bcc;
            $mailerModel->html = $mailer->email_html;
            $mailerModel->alt_text = $mailer->email_text;
            $mailerModel->created_at = $mailer->email_added;
            $mailerModel->updated_at = $mailer->email_updated;

            $__IDLOGGER->saveOrFail();
            $mailerModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleShippingCourier()
    {
        $oldTable = 'shipping_courier';
        $shippingCouriers = DB::connection($this->from['name'])->table($oldTable);

        $bar = $this->output->createProgressBar(count($shippingCouriers));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($shippingCouriers as $shippingCourier) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $shippingCourierModel = new ShippingCourier();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $shippingCourier->shipping_courier_id;

            $shippingCourierModel->id = $__IDLOGGER->id_new = $this::newID(ShippingCourier::class);
            $shippingCourierModel->name = $shippingCourier->shipping_courier_name;
            $shippingCourierModel->active = 1;
            $shippingCourierModel->created_at = $shippingCourier->shipping_courier_added;
            $shippingCourierModel->updated_at = $shippingCourier->shipping_courier_updated;

            $__IDLOGGER->saveOrFail();
            $shippingCourierModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleDosageUnit()
    {
        $oldTable = 'dosage_unit';
        $dosageUnits = DB::connection($this->from['name'])->table($oldTable);

        $bar = $this->output->createProgressBar(count($dosageUnits));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($dosageUnits as $dosageUnit) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $dosageUnitModel = new DosageUnit();

            $__IDLOGGER->table_name = $oldTable;

            $__IDLOGGER->id_old = $dosageUnit->dosage_unit_id;

            $dosageUnitModel->id = $__IDLOGGER->id_new = $this::newID(DosageUnit::class);
            $dosageUnitModel->name = $dosageUnit->dosage_unit_name;
            $dosageUnitModel->active = $dosageUnit->dosage_unit_active;
            $dosageUnitModel->created_at = $dosageUnit->dosage_unit_added;
            $dosageUnitModel->updated_at = $dosageUnit->dosage_unit_updated;

            $__IDLOGGER->saveOrFail();
            $dosageUnitModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleConcentrationUnit()
    {
        $oldTable = 'concentration_unit';
        $concentrationUnits = DB::connection($this->from['name'])->table($oldTable);

        $bar = $this->output->createProgressBar(count($concentrationUnits));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($concentrationUnits as $concentrationUnit) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $concentrationUnitModel = new ConcentrationUnit();

            $__IDLOGGER->table_name = $oldTable;

            $__IDLOGGER->id_old = $concentrationUnit->concentration_unit_id;

            $concentrationUnitModel->id = $__IDLOGGER->id_new = $this::newID(DosageUnit::class);
            $concentrationUnitModel->name = $concentrationUnit->concentration_unit_name;
            $concentrationUnitModel->active = $concentrationUnit->concentration_unit_active;
            $concentrationUnitModel->created_at = $concentrationUnit->concentration_unit_added;
            $concentrationUnitModel->updated_at = $concentrationUnit->concentration_unit_updated;

            $__IDLOGGER->saveOrFail();
            $concentrationUnitModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    public function handleDrugDocumentType()
    {
        $oldTable = 'drug_doc_type';
        $drugDocumentTypes = DB::connection($this->from['name'])->table($oldTable)->get();
        $bar = $this->output->createProgressBar($drugDocumentTypes->count());
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($drugDocumentTypes as $drugDocumentType) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $drugDocumentTypeModel = new DocumentType();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $drugDocumentType->drug_doc_type_id;

            $drugDocumentTypeModel->id = $__IDLOGGER->id_new = $this::newID(DocumentType::class);
            $drugDocumentTypeModel->created_at = $drugDocumentType->drug_doc_type_added;
            $drugDocumentTypeModel->updated_at = $drugDocumentType->drug_doc_type_updated;

            $drugDocumentTypeModel->is_resource = false;
            $drugDocumentTypeModel->is_document = true;
            $drugDocumentTypeModel->active = true;
            $drugDocumentTypeModel->name = trim($drugDocumentType->drug_doc_type_name);
            $drugDocumentTypeModel->saveOrFail();

            $__IDLOGGER->saveOrFail();

            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleDrugs()
    {
        $oldTable = 'drug';
        $drugs = DB::connection($this->from['name'])->table($oldTable)->get();
        // dd($drugs);
        $bar = $this->output->createProgressBar(count($drugs));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($drugs as $drug) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $drugModel = new Drug();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $drug->drug_id;

            $drugModel->id = $__IDLOGGER->id_new = $this::newID(Drug::class);
            $drugModel->company_id = Company::where('id', DEVUPDATESCRIPTTABLE::where(['table_name' => 'company', 'id_old' => $drug->company_id])->firstOrFail()->id_new)->firstOrFail()->id;
            $drugModel->added_by = User::where('id', DEVUPDATESCRIPTTABLE::where(['table_name' => 'eac_user', 'id_old' => $drug->drug_added_by_eac_user_id])->firstOrFail()->id_new)->firstOrFail()->id;
            $drugModel->approved_by = User::where('id', DEVUPDATESCRIPTTABLE::where(['table_name' => 'eac_user', 'id_old' => $drug->drug_approved_by_eac_user_id])->firstOrFail()->id_new)->firstOrFail()->id;;
            $drugModel->name = $drug->drug_name;
            $drugModel->lab_name = $drug->drug_lab_name;
            $drugModel->pre_approval_req = $drug->drug_pre_approval_req;
            $drugModel->logo = $drug->drug_logo;
            $drugModel->short_desc = $drug->drug_desc_short;
            $drugModel->desc = $drug->drug_desc_long;

            $arr = [];
            $count = 0;
            foreach (Country::all() as $country) {
                if ($count > 5) continue;
                $arr[count($arr)] = $country->id;
                $count++;
            }

            $drugModel->countries_available = json_encode($arr);
            $drugModel->active = 1;
            $drugModel->created_at = $drug->drug_added;
            $drugModel->updated_at = $drug->drug_updated;
            $drugModel->status = $drug->drug_status;

            $__IDLOGGER->saveOrFail();
            $drugModel->saveOrFail();

            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $drugComponentModel = new DrugComponent();

            $__IDLOGGER->table_name = 'drug_component';
            $__IDLOGGER->id_old = $drug->drug_id;

            $drugComponentModel->id = $__IDLOGGER->id_new = $this::newID(DrugComponent::class);
            $drugComponentModel->name = 'Component 1';
            $drugComponentModel->drug_id = $drugModel->id;
            $drugComponentModel->desc = $drug->drug_desc_long;
            $drugComponentModel->index = 1;

            $drugComponentModel->saveOrFail();
            $__IDLOGGER->saveOrFail();

            $bar->advance();
        }
        $bar->finish();
    }

    public function handleResourceTypes()
    {
        $oldTable = 'drug_res_type';
        $resourceTypes = DB::connection($this->from['name'])->table($oldTable)->get();
        // dd($resourceTypes);
        $bar = $this->output->createProgressBar(count($resourceTypes));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($resourceTypes as $resourceType) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $resourceTypeModel = new DocumentType();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $resourceType->drug_res_type_id;

            $resourceTypeModel->id = $__IDLOGGER->id_new = $this::newID(DocumentType::class);
            $resourceTypeModel->name = trim($resourceType->drug_res_type_name);
            $resourceTypeModel->is_resource = true;
            $resourceTypeModel->is_document = false;
            $resourceTypeModel->active = true;
            $resourceTypeModel->created_at = $resourceType->drug_res_type_added;
            $resourceTypeModel->updated_at = $resourceType->drug_res_type_updated;

            $foundNotFound = DocumentType::where('name', '=', $resourceType->drug_res_type_name)->first();
            if (empty($foundNotFound) && !isset($foundNotFound->name)) {
                $resourceTypeModel->saveOrFail();
            } else {
                $__IDLOGGER->id_new = $foundNotFound->id;
            }
            $__IDLOGGER->saveOrFail();

            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleDrugResource()
    {
        $oldTable = 'drug_res';
        $drugResources = DB::connection($this->from['name'])->table($oldTable)->get();
        // dd($drugResources);
        $bar = $this->output->createProgressBar(count($drugResources));
        $bar->setBarWidth(2000);
        $bar->start();

        foreach ($drugResources as $drugResource) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $resourceModel = new Resource();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $drugResource->drug_res_id;

            if (!$drugResource->drug_res_file)
                continue;

            $file = $this->getFile($drugResource->drug_res_file, 'drug_res', 'drug.resource');

            $resourceModel->id = $__IDLOGGER->id_new = $this::newID(Resource::class);
            $resourceModel->file_id = $file->id;

            $resourceModel->drug_id = $this->getNewID($drugResource->drug_id);
            $resourceModel->type_id = $this->getNewID($drugResource->drug_res_type_id);
            $resourceModel->name = $drugResource->drug_res_file_title;

            $resourceModel->public = $drugResource->drug_res_public;
            $resourceModel->active = $drugResource->drug_res_active;
            $resourceModel->created_at = $drugResource->drug_res_added;
            $resourceModel->updated_at = $drugResource->drug_res_updated;

            $__IDLOGGER->saveOrFail();
            $resourceModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleAdministrationRoutes()
    {
        $oldTable = 'route_admin';
        $administrationRoutes = DB::connection($this->from['name'])->table($oldTable)->get();
        // dd($administrationRoutes);
        $bar = $this->output->createProgressBar(count($administrationRoutes));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($administrationRoutes as $administrationRoute) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $administrationRouteModel = new DosageRoute();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $administrationRoute->route_admin_id;

            $administrationRouteModel->id = $__IDLOGGER->id_new = $this::newID(DosageRoute::class);
            $administrationRouteModel->name = $administrationRoute->route_admin_name;

            $administrationRouteModel->created_at = $administrationRoute->route_admin_added;
            $administrationRouteModel->updated_at = $administrationRoute->route_admin_updated;

            $foundNotFound = DosageRoute::where('name', '=', $administrationRoute->route_admin_name)->first();
            if (is_null($foundNotFound)) {
                $__IDLOGGER->saveOrFail();
                $administrationRouteModel->saveOrFail();
            }

            // $__IDLOGGER->saveOrFail();
            // $administrationRouteModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    public function handleDosageStrength()
    {
        $oldTable = 'formulation_strength';
        $dosageStrengths = DB::connection($this->from['name'])->table($oldTable);

        $bar = $this->output->createProgressBar(count($dosageStrengths));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($dosageStrengths as $dosageStrength) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $dosageStrengthModel = new DosageStrength();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $dosageStrength->formulation_strength_id;

            $dosageStrengthModel->id = $__IDLOGGER->id_new = $this::newID(DosageStrength::class);
            $dosageStrengthModel->name = $dosageStrength->formulation_strength_name;
            $dosageStrengthModel->active = $dosageStrength->formulation_strength_active;
            $dosageStrengthModel->created_at = $dosageStrength->formulation_strength_added;
            $dosageStrengthModel->updated_at = $dosageStrength->formulation_strength_updated;

            $__IDLOGGER->saveOrFail();
            $dosageStrengthModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleDosageForm()
    {
        $oldTable = 'dosage_form';
        $dosageForms = DB::connection($this->from['name'])->table($oldTable);
        // dd($dosageForms);
        $bar = $this->output->createProgressBar(count($dosageForms));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($dosageForms as $dosageForm) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $dosageFormModel = new DosageForm();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $dosageForm->dosage_form_id;

            $dosageFormModel->id = $__IDLOGGER->id_new = $this::newID(DosageForm::class);
            $dosageFormModel->route_id = DosageRoute::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'route_admin', 'id_old' => $dosageForm->route_admin_id])->firstOrFail()->id_new)->firstOrFail()->id;
            $dosageFormModel->name = $dosageForm->dosage_form_name;
            $dosageFormModel->active = $dosageForm->dosage_form_active;
            $dosageFormModel->concentration_req = $dosageForm->dosage_form_concentration_req;
            $dosageFormModel->created_at = $dosageForm->dosage_form_added;
            $dosageFormModel->updated_at = $dosageForm->dosage_form_updated;

            $__IDLOGGER->saveOrFail();
            $dosageFormModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleDrugDocument()
    {
        $oldTable = 'drug_doc';
        $drugDocuments = DB::connection($this->from['name'])->table($oldTable)->get();
        // dd($drugDocuments);
        $bar = $this->output->createProgressBar(count($drugDocuments));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($drugDocuments as $drugDocument) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $drugDocumentModel = new DrugDocument();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $drugDocument->drug_doc_id;

            $drugDocumentModel->id = $__IDLOGGER->id_new = $this::newID(DrugDocument::class);
            try {
                $drugDocumentModel->drug_id = DEVUPDATESCRIPTTABLE::where(['table_name' => 'drug', 'id_old' => $drugDocument->drug_id])->firstOrFail()->id_new;
            } catch (ModelNotFoundException $modelNotFoundException) {
                $this->info($drugDocument->drug_id);
                continue;
            }

            try {
                $drugDocumentModel->type_id = DEVUPDATESCRIPTTABLE::where(['table_name' => 'drug_doc_type', 'id_old' => $drugDocument->drug_doc_type_id])->firstOrFail()->id_new;
            } catch (\Exception $e) {
                $drugDocumentModel->type_id = null;
            }

            $drugDocumentModel->desc = $drugDocument->drug_doc_desc;
            $drugDocumentModel->created_at = $drugDocument->drug_doc_added;
            $drugDocumentModel->updated_at = $drugDocument->drug_doc_updated;

            $drugDocumentModel->is_required = $drugDocument->drug_doc_req;
            $drugDocumentModel->is_required_resupply = $drugDocument->drug_doc_req_rs;

            if (!is_null($drugDocument->drug_doc_file)) {
                $file = $this->getFile($drugDocument->drug_doc_file, 'drug_doc', 'drug.doc');
                $drugDocumentModel->file_id = $file->id;
            }

            $drugDocumentModel->created_at = $drugDocument->drug_doc_added;
            $drugDocumentModel->updated_at = $drugDocument->drug_doc_updated;
            $drugDocumentModel->is_required = $drugDocument->drug_doc_req;
            $drugDocumentModel->is_required_resupply = $drugDocument->drug_doc_req_rs;
            $__IDLOGGER->saveOrFail();
            $drugDocumentModel->saveOrFail();

            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleDrugDosage()
    {
        $oldTable = 'drug_dosage';
        $drugDosages = DB::connection($this->from['name'])->table($oldTable)->get();
        // dd($drugDosages);
        $bar = $this->output->createProgressBar(count($drugDosages));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($drugDosages as $drugDosage) {
            // dd($drugDosage);
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $drugDosageModel = new Dosage();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $drugDosage->drug_dosage_id;

            $drugDosageModel->id = $__IDLOGGER->id_new = $this::newID(Dosage::class);
            try {
                $drugDosageModel->component_id = DEVUPDATESCRIPTTABLE::where(['table_name' => 'drug_component', 'id_old' => $drugDosage->drug_id])->firstOrFail()->id_new;
            } catch (ModelNotFoundException $modelNotFoundException) {
                continue;
            }
            $drugDosageModel->form_id = $this->getNewID($drugDosage->dosage_form_id, ['dosage_form', 'dosage_form_name'], ['dosage_forms', 'name']) ?? '';
            $drugDosageModel->strength_id = $this->getNewID($drugDosage->drug_dosage_strength, ['formulation_strength', 'formulation_strength_name'], ['dosage_strength', 'name']);
            $drugDosageModel->amount = $drugDosage->drug_dosage_unit_amount;
            $drugDosageModel->concentration_amount = $drugDosage->drug_dosage_concentration_amount ?? null;
            $drugDosageModel->temperature = $drugDosage->drug_dosage_optimal_temperature;
            $drugDosageModel->active = 1;
            $drugDosageModel->created_at = $drugDosage->drug_dosage_added;
            $drugDosageModel->updated_at = $drugDosage->drug_dosage_updated;
            try {
                $drugDosageModel->unit_id = $this->getNewID($drugDosage->dosage_unit_id, ['dosage_unit', 'dosage_unit_name'], ['dosage_units', 'name']);
            } catch (\Exception $e) {
                $drugDosageModel->unit_id = null;
            }

            $drugLot = new DrugLot();
            $__IDLOGGER_LOT = new DEVUPDATESCRIPTTABLE();
            $drugLot->id = $__IDLOGGER_LOT->id_new = $this::newID(DrugLot::class);
            $__IDLOGGER_LOT->table_name = 'drug_lots';
            $__IDLOGGER_LOT->id_old = substr($drugDosage->drug_dosage_id, 0, 7) . "lot";

            $drugLot->dosage_id = $drugDosageModel->id;
            // $drugLot->depot_id = $drugDosageModel->id;
            $drugLot->number = null;
            $drugLot->stock = $drugDosage->drug_dosage_stock;
            $drugLot->minimum = $drugDosage->drug_dosage_threshold_min;
            $drugLot->created_at = $drugDosage->drug_dosage_added;
            $drugLot->updated_at = $drugDosage->drug_dosage_updated;
            $drugLot->saveOrFail();
            $__IDLOGGER->saveOrFail();
            $__IDLOGGER_LOT->saveOrFail();
            $drugDosageModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleRID()
    {
        $oldTable = 'rid';
        $old_rid_ids = DB::connection($this->from['name'])->table($oldTable)->select('rid_id')->whereNull('parent_id')->get()->pluck('rid_id');

        $old_resupplys = DB::connection($this->from['name'])->table($oldTable)->select('rid_id')->whereNotNull('parent_id')->get()->pluck('rid_id');

        $this->info('Master RIDs...');
        $bar = $this->output->createProgressBar(count($old_rid_ids));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($old_rid_ids as $old_id) {
            $new_id = $this->createRidMaster($old_id);
            $this->createRidVisit($old_id, 1);
            $bar->advance();
        }
        $bar->finish();

        $this->info('RID Records...');
        $bar = $this->output->createProgressBar(count($old_resupplys));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($old_resupplys as $old_resupply) {
            $this->createRidVisit($old_resupply);
            $bar->advance();
        }

        $bar->finish();
    }

    protected function createRidMaster($old_id)
    {
        $oldTable = 'rid';
        $rid = DB::connection($this->from['name'])->table($oldTable)->where('rid_id', $old_id)->first();

        $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
        $__IDLOGGER->table_name = $oldTable;
        $__IDLOGGER->id_old = $rid->rid_id;

        $ridModel = new Rid();
        $ridModel->id = $__IDLOGGER->id_new = $this::newID(Rid::class);
        $ridModel->number = $rid->rid_number;
        $ridModel->physician_id = User::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'physician_user', 'id_old' => $rid->rid_created_by])->firstOrFail()->id_new)->firstOrFail()->id;
        $ridModel->drug_id = Drug::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'drug', 'id_old' => $rid->drug_id])->firstOrFail()->id_new)->firstOrFail()->id;

        // get status and sub status
        $status_substatus = $this->get_rid_status_sub_status($rid->rid_status, $rid->rid_shipment_status);
        $ssData = explode("__", $status_substatus);
        $ridModel->status_id = $ssData[0];
        // $ridModel->sub_status = $ssData[1];

        // get rid details
        $ridModel->patient_gender = ($rid->rid_patient_gender) ? 'male' : 'female';
        $ridModel->patient_dob = $rid->rid_patient_birthday;
        $ridModel->username = $rid->rid_number;
        $ridModel->password = $rid->rid_password;
        $ridModel->reason = $rid->rid_reason;
        $ridModel->proposed_treatment_plan = $rid->rid_proposed_treatment_plan;
        $ridModel->req_date = $rid->rid_request_date;

        // get created at and updated at
        $ridModel->created_at = $rid->rid_added;
        $ridModel->updated_at = $rid->rid_updated;

        $ridModel->saveOrFail();
        $__IDLOGGER->saveOrFail();
        return $ridModel->id;
    }

    protected function createRidVisit($old_id, $isFirst = 0)
    {
        $oldTable = 'rid';
        $rid = DB::connection($this->from['name'])->table($oldTable)->where('rid_id', $old_id)->first();

        $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
        $__IDLOGGER->table_name = 'rid_record';
        $__IDLOGGER->id_old = $rid->rid_id;

        $ridVisitModel = new RidVisit();
        $ridVisitModel->id = $__IDLOGGER->id_new = $this::newID(RidVisit::class);
        if ($isFirst) {
            $ridVisitModel->parent_id = DEVUPDATESCRIPTTABLE::where(['table_name' => 'rid', 'id_old' => $old_id])->firstOrFail()->id_new;
            $ridVisitModel->index = 1;
        } else {
            $ridVisitModel->parent_id = $this->findRidParent($old_id);
            $ridVisitModel->index = RidVisit::where('parent_id', $ridVisitModel->parent_id)->count() + 1;
        }

        // get status and sub status
        $status_substatus = $this->get_rid_status_sub_status($rid->rid_status, $rid->rid_shipment_status);
        $ssData = explode("__", $status_substatus);
        $ridVisitModel->status_id = $ssData[0];
        $ridVisitModel->sub_status = $ssData[1];

        // get physician
        $phId = DEVUPDATESCRIPTTABLE::where(['table_name' => 'physician_user', 'id_old' => $rid->physician_id])->first();
        $ridVisitModel->physician_id = !is_null($phId) ? $phId->id_new : null;

        // get status and sub status
        $status_substatus = $this->get_rid_status_sub_status($rid->rid_status, $rid->rid_shipment_status);
        $ssData = explode("__", $status_substatus);
        $ridVisitModel->status_id = $ridVisitModel->status_id = $ssData[0];
        $ridVisitModel->sub_status = $ridVisitModel->sub_status = $ssData[1];
        $ridVisitModel->visit_date = $rid->rid_delivery_date ?? null;

        // get created at and updated at
        $ridVisitModel->created_at = $rid->rid_added;
        $ridVisitModel->updated_at = $rid->rid_updated;

        $ridVisitModel->saveOrFail();
        $__IDLOGGER->saveOrFail();
    }

    protected function findRidParent($id): string
    {
        $foundParent = false;
        do {
            $currentRid = DB::connection($this->from['name'])->table('rid')->where('rid_id', $id)->first();

            if (is_null($currentRid->parent_id)) {
                return DEVUPDATESCRIPTTABLE::where(['table_name' => 'rid', 'id_old' => $currentRid->rid_id])->firstOrFail()->id_new;
            }

            $id = $currentRid->parent_id;
        } while (!$foundParent);
    }

    protected function get_rid_status_sub_status($param, $shipparam)
    {
        // param == "Hold" -> Fulfillment->Withdrew Consent
        if ($param == "Hold") {
            $rid_status = RidStatus::where('name', '=', "Fulfillment")->first()->id;
            $rid_sub_status = RidVisitStatus::where('name', '=', "Withdrew Consent")->first()->id;
        }
        // param == "Resupplied" -> Treatment ->Ongoing
        if ($param == "Resupplied") {
            $rid_status = RidStatus::where('name', '=', "Fulfillment")->first()->id;
            $rid_sub_status = RidVisitStatus::where('name', '=', "Withdrew Consent")->first()->id;
        }
        // param == "Approved" -> Treatment->Initiated

        if ($param == "Approved") {
            if ($param == "Approved" && $shipparam == 'Processed') {
                $rid_status = RidStatus::where('name', '=', "Fulfillment")->first()->id;
                $rid_sub_status = RidVisitStatus::where('name', '=', "Shipped")->first()->id;
            } elseif ($param == "Approved" && $shipparam == 'In Process') {
                $rid_status = RidStatus::where('name', '=', "Fulfillment")->first()->id;

                try {
                    $rid_sub_status = RidVisitStatus::where('name', '=', "Received")->first()->id;
                } catch (\Exception $e) {
                    $rid_s = new RidVisitStatus();
                    $rid_s->id = $rid_sub_status = $this::newID(RidVisitStatus::class);
                    $rid_s->status_id = $rid_status;
                    $rid_s->name = 'Received';
                    $rid_s->saveOrFail();
                }
            } else {
                $rid_status = RidStatus::where('name', '=', "Treatment")->first()->id;
                $rid_sub_status = RidVisitStatus::where('name', '=', "Initiated")->first()->id;
            }
        }
        // param == "NotApproved" -> Completed->Not Approved
        if ($param == "NotApproved") {
            $rid_status = RidStatus::where('name', '=', "Completed")->first()->id;
            $rid_sub_status = RidVisitStatus::where('name', '=', "Not Approved")->first()->id;
        }
        // param == "PendingReview" -> Pending->EAC Review
        if ($param == "PendingReview") {
            $rid_status = RidStatus::where('name', '=', "Pending")->first()->id;
            $rid_sub_status = RidVisitStatus::where('name', '=', "EAC Review")->first()->id;
        }
        // param == "InProcess" -> Approved->Regimen Needed
        if ($param == "InProcess") {
            $rid_status = RidStatus::where('name', '=', "Approved")->first()->id;
            $rid_sub_status = RidVisitStatus::where('name', '=', "Regimen Needed")->first()->id;
        }
        // param == "InProcessResupply" -> Treatment -> Ongoing
        if ($param == "InProcessResupply") {
            $rid_status = RidStatus::where('name', '=', "Treatment")->first()->id;
            $rid_sub_status = RidVisitStatus::where('name', '=', "Ongoing")->first()->id;
        }
        // param == "InProcessResupply" -> Treatment -> Ongoing
        if ($param == "Docneeded") {
            $rid_status = RidStatus::where('name', '=', "Pending")->first()->id;
            $rid_sub_status = RidVisitStatus::where('name', '=', "Documents Needed")->first()->id;
        }

        return $rid_status . "__" . $rid_sub_status;
    }

    protected function handleRidShipments()
    {
        $oldTable = 'rid_ship';
        $ridShipments = DB::connection($this->from['name'])->table($oldTable)->get();
        $bar = $this->output->createProgressBar(count($ridShipments));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($ridShipments as $ridShipment) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $ridShipmentModel = new RidShipment();
            $shipmentDepot = new Depot();
            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $ridShipment->rid_id;

            // rid shipment model
            $ridShipmentModel->id = $__IDLOGGER->id_new = $this::newID(RidShipment::class);
            $rid = DB::connection($this->from['name'])->table('rid')->where('rid_id', '=', $ridShipment->rid_id)->first();
            if (!$rid)
                continue;
            $ridShipmentModel->rid_id = $this->findRidParent($ridShipment->rid_id);

            $ridVisit_id = DEVUPDATESCRIPTTABLE::where('table_name', 'rid_record')->where('id_old', $ridShipment->rid_id)->firstOrFail()->id_new;
            $ridVisit = RidVisit::where('id', $ridVisit_id)->first();
            $ridVisit->shipment_id = $ridShipmentModel->id;
            $ridVisit->saveOrFail();

            /************* pharmacist info **************************************/
            $ridPharmacist = new Pharmacist();
            $ridPharmacist->id = $ridShipmentModel->pharmacist_id = $this::newID(Pharmacist::class);
            $ridPharmacist->email = !is_null($rid->rid_pharmacist_email) ? $rid->rid_pharmacist_email : null;
            $ridPharmacist->name = $rid->rid_pharmacist_name;
            $ridPharmacist->created_at = $rid->rid_added;
            $ridPharmacist->updated_at = $rid->rid_updated;

            if (!is_null($rid->rid_pharmacist_phone)) {
                $userPhone = Phone::where('number', '=', $rid->rid_pharmacist_phone)->first();

                if ($userPhone) {
                    $ridPharmacist->phone = $userPhone->id;
                } else {
                    $ridPhone = new Phone();
                    $ridPhone->id = $ridPharmacist->phone = $this::newID(Phone::class);
                    $ridPhone->country_id = $this->getNewID($rid->country_id, ['country', 'country_name'], ['countries', 'name']);
                    $ridPhone->number = $rid->rid_pharmacist_phone;
                    $ridPhone->is_primary = 1;
                    $ridPhone->created_at = null;
                    $ridPhone->updated_at = null;
                    $ridPhone->saveOrFail();
                }
            } else {
                $ridPharmacist->phone = null;
            }

            // pharmacist id old and id new creation in order to make relation for merging data
            $__IDLOGGER_PHARMACIST = new DEVUPDATESCRIPTTABLE();
            $__IDLOGGER_PHARMACIST->table_name = 'pharmacists';
            $__IDLOGGER_PHARMACIST->id_old = substr($ridShipment->rid_ship_id, 0, 7) . 'pst';
            $ridPharmacist->id = $__IDLOGGER_PHARMACIST->id_new = $this::newID(Pharmacist::class);
            $ridShipmentModel->pharmacist_id = $ridPharmacist->id;
            $__IDLOGGER_PHARMACIST->saveOrFail();
            $ridPharmacist->saveOrFail();

            $ridPharmacy = new Pharmacy();
            $ridPharmacy->id = $ridShipmentModel->pharmacy_id = $this::newID(Pharmacy::class);
            $ridPharmacyAddress = new Address();

            if (is_null($rid->rid_shipment_address) || $rid->rid_shipment_address == 'TBD' || $rid->rid_shipment_address == 'unknown') {
                $ridPharmacy->address_id = null;
            } else {
                $userAddr = Address::where('addr1', $rid->rid_shipment_address)->first();
                if ($userAddr) {
                    $ridPharmacy->address_id = $userAddr->id;
                } else {
                    $ridPharmacy->address_id = $ridPharmacyAddress->id = $this::newID(Address::class);
                    $ridPharmacyAddress->addr1 = (is_null($rid->rid_shipment_address)) ? null : $rid->rid_shipment_address;
                    $ridPharmacyAddress->addr2 = (is_null($rid->rid_shipment_address2)) ? null : $rid->rid_shipment_address2;
                    $ridPharmacyAddress->city = (is_null($rid->rid_shipment_city)) ? null : $rid->rid_shipment_city;
                    $ridPharmacyAddress->zipcode = (is_null($rid->rid_shipment_zip)) ? null : $rid->rid_shipment_zip;
                    $ridPharmacyAddress->state_province = $this->getNewID($rid->state_id, ['state', 'state_name'], ['states', 'name']);
                    $ridPharmacyAddress->country_id = $this->getNewID($rid->country_id, ['country', 'country_name'], ['countries', 'name']);
                    $ridPharmacyAddress->created_at = null;
                    $ridPharmacyAddress->updated_at = null;
                    if ($ridPharmacyAddress->addr1 != null && $ridPharmacyAddress->addr1 != 'TBD') {
                        $ridPharmacyAddress->saveOrFail();
                    }
                }
            }

            $ridPharmacy->name = $rid->rid_shipment_address;
            $ridPharmacy->created_at = $rid->rid_added;
            $ridPharmacy->updated_at = $rid->rid_updated;

            $phId = DEVUPDATESCRIPTTABLE::where(['table_name' => 'physician_user', 'id_old' => $rid->physician_id])->first();
            $ridPharmacy->physician_id = !is_null($phId) ? $phId->id_new : null;

            // test whether pharmacy exist or not
            $pName = Pharmacy::where('name', '=', $rid->rid_shipment_address)->first();

            if (!is_null($pName) && $ridPharmacy->name != 'TBD') {
                $ridShipmentModel->pharmacy_id = $pName->id;
            } else {
                if (is_null($pName) && $ridPharmacy->name != 'TBD') {
                    // pharmacy id old and id new creation in order to make relation for merging data
                    $__IDLOGGER_PHARMACY = new DEVUPDATESCRIPTTABLE();
                    $__IDLOGGER_PHARMACY->table_name = 'pharmacies';
                    $__IDLOGGER_PHARMACY->id_old = substr($ridShipment->rid_ship_id, 0, 7) . "phm";
                    $ridPharmacy->id = $__IDLOGGER_PHARMACY->id_new = $this::newID(Pharmacy::class);

                    $ridShipmentModel->pharmacy_id = $ridPharmacy->id;
                    $__IDLOGGER_PHARMACY->saveOrFail();
                    $ridPharmacy->saveOrFail();
                }
            }

            // $ridShipmentModel->rid_id = DEVUPDATESCRIPTTABLE::where(['table_name' => 'rid', 'id_old' => $ridShipment->rid_id])->firstOrFail()->id_new;
            try {
                $ridShipmentModel->courier_id = ShippingCourier::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'shipping_courier', 'id_old' => $ridShipment->rid_ship_courier])->firstOrFail()->id_new)->firstOrFail()->id;
            } catch (\Exception $e) {
                $ridShipmentModel->courier_id = null;
            }

            $ridShipmentModel->delivery_date = $ridShipment->rid_ship_delivery_date ?? null;
            $ridShipmentModel->tracking_number = (is_null($ridShipment->rid_ship_tracking_number)) ? '' : $ridShipment->rid_ship_tracking_number;

            // depot id
            $ridShipmentModel->depot_id = $shipmentDepot->id = $__IDLOGGER->id_new = $this::newID(Depot::class);
            $shipmentDepot->name = !is_null($ridShipment->rid_ship_originate_address) ? $ridShipment->rid_ship_originate_address : 'No Address given';
            // address
            if (is_null($ridShipment->rid_ship_originate_address) && $ridShipment->rid_ship_originate_address == 'TBD' || $ridShipment->rid_ship_originate_address == 'unknown') {
                $shipmentDepot->address_id = null;
            } else {
                $getExistingAddress = Address::where('addr1', '=', $ridShipment->rid_ship_originate_address)->first();
                if (!is_null($getExistingAddress) && isset($getExistingAddress->addr1)) {
                    $shipmentDepot->address_id = $getExistingAddress->id;
                } else {
                    $depotAddress = new Address();
                    $shipmentDepot->address_id = $depotAddress->id = $this::newID(Address::class);
                    $depotAddress->addr1 = (is_null($ridShipment->rid_ship_originate_address)) ? null : $ridShipment->rid_ship_originate_address;
                    $depotAddress->addr2 = (is_null($ridShipment->rid_ship_originate_address1)) ? null : $ridShipment->rid_ship_originate_address1;
                    $depotAddress->city = (is_null($ridShipment->rid_ship_originate_city)) ? null : $ridShipment->rid_ship_originate_city;
                    $depotAddress->zipcode = (is_null($ridShipment->rid_ship_originate_zip)) ? null : $ridShipment->rid_ship_originate_zip;
                    $fState = State::where('abbr', '=', $ridShipment->rid_ship_originate_state);
                    $depotAddress->state_province = strlen($ridShipment->rid_ship_originate_state == 2) && !empty($fState) && !is_null($fState) ? $fState[0]->id : null;

                    try {
                        $depotAddress->country_id = $this->getNewID($ridShipment->rid_ship_originate_country, ['country', 'country_name'], ['countries', 'name']);;
                    } catch (\Exception $e) {
                        $depotAddress->country_id = null;
                    }
                    $depotAddress->created_at = null;
                    $depotAddress->updated_at = null;
                    if (is_null($ridShipment->rid_ship_originate_address) && $ridShipment->rid_ship_originate_address == 'TBD' || $ridShipment->rid_ship_originate_address == 'unknown') {
                        $shipmentDepot->address_id = null;
                    } else {
                        if ($depotAddress->addr1 != null && $depotAddress->addr1 != 'TBD') {
                            $depotAddress->saveOrFail();
                        }
                    }
                }
            }

            // check unique address and name for depots
            $getDepot = Depot::where('address_id', '=', $shipmentDepot->address_id)->first();
            if (!is_null($getDepot) && isset($getDepot->id)) {
                $shipmentDepot->address_id = $getDepot->address_id;
                $ridShipmentModel->depot_id = $getDepot->id;
            } else {
                if (is_null($ridShipment->rid_ship_originate_address) && $ridShipment->rid_ship_originate_address == 'TBD' || $ridShipment->rid_ship_originate_address == 'unknown') {
                    $ridShipmentModel->depot_id = null;
                } else {
                    $shipmentDepot->created_at = null;
                    $shipmentDepot->updated_at = null;

                    if ($shipmentDepot->name != 'No Address given' && $shipmentDepot->name != 'Not defined') {
                        // depot id old and id new creation in order to make relation for merging data
                        $__IDLOGGER_DEPOT = new DEVUPDATESCRIPTTABLE();
                        $__IDLOGGER_DEPOT->table_name = 'depots';
                        $__IDLOGGER_DEPOT->id_old = substr($ridShipment->rid_ship_id, 0, 7) . "dpo";
                        $shipmentDepot->id = $__IDLOGGER_DEPOT->id_new = $this::newID(Depot::class);
                        $ridShipmentModel->depot_id = $shipmentDepot->id;
                        $__IDLOGGER_DEPOT->saveOrFail();
                        $shipmentDepot->saveOrFail();
                    }
                }
            }

            //Regimen
            $dosage_id = DEVUPDATESCRIPTTABLE::where(['table_name' => 'drug_dosage', 'id_old' => $ridShipment->rid_ship_dosage])->first();
            $drug_lot = DrugLot::where('dosage_id', $dosage_id->id_new ?? '0')->first();
            if ($dosage_id && $drug_lot) {
                $ridRegimen = new RidRegimen();
                $ridRegimen->id = $this::newID(RidRegimen::class);

                $ridRegimen->drug_lot_id = $drug_lot->id;
                $drug_lot->depot_id = $ridShipmentModel->depot_id;
                $drug_lot->number = $ridShipment->rid_ship_lot_number;
                $drug_lot->saveOrFail();

                $ridRegimen->quantity = $ridShipment->rid_ship_quantity ?? null;
                if ($ridShipment->rid_ship_dosage_freq === 'Q12 Hours')
                    $ridRegimen->frequency = '12 H';
                elseif ($ridShipment->rid_ship_dosage_freq === '2D')
                    $ridRegimen->frequency = '2 D';
                else
                    $ridRegimen->frequency = null;

                if ($ridShipment->rid_ship_supply_count) {
                    $ridRegimen->length = $ridShipment->rid_ship_supply_count . ' D';
                } else {
                    $ridRegimen->length = '0 D';
                }
                $ridRegimen->shipment_id = $ridShipmentModel->id;
                $ridRegimen->visit_id = $ridVisit->id;
                $ridRegimen->component_id = $drug_lot->dosage->component->id;
                $ridRegimen->total_count = (is_null($ridShipment->rid_ship_total_count)) ? null : $ridShipment->rid_ship_total_count;
                $ridRegimen->created_at = $ridShipment->rid_ship_added;
                $ridRegimen->updated_at = $ridShipment->rid_ship_updated;
                $ridRegimen->saveOrFail();
            }

            $ridShipmentModel->saveOrFail();
            $__IDLOGGER->saveOrFail();

            $bar->advance();
        }

        $rids = Rid::all();
        foreach ($rids as $rid) {
            $visit_wo_ship = $rid->visits->where('shipment_id', null);
            if ($visit_wo_ship->count() > 0) {
                $shipment = new RidShipment();
                $shipment->id = $this::newID(RidShipment::class);
                $shipment->rid_id = $rid->id;
                foreach ($visit_wo_ship as $visit) {
                    $visit->shipment_id = $shipment->id;
                    $visit->saveOrFail();
                }
                $shipment->saveOrFail();
            }
            RidVisit::where('visit_date', '1969-12-31')
                ->update(['visit_date' => null]);
        }
        $bar->finish();
    }

    protected function handleRidDocuments()
    {
        $ridDocuments = DB::connection($this->from['name'])
            ->table('rid_drug_doc')
            ->leftJoin('drug_doc_upload', 'rid_drug_doc.rid_drug_doc_id', '=', 'drug_doc_upload.rid_drug_doc_id')
            ->orderBy('rid_drug_doc.drug_doc_id')
            ->get();
        $bar = $this->output->createProgressBar(count($ridDocuments));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($ridDocuments as $ridDocument) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $ridDocumentModel = new RidDocument();
            $fileModel = new FileModel();

            $__IDLOGGER->table_name = 'rid_doc';
            $__IDLOGGER->id_old = $ridDocument->rid_drug_doc_id;

            $ridDocumentModel->id = $__IDLOGGER->id_new = $this::newID(RidDocument::class);
            $ridDocumentModel->visit_id = DEVUPDATESCRIPTTABLE::where(['table_name' => 'rid_record', 'id_old' => $ridDocument->rid_id])->firstOrFail()->id_new;
            $drugDocID = DEVUPDATESCRIPTTABLE::where(['id_old' => $ridDocument->drug_doc_id])->first()->id_new ?? false;
            if (!$drugDocID) {
                $bar->advance();
                continue;
            }
            $drugDoc = DrugDocument::where('id', $drugDocID)->first();

            // file
            if (!is_null($ridDocument->drug_doc_upload_file)) {
                $file = $this->getFile($ridDocument->drug_doc_upload_file, 'drug_doc_upload', 'rid.doc');
                $ridDocumentModel->file_id = $file->id;
            } else {
                $ridDocumentModel->file_id = null;
            }
            // redacted
            if (!is_null($ridDocument->drug_doc_upload_file_redacted)) {
                $file = $this->getFile($ridDocument->drug_doc_upload_file_redacted, 'drug_doc_upload', 'rid.redacted');
                $ridDocumentModel->redacted_file_id = $file->id;
            } else {
                $ridDocumentModel->redacted_file_id = null;
            }
            $ridDocumentModel->drug_doc_id = $drugDoc->id;
            $ridDocumentModel->type_id = $drugDoc->type_id;
            $ridDocumentModel->template_file_id = $drugDoc->file_id;
            $ridDocumentModel->is_required = $drugDoc->is_required;
            $ridDocumentModel->is_required_resupply = $drugDoc->is_required_resupply;

            $ridDocumentModel->desc = $ridDocument->drug_doc_upload_notes;
            $ridDocumentModel->created_at = $ridDocument->drug_doc_upload_added;
            $ridDocumentModel->updated_at = $ridDocument->drug_doc_upload_updated;

            $__IDLOGGER->saveOrFail();
            $ridDocumentModel->saveOrFail();

            $bar->advance();
        }
        $bar->finish();

        $oldTable = 'resupply_drug_doc';
        $resupplyDocuments = DB::connection($this->from['name'])->table($oldTable)->get();
        $bar = $this->output->createProgressBar(count($resupplyDocuments));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($resupplyDocuments as $ridDocument) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $ridDocumentModel = new RidDocument();
            $fileModel = new FileModel();

            $__IDLOGGER->table_name = 'rid_doc';
            $__IDLOGGER->id_old = $ridDocument->resupply_drug_doc_id;

            $ridDocumentModel->id = $__IDLOGGER->id_new = $this::newID(RidDocument::class);
            $ridDocumentModel->visit_id = DEVUPDATESCRIPTTABLE::where(['table_name' => 'rid_record', 'id_old' => $ridDocument->rid_id])->firstOrFail()->id_new;

            $drugDocID = DEVUPDATESCRIPTTABLE::where(['id_old' => $ridDocument->drug_doc_id])->first()->id_new ?? false;
            if (!$drugDocID) {
                $bar->advance();
                continue;
            }
            $drugDoc = DrugDocument::where('id', $drugDocID)->first();

            if (!is_null($ridDocument->resupply_drug_doc_file)) {
                $file = $this->getFile($ridDocument->resupply_drug_doc_file, 'resupply_drug_doc', 'rid.doc');
                $ridDocumentModel->file_id = $file->id;
            } else {
                $ridDocumentModel->file_id = null;
            }
            if (!is_null($ridDocument->resupply_drug_doc_file_redacted)) {
                $file = $this->getFile($ridDocument->resupply_drug_doc_file, 'resupply_drug_doc', 'rid.redacted');
                $ridDocumentModel->redacted_file_id = $file->id;
            } else {
                $ridDocumentModel->redacted_file_id = null;
            }

            $ridDocumentModel->drug_doc_id = $drugDoc->id;
            $ridDocumentModel->type_id = $drugDoc->type_id;
            $ridDocumentModel->template_file_id = $drugDoc->file_id;
            $ridDocumentModel->is_required = $drugDoc->is_required;
            $ridDocumentModel->is_required_resupply = $drugDoc->is_required_resupply;

            $ridDocumentModel->desc = $ridDocument->resupply_drug_doc_note;
            $ridDocumentModel->created_at = $ridDocument->resupply_drug_doc_added;
            $ridDocumentModel->updated_at = $ridDocument->resupply_drug_doc_updated;

            $__IDLOGGER->saveOrFail();
            $ridDocumentModel->saveOrFail();

            $bar->advance();
        }
        $bar->finish();


        $visits = RidVisit::all();
        $bar = $this->output->createProgressBar(count($visits));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($visits as $visit) {
            $drugDocs = $visit->parent->drug->documents;
            $ridDocs = $visit->documents;

            foreach ($drugDocs as $drugDoc) {
                if ($ridDocs->where('drug_doc_id', $drugDoc->id)->count())
                    continue;

                $ridDocument = new RidDocument();

                $ridDocument->id = $this::newID(RidDocument::class);
                $ridDocument->visit_id = $visit->id;
                $ridDocument->type_id = $drugDoc->type_id;
                $ridDocument->drug_doc_id = $drugDoc->id;
                $ridDocument->template_file_id = $drugDoc->file_id;
                $ridDocument->is_required = $drugDoc->is_required;
                $ridDocument->is_required_resupply = $drugDoc->is_required_resupply;

                $ridDocument->saveOrFail();
            }
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleRIDUsers()
    {
        $oldTable = 'physician_user_rid';
        $ridUserGroups = DB::connection($this->from['name'])->table($oldTable)->get()->groupBy('rid_id');
        $bar = $this->output->createProgressBar(count($ridUserGroups));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($ridUserGroups as $rid_id => $ridUserGroup) {
            $rid = Rid::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'rid', 'id_old' => $rid_id])->first()->id_new ?? null )->first() ?? null;

            if ($rid) {
                $group = new UserGroup();
                $group->id = $this::newID(UserGroup::class);
                $group->type_id = UserType::where('name', 'Physician')->first()->id;
                $group->parent_user_id = $rid->physician->id ?? false;
                $group->name = 'Rid Group: ' . $rid->number;
                $users = collect([]);
                foreach ($ridUserGroup as $ridUser) {
                    $usr = DEVUPDATESCRIPTTABLE::where('id_old', $ridUser->physician_user_rid_assigned_to)->first()->id_new ?? false;
                    $role = Role::where('id_old', $ridUser->physician_user_type_id)->first()->id ?? false;

                    if($usr && $role) {
                        $member = new \stdClass();
                        $member->id = $usr;
                        $member->role = $role;
                        $users->push($member);
                    }
                }
                $group->group_members = $users->toJson();
                $group->saveOrFail();
                $ridGroup = new RidGroup();
                $ridGroup->id = $this->newID(RidGroup::class);
                $ridGroup->rid_id = $rid->id;
                $ridGroup->user_group_id = $group->id;
                $ridGroup->saveOrFail();
            }

            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleDrugUsers()
    {
        return;
        $oldTable = 'drug_company_user';

        $drugUsers = DB::connection($this->from['name'])->table($oldTable);

        $bar = $this->output->createProgressBar(count($drugUsers));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($drugUsers as $drugUser) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $drugUserModel = new DrugUser();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $drugUser->drug_company_user_id;

            $userModel = User::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'company_user', 'id_old' => $drugUser->company_user_id])->firstOrFail()->id_new)->firstOrFail();

            $drugUserModel->id = $__IDLOGGER->id_new = $this::newID(DrugUser::class);
            $drugUserModel->user_id = $userModel->id;
            $drugUserModel->drug_id = Drug::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'drug', 'id_old' => $drugUser->drug_id])->firstOrFail()->id_new)->firstOrFail()->id;

            $drugUserModel->level = '"Inherited"';
            if ($drugUser) {
                $drugUserModel->role_id = Role::where('id_old', $drugUser->company_user_type_id)->firstOrFail()->id;
            } else {
                $drugUserModel->role_id = $userModel->role->id;
            }
            $drugUserModel->created_at = $drugUser->drug_company_user_added;
            $drugUserModel->updated_at = $drugUser->drug_company_user_updated;

            $__IDLOGGER->saveOrFail();
            $drugUserModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleAbilities()
    {
        $abilities = Gate::abilities();
        $bar = $this->output->createProgressBar(count($abilities));
        $bar->setBarWidth(2000);
        $bar->start();
        $stack = [];
        foreach ($abilities as $key => $value) {
            $abilityModel = new Ability();
            $gate = explode('.', $key)[0];

            if (in_array($gate, $stack)) {
                $bar->advance();
                continue;
            }

            array_push($stack, $gate);
            try {
                $abilityModel->id = $this::newID(Ability::class);
                $abilityModel->name = $gate;
            } catch (ModelNotFoundException $notFoundException) {
                continue 1;
            }

            $abilityModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleRoles()
    {
        $oldTable = 'role';
        $eacRoles = DB::connection($this->from['name'])->table($oldTable);
        $bar = $this->output->createProgressBar(count($eacRoles));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($eacRoles as $eacRole) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $roleModel = new Role();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $eacRole->role_id;

            try {
                $roleModel->id = $__IDLOGGER->id_new = $this::newID(Role::class);
                $roleModel->category = 'Early Access Care';
                $roleModel->name = $eacRole->role_name;
                $roleModel->old_id = $__IDLOGGER->id_old;
            } catch (ModelNotFoundException $notFoundException) {
                continue 1;
            }

            $__IDLOGGER->saveOrFail();
            $roleModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();

        $oldTable = 'company_user_type';
        $pharmaRoles = DB::connection($this->from['name'])->table($oldTable);
        $bar = $this->output->createProgressBar(count($pharmaRoles));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($pharmaRoles as $pharmaRole) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $roleModel = new Role();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $pharmaRole->company_user_type_id;

            try {
                $roleModel->id = $__IDLOGGER->id_new = $this::newID(Role::class);
                $roleModel->category = 'Pharmaceutical';
                $roleModel->name = $pharmaRole->company_user_type_name;
                $roleModel->old_id = $__IDLOGGER->id_old;
            } catch (ModelNotFoundException $notFoundException) {
                continue 1;
            }

            $__IDLOGGER->saveOrFail();
            $roleModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();

        $oldTable = 'physician_user_type';
        $physicianRoles = DB::connection($this->from['name'])->table($oldTable);
        $bar = $this->output->createProgressBar(count($physicianRoles));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($physicianRoles as $physicianRole) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $roleModel = new Role();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $physicianRole->physician_user_type_id;

            try {
                $roleModel->id = $__IDLOGGER->id_new = $this::newID(Role::class);
                $roleModel->category = 'Physician';
                $roleModel->name = $physicianRole->physician_user_type_name;
                $roleModel->old_id = $__IDLOGGER->id_old;
            } catch (ModelNotFoundException $notFoundException) {
                continue 1;
            }

            $__IDLOGGER->saveOrFail();
            $roleModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
        // dd('role done');
    }

    public function handleNotes()
    {
        $oldTable = 'rid_note';
        $notes = DB::connection($this->from['name'])->table($oldTable)->get();

        $bar = $this->output->createProgressBar(count($notes));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($notes as $ridNote) {
            if ($ridNote->rid_note_text === null) continue;
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $noteModel = new Note();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $ridNote->rid_note_id;

            $noteModel->id = $__IDLOGGER->id_new = $this::newID(Note::class);

            if ($ridNote->eac_user_id) {
                try {
                    $noteModel->author_id = User::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'eac_user', 'id_old' => $ridNote->eac_user_id])->firstOrFail()->id_new)->firstOrFail()->id;
                } catch (\Exception $e) {
                    $noteModel->author_id = "NOT_FOUND";
                }
            } else {
                try {
                    $noteModel->author_id = User::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'company_user', 'id_old' => $ridNote->company_user_id])->firstOrFail()->id_new)->firstOrFail()->id;
                } catch (\Exception $e) {
                    $noteModel->author_id = 'NOT_FOUND';
                }
            }

            // $noteModel->subject_id = Rid::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'rid', 'id_old' => $ridNote->rid_id])->firstOrFail()->id_new)->firstOrFail()->id;
            $noteModel->subject_id = $this->findRidParent($ridNote->rid_id);
            $noteModel->text = $ridNote->rid_note_text;
            $noteModel->created_at = $ridNote->rid_note_added;
            $noteModel->updated_at = $ridNote->rid_note_updated;

            $__IDLOGGER->saveOrFail();
            if ($noteModel->author_id != 'NOT_FOUND') {
                $noteModel->saveOrFail();
            }
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleNotifications()
    {
        $oldTable = 'notification';
        $notifications = DB::connection($this->from['name'])->table($oldTable)->get();
        $bar = $this->output->createProgressBar(count($notifications));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($notifications as $notification) {
            if (is_null($notification->notification_notifiable_id)) {
                $bar->advance();
                continue;
            }
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $notificationModel = new Notification();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $notification->notification_id;

            $notificationModel->id = $__IDLOGGER->id_new = $this::newID(Notification::class);
            // get user id
            // get subject id
            try {
                $notificationModel->user_id = DEVUPDATESCRIPTTABLE::where(['id_old' => $notification->notification_sender_id])->firstOrFail()->id_new;
                //dd($notificationModel->user_id);
            } catch (\Exception $e) {
                continue;
            }
            // get subject id
            try {
                if (strtolower($notification->notification_notifiable_type) == 'eac') {
                    if (is_null($notification->notification_notifiable_id)) continue 1;
                    $notificationModel->subject_id = User::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'eac_user', 'id_old' => $notification->notification_notifiable_id])->firstOrFail()->id_new)->firstOrFail()->id;
                } elseif (strtolower($notification->notification_notifiable_type) == 'physician') {
                    if (is_null($notification->notification_notifiable_id)) continue 1;
                    $notificationModel->subject_id = User::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'physician_user', 'id_old' => $notification->notification_notifiable_id])->firstOrFail()->id_new)->firstOrFail()->id;
                } else {
                    if (is_null($notification->notification_notifiable_id)) continue 1;
                    $notificationModel->subject_id = User::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'company_user', 'id_old' => $notification->notification_notifiable_id])->firstOrFail()->id_new)->firstOrFail()->id;
                }
            } catch (\Exception $e) {
                $notificationModel->subject_id = null;
            }

            $notificationModel->message = $notification->notification_message;
            $notificationModel->url = $notification->notification_url;
            $notificationModel->read_at = $notification->notification_read_at;
            $notificationModel->created_at = $notification->notification_created_at;
            $notificationModel->updated_at = $notification->notification_updated_at;

            $__IDLOGGER->saveOrFail();
            $notificationModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    protected function handleUserCertificates()
    {
        $oldTable = 'physician_user';
        $physicanUser = DB::connection($this->from['name'])->table($oldTable)->get();
        $bar = $this->output->createProgressBar(count($physicanUser));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($physicanUser as $phy) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();
            $crt = new UserCertificate();

            $__IDLOGGER->table_name = 'phycian_certificate';
            $__IDLOGGER->id_old = $phy->physician_user_id;
            $crt->id = $__IDLOGGER->id_new = $this::newID(UserCertificate::class);
            // get user id
            // get subject id

            try {
                $crt->user_id = User::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'physician_user', 'id_old' => $phy->physician_user_id])->firstOrFail()->id_new)->firstOrFail()->id;
            } catch (\Exception $e) {
                $crt->user_id = null;
            }
            // store cv_file file and give reference
            if ($phy->physician_user_cv) {
                $file = $this->getFile($phy->physician_user_cv, 'physician', 'user.cv');
                $crt->cv_file = $file->id;
            }
            if ($phy->physician_user_medical_license) {
                $file = $this->getFile($phy->physician_user_medical_license, 'physician', 'user.cv');
                $crt->license_file = $file->id;
            }

            $crt->user_signature = $phy->physician_user_signatures;
            $crt->created_at = $phy->physician_user_added;
            $crt->updated_at = $phy->physician_user_updated;

            $__IDLOGGER->saveOrFail();
            $crt->saveOrFail();
            $bar->advance();
        }

        $bar->finish();
    }

    // protected function handleResource()
    // {

    // 	$oldTable = 'drug_res';
    // 	$resources = DB::connection($this->from['name'])->table($oldTable);
    // 	$bar = $this->output->createProgressBar(count($resources));
    // 	$bar->setBarWidth(2000);
    // 	$bar->start();

    // 	foreach ($resources as $res) {

    // 		$__IDLOGGER = new DEVUPDATESCRIPTTABLE();
    // 		$resourceModel = new Document();
    // 		$fileModel = new FileModel();

    // 		$__IDLOGGER->table_name = $oldTable;
    // 		$__IDLOGGER->id_old = $res->drug_id;

    // 		$resourceModel->id = $__IDLOGGER->id_new = $this::newID(Document::class);
    // 		$resourceModel->drug_id = Drug::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'drug', 'id_old' => $res->drug_id])->firstOrFail()->id_new)->firstOrFail()->id;
    // 		dd($resourceModel->drug_id );
    // 		$resourceModel->type_id = DocumentType::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'drug_doc_type', 'id_old' => $res->drug_res_type_id])->firstOrFail()->id_new)->firstOrFail()->id;
    // 		// $resourceModel->name = $drugResource->drug_doc_file;
    // 		$resourceModel->is_resource = 1;
    // 		// $resourceModel->is_required = $drugResource->drug_doc_req;
    // 		// $resourceModel->is_required_resupply = $drugResource->drug_doc_req_rs;

    // 			// file
    // 			if(!is_null($res->drug_res_file)){

    // 				* chooping [-] if exist *
    // 				$resourceModel->name = $res->drug_res_file_title; //'andrews call'//$drugResource->drug_doc_file;

    // 				$first_character =  mb_substr($res->drug_res_file, 0, 1);
    // 				$str = $res->drug_res_file;
    // 				if($first_character == '_'){
    // 					$str = ltrim($res->drug_res_file, '_');
    // 				}

    // 					$fileModel = new FileModel();
    // 					$resourceModel->file_id  = $fileModel->id = $this::newID(FileModel::class);
    // 					$fileModel->path =  config('eac.storage.file.drug.regular');
    // 					$fileModel->name = $str;
    // 					$fileModel->saveOrFail();

    // 			}else{
    // 				$res->file_id =null;
    // 				$resourceModel->name = $res->drug_res_file_title; //'andrews call'//$drugResource->drug_doc_file;
    // 			}

    // 			// try{
    // 			// 	$resourceModel->rid_id = Rid::where('id', '=', DEVUPDATESCRIPTTABLE::where(['table_name' => 'rid', 'id_old' => $ridDocument->rid_id])->firstOrFail()->id_new)->firstOrFail()->id;
    // 			// }catch(\Exception $e){
    // 			// 	$resourceModel->rid_id =null;
    // 			// }

    // 			$resourceModel->desc = $res->drug_res_desc;
    // 			$resourceModel->created_at=$res->drug_res_added;
    // 			$resourceModel->updated_at=$res->drug_res_updated;

    // 			$__IDLOGGER->saveOrFail();
    // 			$resourceModel->saveOrFail();

    // 		$bar->advance();
    // 	}
    // 	$bar->finish();
    // }

    public function handleRidNotApprovedReason()
    {

        $oldTable = 'rid_not_approved_reason';
        $ridnotapprovedreason = DB::connection($this->from['name'])->table($oldTable);

        $bar = $this->output->createProgressBar(count($ridnotapprovedreason));
        $bar->setBarWidth(2000);
        $bar->start();
        foreach ($ridnotapprovedreason as $var) {
            $__IDLOGGER = new DEVUPDATESCRIPTTABLE();

            $ridnotapprovedreasonModel = new DenialReason();

            $__IDLOGGER->table_name = $oldTable;
            $__IDLOGGER->id_old = $var->rid_not_approved_reason_id;
            $ridnotapprovedreasonModel->id = $__IDLOGGER->id_new = $this::newID(DenialReason::class);
            $ridnotapprovedreasonModel->name = $var->rid_not_approved_reason_name;
            // $ridnotapprovedreasonModel->description = null;
            // $ridnotapprovedreasonModel->created_at = $var->rid_not_approved_reason_added ? $var->rid_not_approved_reason_added : null;
            // $ridnotapprovedreasonModel->updated_at = $var->rid_not_approved_reason_updated;

            $__IDLOGGER->saveOrFail();
            $ridnotapprovedreasonModel->saveOrFail();
            $bar->advance();
        }
        $bar->finish();
    }

    /**
     * Parse whether the column is nullable or not
     * @param string $columnNull
     * @return bool
     */
    protected function parseColumnNullable(string $columnNull): bool
    {
        return ($columnNull == 'Yes') ? true : false;
    }

    public function getPrimaryNewId($old_primary_id, $table_name)
    {
        $row = DEVUPDATESCRIPTTABLE::where(['table_name' => $table_name, 'id_old' => $old_primary_id])->first();
        if ($row) {
            return $row->id_new;
        } else {
            return '';
        }
    }

    public function getNewMigrationId($array)
    {
        $dataArray = json_decode($array, TRUE);
        $data = DEVUPDATESCRIPTTABLE::whereIn('id_old', $dataArray)->select('id_new');
        // dd($data->toJson());
        if ($data->count() > 0) {
            foreach ($data as $key => $value) {
                $singleArray[$key] = $value->id_new;
            }
            return $singleArray;
        }
        return [];
    }

    public function handleDepotMerge()
    {
        $depots = MergeData::where('table_name', 'depots');
        $bar = $this->output->createProgressBar(count($depots));
        $bar->setBarWidth(2000);
        $bar->start();
        if ($depots->count() > 0) {

            foreach ($depots as $val) {
                $primary_data_new = $this->getPrimaryNewId($val->primary_old_id, 'depots');
                $merge_data_new = $this->getNewMigrationId($val->migration_old_id);

                if ($primary_data_new != '' || !empty($merge_data_new)) {
                    $data = MergeData::find($val->id);
                    $data->primary_id = $primary_data_new;
                    $data->merge_id = json_encode($merge_data_new, TRUE);
                    $data->saveOrFail();


                    // replace depot_id in rid_shipment and drug_lots table by primary id
                    $ridShipment = RidShipment::whereIn('depot_id', $merge_data_new)->update(['depot_id' => $primary_data_new]);
                    $drugLot = DrugLot::whereIn('depot_id', $merge_data_new)->update(['depot_id' => $primary_data_new]);

                    // remove primary id from selected merge data
                    $temparray = array($primary_data_new);
                    $result = array_diff($merge_data_new, $temparray);
                    $remove = Depot::whereIn('id', $result)->delete();
                } else {
                    continue;
                }

                $bar->advance();
            }
        }
        $bar->finish();
    }

    public function handlePharmacyMerge()
    {
        $pharmacies = MergeData::where('table_name', 'pharmacies');
        $bar = $this->output->createProgressBar(count($pharmacies));
        $bar->setBarWidth(2000);
        $bar->start();
        if ($pharmacies->count() > 0) {

            foreach ($pharmacies as $val) {
                $primary_data_new = $this->getPrimaryNewId($val->primary_old_id, 'pharmacies');
                $merge_data_new = $this->getNewMigrationId($val->migration_old_id);
                if ($primary_data_new != '' || !empty($merge_data_new)) {
                    $data = MergeData::find($val->id);
                    $data->primary_id = $primary_data_new;
                    $data->merge_id = json_encode($merge_data_new, TRUE);
                    $data->saveOrFail();


                    // replace pharmacy in rid_shipment and drug_lots table by primary id
                    $ridShipment = RidShipment::whereIn('pharmacy_id', $merge_data_new)->update(['pharmacy_id' => $primary_data_new]);
                    $Pharmacist = Pharmacist::whereIn('pharmacy_id', $merge_data_new)->update(['pharmacy_id' => $primary_data_new]);

                    // remove primary id from selected merge data
                    $temparray = array($primary_data_new);
                    $result = array_diff($merge_data_new, $temparray);
                    $remove = Pharmacy::whereIn('id', $result)->delete();
                } else {
                    continue;
                }
                $bar->advance();
            }
        }
        $bar->finish();

    }

    public function handlePharmacistMerge()
    {
        $pharmacist = MergeData::where('table_name', 'pharmacists');
        $bar = $this->output->createProgressBar(count($pharmacist));
        $bar->setBarWidth(2000);
        $bar->start();
        if ($pharmacist->count() > 0) {

            foreach ($pharmacist as $val) {
                $primary_data_new = $this->getPrimaryNewId($val->primary_old_id, 'pharmacists');
                $merge_data_new = $this->getNewMigrationId($val->migration_old_id);
                if ($primary_data_new != '' || !empty($merge_data_new)) {
                    $data = MergeData::find($val->id);
                    $data->primary_id = $primary_data_new;
                    $data->merge_id = json_encode($merge_data_new, TRUE);
                    $data->saveOrFail();


                    // replace pharmacy id in RidShipment table by primary id
                    $ridShipment = RidShipment::whereIn('pharmacist_id', $merge_data_new)->update(['pharmacist_id' => $primary_data_new]);


                    // remove primary id from selected merge data
                    $temparray = array($primary_data_new);
                    $result = array_diff($merge_data_new, $temparray);
                    $remove = Pharmacist::whereIn('id', $result)->delete();
                } else {
                    continue;
                }
                $bar->advance();
            }
        }
        $bar->finish();

    }

    public function handleDrugLotMerge()
    {
        $drug_lots = MergeData::where('table_name', 'drug_lots');
        $bar = $this->output->createProgressBar(count($drug_lots));
        $bar->setBarWidth(2000);
        $bar->start();
        if ($drug_lots->count() > 0) {

            foreach ($drug_lots as $val) {
                $primary_data_new = $this->getPrimaryNewId($val->primary_old_id, 'drug_lots');
                $merge_data_new = $this->getNewMigrationId($val->migration_old_id);
                if ($primary_data_new != '' || !empty($merge_data_new)) {

                    $data = MergeData::find($val->id);
                    $data->primary_id = $primary_data_new;
                    $data->merge_id = json_encode($merge_data_new, TRUE);
                    $data->saveOrFail();


                    // replace depot_id in rid_shipment and drug_lots table by primary id
                    $ridShipment = RidRegimen::whereIn('drug_lot_id', $merge_data_new)->update(['drug_lot_id' => $primary_data_new]);


                    // remove primary id from selected merge data
                    $temparray = array($primary_data_new);
                    $result = array_diff($merge_data_new, $temparray);
                    $remove = DrugLot::whereIn('id', $result)->delete();
                } else {
                    continue;
                }
                $bar->advance();
            }
        }
        $bar->finish();

    }

    protected function setExistingMergeId($old_id, $table)
    {
        $data_m = MergeData::where('table_name', $table);
        if ($data_m->count() > 0) {
            foreach ($data_m as $val) {
                $data_old = json_decode($val->migration_old_id, TRUE);
                foreach ($data_old as $key => $value) {
                    if ($old_id == $value['id_old']) {
                        return $val->primary_id;
                    }
                }
            }
        } else {
            return null;
        }
    }
    // public function newID(string $model)
    // {

    // 	$str = '';
    // 	for ($i = 0; $i < $length; $i++) {
    // 		$str .= self::$chars[random_int(0, strlen(self::$chars) - 1)];
    // 	}
    // 	return $str;
    // }
}
