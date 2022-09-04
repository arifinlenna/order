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
                // $sid = 'ACf3ba81136a16388fc91a87e921d0254b';
                // $token = '822b5d4253b6f4f604caaded8cd7a7e7';
                // $client = new Client($sid, $token);

                // // Use the client to do fun stuff like send text messages!
                // $client->messages->create(
                //     // the number you'd like to send the message to
                //     '+9771234567890',
                //     [
                //         'from' => '+1234567890',
                //         'body' => $message->body,
                //     ]
                // );
                $details = [
                    'title' => 'Mail from laravel arifin rabbitmq',
                    'body' => $message->body
                ];

                Mail::to('arifingdr@gmail.com')->send(new MyTestMail($details));

                // dd("Email is Sent.");

                $resolver->acknowledge($message);

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
