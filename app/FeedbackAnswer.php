<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * This is an answer to a feedback survey question
 *
 * An Eloquent Model: 'FeedbackAnswer'
 *
 * @property integer $id
 * @property string $answer
 * @property string $feedback_question_id
 * @property string $feedback_survey_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\FeedbackQuestion $question
 *
 */

class FeedbackAnswer extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['answer', 'feedback_question_id', 'feedback_survey_id'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function question()
    {
        return $this->belongsTo(FeedbackQuestion::class, 'feedback_question_id');
    }
}
