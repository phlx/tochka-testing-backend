<?php namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;

class GenerateTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:tasks {--count=1000}';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate tasks test data';

    /**
     * Handle comsole command
     */
    public function handle(): void
    {
        $this->info('Generating tasks...');

        if (app()->runningInConsole()) {
            $flush = $this->anticipate('Flush all data from database?', ['yes', 'no'], 'yes');
            if ($flush === 'yes') {
                $table = (new Task())->getTable();
                /** @var DatabaseManager $db */
                $db = app('db');
                $db->table($table)->truncate();
                $this->info('Tasks flushed');
            }
        }

        app('db')->transaction(function () {
            $count = $this->option('count');
            $faker = Factory::create();
            $dateTime = Carbon::create();
            $statuses = ['todo', 'pending', 'testing', 'done', 'archived'];

            for ($iteration = 0; $iteration < $count; $iteration++) {
                $model = new Task();
                $model->title = $faker->bs;
                $model->date = $dateTime->addHour();
                $model->author = $faker->name;
                $model->description = $faker->text;
                $model->status = array_random($statuses);
                $model->save();
                $number = $iteration + 1;
                if ($number % 100 === 0) {
                    $this->info("Generated {$number} tasks");
                }
            }
        });

        $this->info('Done!');
    }
}
