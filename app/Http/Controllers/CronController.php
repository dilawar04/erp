<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CronController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    function send_email(){



		$HTML = '<h3 class="block-text-cols__title">Contact Us</h3>
		<p>These addresses are for contributing patches or reporting problems about V8 sendmail. The members of these lists do not have the resources to support vendor versions. Before sending to any of these addresses, please check the <a href="www.proofpoint.com/us/sendmail/faq">FAQ</a> and the files README, sendmail/README (on this web-site as Compiling Sendmail) and cf/README (on this web-site as the Configuration README pages) to see if they are already answered; about half of the questions received can be answered in this way.</p>';

        \Mail::html($HTML, function ($message) {
            $message->from('', 'Tour');
            $message->to('to@gmail.com', '');
            $message->subject('Mail::html');
        });

		dump(\Mail::failures());

        dump('Call Mail');
    }

}
