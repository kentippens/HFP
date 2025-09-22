@extends('layouts.app')

@section('title', 'Internal Server Error')
@section('meta_description', 'Something went wrong on our end. We apologize for the inconvenience.')

@section('content')
    <div class="error-page-area">
        <div class="container">
            <div class="error-page-wrapper">
                <div class="error-page-content text-center">
                    <div class="error-code">
                        <h1>500</h1>
                    </div>
                    <div class="error-message">
                        <h2>Oops! Something Went Wrong</h2>
                        <p>We encountered an unexpected error while processing your request. Our team has been notified and is working to fix this issue.</p>
                    </div>
                    <div class="error-info">
                        <p>What you can do:</p>
                        <ul class="list-unstyled">
                            <li>• Go back to the previous page</li>
                            <li>• Try again in a few moments</li>
                            <li>• Contact our support team if the problem persists</li>
                            <li>• Call us directly at <a href="tel:+1234567890">(123) 456-7890</a></li>
                        </ul>
                    </div>
                    <div class="error-actions mt-4">
                        <a href="{{ route('home') }}" class="bixol-primary-btn">
                            @icon("fas fa-home") Go to Homepage
                        </a>
                        <a href="javascript:history.back();" class="bixol-primary-btn ml-3">
                            @icon("fas fa-arrow-left") Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .error-page-area {
        padding: 100px 0;
        min-height: 60vh;
        display: flex;
        align-items: center;
    }
    
    .error-page-wrapper {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .error-code h1 {
        font-size: 120px;
        font-weight: 700;
        color: #dc3545;
        margin-bottom: 20px;
        line-height: 1;
    }
    
    .error-message h2 {
        font-size: 32px;
        margin-bottom: 20px;
        color: #22356f;
    }
    
    .error-info {
        margin-top: 30px;
        background: #f8f9fa;
        padding: 30px;
        border-radius: 8px;
    }
    
    .error-info ul li {
        margin-bottom: 10px;
        color: #666;
    }
    
    .error-actions .bixol-primary-btn {
        margin: 0 10px;
    }
    
    @media (max-width: 767px) {
        .error-code h1 {
            font-size: 80px;
        }
        
        .error-message h2 {
            font-size: 24px;
        }
        
        .error-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .error-actions .bixol-primary-btn {
            margin: 0;
            width: 100%;
        }
    }
</style>
@endpush