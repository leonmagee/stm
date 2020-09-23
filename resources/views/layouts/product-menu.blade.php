<div class="products-header-wrap linking">
  <div class="products-header center">
    <div class="products-header__left search-products"><a href="/"><i class="fas fa-mobile-alt"></i><span>All
          Products</span></a>
    </div>
    <div class="products-header__right">
      @foreach($cats as $cat)
      <div>
        <a class="button is-default is-small" href="/?cat={{ $cat->id }}">
          {{ $cat->name }}
        </a>
      </div>
      @endforeach
    </div>
  </div>
</div>
