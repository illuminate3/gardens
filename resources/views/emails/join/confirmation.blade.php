@component('mail::message')

## Thank You {{ucwords(strtolower($data['name']))}}

Thank you for completing the {{strtolower($data['form'])}} form on the McNearCommunity Gardens website.  
Please confirm your application by clicking on this button.
@component('mail::button', ['url' => route('join.confirmation',$data['confirmation_code']), 'color' => 'blue'])
Confirm Your Application
@endcomponent
 or by <a href="{!! route('join.confirmation',$data['confirmation_code']) !!}">clicking on this link</a> 

You will be then added to the wait list and we will keep you posted as the list changes.  Please notify us if your plans change by emailing us at info@mcneargardens.com. 

@endcomponent