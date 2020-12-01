@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>Edit Plan</h3>

    <form method="POST" action="/update-plan/{{ $plan->id }}">

      <div class="form-wrap">

        @csrf

        <div class="form-wrap-flex">

          <div class="field sixth">
            <label class="label" for="carrier">Carrier</label>
            <div class="select">
              <select name="carrier_id" id="carrier">
                @foreach ($carriers as $carrier)
                <option @if ($plan->carrier_id == $carrier->id )
                  selected="selected"
                  @endif
                  value="{{ $carrier->id }}">{{ $carrier->name }}
                </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="field sixth">
            <label class="label" for="value">Value</label>
            <div class="control">
              <input class="input" value="{{ $plan->value }}" type="text" id="value" name="value" />
            </div>
          </div>

          <div class="field sixth">
            <label class="label" for="value">1st Spiff</label>
            <div class="control">
              <input class="input" value="{{ $plan->spiff_1 }}" type="text" id="spiff_1" name="spiff_1" />
            </div>
          </div>

          <div class="field sixth">
            <label class="label" for="value">2nd Spiff</label>
            <div class="control">
              <input class="input" value="{{ $plan->spiff_2 }}" type="text" id="spiff_2" name="spiff_2" />
            </div>
          </div>

          <div class="field sixth">
            <label class="label" for="value">3rd Spiff</label>
            <div class="control">
              <input class="input" value="{{ $plan->spiff_3 }}" type="text" id="spiff_3" name="spiff_3" />
            </div>
          </div>

          <div class="field sixth">
            <label class="label" for="value">4th Spiff</label>
            <div class="control">
              <input class="input" value="{{ $plan->spiff_4 }}" type="text" id="spiff_4" name="spiff_4" />
            </div>
          </div>

          <div class="field fifth">
            <label class="label" for="value">RTR Percent</label>
            <div class="control">
              <input class="input" value="{{ $plan->rtr }}" type="text" id="rtr" name="rtr" />
            </div>
          </div>

          <div class="field fifth">
            <label class="label" for="value">RTR Description</label>
            <div class="control">
              <input class="input" value="{{ $plan->rtr_d }}" type="text" id="rtr_d" name="rtr_d" />
            </div>
          </div>

          <div class="field fifth">
            <label class="label" for="value">Life Percent</label>
            <div class="control">
              <input class="input" value="{{ $plan->life }}" type="text" id="life" name="life" />
            </div>
          </div>

          <div class="field fifth">
            <label class="label" for="value">Life Description</label>
            <div class="control">
              <input class="input" value="{{ $plan->life_d }}" type="text" id="life_d" name="life_d" />
            </div>
          </div>

          <div class="field fifth">
            <label class="label" for="value">Port In Spiff</label>
            <div class="control">
              <input class="input" value="{{ $plan->port }}" type="text" id="port" name="port" />
            </div>
          </div>

          <div class="field half">
            <label class="label" for="value">Feature 1</label>
            <div class="control">
              <input class="input" value="{{ $plan->feature_1 }}" type="text" id="feature_1" name="feature_1" />
            </div>
          </div>

          <div class="field half">
            <label class="label" for="value">Feature 2</label>
            <div class="control">
              <input class="input" value="{{ $plan->feature_2 }}" type="text" id="feature_2" name="feature_2" />
            </div>
          </div>

          <div class="field half">
            <label class="label" for="value">Feature 3</label>
            <div class="control">
              <input class="input" value="{{ $plan->feature_3 }}" type="text" id="feature_3" name="feature_3" />
            </div>
          </div>

          <div class="field half">
            <label class="label" for="value">Feature 4</label>
            <div class="control">
              <input class="input" value="{{ $plan->feature_4 }}" type="text" id="feature_4" name="feature_4" />
            </div>
          </div>

          <div class="field half">
            <label class="label" for="value">Feature 5</label>
            <div class="control">
              <input class="input" value="{{ $plan->feature_5 }}" type="text" id="feature_5" name="feature_5" />
            </div>
          </div>

          <div class="field half padding-bottom">
            <label class="label" for="value">Feature 6</label>
            <div class="control">
              <input class="input" value="{{ $plan->feature_6 }}" type="text" id="feature_6" name="feature_6" />
            </div>
          </div>

        </div>

        <div class="field flex-margin">
          <div class="control">
            <button class="button is-primary call-loader" type="submit">Update</button>
            <a href="#" class="modal-open button is-danger margin-left">Delete Plan</a>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection

@section('modal')

<h3 class="title">Are You Sure?</h3>

<a href="/plan/destroy/{{ $plan->id }}" id="delete-plan" class="button is-danger call-loader">Delete Plan</a>
<a href="#" class="modal-close-button button is-primary">Cancel</a>

@endsection
