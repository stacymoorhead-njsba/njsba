<form class="header-search__form header-search--hide" action="/index.php">
  <div class="header-search__inner">
    <label class="header-search__label">Search:</label>
	<input type="search" class="header-search__input"
			placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
            value="<?php echo get_search_query() ?>" name="s"
            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />

    <input type="submit" class="header-search__submit" value="<?php echo esc_attr_x( 'Go', 'submit button' ) ?>" >
  </div>
</form>
