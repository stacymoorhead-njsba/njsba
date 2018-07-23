<form class="header-search__form header-search--hide">
  <div class="header-search__inner">
    <label class="header-search__label">Search:</label>
	<input type="search" class="header-search__input"
            value="<?php echo get_search_query() ?>" name="s"
            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />

    <input type="submit" class="header-search__submit" value="Go">
  </div>
</form>
<button class="header-search__toggle" aria-label="Toggle Search Form">Search</button>
