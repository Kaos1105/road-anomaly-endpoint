<?php

use App\Http\Controllers\SNET\QuestionController;
use App\Http\Controllers\SNET\AnswerTextController;
use App\Http\Controllers\SNET\AnswerFileController;
use Illuminate\Support\Facades\Route;

Route::get('dropdown-similar-question', [QuestionController::class, 'dropdownSimilarQuestion']);
Route::get('dropdown-question-classification', [QuestionController::class, 'dropdownQuestionClassification']);
Route::get('{question}/answers', [QuestionController::class, 'getAnswers']);
Route::post('{question}/change-display-order', [QuestionController::class, 'changeDisplayOrderAnswer']);
Route::apiResource('{question}/answer-text', AnswerTextController::class)->only(['show', 'store', 'update', 'destroy']);
Route::apiResource('{question}/answer-file', AnswerFileController::class)->only(['show', 'store', 'destroy']);
Route::post('{question}/answer-file/{answer_file}', [AnswerFileController::class, 'update']);

