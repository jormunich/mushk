<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('New Contact Form Submission') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #2c3e50; border-bottom: 3px solid #3498db; padding-bottom: 10px;">
        {{ __('New Contact Form Submission') }}
    </h1>
    
    <p>{{ __('You have received a new contact form submission from your website.') }}</p>
    
    <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #3498db; margin: 20px 0;">
        <p style="margin: 5px 0;"><strong>{{ __('Name') }}:</strong> {{ $contact->name }}</p>
        <p style="margin: 5px 0;"><strong>{{ __('Email') }}:</strong> {{ $contact->email }}</p>
        @if($contact->phone)
        <p style="margin: 5px 0;"><strong>{{ __('Phone') }}:</strong> {{ $contact->phone }}</p>
        @endif
    </div>
    
    <div style="margin: 20px 0;">
        <h3 style="color: #2c3e50;">{{ __('Message') }}:</h3>
        <p style="background-color: #f5f5f5; padding: 15px; border-radius: 5px; white-space: pre-wrap;">{{ $contact->message }}</p>
    </div>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
    
    <p style="color: #7f8c8d; font-size: 14px;">
        {{ __('Submitted on') }}: {{ $contact->created_at->format('F d, Y \a\t g:i A') }}
    </p>
    
    <p style="margin-top: 30px;">
        {{ __('Thanks') }},<br>
        <strong>{{ config('app.name') }}</strong>
    </p>
</body>
</html>


