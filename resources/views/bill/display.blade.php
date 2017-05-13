@extends('layouts.pdf')

@section('content')
    <div class="page-header">
        <h3>Bill No: {{$bill->bill_no}}</h3>
    </div>
    <div class="row">
        <div class="col-xs-7">
            <div class="panel panel-info">
                <div class="panel-heading">Tenant</div>
                <div class="panel-body">
                    <p>Full Name: {{$contract->Tenant()->first()->full_name}}</p>
                    <p>Address: {{$contract->Tenant()->first()->fullAddress()}}</p>
                </div>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="panel panel-info">
                <div class="panel-heading">Contract</div>
                <div class="panel-body">
                    <p>Contract No: {{$contract->contract_no}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <table class="table table-condensed">
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Mode</th>
                <th>Bank</th>
                <th>Period</th>
                <th>Amount</th>
            </tr>
            @foreach($bill->payments()->get() as $payment)
                <tr>
                    <td>{{$payment->payment_no}}</td>
                    <td>{{$payment->effectivity_date}}</td>
                    <td>{{$payment->full_payment_mode}}</td>
                    <td>{{$payment->bank}}</td>
                    <td>
                        {{\Carbon\Carbon::parse($payment->period_start)->toDateString()}} -
                        {{\Carbon\Carbon::parse($payment->period_end)->toDateString()}}</td>
                    <td>{{$payment->amount}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection





