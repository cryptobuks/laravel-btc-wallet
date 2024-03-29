@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Wallets
                  <a class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalGenerateWallet" href="#">New Wallet</a>
                </div>

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
                                                <a class="dropdown-item" href="{{ url('/wallet/transactions/'. $wallet->identifier) }}">Transactions</a>
                                                
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
      <form action="/wallet/generate/address" method="post">
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

<div class="modal" tabindex="-1" role="dialog" id="modalGenerateWallet">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Generate new wallet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/wallet/generate/new" method="post">
        @csrf
        <input type="hidden" id="wallet_id" name="wallet_id" /> 
        <div class="modal-body">
            <p>Want to create new wallet?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalSend">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Send</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <p id="errors" style="color: red;"></p>
        <p id="success" style="color: green;"></p>
        <p id="transactionContent">
          <form id="frmTransaction">
            <input type="hidden" id="senderWalletId" />
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="btc">Amount</label>
                  <input type="text" class="form-control" id="btc" placeholder="Amount">
                </div>
              <div class="form-group col-md-6">
                <label for="usd">USD Value</label>
                <input type="text" class="form-control" id="usd" placeholder="USD Value" readonly> 
              </div>
              </div>
              <div class="form-group">
                <label for="destination">Address</label>
                <input type="text" class="form-control" id="destination" placeholder="Enter destination address">
              </div>
              <div class="form-group">
                <label for="numblocks">Confirmation target</label>
                <select id="numblocks" class="form-control">
                  
                  @for ($i = 2; $i < 10; $i++)
                    <option value="{{$i}}">{{$i}} blocks</option>
                  @endfor
                  
                </select>
              </div>         
          </form>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success btn-create-transaction">Create Transaction</button>
      </div>
    </div>
  </div>
</div>


@endsection
