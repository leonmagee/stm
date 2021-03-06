<ul class="sidebar-menu">

  @foreach($menu as $item)

  <?php

  $className = strtolower(str_replace(' ', '-', $item['name']));
  $active = '';
  if($path == '/') {
    $path_new = $path;
  } else {
  $path_new = '/' . $path;
  }
  // make children work
  if(isset($match_array[$path])) {
    $path_new = '/' . $match_array[$path];
  }

  if(($path_new == $item['link']) || ($path_new == $item['default'])) {
    $active = 'active';
  }

  if($path == 'email-tracker' || $path == 'login-tracker') {
    if($item['name'] == 'Emails') {
      $active = 'active';
    }
    if($item['name'] == 'Dealer History') {
      $active = 'active';
    }
  }

  $user_login_array = [
    'profile',
    'edit-profile',
    'change-profile-password'
  ];
  if(in_array($path, $user_login_array)) {
    if($item['name'] == 'My Profile') {
      $active = 'active';
    }
  }

  if($item['name'] == 'My Reports') {
    if($path == 'reports') {
      $active = 'active';
    }
  }

  if($item['name'] == 'IMEI Check History') {
    if($path == 'imeis') {
      $active = 'active';
    }
  }

  if($item['name'] == 'Credit History') {
    if($path == 'transaction-tracker') {
      $active = 'active';
    }
  }

  if($item['name'] == 'Credit History') {
    if($path == 'credit-tracker') {
      $active = 'active';
    }
  }

  if($item['name'] == 'Products List') {
    if($path == 'rmas') {
      $active = 'active';
    }
  }

  if($item['name'] == 'My History') {
    if($path == 'transaction-tracker') {
      $active = 'active';
    }
  }

  if($item['name'] == 'Monthly Sims') {
    $sub_path = substr($path, 0, 13);
    if($sub_path == 'sims/archive/') {
      $active = 'active';
    }
  }

  if($item['name'] == 'Report Types') {
    $sub_path = substr($path, 0, 13);
    if($sub_path == 'report-types/') {
      $active = 'active';
    }
  }

  if($item['name'] == 'Blacklisted IMEI Check') {
    $sub_path = substr($path, 0, 6);
    if($sub_path == 'imeis/') {
      $active = 'active';
    }
  }

  if($item['name'] == 'Users') {

    $match_array_users = [
      [
        'length' => 6,
        'match_array' => ['users/', 'edit-u', 'change']
      ],
      [
        'length' => 8,
        'match_array' => ['reports/']
      ],
      [
        'length' => 12,
        'match_array' => ['sims/upload/']
      ],
      [
        'length' => 13,
        'match_array' => ['bonus-credit/']
      ],
      [
        'length' => 14,
        'match_array' => ['login-tracker/', 'email-tracker/']
      ],
      [
        'length' => 15,
        'match_array' => ['user-sims/user/']
      ],
      [
        'length' => 17,
        'match_array' => ['user-plan-values/']
      ],
      [
        'length' => 20,
        'match_array' => ['transaction-tracker/']
      ],
      [
        'length' => 26,
        'match_array' => ['transaction-change-credit/']
      ],
    ];

    foreach($match_array_users as $match) {
      $sub_path = substr($path, 0, $match['length']);
          if(in_array($sub_path, $match['match_array'])) {
          $active = 'active';
       }
    }

  }

  if($item['name'] == 'Sims') {

  $match_array_sims = [
  [
  'length' => 10,
  'match_array' => ['list-sims/']
  ],
  [
  'length' => 16,
  'match_array' => ['list-sims-phone/']
  ],
  ];

  foreach($match_array_sims as $match) {
  $sub_path = substr($path, 0, $match['length']);
  if(in_array($sub_path, $match['match_array'])) {
  $active = 'active';
  }
  }

  }

  if(($item['name'] == 'Invoices') || ($item['name'] == 'Invoice History')) {

  $match_array_sims = [
  [
  'length' => 9,
  'match_array' => ['invoices/']
  ],
  ];

  foreach($match_array_sims as $match) {
  $sub_path = substr($path, 0, $match['length']);
  if(in_array($sub_path, $match['match_array'])) {
  $active = 'active';
  }
  }

  }

  //

  // if($item['name'] == 'Users') {
  //   $sub_path = substr($path, 0, 15);
  //   //dd($sub_path);
  //   $match_array = ['user-sims/user/'];
  //   if(in_array($sub_path, $match_array)) {
  //     $active = 'active';
  //   }
  // }

  // if($item['name'] == 'Users') {
  //   $sub_path = substr($path, 0, 12);
  //   //dd($sub_path);
  //   $match_array = ['sims/upload/'];
  //   if(in_array($sub_path, $match_array)) {
  //     $active = 'active';
  //   }
  // }
  ?>


  <li class="{{ $className }} {{ $active }}">

    <div class="icon-wrap">
      <i class="fi {{ $item['icon'] }}"></i>
    </div>
    @if($item['link'])



    <a href="{{ $item['link'] }}">{!! $item['name'] !!}</a>

    @else

    @if($item['default'])

    <a href="{{ $item['default'] }}">{{ $item['name'] }}</a>

    @else

    <a>{{ $item['name'] }}</a>

    @endif

    <ul class="sub-menu">

      @foreach( $item['sub'] as $sub)

      <li><a href="{{ $sub['link'] }}">{!! $sub['name'] !!}</a></li>

      @endforeach

    </ul>

    @endif

  </li>

  @endforeach

</ul>
