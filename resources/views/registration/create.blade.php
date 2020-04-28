@extends('layouts.layout')

@section('content')

@include('layouts.errors')

<div class="form-wrapper">

  <div class="form-wrapper-inner">

    <h3>New User Registration</h3>

    <form method="POST" action="/register" id="stm_reg_form">

      <div class="form-wrap">

        {{ csrf_field() }}

        <div class="form-wrap-flex">

          <div class="field">
            <label class="label" for="name">Name</label>
            <div class="control">
              <input class="input" type="text" id="name" name="name" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="email">Email</label>
            <div class="control">
              <input class="input" type="email" id="email" name="email" autocomplete="false" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="company">Company</label>
            <div class="control">
              <input class="input" type="text" id="company" name="company" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="role_id">Site</label>
            <div class="select">
              <select name="role_id" id="role_id">
                @foreach ($sites_array as $site)
                <option value="{{ $site['role'] }}" @if ($current_site_id==$site['site']) selected="selected" @endif>
                  {{ $site['name'] }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="field">
            <label class="label" for="phone">Phone Number</label>
            <div class="control">
              <input class="input" type="number" id="phone" name="phone" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="address">Address</label>
            <div class="control">
              <input class="input" type="text" id="address" name="address" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="city">City</label>
            <div class="control">
              <input class="input" type="text" id="city" name="city" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="state">State</label>
            <div class="select">
              <select name="state" id="state">
                @foreach ($states as $state)
                <option value="{{ $state }}">{{ $state }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="field">
            <label class="label" for="zip">Zip</label>
            <div class="control">
              <input class="input" type="text" id="zip" name="zip" />
            </div>
          </div>

          <div class="field">
            <label class="label" for="password">Password</label>
            <div class="control">
              <input class="input" type="password" id="password" name="password" autocomplete="false" />
            </div>
          </div>

          <div class="field last-item">
            <label class="label" for="password_2">Password Confirm</label>
            <div class="control">
              <input class="input" type="password" id="password_2" name="password_confirmation" />
            </div>
          </div>

        </div>

        <div class="field flex-margin">
          <div class="control">
            <button class="button is-primary" type="submit">Register</button>
          </div>
        </div>

      </div>

    </form>

  </div>

</div>

@endsection

@section('page-script')

<script>
  $('#stm_reg_form').submit( function(e) {

		$('.stm-absolute-wrap#loader-wrap').css({'display':'flex'});

		$('.notification.is-danger').hide();

		$('.notification.is-success').hide();

		e.preventDefault();

		var reg_name = $('.form-wrap-flex #name').val();
		var reg_email = $('.form-wrap-flex #email').val();
		var reg_company = $('.form-wrap-flex #company').val();
		var reg_role_id = $('.form-wrap-flex #role_id').val();
		var reg_phone = $('.form-wrap-flex #phone').val();
		var reg_address = $('.form-wrap-flex #address').val();
		var reg_city = $('.form-wrap-flex #city').val();
		var reg_state = $('.form-wrap-flex #state').val();
		var reg_zip = $('.form-wrap-flex #zip').val();
		var reg_password = $('.form-wrap-flex #password').val();
		var reg_password2 = $('.form-wrap-flex #password_2').val();

		console.log(reg_password);
		console.log(reg_password2);

    	var token = document.head.querySelector('meta[name="csrf-token"]');
		window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

		//return false;

		axios({
			method: 'post',
			url: '/register',
			data: {
				name: reg_name,
				email: reg_email,
				company: reg_company,
				role_id: reg_role_id,
				phone: reg_phone,
				address: reg_address,
				city: reg_city,
				state: reg_state,
				zip: reg_zip,
				password: reg_password,
				password_confirmation: reg_password2
			}
		}).then(response => {

			console.log(response);

			$('.stm-absolute-wrap#loader-wrap').hide();

			var notification =
			'<div class="notification is-success">' +
			'<button class="delete"></button>' +
			'A new user account has been created! <a href="/users/' + response.data + '">View User</a>' +
			'</div>';

			$('.stm-body div#content').prepend(notification);

			$('.notification .delete').click(function() {
				$(this).parent().fadeOut();
			});

		}).catch(error => {

			$('.stm-absolute-wrap#loader-wrap').hide();

			console.log(error);

			let error_messages = '';

			let errors_obj = error.response.data.errors;

			for (var property in errors_obj) {
			    if (errors_obj.hasOwnProperty(property)) {
			        console.log(errors_obj[property]);
			         errors_obj[property].map(item => {
			          error_messages += '<div>' + item + '</div>';
			        });
			    }
			}

			var notification =
			'<div class="notification is-danger">' +
			'<button class="delete"></button>' +
			error_messages +
			'</div>';

			$('.stm-body div#content').prepend(notification);

			$('.notification .delete').click(function() {
				$(this).parent().fadeOut();
			});

		});

	});

</script>

@endsection
