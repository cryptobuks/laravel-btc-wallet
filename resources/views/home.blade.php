@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Wallets</div>

                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Wallet ID</th>
                                <th>Currency</th>
                                <th>Balance</th>
                                <th>Receive Address</h1>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wallets as $wallet) 
                                <tr>
                                    <td>{{ $wallet->identifier }}</td>
                                    <td>{{ $wallet->currency->currency }}</td>
                                    <td>{{ $wallet->balance}} {{ $wallet->currency->code }}</td>
                                    <td>{{ $wallet->addresses->sortByDesc('id')->last()->address }}</td>
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
