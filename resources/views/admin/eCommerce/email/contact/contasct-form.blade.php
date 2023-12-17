@component('mail::message')
# Thanks for You Contact Messsage
<strong>Email:</strong>{{$data['email']}}
<strong>Subject:</strong>{{$data['subject']}}
<strong>Message:</strong> {{$data['description']}}
@endcomponent
