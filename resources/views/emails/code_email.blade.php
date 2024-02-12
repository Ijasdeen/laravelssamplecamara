@component('mail::message')
<h1>Your code has been sent</h1>
 
@component('mail::panel')
{{ $code }}
@endcomponent

 @endcomponent