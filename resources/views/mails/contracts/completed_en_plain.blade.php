Dear {{ $fullname }},\r\n
\r\n
We have processed your request #{{ $contract->number }} for the insurance for the trip to {{ \App\Library\AseguratuViaje\ATV::getRegionName($contract->quotation->destination_region_code) }} and your voucher has been sent to this e-mail address through our operator aseguratuviaje.com.\r\n
\r\n
In said message you will find the voucher, the insurance coverage details, useful phone numbers, and all the necessary information to travel safely.\r\n
\r\n
The message should take some minutes to arrive, and an hour at maximum. If you can't find it check your spam inbox or contact us: {{ __('front\support.contact_email') }}.\r\n
\r\n
Thank you for choosing us!\r\n
The Viajoasegurado.com team