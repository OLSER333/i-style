<?php

namespace Themes\Purple\Models;

use function App\get_text;

class FaqQuestionModel extends PurpleModel
{
    function __construct(array $question)
    {
        $variables['title'] = get_text($question['title_lang_key'], $question['faq_title']);
        $variables['text'] = get_text($question['text_lang_key'], $question['faq_text']);
        $variables['id'] = $question['faq_id'];
        parent::__construct('components/faq_question', $variables);
    }
}
