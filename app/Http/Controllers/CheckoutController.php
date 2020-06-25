<?php

namespace App\Http\Controllers;

use App\Book;
use App\Mail\BookShipping;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
  public function purchase(Request $request)
  {
    // 
    try {
      \Stripe\Stripe::setApiKey("sk_test_kQeGPyzUEtnwIWuGkSSnkEYy00MTZcMDFF");

      $customer = \Stripe\Customer::create([
        'email' => $request->token['email'],
        'source' => $request->token['id']
      ]);

      $charge = \Stripe\Charge::create([
        "amount" => $request->product['price'] * 100,
        "currency" => "usd",
        "customer" => $customer->id,
        "receipt_email" => $request->token['email'],
        "description" => $request->product['title'],
      ]);

      Log::channel('stderr')->info($request->token);
      // Log::channel('stderr')->info($charge);

      $requestedBook = Book::find($request->product['id']);
      // Mail::to($request->token['email'])->send(new BookShipping($requestedBook));
      // Mail::to($request->token['email'])->send();
      Mail::raw('Your Book', function ($message) use ($request,$requestedBook) {
        $message->from('eslamelkholy444@gmail.com');
        $message->to($request->token['email'])->subject('The Book you just ordered');
        $message->attach(public_path() . '/' . $requestedBook->bookPdf, ['as' => $requestedBook->title]);
        // $message->from('mahmoedmohamed19@gmail.com', 'Mahmoud Mohamed');
      });

      // $mailBody = "Welcome to our Website your Password is ". $password;
      // Mail::raw($mailBody, function ($message) use($userEmail) {
      // $message->from('eslamelkholy444@gmail.com', 'News Website');
      // $message->to($userEmail);
      // $message->subject('New Password');
      // }); 
      return response()->json(['data' => ['status' => 'success']]);
      // } catch (\Stripe\Exception\CardException $e) {
      //     // Since it's a decline, \Stripe\Exception\CardException will be caught
      //     echo 'Status is:' . $e->getHttpStatus() . '\n';
      //     echo 'Type is:' . $e->getError()->type . '\n';
      //     echo 'Code is:' . $e->getError()->code . '\n';
      //     // param is '' in this case
      //     echo 'Param is:' . $e->getError()->param . '\n';
      //     echo 'Message is:' . $e->getError()->message . '\n';
      // } catch (\Stripe\Exception\RateLimitException $e) {
      //     // Too many requests made to the API too quickly
      // } catch (\Stripe\Exception\InvalidRequestException $e) {
      //     // Invalid parameters were supplied to Stripe's API
      // } catch (\Stripe\Exception\AuthenticationException $e) {
      //     // Authentication with Stripe's API failed
      //     // (maybe you changed API keys recently)
      // } catch (\Stripe\Exception\ApiConnectionException $e) {
      //     // Network communication with Stripe failed
      // } catch (\Stripe\Exception\ApiErrorException $e) {
      //     // Display a very generic error to the user, and maybe send
      //     // yourself an email
    } catch (Exception $e) {
      Log::channel('stderr')->info($e);
      return response()->json(['data' => ['status' => 'error']]);
    }
  }
}
