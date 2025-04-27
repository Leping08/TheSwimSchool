@component('mail::message')

# Lesson Error Details

@if(isset($exception))
---
**Error Details:**
Message: {{ $exception->getMessage() }}  
File: {{ $exception->getFile() }}  
Line: {{ $exception->getLine() }}

@php
  $trace = $exception->getTraceAsString();
@endphp

<details>
<summary>Stack Trace</summary>
<pre>{{ $trace }}</pre>
</details>
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
