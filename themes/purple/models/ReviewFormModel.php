<?php

namespace Themes\Purple\Models;

class ReviewFormModel extends PurpleModel
{
    function __construct(string|null $object_name, string|null $form_title, string|null $form_desc, bool $addPhotosButton = true, array $variables = [])
    {
        $variables['add_photos_button'] = $addPhotosButton;
        $variables['object_name'] = $object_name;
        $variables['form_title'] = $form_title;
        $variables['form_desc'] = $form_desc;
        parent::__construct('components/review_form', $variables);
    }
}
