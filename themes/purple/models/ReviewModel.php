<?php

namespace Themes\Purple\Models;

use function App\db;

class ReviewModel extends PurpleModel
{
    function __construct(array $review, string $viewName = 'review', array $variables = [])
    {
        if ($review['review_object'] === 'service') {
            $review['photos'] = db()->find('review_photo', ['review_id' => $review['review_id'], 'review_photo_status' => 'active']);
            $review['object_url'] = '/services/' . $review['review_object_id'];
        } else {
            $review['object_url'] = '/sellers/' . $review['review_object_id'];
        }
        $review['stars'] = getStars($review['review_rating']);
        $review['date'] = date('d.m.Y', $review['review_date_add']);
        $review['user_name'] = $review['first_name'] . ' ' . $review['last_name'];
        $review['hidden_text'] = false;
        $review['hidden_text_class'] = '';
        if (substr_count($review['review_text'], '<br>') > 2) {
            // $reviewTextArray = explode('<br>', $review['review_text']);
            // $review['review_text'] = implode('<br>', [$reviewTextArray[0], $reviewTextArray[1]]);
            $review['hidden_text'] = true;
            $review['hidden_text_class'] = 'hidden-review-text';
        }
        $variables = $variables + $review;
        $this->data = $variables;
        // var_dump($this->data);
        parent::__construct("components/$viewName", $variables);
    }
}
