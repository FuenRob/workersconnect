@component('mail::message')
# Introduction

El usuario {{ $datas['userRequest']}} ha pedido vacaciones.

@component('mail::button', ['url' => $datas['url']])
Detalles
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent