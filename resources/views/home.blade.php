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
                                <th>Receive Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wallets as $wallet) 
                                <tr>
                                    <td>{{ $wallet->identifier }}</td>
                                    <td>{{ $wallet->currency->currency }}</td>
                                    <td>{{ $wallet->balance / $wallet->currency->units}} {{ $wallet->currency->code }}</td>
                                    <td>{{ $wallet->addresses->sortByDesc('id')->first()->address }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Select Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item btn-send" data-id="{{ $wallet->identifier }}" href="#">Send</a>
                                                <a class="dropdown-item btn-generate" data-id="{{$wallet->identifier}}" href="#">Generate new receive address</a>
                                                <a class="dropdown-item" href="{{ url('/transactions/'. $wallet->identifier) }}">Transactions</a>
                                                
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                         
                 </div>
            </div>
        </div>
    </div>
</div>
 
<div class="modal" tabindex="-1" role="dialog" id="modalGenerate">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Generate new receiving address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/wallet/generate" method="post">
        @csrf
        <input type="hidden" id="wallet_id" name="wallet_id" /> 
        <div class="modal-body">
            <p>Are you sure about this?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Generate</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


@endsection
