@if($flash = session('message'))

<div class="notification is-success">

  <button class="delete"></button>

  {{ $flash }}

</div>

@endif

@if($flash = session('status'))

<div class="notification is-success">

  <button class="delete"></button>

  {{ $flash }}

</div>

@endif

@if($flash = session('danger'))

<div class="notification is-danger">

  <button class="delete"></button>

  {{ $flash }}

</div>

@endif

@if($duplicates = session('duplicates'))

<div class="notification is-danger">

  <button class="delete"></button>

  <span>Duplicate Sims Not Uploaded:</span>

  <ul>
    @foreach($duplicates as $duplicate)

    <li>{{ $duplicate }}</li>

    @endforeach
  </ul>

</div>

@endif

@if($sims = session('sims_not_found'))

<div class="notification is-danger">

  <button class="delete"></button>

  <span>Sims Not Found:</span>

  <ul>
    @foreach($sims as $sim)

    <li>{{ $sim }}</li>

    @endforeach
  </ul>

</div>

@endif

@if($sims = session('sims_transferred'))

<div class="notification is-success">

  <button class="delete"></button>

  <span>Sims Transferred:</span>

  <ul>
    @foreach($sims as $sim)

    <li>{{ $sim }}</li>

    @endforeach
  </ul>

</div>

@endif

@if($removed_sims = session('removed'))

<div class="notification is-success">

  <button class="delete"></button>

  <span>The following sims were removed:</span>

  <ul>
    @foreach($removed_sims as $sim)

    <li>{{ $sim }}</li>

    @endforeach
  </ul>

</div>

@endif

@if($removed_sims = session('not_removed'))

<div class="notification is-danger">

  <button class="delete"></button>

  <span>The following sims were not found:</span>

  <ul>
    @foreach($removed_sims as $sim)

    <li>{{ $sim }}</li>

    @endforeach
  </ul>

</div>

@endif
