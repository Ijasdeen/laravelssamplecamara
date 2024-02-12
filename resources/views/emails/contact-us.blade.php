@component('mail::message')
<h1>We have received your contact information</h1>
 
@component('mail::panel')

<h3>{{ $info['subject'] }}</h3>

<div>
{{ $info['message'] }}
</div>
@endcomponent  

 @endcomponent