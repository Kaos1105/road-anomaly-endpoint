<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperAnswerText
 */
class AnswerText extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'question_id',
        'answer_content',
        'display_order',
    ];

    public static $selectProps = [
        'snet_answer_texts.id',
        'snet_answer_texts.question_id',
        'snet_answer_texts.answer_content',
        'snet_answer_texts.display_order',
    ];

    protected $table = 'snet_answer_texts';

    public $timestamps = false;

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'display_id');
    }

}
