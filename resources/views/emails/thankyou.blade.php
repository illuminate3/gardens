@component('mail::message')

## Thank You {{ucwords(strtolower($data['name']))}}

Thank you for completing the {{strtolower($data['form'])}} form on the McNearCommunity Gardens website.

If neccessary someone will contact you shortly about your message. 

@endcomponent