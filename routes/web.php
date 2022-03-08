<?php

//Route::redirect('/', '/login');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
   
    
    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // Listing
    Route::delete('listings/destroy', 'ListingController@massDestroy')->name('listings.massDestroy');
    Route::post('listings/media', 'ListingController@storeMedia')->name('listings.storeMedia');
    Route::post('listings/ckmedia', 'ListingController@storeCKEditorImages')->name('listings.storeCKEditorImages');
    Route::resource('listings', 'ListingController');
    Route::get('listings/{listing}/pdf', 'ListingController@exportPdf')->name('listings.exportPdf');

    // Owner
    Route::post('owners/assign_user', 'OwnerController@massAssignUser')->name('owners.assign_user');
    Route::delete('owners/destroy', 'OwnerController@massDestroy')->name('owners.massDestroy');
    Route::resource('owners', 'OwnerController');
    Route::post('owners/media', 'OwnerController@storeMedia')->name('owners.storeMedia');

    // Project
    Route::delete('projects/destroy', 'ProjectController@massDestroy')->name('projects.massDestroy');
    Route::post('projects/media', 'ProjectController@storeMedia')->name('projects.storeMedia');
    Route::post('projects/ckmedia', 'ProjectController@storeCKEditorImages')->name('projects.storeCKEditorImages');
    Route::resource('projects', 'ProjectController');

    // Contact
    Route::post('contacts/assign_user', 'ContactController@massAssignUser')->name('contacts.assign_user');
    Route::delete('contacts/destroy', 'ContactController@massDestroy')->name('contacts.massDestroy');
    Route::resource('contacts', 'ContactController');
    Route::get('leads', [\App\Http\Controllers\Admin\ContactController::class, 'leads'])->name('leads');
   

    // Task
    Route::delete('tasks/destroy', 'TaskController@massDestroy')->name('tasks.massDestroy');
    Route::resource('tasks', 'TaskController');

    // Exports
    Route::get('exports/listings', 'ExportExcelController@listings')->name('exports.excel.listings');
    Route::get('exports/listings-csv', 'ExportCSVController@listings')->name('exports.csv.listings');
    Route::get('exports/projects', 'ExportExcelController@projects')->name('exports.excel.projects');
    Route::get('exports/projects-csv', 'ExportCSVController@projects')->name('exports.csv.projects');
    Route::get('exports/contacts', 'ExportExcelController@contacts')->name('exports.excel.contacts');
    Route::get('exports/contacts-csv', 'ExportCSVController@contacts')->name('exports.csv.contacts');
    Route::get('exports/owners', 'ExportExcelController@owners')->name('exports.excel.owners');
    Route::get('exports/owners-csv', 'ExportCSVController@owners')->name('exports.csv.owners');
    Route::get('exports/leads-csv', 'ExportCSVController@leads')->name('exports.csv.leads');
    //import
    Route::get('import/listings', [ListingController::class, 'index'])->name('upload-listing-csv');
    Route::post('import/listings', 'ListingController@upload_csv_records');
    Route::get('import/projects', [ProjectController::class, 'index'])->name('upload-project-csv');
    Route::post('import/projects', 'ProjectController@upload_csv_records');
    Route::get('import/contacts', [ContactController::class, 'index'])->name('upload-contact-csv');
    Route::post('import/contacts', 'ContactController@upload_csv_records');
    Route::get('import/owners', [OwnerController::class, 'index'])->name('upload-owner-csv');
    Route::post('import/owners', 'OwnerController@upload_csv_records');

    Route::get('notifications/mark-as-read', 'NotificationsController@markAsRead')->name('notifications.markAsRead');

    // Followup
    Route::delete('followups/destroy', 'FollowupController@massDestroy')->name('followups.massDestroy');
    Route::post('followups/media', 'FollowupController@storeMedia')->name('followups.storeMedia');
    Route::post('followups/ckmedia', 'FollowupController@storeCKEditorImages')->name('followups.storeCKEditorImages');
    //Route::resource('followups', 'FollowupController');
    Route::get('followups/create/{contactId?}', 'FollowupController@create')->name('followups.create.from_contact');
    Route::resource('followups', 'FollowupController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

Route::get('storage/link', function () {
   \Artisan::call('storage:link'); 
});


