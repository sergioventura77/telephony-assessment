<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Feature\TwilioIntegrationTest;
use Twilio\Rest\Client;
use App\Twilio;



class TwilioControllerTest extends TestCase
{
    public function testMakeCall()
    {
        $response = $this->get('/make-call');

        $response->assertStatus(200);
    }

}
