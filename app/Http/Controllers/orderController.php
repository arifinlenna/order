<?php

namespace App\Http\Controllers;

use Exception;
use Twilio\Http\Client;
use App\Mail\MyTestMail;
use Illuminate\Http\Request;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Facades\Mail;

class orderController extends Controller
{

    public function index()
    {
        try {
            $min = 1;
            $max = 10000;
            $order = rand($min, $max);
            $message = "Thank you for using ecommerce your order number is:" . $order;
            Amqp::publish('test', $message, ['queue' => 'test']);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
    public function notification()
    {
        try {
            Amqp::consume('test', function ($message, $resolver) {
                $details = [
                    'title' => 'Mail from laravel arifin rabbitmq',
                    'body' => $message->body
                ];
                Mail::to('arifingdr@gmail.com')->send(new MyTestMail($details));


                /*
                --> acknowledge
                proccess delivering from customers messaging
                -- data being process --
                */
                $resolver->acknowledge($message);

                /*
                --> stopWhenProcessed
                stop proccess delivering acknowledge
                */
                $resolver->stopWhenProcessed();
            });
            $data = [
                'status' => 'success',
            ];

            return response($data, 200);
        } catch (\Exception $exception) {
            dd($exception->getMessage());

            return response('error', 500);
        }
    }
}
