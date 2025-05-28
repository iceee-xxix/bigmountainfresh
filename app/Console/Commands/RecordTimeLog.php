<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attemp;
use App\Models\User;
use Carbon\Carbon;
class RecordTimeLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:record-time-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        $currentDate = now()->toDateString();


        foreach ($users as $user) {
            Attemp::create([
                'users_id' => $user->id,
                'attemp_date' => $currentDate,
                'attemp_status' => 3,
            ]);
        }
    }
}
