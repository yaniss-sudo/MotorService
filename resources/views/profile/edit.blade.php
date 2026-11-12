@extends('layouts.main')
@section('title', 'Profile')

@section('content')
<!-- BANNER HEADER -->
<div class="module-banner" style="background-image: url('{{ asset('images/sergey-zolkin-_UeY8aTI6d0-unsplash.jpg') }}');">
    <div class="module-banner-content">
        <div>
            <span class="module-eyebrow">Pengaturan Akun</span>
            <h1 class="page-title">Profile</h1>
            <p class="page-subtitle">Kelola informasi profil dan kata sandi akun Anda.</p>
        </div>
    </div>
</div>

<div class="form-shell" style="max-width: 860px;">
    <div class="editor-card">
        <div class="editor-body">
            <div class="form-section-label">Informasi Profil</div>
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <div class="editor-card mt-3">
        <div class="editor-body">
            <div class="form-section-label">Kata Sandi</div>
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    <div class="editor-card mt-3">
        <div class="editor-body">
            <div class="form-section-label">Hapus Akun</div>
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
