<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperQuestion
 */
class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'display_id',
        'code',
        'classification',
        'title',
        'permission_2',
        'permission_3',
        'permission_4',
        'similar_faq_1_id',
        'similar_faq_2_id',
        'similar_faq_3_id',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public static $selectProps = [
        'snet_questions.id',
        'snet_questions.display_id',
        'snet_questions.code',
        'snet_questions.classification',
        'snet_questions.title',
        'snet_questions.permission_2',
        'snet_questions.permission_3',
        'snet_questions.permission_4',
        'snet_questions.similar_faq_1_id',
        'snet_questions.similar_faq_2_id',
        'snet_questions.similar_faq_3_id',
        'snet_questions.memo',
        'snet_questions.display_order',
        'snet_questions.use_classification',
        'snet_questions.created_by',
        'snet_questions.created_at',
        'snet_questions.updated_by',
        'snet_questions.updated_at',
    ];

    protected $table = 'snet_questions';


    public function display(): BelongsTo
    {
        return $this->belongsTo(Display::class, 'display_id');
    }

    public function similarFaq1(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'similar_faq_1_id');
    }

    public function similarFaq2(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'similar_faq_2_id');
    }

    public function similarFaq3(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'similar_faq_3_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function answerTexts(): HasMany
    {
        return $this->hasMany(AnswerText::class, 'question_id', 'id')->orderBy('display_order');
    }
    public function answerFiles(): HasMany
    {
        return $this->hasMany(AnswerFile::class, 'question_id', 'id')->orderBy('display_order');
    }
}
