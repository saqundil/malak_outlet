@extends('layouts.main')

@section('title', 'قائمة الأمنيات - متجر ملاك')

@section('content')


    <div class="container mx-auto px-4 py-12">
        <!-- Enhanced Wishlist Header -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-10 border border-gray-100">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-2">
                    <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-pink-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        منتجاتي المفضلة
                    </h2>
                    <p class="text-lg text-gray-600">
                        لديك 
                        <span id="wishlist-count" class="font-bold text-orange-600 text-xl">{{ $favorites->count() }}</span> 
                        {{ $favorites->count() == 1 ? 'منتج' : 'منتجات' }} في قائمة الأمنيات
                    </p>
                </div>
                @if($favorites->count() > 0)
                <div class="flex flex-col sm:flex-row gap-3">
                    <button class="premium-btn premium-btn-primary flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 add-all-to-cart">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13v6a1 1 0 001 1h10a1 1 0 001-1v-6m-8 0V9a1 1 0 011-1h4a1 1 0 011 1v4"/>
                        </svg>
                        إضافة الكل للسلة
                    </button>
                    <button class="premium-btn premium-btn-danger flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 clear-wishlist">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        مسح القائمة
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- Modern Wishlist Items -->
        @if($favorites->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="wishlist-items">
            @foreach($favorites as $favorite)
            <!-- Modern Card Design -->
            <div class="modern-card wishlist-item group" data-product-id="{{ $favorite->product->slug }}">
                <!-- Image Container -->
                <div class="card-image-container">
                    <div class="aspect-[4/5] overflow-hidden relative">
                        @if($favorite->product->images && $favorite->product->images->first())
                            <img src="{{ $favorite->product->images->first()->image_path }}" 
                                 alt="{{ $favorite->product->name }}" 
                                 class="w-full h-full object-cover transition-all duration-700 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                <div class="text-center p-6">
                                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mb-3 shadow-lg mx-auto">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-slate-600 font-medium text-sm">{{ $favorite->product->name }}</span>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Floating Badge -->
                        @if($favorite->product->sale_price)
                        <div class="floating-badge sale-badge">
                            <span class="badge-text">خصم</span>
                            <span class="badge-percent">-{{ round((($favorite->product->price - $favorite->product->sale_price) / $favorite->product->price) * 100) }}%</span>
                        </div>
                        @endif
                        
                        <!-- Heart Button -->
                        <button class="floating-heart remove-from-wishlist" data-product-id="{{ $favorite->product->slug }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <!-- Quick Actions Overlay -->
                        <div class="quick-actions-overlay">
                            <button class="quick-action-btn add-to-cart" data-product-id="{{ $favorite->product->slug }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13v6a1 1 0 001 1h10a1 1 0 001-1v-6m-8 0V9a1 1 0 011-1h4a1 1 0 011 1v4"/>
                                </svg>
                                <span>إضافة للسلة</span>
                            </button>
                            <a href="{{ route('products.show', $favorite->product->slug) }}" class="quick-action-btn view-btn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span>عرض المنتج</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Content Container -->
                <div class="card-content">
                    <!-- Category Tag -->
                    <div class="category-tag">
                        {{ $favorite->product->category->name ?? 'فئة غير محددة' }}
                    </div>
                    
                    <!-- Product Name -->
                    <h3 class="product-title">
                        {{ $favorite->product->name }}
                    </h3>
                    
                    <!-- Rating -->
                    <div class="rating-container">
                        <div class="stars-wrapper">
                            @foreach(range(1, 5) as $star)
                                <svg class="star {{ $star <= ($favorite->product->average_rating ?? 0) ? 'star-filled' : 'star-empty' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endforeach
                        </div>
                        <span class="reviews-count">({{ $favorite->product->reviews_count ?? 0 }})</span>
                    </div>
                    
                    <!-- Price Section -->
                    <div class="price-section">
                        @if($favorite->product->sale_price)
                            <div class="price-row">
                                <span class="current-price">{{ number_format($favorite->product->sale_price, 2) }} د.أ</span>
                                <span class="old-price">{{ number_format($favorite->product->price, 2) }} د.أ</span>
                            </div>
                        @else
                            <div class="price-row">
                                <span class="current-price single-price">{{ number_format($favorite->product->price, 2) }} د.أ</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Enhanced Empty Wishlist State -->
        <div class="text-center py-20" id="empty-wishlist">
            <div class="max-w-md mx-auto">
                <!-- Empty state icon -->
                <div class="relative mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-orange-100 to-pink-100 rounded-full flex items-center justify-center mx-auto shadow-xl">
                        <svg class="w-16 h-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <!-- Floating hearts animation -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-4">
                        <div class="flex space-x-2 animate-bounce">
                            <div class="w-3 h-3 bg-red-400 rounded-full opacity-60"></div>
                            <div class="w-2 h-2 bg-pink-400 rounded-full opacity-80 animation-delay-150"></div>
                            <div class="w-4 h-4 bg-orange-400 rounded-full opacity-40 animation-delay-300"></div>
                        </div>
                    </div>
                </div>
                
                <h3 class="text-3xl font-bold text-gray-700 mb-4">قائمة الأمنيات فارغة</h3>
                <p class="text-lg text-gray-500 mb-8 leading-relaxed">
                    لم تقم بإضافة أي منتجات لقائمة الأمنيات بعد.<br>
                    ابدأ في استكشاف منتجاتنا الرائعة وأضف ما يعجبك!
                </p>
                
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="premium-btn premium-btn-primary inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-semibold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        تصفح المنتجات
                    </a>
                    
                    <div class="flex justify-center gap-4 text-sm text-gray-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                            أضف للمفضلة
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13v6a1 1 0 001 1h10a1 1 0 001-1v-6m-8 0V9a1 1 0 011-1h4a1 1 0 011 1v4"/>
                            </svg>
                            أضف للسلة
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12z"/>
                            </svg>
                            تسوق سريع
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Modern Card CSS Styles -->
    <style>
        /* Animation Keyframes */
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float-up {
            0% {
                opacity: 0;
                transform: translateY(100%);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes heart-beat {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) skewX(-15deg);
            }
            100% {
                transform: translateX(200%) skewX(-15deg);
            }
        }

        /* Utility Classes */
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out;
        }

        .animation-delay-150 {
            animation-delay: 150ms;
        }

        .animation-delay-300 {
            animation-delay: 300ms;
        }

        /* Modern Card Styles */
        .modern-card {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .modern-card:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
            z-index: 1;
        }

        .modern-card:hover::before {
            left: 100%;
        }

        /* Image Container */
        .card-image-container {
            position: relative;
            overflow: hidden;
        }

        /* Floating Badge */
        .floating-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 60px;
        }

        .badge-text {
            font-size: 10px;
            margin-bottom: 2px;
        }

        .badge-percent {
            font-size: 14px;
            font-weight: 900;
        }

        .sale-badge {
            animation: heart-beat 2s infinite;
        }

        /* Floating Heart */
        .floating-heart {
            position: absolute;
            top: 16px;
            left: 16px;
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 3;
            color: #ef4444;
        }

        .floating-heart:hover {
            background: rgba(239, 68, 68, 0.1);
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }

        /* Quick Actions Overlay */
        .quick-actions-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            padding: 20px 16px 16px;
            transform: translateY(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2;
        }

        .modern-card:hover .quick-actions-overlay {
            transform: translateY(0);
        }

        .quick-action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 12px;
            color: #374151;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 8px;
        }

        .quick-action-btn:last-child {
            margin-bottom: 0;
        }

        .quick-action-btn:hover {
            background: #f97316;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(249, 115, 22, 0.3);
        }

        .view-btn:hover {
            background: #6366f1;
            box-shadow: 0 8px 16px rgba(99, 102, 241, 0.3);
        }

        /* Card Content */
        .card-content {
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        /* Category Tag */
        .category-tag {
            display: inline-block;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 12px;
        }

        /* Product Title */
        .product-title {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            line-height: 1.4;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.3s ease;
        }

        .modern-card:hover .product-title {
            color: #f97316;
        }

        /* Rating Container */
        .rating-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .stars-wrapper {
            display: flex;
            gap: 2px;
        }

        .star {
            width: 16px;
            height: 16px;
            transition: all 0.2s ease;
        }

        .star-filled {
            color: #fbbf24;
        }

        .star-empty {
            color: #d1d5db;
        }

        .reviews-count {
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
        }

        /* Price Section */
        .price-section {
            border-top: 1px solid #f3f4f6;
            padding-top: 16px;
        }

        .price-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .current-price {
            font-size: 20px;
            font-weight: 800;
            color: #1f2937;
        }

        .current-price.single-price {
            color: #f97316;
        }

        .old-price {
            font-size: 16px;
            color: #9ca3af;
            text-decoration: line-through;
            font-weight: 500;
        }

        /* Sale price styling */
        .price-row:has(.old-price) .current-price {
            color: #ef4444;
        }

        /* Premium Button Styles (Updated) */
        .premium-btn {
            position: relative;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .premium-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .premium-btn:hover::before {
            left: 100%;
        }

        .premium-btn-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
        }

        .premium-btn-primary:hover {
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
            transform: translateY(-2px);
        }

        .premium-btn-secondary {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #374151;
            border-color: #d1d5db;
        }

        .premium-btn-secondary:hover {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            border-color: #9ca3af;
            transform: translateY(-2px);
        }

        .premium-btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .premium-btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-card {
                border-radius: 16px;
            }
            
            .card-content {
                padding: 16px;
            }
            
            .product-title {
                font-size: 15px;
            }
            
            .current-price {
                font-size: 18px;
            }
            
            .floating-badge {
                top: 12px;
                right: 12px;
                padding: 6px 10px;
                font-size: 11px;
            }
            
            .floating-heart {
                top: 12px;
                left: 12px;
                width: 40px;
                height: 40px;
            }
        }

        /* Loading state for buttons */
        .premium-btn:disabled,
        .quick-action-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        .premium-btn:disabled:hover,
        .quick-action-btn:disabled:hover {
            transform: none !important;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
        }

        /* Enhanced Card Stagger Animation */
        .modern-card:nth-child(1) { animation-delay: 0ms; }
        .modern-card:nth-child(2) { animation-delay: 100ms; }
        .modern-card:nth-child(3) { animation-delay: 200ms; }
        .modern-card:nth-child(4) { animation-delay: 300ms; }
        .modern-card:nth-child(5) { animation-delay: 400ms; }
        .modern-card:nth-child(6) { animation-delay: 500ms; }
        .modern-card:nth-child(7) { animation-delay: 600ms; }
        .modern-card:nth-child(8) { animation-delay: 700ms; }

        /* Line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Remove from wishlist
        document.querySelectorAll('.remove-from-wishlist').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const wishlistItem = document.querySelector(`.wishlist-item[data-product-id="${productId}"]`);
                
                // Make API call to remove from wishlist
                removeFromWishlist(productId, wishlistItem);
            });
        });

        // Add to cart
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                addToCart(productId, this);
            });
        });

        // Bulk actions - updated selectors for premium buttons
        document.querySelector('.add-all-to-cart')?.addEventListener('click', function() {
            addAllToCart();
        });

        document.querySelector('.clear-wishlist')?.addEventListener('click', function() {
            clearWishlist();
        });

        function removeFromWishlist(productId, wishlistItem) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                showNotification('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
                return;
            }

            // Add removing animation
            wishlistItem.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            wishlistItem.style.transform = 'scale(0.95) translateY(-10px)';
            wishlistItem.style.opacity = '0.7';

            fetch(`/wishlist/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Enhanced fade out animation
                    wishlistItem.style.transform = 'scale(0.8) translateY(-20px)';
                    wishlistItem.style.opacity = '0';
                    
                    setTimeout(() => {
                        wishlistItem.remove();
                        updateWishlistCount();
                        
                        // Check if wishlist is empty
                        const remainingItems = document.querySelectorAll('.wishlist-item');
                        if (remainingItems.length === 0) {
                            location.reload(); // Reload to show empty state properly
                        }
                    }, 400);
                    
                    showNotification(data.message || 'تم حذف المنتج من قائمة الأمنيات', 'success');
                } else {
                    // Restore original state if failed
                    wishlistItem.style.transform = 'scale(1) translateY(0)';
                    wishlistItem.style.opacity = '1';
                    showNotification(data.message || 'حدث خطأ في حذف المنتج', 'error');
                }
            })
            .catch(error => {
                console.error('Remove from wishlist error:', error);
                // Restore original state if failed
                wishlistItem.style.transform = 'scale(1) translateY(0)';
                wishlistItem.style.opacity = '1';
                showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
            });
        }

        function addToCart(productId, button) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                showNotification('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
                return;
            }

            // Enhanced loading state for modern cards
            const originalContent = button.innerHTML;
            button.innerHTML = `
                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>جاري الإضافة...</span>
            `;
            button.disabled = true;
            button.style.transform = 'scale(0.95)';
            button.style.background = 'linear-gradient(135deg, #6b7280 0%, #4b5563 100%)';

            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart badge if exists
                    updateCartBadge(data.cart_count);
                    
                    // Enhanced success state for modern cards
                    button.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>تم الإضافة!</span>
                    `;
                    button.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                    button.style.transform = 'scale(1.02)';
                    button.style.boxShadow = '0 8px 25px rgba(16, 185, 129, 0.4)';
                    
                    showNotification('تم إضافة المنتج إلى السلة بنجاح!', 'success');
                    
                    // Reset after 3 seconds
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.style.background = '';
                        button.style.transform = '';
                        button.style.boxShadow = '';
                        button.disabled = false;
                    }, 3000);
                } else {
                    showNotification(data.message || 'حدث خطأ في إضافة المنتج', 'error');
                    button.innerHTML = originalContent;
                    button.style.background = '';
                    button.style.transform = '';
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Add to cart error:', error);
                showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
                button.innerHTML = originalContent;
                button.style.background = '';
                button.style.transform = '';
                button.disabled = false;
            });
        }

        function addAllToCart() {
            const wishlistItems = document.querySelectorAll('.wishlist-item');
            const productIds = Array.from(wishlistItems).map(item => item.dataset.productId);
            
            if (productIds.length === 0) {
                showNotification('لا توجد منتجات في قائمة الأمنيات', 'error');
                return;
            }

            showNotification('جاري إضافة جميع المنتجات إلى السلة...', 'info');

            // Add each product to cart with staggered animation
            productIds.forEach((productId, index) => {
                setTimeout(() => {
                    const addButton = document.querySelector(`.wishlist-item[data-product-id="${productId}"] .add-to-cart`);
                    if (addButton && !addButton.disabled) {
                        addToCart(productId, addButton);
                    }
                }, index * 600); // Increased delay for better UX
            });
        }

        function clearWishlist() {
            if (!confirm('هل أنت متأكد من حذف جميع المنتجات من قائمة الأمنيات؟\nلا يمكن التراجع عن هذا الإجراء.')) {
                return;
            }

            const wishlistItems = document.querySelectorAll('.wishlist-item');
            const productIds = Array.from(wishlistItems).map(item => item.dataset.productId);
            
            showNotification('جاري مسح قائمة الأمنيات...', 'info');
            
            productIds.forEach((productId, index) => {
                setTimeout(() => {
                    const removeButton = document.querySelector(`.wishlist-item[data-product-id="${productId}"] .remove-from-wishlist`);
                    if (removeButton) {
                        removeButton.click();
                    }
                }, index * 300); // Stagger the removals for better UX
            });
        }

        function updateWishlistCount() {
            const count = document.querySelectorAll('.wishlist-item').length;
            const countElement = document.getElementById('wishlist-count');
            if (countElement) {
                countElement.textContent = count;
                // Add a subtle animation to the count change
                countElement.style.transform = 'scale(1.2)';
                countElement.style.color = '#f97316';
                setTimeout(() => {
                    countElement.style.transform = 'scale(1)';
                    countElement.style.color = '';
                }, 300);
            }
        }

        function updateCartBadge(cartCount) {
            let cartBadge = document.getElementById('cart-count');
            
            if (cartBadge) {
                cartBadge.textContent = cartCount;
                if (cartCount > 0) {
                    cartBadge.classList.remove('hidden');
                    // Add pulse animation
                    cartBadge.style.animation = 'pulse 0.5s ease-in-out';
                    setTimeout(() => {
                        cartBadge.style.animation = '';
                    }, 500);
                } else {
                    cartBadge.classList.add('hidden');
                }
            } else if (cartCount > 0) {
                // Create cart badge if it doesn't exist
                const cartLink = document.querySelector('a[href*="cart"]');
                if (cartLink) {
                    cartLink.style.position = 'relative';
                    const badge = document.createElement('span');
                    badge.id = 'cart-count';
                    badge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold';
                    badge.textContent = cartCount;
                    cartLink.appendChild(badge);
                }
            }
        }

        function showNotification(message, type = 'success') {
            // Remove existing notifications
            document.querySelectorAll('.notification').forEach(notif => notif.remove());
            
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            
            notification.className = `notification fixed top-4 right-4 z-50 px-6 py-4 rounded-xl text-white shadow-2xl transition-all duration-300 transform ${bgColor} max-w-sm`;
            notification.style.transform = 'translateX(100%)';
            
            notification.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        ${type === 'success' ? 
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>' :
                            type === 'error' ? 
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' :
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                        }
                    </div>
                    <div class="text-sm font-medium">${message}</div>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Slide in animation
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Auto hide after 4 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 4000);
        }
    });
    </script>
@endsection




