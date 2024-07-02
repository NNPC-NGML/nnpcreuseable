<?

namespace Skillz\Nnpcreusable\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class NnpcreusableDomainComponents extends Command
{
    // The name and signature of the console command
    protected $signature = 'publish:service {domain}';

    // The console command description
    protected $description = 'Publish and bind files related to a specific domain';

    // Path to package components
    protected $packagePath = __DIR__ . '/../../';

    public function handle()
    {
        $domain = $this->argument('domain');

        switch (strtolower($domain)) {
            case 'user':
                $this->publishUserComponents();
                break;
            case 'processflow':
                $this->publishProcessFLowComponents();
                break;
            case 'notification':
                $this->publishNotificationComponents();
                break;
            case 'automator':
                $this->publishAutomatorComponents();
                break;
            case 'formbuilder':
                $this->publishFormBuilderComponents();
                break;
            case 'customer':
                $this->publishCustomerComponents();
                break;

                // Add more cases for other domains if needed
            default:
                $this->error("Unknown domain: {$domain}");
                break;
        }
    }

    protected function publishUserComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2014_10_12_000000_create_users_table.php" => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            "{$this->packagePath}database/migrations/2024_02_21_100401_create_designations_table.php" => database_path('migrations/2024_02_21_100401_create_designations_table.php'),
            "{$this->packagePath}database/migrations/2024_04_02_095718_create_units_table.php" => database_path('migrations/2024_04_02_095718_create_units_table.php'),
            "{$this->packagePath}database/migrations/2024_04_08_194051_create_departments_table.php" => database_path('migrations/2024_04_08_194051_create_departments_table.php'),
            // Load Users jobs on host app
            "{$this->packagePath}Jobs/User/UserCreated.php" => app_path('Jobs/User/UserCreated.php'),
            "{$this->packagePath}Jobs/User/UserUpdated.php" => app_path('Jobs/User/UserUpdated.php'),
            "{$this->packagePath}Jobs/User/UserDeleted.php" => app_path('Jobs/User/UserDeleted.php'),

            // Load Department jobs on host app
            "{$this->packagePath}Jobs/Department/DepartmentCreated.php" => app_path('Jobs/Department/DepartmentCreated.php'),
            "{$this->packagePath}Jobs/Department/DepartmentUpdated.php" => app_path('Jobs/Department/DepartmentUpdated.php'),
            "{$this->packagePath}Jobs/Department/DepartmentDeleted.php" => app_path('Jobs/Department/DepartmentDeleted.php'),

            // Load Unit jobs on host app
            "{$this->packagePath}Jobs/Unit/UnitCreated.php" => app_path('Jobs/Unit/UnitCreated.php'),
            "{$this->packagePath}Jobs/Unit/UnitUpdated.php" => app_path('Jobs/Unit/UnitUpdated.php'),
            "{$this->packagePath}Jobs/Unit/UnitDeleted.php" => app_path('Jobs/Unit/UnitDeleted.php'),

            // Load Designations jobs on host app
            "{$this->packagePath}Jobs/Designation/DesignationCreated.php" => app_path('Jobs/Designation/DesignationCreated.php'),
            "{$this->packagePath}Jobs/Designation/DesignationUpdated.php" => app_path('Jobs/Designation/DesignationUpdated.php'),
            "{$this->packagePath}Jobs/Designation/DesignationDeleted.php" => app_path('Jobs/Designation/DesignationDeleted.php'),

        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        Artisan::call('migrate');

