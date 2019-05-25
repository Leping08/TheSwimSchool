<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * This is a question type on the feedback survey
 *
 * An Eloquent Model: 'FeedbackQuestionType'
 *
 * @property integer $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\FeedbackQuestion $questions
 *
 */

class FeedbackQuestionType extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(FeedbackQuestion::class, 'feedback_type_id');
    }
}
