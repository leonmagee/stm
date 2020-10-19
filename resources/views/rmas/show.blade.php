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
          <div class="stm_inv__header--item"><a href="/purchases/{{ $rma->product->purchase_id }}">View</a></div>
          <div class="stm_inv__header--item stm_inv__header--item-status-{{ $rma->status }}">
            {{ \App\Helpers::rma_status($rma->status) }}
          </div>
        </div>
      </div>

      <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label stm_inv__flex--20">Product</div>
          <div class="stm_inv__header--label">Color</div>
          <div class="stm_inv__header--label">Unit Cost</div>
          <div class="stm_inv__header--label">Quantity</div>
          <div class="stm_inv__header--label">Discount</div>
          <div class="stm_inv__header--label">Total</div>
          @if(count($rma->imeis))
          <div class="stm_inv__header--label stm_inv__flex--15">IMEI / Serial Number</div>
          @endif
        </div>

        <div class="stm_inv__flex">
          <div class="stm_inv__header--item stm_inv__flex--20">{{ $rma->product->name }}</div>
          <div class="stm_inv__header--item">{{ $rma->product->variation }}</div>
          <div class="stm_inv__header--item">${{ number_format($rma->product->unit_cost, 2) }}</div>
          <div class="stm_inv__header--item">{{ $rma->quantity }}</div>
          <div class="stm_inv__header--item">{{ $rma->product->discount }}%</div>
          <div class="stm_inv__header--item">
            ${{ number_format($rma->quantity * \App\Helpers::get_discount_price($rma->product->unit_cost, $rma->product->discount), 2) }}
          </div>
          @if(count($rma->imeis))
          <div class="stm_inv__header--item stm_inv__flex--15">
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

      {{-- <div class="stm_inv__items">
        <div class="stm_inv__flex">
          <div class="stm_inv__item--label stm_inv__flex--60">Product Name</div>
          <div class="stm_inv__item--label">Color</div>
          <div class="stm_inv__item--label">Unit Price</div>
          <div class="stm_inv__item--label">Quantity</div>
          <div class="stm_inv__item--label">Subtotal</div>
          <div class="stm_inv__item--label">Discount</div>
          <div class="stm_inv__item--label">Item Total</div>
        </div>

        @foreach($rma->products as $product)
        <div class="stm_inv__flex stm_inv__flex-{{ $product->id }}">
      <div class="stm_inv__item--item stm_inv__flex--60">{{ $product->name }}</div>
      <div class="stm_inv__item--item">{{ $product->variation }}</div>
      <div class="stm_inv__item--item ">${{ number_format($product->unit_cost, 2) }}</div>
      <div class="stm_inv__item--item">{{ $product->quantity }}</div>
      <div class="stm_inv__item--item">${{ number_format($product->unit_cost * $product->quantity, 2) }}</div>
      <div class="stm_inv__item--item">{{ $product->discount ? $product->discount . '%' : '' }}</div>
      <div class="stm_inv__item--item">${{ number_format($product->final_cost, 2) }}</div>
    </div>
    @endforeach
  </div> --}}

  {{-- <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label">Payment Type</div>
          <div class="stm_inv__header--label">Subtotal</div>
          <div class="stm_inv__header--label">Service Charge</div>
          <div class="stm_inv__header--label">Total</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item">{{ strtoupper($rma->type) }}
</div>
<div class="stm_inv__header--item">${{ number_format($rma->sub_total, 2) }}</div>
<div class="stm_inv__header--item stm_inv__header--item-red">
  ${{ number_format($rma->sub_total * 2 / 100, 2) }}</div>
<div class="stm_inv__header--item">${{ number_format($rma->total, 2) }}</div>
</div>
</div> --}}

{{-- <div class="stm_inv__header margin-top-1-5">
        <div class="stm_inv__flex">
          <div class="stm_inv__header--label stm_inv__flex--30">Shipping Address</div>
          <div class="stm_inv__header--label">City</div>
          <div class="stm_inv__header--label">State</div>
          <div class="stm_inv__header--label">Zip</div>
          <div class="stm_inv__header--label">Tracking Number</div>
          <div class="stm_inv__header--label">Shipping Service</div>
        </div>
        <div class="stm_inv__flex">
          <div class="stm_inv__header--item stm_inv__flex--30">{{ $rma->user->address  }}
</div>
<div class="stm_inv__header--item">{{ $rma->user->city }}</div>
<div class="stm_inv__header--item">{{ $rma->user->state }}</div>
<div class="stm_inv__header--item">{{ $rma->user->zip }}</div>
<div class="stm_inv__header--item">{{ $rma->tracking_number }}</div>
<div class="stm_inv__header--item">{{ $rma->shipping_type }}</div>
</div>
</div> --}}

