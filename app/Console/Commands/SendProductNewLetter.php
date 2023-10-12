<?php

namespace App\Console\Commands;

use App\Jobs\WeeklyProductNewMailJob;
use App\Models\Subscriber;
use App\Mail\ProductNewLetter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendProductNewLetter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-product-new-letter';

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
        WeeklyProductNewMailJob::dispatch()->onConnection('database');
        return 'weekly mails sent successfully';
    }
}
