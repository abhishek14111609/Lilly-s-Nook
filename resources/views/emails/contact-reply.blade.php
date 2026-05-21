<x-mail::message>
# Hello {{ $contactMessage->name }},

Thank you for reaching out to us. 

{{ $replyMessage }}

<br>
Best regards,<br>
{{ config('app.name') }} Team
</x-mail::message>
