@extends('mails.layout')


@section('content')

La contratación <a href="{{ 'https://backoffice.'.config('app.domain').'/contract/'.$contract->id }}">#{{ $contract->number }}</a> fue pagada exitosamente por <strong>${{ $paymentRequest->total_ammount }}</strong>. El cliente aguarda el voucher.

@endsection