        // Bind methods for the jobs
        $this->bindUsersJobs();
    }

    protected function publishProcessFLowComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2024_01_19_171147_create_process_flows_table.php" => database_path('migrations/2024_01_19_171147_create_process_flows_table.php'),
            "{$this->packagePath}database/migrations/2024_01_19_171220_create_process_flow_steps_table.php" => database_path('migrations/2024_01_19_171220_create_process_flow_steps_table.php'),
            "{$this->packagePath}database/migrations/2024_01_19_171236_create_process_flow_histories_table.php" => database_path('migrations/2024_01_19_171236_create_process_flow_histories_table.php'),
            "{$this->packagePath}database/migrations/2024_02_26_111937_create_routes_table.php" => database_path('migrations/2024_02_26_111937_create_routes_table.php'),

            // Load Route jobs on host app
            "{$this->packagePath}Jobs/Route/RouteCreated.php" => app_path('Jobs/Route/RouteCreated.php'),
            "{$this->packagePath}Jobs/Route/RouteUpdated.php" => app_path('Jobs/Route/RouteUpdated.php'),
            "{$this->packagePath}Jobs/Route/RouteDeleted.php" => app_path('Jobs/Route/RouteDeleted.php'),

            // Load ProcessFlow jobs on host app
            "{$this->packagePath}Jobs/ProcessFlow/ProcessFlowCreated.php" => app_path('Jobs/ProcessFlow/ProcessFlowCreated.php'),
            "{$this->packagePath}Jobs/ProcessFlow/ProcessFlowUpdated.php" => app_path('Jobs/ProcessFlow/ProcessFlowUpdated.php'),
            "{$this->packagePath}Jobs/ProcessFlow/ProcessFlowDeleted.php" => app_path('Jobs/ProcessFlow/ProcessFlowDeleted.php'),

            // Load ProcessflowStep jobs on host app
            "{$this->packagePath}Jobs/ProcessflowStep/ProcessflowStepCreated.php" => app_path('Jobs/ProcessflowStep/ProcessflowStepCreated.php'),
            "{$this->packagePath}Jobs/ProcessflowStep/ProcessflowStepUpdated.php" => app_path('Jobs/ProcessflowStep/ProcessflowStepUpdated.php'),
            "{$this->packagePath}Jobs/ProcessflowStep/ProcessflowStepDeleted.php" => app_path('Jobs/ProcessflowStep/ProcessflowStepDeleted.php'),

            // Load ProcessflowStep jobs on host app
            "{$this->packagePath}Jobs/ProcessFlowHistory/ProcessFlowHistoryCreated.php" => app_path('Jobs/ProcessflowStep/ProcessflowStepCreated.php'),
            "{$this->packagePath}Jobs/ProcessFlowHistory/ProcessFlowHistoryUpdated.php" => app_path('Jobs/ProcessflowStep/ProcessflowStepUpdated.php'),
            "{$this->packagePath}Jobs/ProcessFlowHistory/ProcessFlowHistoryDeleted.php" => app_path('Jobs/ProcessflowStep/ProcessflowStepDeleted.php'),

        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        Artisan::call('migrate');
        // Bind methods for the jobs
        $this->bindProcessFlowJobs();
    }

    protected function publishNotificationComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2024_05_09_115616_create_notification_tasks_table.php" => database_path('migrations/2024_05_09_115616_create_notification_tasks_table.php'),
            "{$this->packagePath}Jobs/NotificationTask/NotificationTaskCreated.php" => app_path('Jobs/NotificationTask/NotificationTaskCreated.php'),
            "{$this->packagePath}Jobs/NotificationTask/NotificationTaskUpdated.php" => app_path('Jobs/NotificationTask/NotificationTaskUpdated.php'),
            "{$this->packagePath}Jobs/NotificationTask/NotificationTaskDeleted.php" => app_path('Jobs/NotificationTask/NotificationTaskDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        Artisan::call('migrate');
        // Bind methods for the jobs
        $this->bindNotificationTaskJobs();
    }

    protected function publishAutomatorComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2024_05_09_130418_create_automator_tasks_table.php" => database_path('migrations/2024_05_09_130418_create_automator_tasks_table.php'),
            "{$this->packagePath}Jobs/AutomatorTask/AutomatorTaskCreated.php" => app_path('Jobs/AutomatorTask/AutomatorTaskCreated.php'),
            "{$this->packagePath}Jobs/AutomatorTask/AutomatorTaskUpdated.php" => app_path('Jobs/AutomatorTask/AutomatorTaskUpdated.php'),
            "{$this->packagePath}Jobs/AutomatorTask/AutomatorTaskDeleted.php" => app_path('Jobs/AutomatorTask/AutomatorTaskDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        Artisan::call('migrate');
        // Bind methods for the jobs
        $this->bindAutomatorTaskJobs();
    }

    protected function publishFormBuilderComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2024_05_10_102630_create_forms_table.php" => database_path('migrations/2024_05_10_102630_create_forms_table.php'),
            "{$this->packagePath}database/migrations/2024_05_11_160412_create_form_data_table.php" => database_path('migrations/2024_05_11_160412_create_form_data_table.php'),
            "{$this->packagePath}database/migrations/2024_05_11_160412_create_tags_table.php" => database_path('migrations/2024_05_11_160412_create_tags_table.php'),

            "{$this->packagePath}database/seeders/TagSeeder.php" => database_path('seeders/TagSeeder.php'),

            "{$this->packagePath}Jobs/FormBuilder/FormBuilderCreated.php" => app_path('Jobs/FormBuilder/FormBuilderCreated.php'),
            "{$this->packagePath}Jobs/FormBuilder/FormBuilderUpdated.php" => app_path('Jobs/FormBuilder/FormBuilderUpdated.php'),
            "{$this->packagePath}Jobs/FormBuilder/FormBuilderDeleted.php" => app_path('Jobs/FormBuilder/FormBuilderDeleted.php'),

            "{$this->packagePath}Jobs/FormData/FormDataCreated.php" => app_path('Jobs/FormData/FormDataCreated.php'),
            "{$this->packagePath}Jobs/FormData/FormDataUpdated.php" => app_path('Jobs/FormData/FormDataUpdated.php'),
            "{$this->packagePath}Jobs/FormData/FormDataDeleted.php" => app_path('Jobs/FormData/FormDataDeleted.php'),

            "{$this->packagePath}Jobs/Tag/TagDeleted.php" => app_path('Jobs/Tag/TagDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }
        // Bind methods for the jobs
        $this->bindFormBuilderJobs();
    }
    protected function publishCustomerComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2024_05_12_093540_create_customers_table.php" => database_path('migrations/2024_05_12_093540_create_customers_table.php'),
            "{$this->packagePath}database/migrations/2024_06_30_192453_create_customer_sites_table.php" => database_path('migrations/2024_06_30_192453_create_customer_sites_table.php'),

            "{$this->packagePath}Jobs/Customer/CustomerCreated.php" => app_path('Jobs/Customer/CustomerCreated.php'),
            "{$this->packagePath}Jobs/Customer/CustomerUpdated.php" => app_path('Jobs/Customer/CustomerUpdated.php'),
            "{$this->packagePath}Jobs/Customer/CustomerDeleted.php" => app_path('Jobs/Customer/CustomerDeleted.php'),

            "{$this->packagePath}Jobs/CustomerSite/CustomerSiteCreated.php" => app_path('Jobs/CustomerSite/CustomerSiteCreated.php'),
            "{$this->packagePath}Jobs/CustomerSite/CustomerSiteUpdated.php" => app_path('Jobs/CustomerSite/CustomerSiteUpdated.php'),
            "{$this->packagePath}Jobs/CustomerSite/CustomerSiteDeleted.php" => app_path('Jobs/CustomerSite/CustomerSiteDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        Artisan::call('migrate');
        // Bind methods for the jobs
        $this->bindCustomerJobs();
    }
    protected function publishSupplierComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2014_10_12_000000_create_users_table.php" => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            "{$this->packagePath}Jobs/User/UserCreated.php" => app_path('Jobs/User/UserCreated.php'),
            "{$this->packagePath}Jobs/User/UserUpdated.php" => app_path('Jobs/User/UserUpdated.php'),
            "{$this->packagePath}Jobs/User/UserDeleted.php" => app_path('Jobs/User/UserDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        // Bind methods for the jobs
        $this->bindUsersJobs();
    }
    protected function publishGasComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2014_10_12_000000_create_users_table.php" => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            "{$this->packagePath}Jobs/User/UserCreated.php" => app_path('Jobs/User/UserCreated.php'),
            "{$this->packagePath}Jobs/User/UserUpdated.php" => app_path('Jobs/User/UserUpdated.php'),
            "{$this->packagePath}Jobs/User/UserDeleted.php" => app_path('Jobs/User/UserDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        // Bind methods for the jobs
        $this->bindUsersJobs();
    }
    protected function publishTenderComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2014_10_12_000000_create_users_table.php" => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            "{$this->packagePath}Jobs/User/UserCreated.php" => app_path('Jobs/User/UserCreated.php'),
            "{$this->packagePath}Jobs/User/UserUpdated.php" => app_path('Jobs/User/UserUpdated.php'),
            "{$this->packagePath}Jobs/User/UserDeleted.php" => app_path('Jobs/User/UserDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        // Bind methods for the jobs
        $this->bindUsersJobs();
    }
    protected function publishDocumentComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2014_10_12_000000_create_users_table.php" => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            "{$this->packagePath}Jobs/User/UserCreated.php" => app_path('Jobs/User/UserCreated.php'),
            "{$this->packagePath}Jobs/User/UserUpdated.php" => app_path('Jobs/User/UserUpdated.php'),
            "{$this->packagePath}Jobs/User/UserDeleted.php" => app_path('Jobs/User/UserDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        // Bind methods for the jobs
        $this->bindUsersJobs();
    }

    protected function publishReportComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2014_10_12_000000_create_users_table.php" => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            "{$this->packagePath}Jobs/User/UserCreated.php" => app_path('Jobs/User/UserCreated.php'),
            "{$this->packagePath}Jobs/User/UserUpdated.php" => app_path('Jobs/User/UserUpdated.php'),
            "{$this->packagePath}Jobs/User/UserDeleted.php" => app_path('Jobs/User/UserDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        // Bind methods for the jobs
        $this->bindUsersJobs();
    }
    protected function publishBillingComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2014_10_12_000000_create_users_table.php" => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            "{$this->packagePath}Jobs/User/UserCreated.php" => app_path('Jobs/User/UserCreated.php'),
            "{$this->packagePath}Jobs/User/UserUpdated.php" => app_path('Jobs/User/UserUpdated.php'),
            "{$this->packagePath}Jobs/User/UserDeleted.php" => app_path('Jobs/User/UserDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        // Bind methods for the jobs
        $this->bindUsersJobs();
    }
    protected function publishActivityComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2014_10_12_000000_create_users_table.php" => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            "{$this->packagePath}Jobs/User/UserCreated.php" => app_path('Jobs/User/UserCreated.php'),
            "{$this->packagePath}Jobs/User/UserUpdated.php" => app_path('Jobs/User/UserUpdated.php'),
            "{$this->packagePath}Jobs/User/UserDeleted.php" => app_path('Jobs/User/UserDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        // Bind methods for the jobs
        $this->bindUsersJobs();
    }
    protected function publishProjectComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2014_10_12_000000_create_users_table.php" => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            "{$this->packagePath}Jobs/User/UserCreated.php" => app_path('Jobs/User/UserCreated.php'),
            "{$this->packagePath}Jobs/User/UserUpdated.php" => app_path('Jobs/User/UserUpdated.php'),
            "{$this->packagePath}Jobs/User/UserDeleted.php" => app_path('Jobs/User/UserDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        // Bind methods for the jobs
        $this->bindUsersJobs();
    }

    protected function publishCommunicationComponents()
    {
        // Define the files and bindings for the "user" domain
        $filesToPublish = [
            "{$this->packagePath}database/migrations/2014_10_12_000000_create_users_table.php" => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            "{$this->packagePath}Jobs/User/UserCreated.php" => app_path('Jobs/User/UserCreated.php'),
            "{$this->packagePath}Jobs/User/UserUpdated.php" => app_path('Jobs/User/UserUpdated.php'),
            "{$this->packagePath}Jobs/User/UserDeleted.php" => app_path('Jobs/User/UserDeleted.php'),
            // Add more files as needed
        ];

        foreach ($filesToPublish as $source => $destination) {
            $destinationDir = dirname($destination);

            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true); // Permissions and recursive directory creation
                $this->info("Created directory: {$destinationDir}");
            }
            if (File::exists($source)) {
                if (!File::exists($destination)) {
                    File::copy($source, $destination);
                    $this->info("Published: {$destination}");
                } else {
                    $this->warn("Skipped (already exists): {$destination}");
                }
            } else {
                $this->error("Source file not found: {$source}");
            }
        }

        // Bind methods for the jobs
        $this->bindUsersJobs();
    }

    protected function bindUsersJobs()
    {
        \App::bindMethod('App\\Jobs\\User\\UserCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\User\\UserUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\User\\UserDeleted@handle', fn ($job) => $job->handle());

        \App::bindMethod('App\\Jobs\\Unit\\UnitCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\Unit\\UnitUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\Unit\\UnitDeleted@handle', fn ($job) => $job->handle());

        \App::bindMethod('App\\Jobs\\Department\\DepartmentCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\Department\\DepartmentUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\Department\\DepartmentDeleted@handle', fn ($job) => $job->handle());

        \App::bindMethod('App\\Jobs\\Designation\\DesignationCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\Designation\\DesignationUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\Designation\\DesignationDeleted@handle', fn ($job) => $job->handle());


        $this->info("Users Jobs have been bound successfully.");
    }
    protected function bindProcessFlowJobs()
    {
        // Bind methods for the ProcessFlow jobs
        \App::bindMethod('App\\Jobs\\ProcessFlow\\ProcessFlowCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\ProcessFlow\\ProcessFlowUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\ProcessFlow\\ProcessFlowDeleted@handle', fn ($job) => $job->handle());
        // Bind methods for the ProcessFlowHistory jobs
        \App::bindMethod('App\\Jobs\\ProcessFlowHistory\\ProcessFlowHistoryCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\ProcessFlowHistory\\ProcessFlowHistoryUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\ProcessFlowHistory\\ProcessFlowHistoryDeleted@handle', fn ($job) => $job->handle());
        // Bind methods for the ProcessflowStep jobs
        \App::bindMethod('App\\Jobs\\ProcessflowStep\\ProcessflowStepCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\ProcessflowStep\\ProcessflowStepUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\ProcessflowStep\\ProcessflowStepDeleted@handle', fn ($job) => $job->handle());
        // Bind methods for the Route jobs
        \App::bindMethod('App\\Jobs\\Route\\RouteCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\Route\\RouteUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\Route\\RouteDeleted@handle', fn ($job) => $job->handle());

        $this->info("Processflow Jobs have been bound successfully.");
    }
    protected function bindNotificationTaskJobs()
    {
        // Bind methods for the ProcessFlow jobs
        \App::bindMethod('App\\Jobs\\NotificationTask\\NotificationTaskCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\NotificationTask\\NotificationTaskUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\NotificationTask\\NotificationTaskDeleted@handle', fn ($job) => $job->handle());

        $this->info("Notification Jobs have been bound successfully.");
    }
    protected function bindAutomatorTaskJobs()
    {
        // Bind methods for the ProcessFlow jobs
        \App::bindMethod('App\\Jobs\\AutomatorTask\\AutomatorTaskCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\AutomatorTask\\AutomatorTaskUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\AutomatorTask\\AutomatorTaskDeleted@handle', fn ($job) => $job->handle());

        $this->info("Automator Jobs have been bound successfully.");
    }
    protected function bindFormBuilderJobs()
    {
        // Bind methods for the ProcessFlow jobs
        \App::bindMethod('App\\Jobs\\FormBuilder\\FormBuilderCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\FormBuilder\\FormBuilderUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\FormBuilder\\FormBuilderDeleted@handle', fn ($job) => $job->handle());

        \App::bindMethod('App\\Jobs\\FormData\\FormDataCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\FormData\\FormDataUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\FormData\\FormDataDeleted@handle', fn ($job) => $job->handle());

        \App::bindMethod('App\\Jobs\\Tag\\TagCreated@handle', fn ($job) => $job->handle());

        $this->info("Formbuilder Jobs have been bound successfully.");
    }
    protected function bindCustomerJobs()
    {
        // Bind methods for the ProcessFlow jobs
        \App::bindMethod('App\\Jobs\\Customer\\CustomerCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\Customer\\CustomerUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\Customer\\CustomerDeleted@handle', fn ($job) => $job->handle());

        \App::bindMethod('App\\Jobs\\CustomerSite\\CustomerSiteCreated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\CustomerSite\\CustomerSiteUpdated@handle', fn ($job) => $job->handle());
        \App::bindMethod('App\\Jobs\\CustomerSite\\CustomerSiteDeleted@handle', fn ($job) => $job->handle());

        $this->info("Customer Jobs have been bound successfully.");
    }
}
