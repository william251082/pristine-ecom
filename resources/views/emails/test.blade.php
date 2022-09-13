@component('mail::message')
#Introduction

Body of message

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{config('app.name')}}
@endcomponent

