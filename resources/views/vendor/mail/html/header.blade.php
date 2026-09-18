@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('assets/images/logo-with-text.png') }}" class="logo" alt="Q4I Logo" style="height: 40px; width: auto; max-width: 100%;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
