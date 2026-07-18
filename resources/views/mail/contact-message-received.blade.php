<x-mail::message>
# New Contact Message

You received a new message through your portfolio.

**From:** {{ $contactMessage->name }} ({{ $contactMessage->email }})
**Subject:** {{ $contactMessage->subject ?: 'No subject' }}

<x-mail::panel>
{{ $contactMessage->message }}
</x-mail::panel>

Received at {{ $contactMessage->created_at->toDayDateTimeString() }}.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
