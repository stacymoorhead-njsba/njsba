<?php

/* Template Name: Job */

?>


<!-- START TESTING -->

<!-- END TESTING -->

<?php

$context = get_queried_object();

// Build the hero banner

$hero = array(
	'acf_arg' => $context,
	'title' => $context->name,
	);
Components\build_with($hero,'hero');


// Prolly should be a separate component...Build the default page content area

$content2 = array( 'content' => $context->content);

Components\build_with($content2,'content');

?>


	</section>
</div>

