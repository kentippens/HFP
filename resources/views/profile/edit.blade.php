@extends('layouts.app')

@section('title', $title ?? 'Edit Profile')
@section('meta_description', $description ?? 'Update your account information')

@section('content')
<style>
    /* Profile Form Styling */
    .contact-form {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .contact-form__title {
        color: #043f88;
        margin-bottom: 25px;
        font-size: 24px;
        font-weight: 600;
    }
    
    .contact-form__input input {
        width: 100%;
        padding: 12px 20px;
        border: 2px solid #043f88;
        border-radius: 5px;
        font-size: 14px;
        font-family: "Poppins", sans-serif;
        transition: all 0.3s ease;
        background: #fff;
        color: #333;
    }
    
    .contact-form__input input:focus {
        outline: none;
        border-color: #0056b3;
        box-shadow: 0 0 0 0.2rem rgba(4, 63, 136, 0.25);
    }
    
    .contact-form__input input::placeholder {
        color: #999;
        font-style: italic;
    }
    
    .contact-form__btn {
        margin-top: 10px;
    }
    
    .contact-form__btn button {
        background-color: #043f88;
        color: #fff;
        padding: 12px 30px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: "Poppins", sans-serif;
        width: 100%;
    }
    
    .contact-form__btn button:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .alert-danger p {
        margin: 5px 0;
    }
    
    .page-header {
        background: #043f88;
        padding: 40px 0;
        margin-bottom: 0;
    }
    
    .page-header__title {
        color: #fff;
        font-size: 36px;
        margin-bottom: 10px;
    }
    
    .page-header__breadcrumb ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 15px;
    }
    
    .page-header__breadcrumb ul li {
        color: #fff;
        font-size: 14px;
    }
    
    .page-header__breadcrumb ul li a {
        color: #fff;
        text-decoration: none;
        transition: opacity 0.3s ease;
    }
    
    .page-header__breadcrumb ul li a:hover {
        opacity: 0.8;
    }
    
    .page-header__breadcrumb ul li:not(:first-child)::before {
        content: "/";
        margin-right: 15px;
    }
</style>

<div class="page-header">
    <div class="container">
        <div class="page-header__wrapper">
            <div class="page-header__content">
                <h1 class="page-header__title">Edit Profile</h1>
                <nav class="page-header__breadcrumb">
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Profile</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="contact-section" style="padding-top: 100px; padding-bottom: 100px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-form">
                    <h3 class="contact-form__title">Update Profile Information</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->updateProfile->any())
                        <div class="alert alert-danger">
                            @foreach($errors->updateProfile->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="contact-form__input">
                                    <input type="text" name="name" placeholder="Full Name" value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="contact-form__input">
                                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="contact-form__btn">
                                    <button type="submit" class="btn">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="contact-form">
                    <h3 class="contact-form__title">Update Password</h3>
                    
                    @if($errors->updatePassword->any())
                        <div class="alert alert-danger">
                            @foreach($errors->updatePassword->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="contact-form__input">
                                    <input type="password" name="current_password" placeholder="Current Password" required>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="contact-form__input">
                                    <input type="password" name="password" placeholder="New Password" required>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="contact-form__input">
                                    <input type="password" name="password_confirmation" placeholder="Confirm New Password" required>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="contact-form__btn">
                                    <button type="submit" class="btn">Update Password</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection