<?php

namespace App\Controllers;

use App\System\Core\Controller;
use Themes\Purple\Models\ContentModel;
use Themes\Purple\Models\FaqQuestionModel;
use Themes\Purple\Models\PageModel;
use Themes\Purple\Models\PurpleModel;

use function App\app;
use function App\get_text;
use function App\option;

class Pages extends Controller
{

    function __construct()
    {
        $this->loadTheme('purple');
    }

    function faq()
    {
        $questions = app()->db->find('faq', [], '*', 'CASE WHEN `sort_number` > 0 THEN `sort_number` = 0 ELSE `faq_id` END ', false);
        $questions = array_chunk($questions, ceil(count($questions) / 2));

        foreach ($questions[0] as $question) {
            $variables['faq'][] = new FaqQuestionModel($question);
        }
        foreach ($questions[1] as $question) {
            $variables['faq2'][] = new FaqQuestionModel($question);
        }
        $this->model = new PageModel(get_text('faq'), new PurpleModel('content/faq', $variables), get_text('faq_page_title'), null, 'faq-background fag-page');
        $this->model->load();
    }

    function contacts()
    {
        $variables['phone'] = option('contact_phone');
        $variables['requisites'] = option('requisites');
        $this->model = new PageModel(get_text('contacts'), new PurpleModel('content/contacts', $variables), get_text('contacts'), null, 'contacts-background contacts-page');
        $this->model->load();
    }

    function about()
    {
        $variables = [];
        $faqVariables = [];
        $questions = app()->db->find('faq', [], '*', 'CASE WHEN `sort_number` > 0 THEN `sort_number` = 0 ELSE `faq_id` END ', false);
        $questions = array_slice($questions, 0, 5);

        foreach ($questions as $question) {
            $faqVariables['faq'][] = new FaqQuestionModel($question);
        }

        $this->model = new PageModel(get_text('about_us'), new PurpleModel('content/about', $variables), get_text('about_us'), null, 'about-background about-page', 'page-about', '', [], [], true, new PurpleModel('content/about_bottom', $faqVariables));

        $this->model->load();
    }
}