<div class="stm_inv__flex--forms">

  <div class="stm_inv__form stm_inv__form--buttons">
    <button class="button is-green modal-open-rma-approve">Approve RMA</button>
    <button class="button is-danger modal-open-rma-reject">Reject RMA</button>
  </div>

  <div class="modal" id="rma-approve-modal">

    <div class="modal-background"></div>

    <div class="modal-content">

      <div class="modal-box">

        <h4 class="title">Are You Sure?</h4>

        <form method="POST" action="/update-rma-status-approve/{{ $rma->id }}">
          @csrf
          <label class="label">Message</label>
          <?php $message = 'Your RMA has been approved.'; ?>
          <textarea class="textarea" name="rma_message">{{ $message }}</textarea>
          <button type="submit" class="button is-danger margin-top-1-5 call-loader">Approve RMA</button>
        </form>

        <a class="modal-rma-approve-close button is-primary">Cancel</a>
      </div>

    </div>

    <a id="modal-close-rma-approve-icon" class="modal-close is-large" aria-label="close"></a>

  </div>

  <div class="modal" id="rma-reject-modal">

    <div class="modal-background"></div>

    <div class="modal-content">

      <div class="modal-box">

        <h4 class="title">Are You Sure?</h4>

        <form method="POST" action="/update-rma-status-reject/{{ $rma->id }}">
          @csrf
          <label class="label">Message</label>
          <?php $message = 'Your RMA has been rejected.'; ?>
          <textarea class="textarea" name="rma_message">{{ $message }}</textarea>
          <button type="submit" class="button is-danger margin-top-1-5 call-loader">Reject RMA</button>
        </form>

        <a class="modal-rma-reject-close button is-primary">Cancel</a>
      </div>

    </div>

    <a id="modal-close-rma-reject-icon" class="modal-close is-large" aria-label="close"></a>

  </div>


  <div class="stm_inv__form stm_inv__flex--forms-item stm_inv__flex--forms-grow margin-horizontal">
    @if($rma->notes->count())
    @foreach($rma->notes as $note)
    <div class="rma-note">
      <div class="note-header">
        <span class="date">{{ $note->created_at->format('m/d/Y g:ia') }}</span>
        <span class="user">{{ $note->author }}</span>
        <span class="icon">
          @if(Auth()->user()->isAdmin())
          <i class="fas fa-times-circle modal-delete-open" item_id={{ $note->id }}></i>
          @endif
        </span>
      </div>
      <div class="note-body">{{ $note->text }}</div>
    </div>
    <div class="modal" id="delete-item-modal-{{ $note->id }}">

      <div class="modal-background"></div>

      <div class="modal-content">

        <div class="modal-box">

          <h3 class="title">Are You Sure?</h3>

          <a href="/delete-rma-note/{{ $note->id }}" class="button is-danger">Delete Note</a>
          <a class="modal-delete-close-button button is-primary" item_id={{ $note->id }}>Cancel</a>
        </div>

      </div>

      <button class="modal-delete-close is-large" aria-label="close" item_id={{ $note->id }}></button>

    </div>
    @endforeach
    @else
    <div class="no-notes">No notes have been saved.</div>
    @endif
    <form method="POST" action="/add-rma-note/{{ $rma->id }}">
      @csrf
      <div class="stm_inv__forms-no-flex">
        <input type="hidden" name="purchase_id" value="{{ $rma->id }}" />
        <div class="field">
          <label class="label" for="note">New RMA Note</label>
          <div class="control">
            <textarea class="textarea" name="note"></textarea>
          </div>
        </div>
        <div class="field flex-margin margin-top-1">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Add Note</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="stm_inv__form stm_inv__flex--forms-item stm_inv__flex--forms-status">
    <form method="POST" action="/update-rma-status/{{ $rma->id }}">
      @csrf
      <div class="stm_inv__forms-no-flex">
        <input type="hidden" name="purchase_id" value="{{ $rma->id }}" />
        <div class="field">
          <label class="label" for="status">RMA Status</label>
          <div class="select">
            <select name="status" id="status">
              <option value="2" @if($rma->status == 2) selected @endif>Pending</option>
              <option value="3" @if($rma->status == 3) selected @endif>Approved</option>
              <option value="4" @if($rma->status == 4) selected @endif>Rejected</option>
              <option value="1" @if($rma->status == 1) selected @endif>Completed</option>
            </select>
          </div>
        </div>
        <div class="field flex-margin margin-top-1">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Update Status</button>
          </div>
        </div>
      </div>
    </form>
  </div>


</div>


</div>
</div>

</div>

@endsection
