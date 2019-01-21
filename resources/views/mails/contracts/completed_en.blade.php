@extends('mails.layout')


@section('content')

<p>Dear {{ $fullname }},<br/><br/>
We have processed your request <strong>#{{ $contract->number }}</strong> for the insurance for the trip to <strong>{{ \App\Library\AseguratuViaje\ATV::getRegionName($contract->quotation->destination_region_code) }}</strong> and your voucher has been sent to this e-mail address through our operator <strong>aseguratuviaje.com</strong>.</p>
<p>In said message you will find <strong>the voucher, the insurance coverage details, useful phone numbers</strong>, and all the necessary information to travel safely.</p>
<p>The message should take some minutes to arrive, and an hour at maximum. If you can't find it check your spam inbox or <a href="mailto:{{ __('front/support.contact_email') }}">contact us</a>.</p>
<p>Thank you for choosing us!<br/>
The Viajoasegurado.com team</p>

@endsection