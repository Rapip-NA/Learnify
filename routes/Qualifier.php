<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Features\Qualifier;
use App\Livewire\Features\Admin;

Route::prefix('qualifier')
    ->name('qualifier.')
    ->group(function () {

        Route::get('/dashboard', Qualifier\Dashboard::class)->name('dashboard');
        Route::get('/answer-validation', Qualifier\AnswerValidation::class)->name('answer-validation');

        // Essay Question Management (reuse Admin question components, access controlled inside component)
        Route::prefix('questions')->name('questions.')->group(function () {
            Route::get('/', Admin\Question\QuestionIndex::class)->name('index');
            Route::get('/create', Admin\Question\QuestionCreate::class)->name('create');
            Route::get('/{id}/edit', Admin\Question\QuestionEdit::class)->name('edit');
            Route::get('/{id}', Admin\Question\QuestionView::class)->name('view');
        });
    });