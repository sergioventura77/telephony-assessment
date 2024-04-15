<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;
use Illuminate\Http\Request;

class TwilioController extends Controller
{

    public function make_call(){
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');
        $sid = env("TWILIO_ACCOUNT_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
        $url = env('APP_URL').'/handle-call';
        $call = $twilio->calls
        ->create("+919586898683", // to
                $twilioPhoneNumber, // from
                [
                    "twiml" => "<?xml version='1.0' encoding='UTF-8'?><Response>
                        <Gather action='" . $url . "' method='GET'>
                            <Say voice='Polly.Joanna-Neural'>Hello, press 1 for Forward the call to agent or pree 2 for Record a voicemail!
                            </Say>
                        </Gather>
                        <Say>We didn't receive any input. Goodbye!</Say>
                        </Response>"
                ]
        );
        print($call->sid);
    }

    public function handle_call(Request $request){

        $digits = $request->input('Digits', null);
        if($digits != null){
            if($digits == 1){
                $xml = "<?xml version='1.0' encoding='UTF-8'?><Response><Dial>+919586898683</Dial><Say>Your call have forwarding to your agent</Say></Response>";
                return $xml;
            }
            else if($digits == 2){
                $recordUrl = env('APP_URL').'/handle-record';
                $xml = "<?xml version='1.0' encoding='UTF-8'?><Response><Record action='".$recordUrl."' method='GET' /></Response>";
                return $xml;
            }
            else{
                $xml = "<?xml version='1.0' encoding='UTF-8'?><Response><Say>Invalid Choice!</Say></Response>";
                return $xml;
            }
        }
        else{
            $xml = "<?xml version='1.0' encoding='UTF-8'?><Response><Say>We didn't receive any input. Goodbye!</Say></Response>";
            return $xml;
        }
    }

    public function handle_record(Request $request)
    {
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');
        $sid = env("TWILIO_ACCOUNT_SID");
        $token = env("TWILIO_AUTH_TOKEN");

        $client = new Client($sid, $token);

        // Recording SID
        $recordingSid = $request->input('RecordingSid', null);

        // Fetch the recording details
        $recording = $client->recordings($recordingSid)->fetch();

        // Get the recording URL
        $recordingUrl = str_replace('.json',' ','https://api.twilio.com'.$recording->uri);

        // Set Twilio API URL and authentication headers
        $headers = [
            'Authorization: Basic ' . base64_encode("$sid:$token"),
        ];

        // Create a stream context to send the headers
        $context = stream_context_create([
            'http' => [
                'header' => $headers
            ]
        ]);
        // Fetch the recording content
        $recordingContent = file_get_contents($recordingUrl, false, $context);

        // Save the recording to a local file
        $savfile =  'recording/'.$recordingSid.'.mp3';

        $localFilePath = public_path($savfile); // Path to save the recording locally

        file_put_contents($localFilePath, $recordingContent);

        $originalUrl = url($savfile);

        $client = new Client($sid, $token);
        $client->messages->create(
            '+919586898683', // Replace with recipient's phone number
            array(
                'from' => $twilioPhoneNumber,
                'body' => 'Here is the recording of your call: '.$originalUrl
            )
        );
        return '';
    }

}
