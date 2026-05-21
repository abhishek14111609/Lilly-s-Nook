<x-mail::message>
    # Hello {{ $contactMessage->name }},

    Thank you for contacting {{ config('app.name') }}. We have reviewed your message and replied below.

    <x-mail::panel>
        {{ $replyMessage }}
    </x-mail::panel>

    If you need any further assistance, simply reply to this email and we will be happy to help.

    Best regards,<br>
    {{ config('app.name') }} Support Team
</x-mail::message>
