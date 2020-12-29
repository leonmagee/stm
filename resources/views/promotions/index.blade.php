@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Promotions</h3>

    <div class="coupons">
      @foreach($promotions as $promotion)
      <div class="coupon quill-coupon">
        <div class="coupon__item coupon__tag"><i class="fas fa-bullhorn"></i></div>
        <div class="coupon__item coupon__code">
          <div class="quill-text-wrap">
            {!! $promotion->text !!}
          </div>
        </div>
        <div class="coupon__item coupon__activate quill-activate">
          @if(!$promotion->active)
          <form method="POST" action="/start-promotion-non-coupon/{{ $promotion->id }}">
            @csrf
            <button class="start call-loader" type="submit">Start Promotion</button>
          </form>
          @else
          <form method="POST" action="/end-promotion-non-coupon/{{ $promotion->id }}">
            @csrf
            <button class="end call-loader" type="submit">End Promotion</button>
          </form>
          @endif
        </div>
        <div class="coupon__item coupon__icon coupon__delete modal-delete-open" item_id={{ $promotion->id }}><i
            class="fa fa-trash"></i></div>
      </div>

      <div class="modal" id="delete-item-modal-{{ $promotion->id }}">

        <div class="modal-background"></div>

        <div class="modal-content">

          <div class="modal-box">

            <h4 class="title modal-title">Are You Sure?</h4>

            <a href="/delete-promotion/{{ $promotion->id }}" class="button is-danger">Delete Promotion</a>
            <a class="modal-delete-close-button button is-primary" item_id={{ $promotion->id }}>Cancel</a>
          </div>

        </div>

        <button class="modal-delete-close is-large" aria-label="close" item_id={{ $promotion->id }}></button>

      </div>

      @endforeach

    </div>



    <div class="form-wrap-flex promotion-form-wrapper">
      <form method="POST" action="/add-promotion" id="new-promotion-form">
        @csrf
        <div class="field description">
          <label class="label" for="description">Promotion Text</label>
          <div class="control">
            <div id="quill_editor" class="quill-wrap"></div>
            <textarea class="textarea quill_text" id="promotion-text" name="text"></textarea>
          </div>
        </div>
        <div class="field">
          <button class="button is-primary" type="submit">Add Promotion</button>
        </div>
      </form>
    </div>


  </div>

</div>

</div>

@endsection

@section('page-script')
<script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>
<script>
  const quill_settings = {
    modules: {
    toolbar: [
    [{ header: [1, 2, 3, 4, false] }],
    ['bold', 'italic', 'underline', 'strike', 'link'],
    [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    ]
    },
    placeholder: 'Enter Promotion Text...',
    theme: 'snow'
    };
    new Quill('#quill_editor', quill_settings);
</script>

@endsection
