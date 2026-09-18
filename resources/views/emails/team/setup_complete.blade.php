<x-mail::message>
# Account Setup Complete

Hi {{ $member->first_name }},

Your account for **{{ $merchant->business_name ?? 'the Merchant Panel' }}** has been successfully set up. 

You can now log in using your email address (**{{ $member->email }}**) and the password you just created.

<x-mail::button :url="route('merchant.login')">
Log In to Dashboard
</x-mail::button>

If you did not perform this action or need any assistance, please contact your administrator.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
