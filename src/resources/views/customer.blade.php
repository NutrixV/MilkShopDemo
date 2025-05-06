@extends('layouts.app')

@section('title', 'Customer Page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
@endpush

@section('content')
<div class="customer-page">
    <div class="customer-sidebar">
        <ul class="sidebar-menu">
            <li class="menu-item"><a href="#personal-details">Персональні дані</a></li>
            <li class="menu-item"><a href="#order-history">Історія замовлень</a></li>
            <li class="menu-item"><a href="#settings">Налаштування</a></li>
        </ul>
    </div>
    <div class="customer-content">
        <h1 class="customer-title">Інформація про користувача</h1>
        <div id="personal-details" class="customer-info">
            <h2 class="info-title">Персональні дані</h2>
            <p class="info-item">Ім'я: {{ $customer->name }}</p>
            <p class="info-item">Email: {{ $customer->email }}</p>
            <p class="info-item">Зареєстрований: {{ $customer->created_at->format('d.m.Y') }}</p>
        </div>
        <div id="order-history" class="order-history">
            <h2 class="history-title">Історія замовлень</h2>
            @if(isset($orders) && count($orders) > 0)
                <ul class="order-list">
                    @foreach($orders as $order)
                        <li class="order-item">
                            Замовлення #{{ $order->id }} - {{ number_format($order->total, 2) }} грн - {{ $order->status }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>У вас поки немає замовлень.</p>
            @endif
        </div>
        <div id="settings" class="customer-settings">
            <h2 class="settings-title">Налаштування</h2>
            <form action="{{ route('customer.logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">Вийти з облікового запису</button>
            </form>
        </div>
    </div>
</div>

@endsection 