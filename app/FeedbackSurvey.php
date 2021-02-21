<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * This is the feedback survey object
 *
 * An Eloquent Model: 'FeedbackSurvey'
 *
 * @property integer $id
 * @property boolean $viewed
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\FeedbackAnswer $answers
 *
 */

class FeedbackSurvey extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = ['viewed'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(FeedbackAnswer::class, 'feedback_survey_id');
    }
}
