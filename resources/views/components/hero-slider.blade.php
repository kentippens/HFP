<!-- Hero Slider -->
<div class="home2-hero-slider">
    <p class="rs-p-wp-fix"></p>
    <rs-module-wrap id="rev_slider_2_1_wrapper" data-alias="home-2" data-source="gallery" style="visibility:hidden;background:transparent;padding:0;margin:0px auto;margin-top:0;margin-bottom:0;">
        <rs-module id="rev_slider_2_1" data-version="6.5.7">
            <rs-slides>
                @foreach($slides ?? [] as $index => $slide)
                <rs-slide style="position: absolute;" data-key="rs-{{ $index + 4 }}" data-title="Slide" data-thumb="{{ asset($slide['thumb'] ?? 'assets/bg-slider4-50x100.jpg') }}" data-anim="ms:1000;r:0;" data-in="o:0;" data-out="a:false;">
                    <img src="{{ asset($slide['image'] ?? 'assets/images/slider/home2/bg-slider4.jpg') }}" title="{{ $slide['title'] ?? 'Slide' }}" width="1920" height="715" class="rev-slidebg tp-rs-img" data-parallax="8" data-no-retina>
                    
                    <rs-group
                        id="slider-2-slide-{{ $index + 4 }}-layer-0" 
                        data-type="group"
                        data-xy="xo:30px,30px,30px,22px;y:m;yo:-20px,-20px,0,0;"
                        data-text="w:normal;s:20,16,12,7;l:0,20,15,9;"
                        data-dim="w:800px,800px,800px,400px;h:430px,410px,370px,370px;"
                        data-rsp_bd="off"
                        data-frame_0="o:1;"
                        data-frame_999="o:0;st:w;sR:8700;sA:9000;"
                        style="z-index:13;"
                    >
                        @if($slide['has_video'] ?? false)
                        <rs-layer
                            id="slider-2-slide-{{ $index + 4 }}-layer-1" 
                            data-type="text"
                            data-xy="xo:20px;"
                            data-text="w:normal;s:20,16,12,7;l:25,20,15,9;"
                            data-rsp_bd="off"
                            data-frame_0="sX:0.9;sY:0.9;"
                            data-frame_1="st:800;sp:1000;sR:800;"
                            data-frame_999="o:0;st:w;sR:7200;"
                            style="z-index:9;font-family:'Roboto';"
                        ><a class="ct-video-button slider-style1 video-popup" target="_blank" href="{{ $slide['video_url'] ?? 'https://www.youtube.com/watch?v=SF4aHwxHtZ0' }}"><i class="icon"><svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M5 3l8 5-8 5V3z"/></svg></i></a> 
                        </rs-layer>
                        @endif

                        <rs-layer
                            id="slider-2-slide-{{ $index + 4 }}-layer-2" 
                            data-type="text"
                            data-xy="yo:93px;"
                            data-text="w:normal;s:70,60,42,30;l:80,70,56,36;ls:-1px;fw:700;"
                            data-rsp_o="off"
                            data-rsp_bd="off"
                            data-frame_0="rX:-70deg;oZ:-50;"
                            data-frame_1="oZ:-50;e:power4.inOut;st:1000;sp:1750;sR:1000;"
                            data-frame_999="o:0;st:w;sR:6250;"
                            style="z-index:10;font-family:'Poppins';"
                        >{!! $slide['heading'] ?? 'We are Professional<br />Cleaning Services' !!}
                        </rs-layer>
                        
                        @if($slide['description'] ?? false)
                        <rs-layer
                            id="slider-2-slide-{{ $index + 4 }}-layer-4" 
                            data-type="text"
                            data-xy="yo:274px,254px,220px,185px;"
                            data-text="w:normal;s:18,18,16,16;l:28,28,28,26;fw:500;"
                            data-dim="w:540px,540px,460px,240px;"
                            data-rsp_o="off"
                            data-rsp_bd="off"
                            data-frame_0="y:50;"
                            data-frame_1="st:1750;sp:1000;sR:1750;"
                            data-frame_999="o:0;st:w;sR:6250;"
                            style="z-index:11;font-family:'Rubik';"
                        >{{ $slide['description'] ?? 'Bixol is professionalism in the cleaning industry by providing top-quality cleaning and related services' }}
                        </rs-layer>
                        @endif

                        <a
                            id="slider-2-slide-{{ $index + 4 }}-layer-5" 
                            class="rs-layer"
                            href="{{ route('services.index') }}" target="_self" rel="nofollow"
                            data-type="text"
                            data-xy="y:b;"
                            data-text="w:normal;s:20,20,16,16;l:25,25,26,26;"
                            data-rsp_o="off"
                            data-rsp_bd="off"
                            data-frame_0="y:50;"
                            data-frame_1="st:1950;sp:1000;sR:1950;"
                            data-frame_999="o:0;st:w;sR:6050;"
                            style="z-index:12;font-family:'Roboto';"
                        ><span class="btn btn-plus btn-plus-primary btn-plus-round icon-right">Our Services<span class="icon-abs"><i class="icon"><svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="8" r="2" fill="currentColor"/><path d="M8 1l1 2h2l-1 2 2 1v2l-2 1 1 2h-2l-1 2-2-1v-2l-2-1 1-2H2l1-2V3l2-1L6 1h2z" stroke="currentColor" stroke-width="1" fill="none"/></svg></i></span></span> 
                        </a>
                    </rs-group>

                    <rs-layer
                        id="slider-2-slide-{{ $index + 4 }}-layer-7" 
                        data-type="image"
                        data-xy="x:r;xo:-180px;yo:40px;"
                        data-text="w:normal;s:20,16,12,7;l:0,20,15,9;"
                        data-dim="w:['138px','138px','138px','138px'];h:['118px','118px','118px','118px'];"
                        data-rsp_bd="off"
                        data-frame_999="o:0;st:w;"
                        data-loop_999="sX:0.8;sY:0.8;o:0.6;sp:3000;st:600;e:power2.inOut;yys:t;yyf:t;"
                        style="z-index:15;"
                    ><img src="{{ asset('images/slider/home2/slider-star1.png') }}" alt="slider-star1" class="tp-rs-img" width="138" height="118" data-no-retina> 
                    </rs-layer>


                    <rs-layer
                        id="slider-2-slide-{{ $index + 4 }}-layer-9" 
                        data-type="image"
                        data-xy="xo:-190px;y:b;yo:65px;"
                        data-text="w:normal;s:20,16,12,7;l:0,20,15,9;"
                        data-dim="w:['138px','138px','138px','138px'];h:['118px','118px','118px','118px'];"
                        data-rsp_bd="off"
                        data-frame_999="o:0;st:w;"
                        data-loop_999="sX:0.8;sY:0.8;o:0.6;sp:3000;st:0;e:power2.inOut;yys:t;yyf:t;"
                        style="z-index:14;"
                    ><img src="{{ asset('images/slider/home2/slider-star1.png') }}" alt="slider-star1" class="tp-rs-img" width="138" height="118" data-no-retina> 
                    </rs-layer>
                </rs-slide>
                @endforeach
                
                @if(empty($slides))
                <!-- Default slides if no data provided -->
                <rs-slide style="position: absolute;" data-key="rs-4" data-title="Slide" data-thumb="assets/bg-slider4-50x100.jpg" data-anim="ms:1000;r:0;" data-in="o:0;" data-out="a:false;">
                    <img src="{{ asset('images/slider/home2/bg-slider4.jpg') }}" title="bg-slider4" width="1920" height="715" class="rev-slidebg tp-rs-img" data-parallax="8" data-no-retina>

                    <rs-group
                        id="slider-2-slide-4-layer-0" 
                        data-type="group"
                        data-xy="xo:30px,30px,30px,22px;y:m;yo:-20px,-20px,0,0;"
                        data-text="w:normal;s:20,16,12,7;l:0,20,15,9;"
                        data-dim="w:800px,800px,800px,400px;h:430px,410px,370px,370px;"
                        data-rsp_bd="off"
                        data-frame_0="o:1;"
                        data-frame_999="o:0;st:w;sR:8700;sA:9000;"
                        style="z-index:13;"
                    >
                        <rs-layer
                            id="slider-2-slide-4-layer-1" 
                            data-type="text"
                            data-xy="xo:20px;"
                            data-text="w:normal;s:20,16,12,7;l:25,20,15,9;"
                            data-rsp_bd="off"
                            data-frame_0="sX:0.9;sY:0.9;"
                            data-frame_1="st:800;sp:1000;sR:800;"
                            data-frame_999="o:0;st:w;sR:7200;"
                            style="z-index:9;font-family:'Roboto';"
                        ><a class="ct-video-button slider-style1 video-popup" target="_blank" href="https://www.youtube.com/watch?v=SF4aHwxHtZ0"><i class="icon"><svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M5 3l8 5-8 5V3z"/></svg></i></a> 
                        </rs-layer>

                        <rs-layer
                            id="slider-2-slide-4-layer-2" 
                            data-type="text"
                            data-xy="yo:93px;"
                            data-text="w:normal;s:70,60,42,30;l:80,70,56,36;ls:-1px;fw:700;"
                            data-rsp_o="off"
                            data-rsp_bd="off"
                            data-frame_0="rX:-70deg;oZ:-50;"
                            data-frame_1="oZ:-50;e:power4.inOut;st:1000;sp:1750;sR:1000;"
                            data-frame_999="o:0;st:w;sR:6250;"
                            style="z-index:10;font-family:'Poppins';"
                        >We are Professional<br />Cleaning Services 
                        </rs-layer>
                        <rs-layer
                            id="slider-2-slide-4-layer-4" 
                            data-type="text"
                            data-xy="yo:274px,254px,220px,185px;"
                            data-text="w:normal;s:18,18,16,16;l:28,28,28,26;fw:500;"
                            data-dim="w:540px,540px,460px,240px;"
                            data-rsp_o="off"
                            data-rsp_bd="off"
                            data-frame_0="y:50;"
                            data-frame_1="st:1750;sp:1000;sR:1750;"
                            data-frame_999="o:0;st:w;sR:6250;"
                            style="z-index:11;font-family:'Rubik';"
                        >Enjoy more free time while we handle the cleaning. Professional house, carpet, and pool services that deliver exceptional results you can count on. 
                        </rs-layer>

                        <a
                            id="slider-2-slide-4-layer-5" 
                            class="rs-layer"
                            href="{{ route('services.index') }}" target="_self" rel="nofollow"
                            data-type="text"
                            data-xy="y:b;"
                            data-text="w:normal;s:20,20,16,16;l:25,25,26,26;"
                            data-rsp_o="off"
                            data-rsp_bd="off"
                            data-frame_0="y:50;"
                            data-frame_1="st:1950;sp:1000;sR:1950;"
                            data-frame_999="o:0;st:w;sR:6050;"
                            style="z-index:12;font-family:'Roboto';"
                        ><span class="btn btn-plus btn-plus-primary btn-plus-round icon-right">Our Services<span class="icon-abs"><i class="icon"><svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="8" r="2" fill="currentColor"/><path d="M8 1l1 2h2l-1 2 2 1v2l-2 1 1 2h-2l-1 2-2-1v-2l-2-1 1-2H2l1-2V3l2-1L6 1h2z" stroke="currentColor" stroke-width="1" fill="none"/></svg></i></span></span> 
                        </a>
                    </rs-group>

                    <rs-layer
                        id="slider-2-slide-4-layer-7" 
                        data-type="image"
                        data-xy="x:r;xo:-180px;yo:40px;"
                        data-text="w:normal;s:20,16,12,7;l:0,20,15,9;"
                        data-dim="w:['138px','138px','138px','138px'];h:['118px','118px','118px','118px'];"
                        data-rsp_bd="off"
                        data-frame_999="o:0;st:w;"
                        data-loop_999="sX:0.8;sY:0.8;o:0.6;sp:3000;st:600;e:power2.inOut;yys:t;yyf:t;"
                        style="z-index:15;"
                    ><img src="{{ asset('images/slider/home2/slider-star1.png') }}" alt="slider-star1" class="tp-rs-img" width="138" height="118" data-no-retina> 
                    </rs-layer>


                    <rs-layer
                        id="slider-2-slide-4-layer-9" 
                        data-type="image"
                        data-xy="xo:-190px;y:b;yo:65px;"
                        data-text="w:normal;s:20,16,12,7;l:0,20,15,9;"
                        data-dim="w:['138px','138px','138px','138px'];h:['118px','118px','118px','118px'];"
                        data-rsp_bd="off"
                        data-frame_999="o:0;st:w;"
                        data-loop_999="sX:0.8;sY:0.8;o:0.6;sp:3000;st:0;e:power2.inOut;yys:t;yyf:t;"
                        style="z-index:14;"
                    ><img src="{{ asset('images/slider/home2/slider-star1.png') }}" alt="slider-star1" class="tp-rs-img" width="138" height="118" data-no-retina> 
                    </rs-layer>
                </rs-slide>
                @endif
            </rs-slides>
        </rs-module>
    </rs-module-wrap>
    <!-- END REVOLUTION SLIDER -->

    <div class="container">
        <div class="appoinment-form" data-background="{{ asset('images/home2/form-bg.jpg') }}">
            <div class="appoinment-title">
                <h4>👉 Free Online Quote 👈</h4>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('contact.store') }}" method="POST" id="hero-slider-form">
                @csrf
                <input type="hidden" name="type" value="appointment">
                <div class="name-field-wrapper" style="position: relative;">
                    <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required 
                           class="{{ $errors->has('name') ? 'error' : '' }}">
                    <style>
                        .name-field-wrapper::after {
                            content: "Mr. Mrs. Ms.";
                            position: absolute;
                            right: 15px;
                            top: 50%;
                            transform: translateY(-50%);
                            font-style: italic;
                            color: #999;
                            pointer-events: none;
                            font-size: 14px;
                        }
                        .name-field-wrapper input[name="name"] {
                            padding-right: 120px;
                        }
                        .appoinment-form input.error,
                        .appoinment-form select.error,
                        .appoinment-form textarea.error {
                            border-color: #dc3545 !important;
                            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
                        }
                    </style>
                </div>
                <input type="tel" name="phone" placeholder="Phone Number*" value="{{ old('phone') }}" required
                       class="{{ $errors->has('phone') ? 'error' : '' }}" maxlength="20" autocomplete="tel">
                <input type="email" name="address" placeholder="Email Address" value="{{ old('address') }}"
                       class="{{ $errors->has('address') ? 'error' : '' }}">
                <div class="select-field">
                    <select name="service" required class="{{ $errors->has('service') ? 'error' : '' }}">
                        <option value="request-callback" {{ old('service') == 'request-callback' || old('service') === null ? 'selected' : '' }}>Request A Callback</option>
                        <option value="pool-resurfacing-conversion" {{ old('service') == 'pool-resurfacing-conversion' ? 'selected' : '' }}>Pool Resurfacing & Conversion</option>
                        <option value="pool-repair" {{ old('service') == 'pool-repair' ? 'selected' : '' }}>Pool Repair</option>
                        <option value="pool-remodeling" {{ old('service') == 'pool-remodeling' ? 'selected' : '' }}>Pool Remodeling</option>
                    </select>
                </div>
                <textarea name="message" placeholder="Notes for our team..." rows="8"
                          class="{{ $errors->has('message') ? 'error' : '' }}">{{ old('message') }}</textarea>
                <button type="submit" class="bixol-primary-btn">Get A Quote<span>@icon("fab fa-telegram-plane")</span></button>
            </form>
        </div>
    </div>
</div>
<!-- Hero Slider End -->