# VoIP Phone Application

This is a simplified VoIP phone application built with PHP/Laravel and Twilio.

## Setup Instructions

1. Clone the repository: `git clone https://github.com/sergioventura77/telephony-assessment.git`
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env` and configure your Twilio credentials and phone number
4. Change current server URL to the `APP_URL` in the `.env` file.
5. Run migrations: `php artisan migrate`
6. Start the development server: `php artisan serve`

## Running the Application

1. To make a call, visit `/make-call` route.
2. Follow the instructions to forward the call to an agent or record a voicemail.

## Twilio Setup

1. Create a Twilio account at https://www.twilio.com/try-twilio
2. Get phone number,sid,auth Token from twilio and configure it in your `.env` file.
3. Use ngrok or a personal internet server to handle inbound HTTP requests from Twilio.

## Testing

Run PHPUnit tests with `php artisan test`.

## Architecture

The application uses Laravel for the backend and Twilio for telephony services. Calls are initiated through Twilio, and users can choose to forward the call or record a voicemail.

For detailed technical documentation, refer to the codebase and inline comments.
