@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>RMA</h3>

    <div class="stm_inv">
      <div class="stm_inv__header">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">RMA #</div>
          <div class="stm_inv__header--label">Company</div>
          <div class="stm_inv__header--label">Name</div>
          <div class="stm_inv__header--label">RMA Date</div>
          <div class="stm_inv__header--label">Purchase Order</div>
          <div class="stm_inv__header--label">Status</div>
        </div>

        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">RMA-GSW-{{ $rma->id }}</div>
          <div class="stm_inv__header--item">{{ $rma->user->company }}</div>
          <div class="stm_inv__header--item">{{ $rma->user->name }}</div>
          <div class="stm_inv__header--item">{{ $rma->created_at->format('M d, Y') }}</div>
          <div class="stm_inv__header--item"><a href="/dealer-purchases/{{ $rma->product->purchase_id }}">View</a></div>
          <div class="stm_inv__header--item stm_inv__header--item-status-{{ $rma->status }}">
            {{ \App\Helpers::rma_status($rma->status) }}
          </div>
        </div>
      </div>

      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Product</div>
          <div class="stm_inv__header--label">Color</div>
          <div class="stm_inv__header--label">Quantity</div>
          @if(count($rma->imeis))
          <div class="stm_inv__header--label">IMEI / Serial Number</div>
          @endif
        </div>

        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">{{ $rma->product->name }}</div>
          <div class="stm_inv__header--item">{{ $rma->product->variation }}</div>
          <div class="stm_inv__header--item">{{ $rma->quantity }}</div>
          @if(count($rma->imeis))
          <div class="stm_inv__header--item">
            @foreach($rma->imeis as $imei)
            <div>{{ $imei }}</div>
            @endforeach
          </div>
          @endif
        </div>
      </div>

      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Reason for Return</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">{{ $rma->explanation }}</div>
        </div>
      </div>

      <div class="stm_inv__flex--forms">

        <div class="stm_inv__form stm_inv__flex--forms-item stm_inv__flex--forms-grow">
          @if($rma->notes->count())
          @foreach($rma->notes as $note)
          <div class="rma-note">
            <div class="note-header">
              <span class="date">{{ $note->created_at->format('m/d/Y g:ia') }}</span>
              <span class="user">{{ $note->author }}</span>
            </div>
            <div class="note-body">{{ $note->text }}</div>
          </div>

          @endforeach
          @else
          <div class="no-notes">No notes have been saved.</div>
          @endif

        </div>




      </div>


    </div>
  </div>

</div>

@endsection
