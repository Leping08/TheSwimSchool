<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * This is a question category on the feedback survey
 * Ex: Instructor or Overall Program
 *
 * An Eloquent Model: 'FeedbackQuestionCategory'
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\FeedbackQuestion $questions
 */
class FeedbackQuestionCategory extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(FeedbackQuestion::class, 'feedback_question_category_id');
    }
}
