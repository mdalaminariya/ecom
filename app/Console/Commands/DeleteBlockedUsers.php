<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeleteBlockedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-blocked-users';

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
        $date = Carbon::now()->subDays(1);// Adjust the number of days as needed

        User::where('blocked', true)
            ->where('blocked_at', '<=', $date)
            ->delete();

        $this->info('Blocked users older than 30 days deleted.');
    }
}
