<div class="customer-info">
  <div>{{ $user->company . ' / ' . $user->name }}</div>
  <div>{{ $user->address }}</div>
  <div>{{ $user->city }}, {{ $user->state }} {{ $user->zip }}</div>
  <div class="email">{{ $user->email }}</div>
  <div>{{ $user->phone }}</div>
</div>
