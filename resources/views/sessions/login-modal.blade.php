<div class="modal" id="layout-modal">

  <div class="modal-background"></div>

  <div class="modal-content">

    <div class="modal-box">

      <img src="{{ URL::asset('img/gs-wireless.png') }}" />

      <form method="POST" action="/login">
        @csrf
        <div class="form-wrap">
          <div class="field">
            <label class="label" for="email">Email</label>
            <div class="control">
              <input class="input" type="email" id="email" name="email" required />
            </div>
          </div>

          <div class="field">
            <label class="label" for="password">Password</label>
            <div class="control">
              <input class="input" type="password" id="password" name="password" required />
            </div>
          </div>

          <div class="field margin-top-1-5">
            <div class="control">
              <button class="button is-primary call-loader" type="submit">Log In</button>
              <a href="#" class="modal-close-button button is-danger">Cancel</a>
            </div>
          </div>

          <a href="/password/reset">Reset Password</a>

          <div class="field">

            @include('layouts.errors')

          </div>

        </div>

      </form>

    </div>

  </div>

  <button class="modal-close is-large" aria-label="close"></button>

</div>
