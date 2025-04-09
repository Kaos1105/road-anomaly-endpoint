<?php

use App\Http\Controllers\Main\AttachmentFileController;
use Illuminate\Support\Facades\Route;

Route::delete('{attachment_file}', [AttachmentFileController::class, 'destroy'])->name('attachment_file.destroy');
Route::get('{attachment_file}/download', [AttachmentFileController::class, 'download'])->name('attachment_file.download');
Route::get('get-attachments', [AttachmentFileController::class, 'getAttachableFiles'])->name('attachment_file.getAttachableFiles');
Route::post('upload-file', [AttachmentFileController::class, 'uploadFile'])->name('attachment_file.uploadFile');
Route::get('avatar', [AttachmentFileController::class, 'getAvatar']);
