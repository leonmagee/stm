@extends('layouts.layout')
@section('content')
@include('layouts.errors')
<div class="users-flex-wrap">
  <div class="users-left-content">
    <div class="single-user-wrap">
      <div class="item company">{{ $user->company}}</div>
      <div class="item role flex-wrap">
        <i class="fas fa-sitemap"></i>
        <span>{{ $role }}</span>
      </div>
      <div class="item name flex-wrap">
        <i class="fas fa-user"></i>
        <span>{{ $user->name }}</span>
      </div>
      @if($user->address || $user->city || $user->state || $user->zip)
      <div class="item address-wrap flex-wrap">
        <i class="fas fa-map-marker-alt"></i>
        <div class="address-wrap-inner">
          <div class="address">{{ $user->address }}</div>
          <div class="city_state_zip">
            {{ $user->city }}, {{ $user->state }} {{ $user->zip }}
          </div>
        </div>
      </div>
      @endif

      <div class="item email flex-wrap">
        <i class="far fa-envelope"></i>
        <span>{{ $user->email }}</span>
      </div>

      <div class="item phone flex-wrap">
        <i class="fas fa-phone"></i>
        <span>{{ $user->phone }}</span>
      </div>

      @if($bonus)
      <div class="item credit-bonus flex-wrap">
        <i class="fas fa-user-plus"></i>
        <span>Monthly Bonus: <span class="bonus-val">{{ $bonus }}</span></span>
      </div>
      @endif

      @if($credit)
      <div class="item credit-bonus flex-wrap">
        <i class="fas fa-user-minus"></i>
        <span>Outstanding Balance: <span class="credit-val">{{ $credit }}</span></span>
      </div>
      @endif

      <div class="item credit-bonus flex-wrap">
        <i class="fas fa-dollar-sign"></i>
        <span>Available STM Credit: <span class="bonus-val">${{ number_format($user->balance, 2) }}</span></span>
      </div>

    </div>

    @if(!$user->isAdminManagerEmployee())

    <div class="reports-wrap">

      @foreach( $recharge_data_array as $item )

      <div class="report-wrap reports-wrap-grid">
        <h3 class='recharge-title'>2nd Recharge</h3>

        <div class="recharge-details">

          @foreach($item['data'] as $data)

          <div class="recharge-item">
            <div class="item">
              <label>{!! $data['act_name'] !!}</label>
              <div class="count">{{ $data['act_count'] }}</div>
            </div>
            <div class="item">
              <label>{!! $data['rec_name'] !!}</label>
              <div class="count">{{ $data['rec_count'] }}</div>
            </div>
            <div class="item percent {{ $data['class'] }}">
              <span>{{ $data['percent'] }}%</span>
            </div>

          </div>

          @endforeach

        </div>

      </div>

      @endforeach

    </div>

    <div class="reports-wrap">

      @foreach( $third_recharge_data_array as $item )

      <div class="report-wrap">
        <h3 class='recharge-title'>3rd Recharge</h3>

        <div class="recharge-details">

          @foreach($item['data'] as $data)

          <div class="recharge-item">
            <div class="item">
              <label>{!! $data['act_name'] !!}</label>
              <div class="count">{{ $data['act_count'] }}</div>
            </div>
            <div class="item">
              <label>{!! $data['rec_name'] !!}</label>
              <div class="count">{{ $data['rec_count'] }}</div>
            </div>
            <div class="item percent {{ $data['class'] }}">
              <span>{{ $data['percent'] }}%</span>
            </div>

          </div>

          @endforeach

        </div>

      </div>

      @endforeach

    </div>
    @endif

  </div>

  <div class="notes-wrap">

    <label>STM Balance / Store Credit</label>
    <div class="transfer-balance">
      <div class="transfer-balance__row">
        <div class="transfer-balance__item transfer-balance__item--header flex-25 left">
          Your Balance
        </div>
        <div class="transfer-balance__item transfer-balance__item--header flex-25 left">
          Dealer Balance
        </div>
        <div class="transfer-balance__item transfer-balance__item--header">
          Dealer Store Credit
        </div>
      </div>
      <div class="transfer-balance__row">
        <div class="transfer-balance__item flex-25 left">
          <?php $your_balance = \Auth::user()->balance; ?>
          ${{ number_format($your_balance, 2) }}
        </div>
        <div class="transfer-balance__item flex-25 left">
          ${{ number_format($user->balance, 2) }}
        </div>
        <div class="transfer-balance__item">
          ${{ number_format($user->store_credit, 2) }}
        </div>
      </div>
      <div class="transfer-balance__form margin-top-1">
        <form method="POST" action="/transfer-balance">
          @csrf
          <div class="transfer-balance__row">
            <div class="balance-to-transfer">
              <input type="hidden" name="user_id" value="{{ $user->id }}" />
              <div class="field">
                <div class="control">
                  <input class="input" type="number" name='balance_to_transfer' step=".01" min="0"
                    max="{{ $your_balance }}" placeholder="Transfer to STM Balance" />
                </div>
              </div>
            </div>
            <div class="field">
              <a href="#" class="modal-open button is-danger">Submit</a>
            </div>
          </div>
          <div class="modal" id="layout-modal">
            <div class="modal-background"></div>
            <div class="modal-content">
              <div class="modal-box">
                <h3 class="title">Are You Sure?</h3>
                <button class="button is-danger call-loader" type="submit">Process Transfer</button>
                <a href="#" class="modal-close-button button is-primary">Cancel</a>
              </div>
            </div>
            <button class="modal-close is-large" aria-label="close"></button>
          </div>
        </form>
      </div>
      <div class="transfer-balance__form margin-top-1">
        <form method="POST" action="/transfer-store-credit">
          @csrf
          <div class="transfer-balance__row">
            <div class="balance-to-transfer">
              <input type="hidden" name="user_id" value="{{ $user->id }}" />
              <div class="field">
                <div class="control">
                  <input class="input" type="number" name='balance_to_transfer' step=".01" min="0"
                    max="{{ $your_balance }}" placeholder="Transfer to Store Credit" />
                </div>
              </div>
            </div>
            <div class="field">
              <a href="#" class="modal-open-2 button is-danger">Submit</a>
            </div>
          </div>
          <div class="modal" id="layout-modal-2">
            <div class="modal-background"></div>
            <div class="modal-content">
              <div class="modal-box">
                <h3 class="title">Are You Sure?</h3>
                <button class="button is-danger call-loader" type="submit">Process Transfer</button>
                <a href="#" class="modal-close-button button is-primary">Cancel</a>
              </div>
            </div>
            <button class="modal-close-2 is-large" aria-label="close"></button>
          </div>
        </form>
      </div>
    </div>

    <div class="notes-list-wrap">
      <label>Notes</label>
      @if($notes->count())
      @foreach($notes as $note)
      <div class="note">
        <div class="note-header">
          <span class="date">{{ $note->created_at->format('m/d/Y g:ia') }}</span>
          <span class="user">{{ $note->author }}</span>
        </div>
        <div class="note-body">{{ $note->text }}</div>
      </div>
      <div class="modal" id="delete-note-modal-{{ $note->id }}">

        <div class="modal-background"></div>

        <div class="modal-content">

          <div class="modal-box">

            <h3 class="title">Are You Sure?</h3>

            <a href="/delete-note/{{ $note->id }}" class="button is-danger">Delete Note</a>
            <a class="modal-delete-close-button button is-primary" note_id={{ $note->id }}>Cancel</a>
          </div>

        </div>

        <button class="modal-delete-close is-large" aria-label="close" note_id={{ $note->id }}></button>

      </div>
      @endforeach
      @else
      <div class="no-notes">No notes have been saved.</div>
      @endif
    </div>
  </div>

</div>

@endsection
