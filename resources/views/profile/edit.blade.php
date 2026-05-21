@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-slate-900 border border-slate-800 shadow-sm p-6 sm:p-8 rounded">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 shadow-sm p-6 sm:p-8 rounded">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="bg-slate-900 border-red-900/50 shadow-sm p-6 sm:p-8 rounded">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
