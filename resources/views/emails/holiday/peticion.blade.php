@component('mail::message')
# Introduction

Tus vacaciones han sido enviadas para validar.

@component('mail::button', ['url' => $datas['url']])
Detalles
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
