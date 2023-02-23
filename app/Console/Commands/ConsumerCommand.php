<?php

namespace App\Console\Commands;

use App\Mail\MyTestMail;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        try {
            Amqp::consume('test', function ($message, $resolver) {
                $details = [
                    'title' => 'Mail from laravel arifin rabbitmq',
                    'body' => $message->body
                ];

                Mail::to('arifingdr@gmail.com')->send(new MyTestMail($details));

                $resolver->acknowledge($message);

                $resolver->stopWhenProcessed();
            });

            return 0;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
