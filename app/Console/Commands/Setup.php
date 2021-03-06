<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\WorkStatus;
use App\Index;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates all the necessary database inserts so the application works as intended.';

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
     * @return void
     */
    public function handle()
    {
        $workStatuses = ['Plānotie darbi', 'Pašreizējie darbi', 'Pabeigtie darbi'];
        foreach ($workStatuses as $status)
        {
            WorkStatus::create([
                'status' => $status
            ]);

            $this->info($status . ' row added to the work_statuses table.');
        }

        Index::create([
            'section' => 'involve',
            'section_title' => 'Iesaisties!',
            'title' => 'Vidusskolai vajag tevi!',
            'body' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magni voluptatem doloribus cumque, minima repudiandae delectus alias dolore iusto facere ipsam, rem assumenda voluptatum dignissimos et quis ea nobis porro molestias.',
        ]);

        $this->info('Involve row added to indexes table.');

        Index::create([
            'section' => 'presentation',
            'section_title' => 'Nav prezentācijas'
        ]);

        $this->info('Presentation row added to indexes table.');

        Index::create([
            'section' => 'regulation',
            'section_title' => 'Nav nolikuma'
        ]);

        $this->info('Regulation row added to indexes table.');

        Index::create([
            'section' => 'parallax',
            'section_title' => 'Lapas attēls'
        ]);

        $this->info('Parallax row added to indexes table.');
    }
}
