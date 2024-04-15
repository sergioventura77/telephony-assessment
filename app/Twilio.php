<?php

namespace App;

use Twilio\Rest\Client;

class Twilio
{
    public function makeCall()
    {
        // Your implementation here
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');
        $sid = env("TWILIO_ACCOUNT_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
        $call = $twilio->calls
            ->create("+919586898683", // to
                $twilioPhoneNumber, // from
                [
                    "twiml" => "<?xml version='1.0' encoding='UTF-8'?><Response>
                        <Gather action='" . route('handle_call') . "' method='GET'>
                            <Say voice='Polly.Joanna-Neural'>Hello, press 1 for Forward the call to agent or press 2 for Record a voicemail!</Say>
                        </Gather>
                        <Say>We didn't receive any input. Goodbye!</Say>
                    </Response>"
                ]
            );
        return $call->sid;
    }

}
