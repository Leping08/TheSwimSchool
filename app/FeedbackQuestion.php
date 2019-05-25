<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * This is a question on a feedback survey
 *
 * An Eloquent Model: 'FeedbackQuestion'
 *
 * @property integer $id
 * @property string $question
 * @property string $feedback_question_type_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\FeedbackQuestionType $type
 * @property-read \App\FeedbackAnswer $answers
 *
 */

class FeedbackQuestion extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['question', 'feedback_question_type_id', 'feedback_question_category_id'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(FeedbackQuestionType::class, 'feedback_question_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(FeedbackQuestionCategory::class, 'feedback_question_category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(FeedbackAnswer::class, 'feedback_question_id');
    }
}
