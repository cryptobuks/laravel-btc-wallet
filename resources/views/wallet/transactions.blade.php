@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Transactions
                </div>

                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr> 
                                <th>Sender</th>
                                <th>Receiver</th>
                                <th>Amount</th>
                                <th>Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($transactions as $transaction) 
                                <tr> 
                                    <td>{{ $transaction->sender_address }}</td>
                                    <td>{{ $transaction->receiver_address }}</td>
                                    <td>{{ number_format($transaction->amount / $wallet->currency->units, 8) }}</td>
                                    <td>{{ number_format($transaction->fee / $wallet->currency->units, 8) }}</td> 
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                         
                 </div>
            </div>
        </div>
    </div>
</div>
 

@endsection
