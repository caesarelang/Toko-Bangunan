<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #0a0a0a;
            overflow: hidden;
            position: relative;
        }
        /* Alert Error Box */
.alert {
    padding: 15px 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    animation: slideDown 0.3s ease;
}

.alert-error {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.3);
    backdrop-filter: blur(10px);
}

.alert-error p {
    color: #ffffff;
    font-size: 14px;
    margin: 5px 0;
    line-height: 1.5;
}

.alert-error p:first-child {
    margin-top: 0;
}

.alert-error p:last-child {
    margin-bottom: 0;
}

/* Error Text per Field */
.error-text {
    display: block;
    color: #ffffff;
    font-size: 13px;
    margin-top: 6px;
    padding-left: 4px;
    animation: fadeIn 0.3s ease;
}

/* Input Error State */
.input-error {
    border: 1px solid rgba(239, 68, 68, 0.5) !important;
    background: rgba(239, 68, 68, 0.05) !important;
}

/* Animation */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
        /* Animated Particles Background */
        .grid-background {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            animation: particleFloat 15s infinite;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .particle::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: inherit;
            border-radius: 50%;
            animation: pulse-particle 1.5s infinite;
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) translateX(0) scale(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(200px) scale(1.5) rotate(720deg);
                opacity: 0;
            }
        }

        @keyframes pulse-particle {
            0%, 100% {
                transform: scale(1);
                opacity: 0.8;
            }
            50% {
                transform: scale(2);
                opacity: 1;
            }
        }

        /* Animated Lines */
        .line {
            position: absolute;
            width: 2px;
            height: 150px;
            background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.6), transparent);
            animation: lineMove 12s infinite linear;
        }

        @keyframes lineMove {
            0% {
                transform: translateY(-100%) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(180deg);
                opacity: 0;
            }
        }

        /* Diagonal Lines */
        .diagonal-line {
            position: absolute;
            width: 300px;
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(200, 200, 200, 0.4), transparent);
            animation: diagonalMove 20s infinite linear;
        }

        @keyframes diagonalMove {
            0% {
                transform: translate(-100%, -100%) rotate(45deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translate(200vw, 200vh) rotate(45deg);
                opacity: 0;
            }
        }

        /* Circles */
        .circle {
            position: absolute;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: circleExpand 8s infinite ease-out;
        }

        @keyframes circleExpand {
            0% {
                width: 20px;
                height: 20px;
                opacity: 1;
            }
            100% {
                width: 300px;
                height: 300px;
                opacity: 0;
            }
        }

        /* Stars */
        .star {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            animation: starTwinkle 3s infinite;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
        }

        @keyframes starTwinkle {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.5);
            }
        }

        /* Glowing Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.5;
            animation: float 15s infinite ease-in-out;
        }

        .orb1 {
            width: 500px;
            height: 500px;
            background: linear-gradient(45deg, #888888, #666666);
            top: -250px;
            left: -250px;
            animation: float 20s infinite ease-in-out, rotate 30s infinite linear;
        }

        .orb2 {
            width: 600px;
            height: 600px;
            background: linear-gradient(45deg, #aaaaaa, #888888);
            bottom: -300px;
            right: -300px;
            animation: float 25s infinite ease-in-out, rotate 40s infinite linear reverse;
        }

        .orb3 {
            width: 450px;
            height: 450px;
            background: linear-gradient(45deg, #777777, #555555);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: float 22s infinite ease-in-out, rotate 35s infinite linear;
        }

        .orb4 {
            width: 350px;
            height: 350px;
            background: linear-gradient(45deg, #cccccc, #999999);
            top: 20%;
            right: 10%;
            animation: float 18s infinite ease-in-out, rotate 28s infinite linear;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }
            25% {
                transform: translate(200px, -200px) scale(1.3) rotate(90deg);
            }
            50% {
                transform: translate(0, -100px) scale(0.8) rotate(180deg);
            }
            75% {
                transform: translate(-200px, 200px) scale(1.1) rotate(270deg);
            }
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: rgba(17, 17, 17, 0.000001);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border-radius: 24px;
            padding: 60px 45px;
            box-shadow: 
                0 8px 32px 0 rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.000001), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% {
                left: -100%;
            }
            100% {
                left: 100%;
            }
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #ffffff, #e5e5e5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 40px rgba(255, 255, 255, 0.4);
            animation: pulse 2s infinite;
            position: relative;
            overflow: visible;
        }

        /* Palu */
        .logo-circle::before {
            content: '🔨';
            position: absolute;
            font-size: 28px;
            animation: hammerSwing 2s infinite ease-in-out;
            transform-origin: bottom right;
        }

        /* Obeng/Sekrup */
        .logo-circle::after {
            content: '🔧';
            position: absolute;
            font-size: 24px;
            animation: wrenchRotate 3s infinite ease-in-out;
        }

        @keyframes hammerSwing {
            0%, 100% {
                transform: rotate(-15deg) translateY(0);
            }
            50% {
                transform: rotate(15deg) translateY(-5px);
            }
        }

        @keyframes wrenchRotate {
            0%, 100% {
                transform: rotate(0deg) scale(1);
            }
            33% {
                transform: rotate(120deg) scale(1.1);
            }
            66% {
                transform: rotate(240deg) scale(0.9);
            }
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 10px 40px rgba(255, 255, 255, 0.4);
                transform: scale(1);
            }
            50% {
                box-shadow: 0 10px 60px rgba(255, 255, 255, 0.6);
                transform: scale(1.05);
            }
        }

        h1 {
            color: #fff;
            text-align: center;
            margin-bottom: 15px;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 40px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .input-wrapper {
            position: relative;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 16px 20px;
            background: transparent !important;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: #cccccc;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        input[type="email"]:-webkit-autofill,
        input[type="password"]:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
            -webkit-text-fill-color: #fff !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #aaaaaa 0%, #888888 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 30px 0;
            color: rgba(255, 255, 255, 0.3);
            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .divider span {
            padding: 0 15px;
        }

        .extra-links {
            text-align: center;
        }

        .extra-links a {
            color: #cccccc;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .extra-links a:hover {
            color: #ffffff;
        }

        .social-login {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .social-btn {
            padding: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .social-btn:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.15);
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 50px 35px;
            }

            h1 {
                font-size: 28px;
            }

            .logo-circle {
                width: 70px;
                height: 70px;
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <div class="grid-background">
        <!-- Particles (40 particles) -->
        <div class="particle" style="left: 5%; animation-delay: 0s; animation-duration: 12s;"></div>
        <div class="particle" style="left: 10%; animation-delay: 0.5s; animation-duration: 14s;"></div>
        <div class="particle" style="left: 15%; animation-delay: 1s; animation-duration: 16s;"></div>
        <div class="particle" style="left: 20%; animation-delay: 1.5s; animation-duration: 13s;"></div>
        <div class="particle" style="left: 25%; animation-delay: 2s; animation-duration: 15s;"></div>
        <div class="particle" style="left: 30%; animation-delay: 2.5s; animation-duration: 17s;"></div>
        <div class="particle" style="left: 35%; animation-delay: 3s; animation-duration: 11s;"></div>
        <div class="particle" style="left: 40%; animation-delay: 3.5s; animation-duration: 14s;"></div>
        <div class="particle" style="left: 45%; animation-delay: 4s; animation-duration: 16s;"></div>
        <div class="particle" style="left: 50%; animation-delay: 4.5s; animation-duration: 12s;"></div>
        <div class="particle" style="left: 55%; animation-delay: 5s; animation-duration: 15s;"></div>
        <div class="particle" style="left: 60%; animation-delay: 5.5s; animation-duration: 13s;"></div>
        <div class="particle" style="left: 65%; animation-delay: 6s; animation-duration: 17s;"></div>
        <div class="particle" style="left: 70%; animation-delay: 6.5s; animation-duration: 14s;"></div>
        <div class="particle" style="left: 75%; animation-delay: 7s; animation-duration: 16s;"></div>
        <div class="particle" style="left: 80%; animation-delay: 7.5s; animation-duration: 11s;"></div>
        <div class="particle" style="left: 85%; animation-delay: 8s; animation-duration: 15s;"></div>
        <div class="particle" style="left: 90%; animation-delay: 8.5s; animation-duration: 13s;"></div>
        <div class="particle" style="left: 95%; animation-delay: 9s; animation-duration: 14s;"></div>
        <div class="particle" style="left: 3%; animation-delay: 1.2s; animation-duration: 16s;"></div>
        <div class="particle" style="left: 8%; animation-delay: 2.2s; animation-duration: 12s;"></div>
        <div class="particle" style="left: 13%; animation-delay: 3.2s; animation-duration: 15s;"></div>
        <div class="particle" style="left: 18%; animation-delay: 4.2s; animation-duration: 17s;"></div>
        <div class="particle" style="left: 23%; animation-delay: 5.2s; animation-duration: 13s;"></div>
        <div class="particle" style="left: 28%; animation-delay: 6.2s; animation-duration: 14s;"></div>
        <div class="particle" style="left: 33%; animation-delay: 7.2s; animation-duration: 16s;"></div>
        <div class="particle" style="left: 38%; animation-delay: 8.2s; animation-duration: 11s;"></div>
        <div class="particle" style="left: 43%; animation-delay: 9.2s; animation-duration: 15s;"></div>
        <div class="particle" style="left: 48%; animation-delay: 1.8s; animation-duration: 13s;"></div>
        <div class="particle" style="left: 53%; animation-delay: 2.8s; animation-duration: 17s;"></div>
        <div class="particle" style="left: 58%; animation-delay: 3.8s; animation-duration: 14s;"></div>
        <div class="particle" style="left: 63%; animation-delay: 4.8s; animation-duration: 12s;"></div>
        <div class="particle" style="left: 68%; animation-delay: 5.8s; animation-duration: 16s;"></div>
        <div class="particle" style="left: 73%; animation-delay: 6.8s; animation-duration: 15s;"></div>
        <div class="particle" style="left: 78%; animation-delay: 7.8s; animation-duration: 13s;"></div>
        <div class="particle" style="left: 83%; animation-delay: 8.8s; animation-duration: 14s;"></div>
        <div class="particle" style="left: 88%; animation-delay: 9.8s; animation-duration: 17s;"></div>
        <div class="particle" style="left: 93%; animation-delay: 0.3s; animation-duration: 11s;"></div>
        <div class="particle" style="left: 98%; animation-delay: 1.3s; animation-duration: 16s;"></div>
        <div class="particle" style="left: 12%; animation-delay: 2.3s; animation-duration: 15s;"></div>
        
        <!-- Vertical Lines (12 lines) -->
        <div class="line" style="left: 8%; animation-delay: 0s; animation-duration: 10s;"></div>
        <div class="line" style="left: 16%; animation-delay: 1.5s; animation-duration: 12s;"></div>
        <div class="line" style="left: 24%; animation-delay: 3s; animation-duration: 11s;"></div>
        <div class="line" style="left: 32%; animation-delay: 4.5s; animation-duration: 13s;"></div>
        <div class="line" style="left: 40%; animation-delay: 6s; animation-duration: 10s;"></div>
        <div class="line" style="left: 48%; animation-delay: 7.5s; animation-duration: 12s;"></div>
        <div class="line" style="left: 56%; animation-delay: 2s; animation-duration: 11s;"></div>
        <div class="line" style="left: 64%; animation-delay: 3.5s; animation-duration: 13s;"></div>
        <div class="line" style="left: 72%; animation-delay: 5s; animation-duration: 10s;"></div>
        <div class="line" style="left: 80%; animation-delay: 6.5s; animation-duration: 12s;"></div>
        <div class="line" style="left: 88%; animation-delay: 8s; animation-duration: 11s;"></div>
        <div class="line" style="left: 96%; animation-delay: 1s; animation-duration: 13s;"></div>
        
        <!-- Diagonal Lines (8 lines) -->
        <div class="diagonal-line" style="top: 10%; animation-delay: 0s;"></div>
        <div class="diagonal-line" style="top: 20%; animation-delay: 3s;"></div>
        <div class="diagonal-line" style="top: 30%; animation-delay: 6s;"></div>
        <div class="diagonal-line" style="top: 40%; animation-delay: 9s;"></div>
        <div class="diagonal-line" style="top: 50%; animation-delay: 12s;"></div>
        <div class="diagonal-line" style="top: 60%; animation-delay: 15s;"></div>
        <div class="diagonal-line" style="top: 70%; animation-delay: 2s;"></div>
        <div class="diagonal-line" style="top: 80%; animation-delay: 5s;"></div>
        
        <!-- Expanding Circles (6 circles) -->
        <div class="circle" style="left: 20%; top: 30%; animation-delay: 0s;"></div>
        <div class="circle" style="left: 50%; top: 20%; animation-delay: 2s;"></div>
        <div class="circle" style="left: 80%; top: 60%; animation-delay: 4s;"></div>
        <div class="circle" style="left: 30%; top: 70%; animation-delay: 1s;"></div>
        <div class="circle" style="left: 60%; top: 50%; animation-delay: 3s;"></div>
        <div class="circle" style="left: 90%; top: 40%; animation-delay: 5s;"></div>
        
        <!-- Twinkling Stars (25 stars) -->
        <div class="star" style="left: 15%; top: 15%; animation-delay: 0s;"></div>
        <div class="star" style="left: 25%; top: 25%; animation-delay: 0.3s;"></div>
        <div class="star" style="left: 35%; top: 35%; animation-delay: 0.6s;"></div>
        <div class="star" style="left: 45%; top: 45%; animation-delay: 0.9s;"></div>
        <div class="star" style="left: 55%; top: 55%; animation-delay: 1.2s;"></div>
        <div class="star" style="left: 65%; top: 65%; animation-delay: 1.5s;"></div>
        <div class="star" style="left: 75%; top: 75%; animation-delay: 1.8s;"></div>
        <div class="star" style="left: 85%; top: 85%; animation-delay: 2.1s;"></div>
        <div class="star" style="left: 10%; top: 50%; animation-delay: 2.4s;"></div>
        <div class="star" style="left: 20%; top: 60%; animation-delay: 2.7s;"></div>
        <div class="star" style="left: 30%; top: 70%; animation-delay: 0.2s;"></div>
        <div class="star" style="left: 40%; top: 80%; animation-delay: 0.5s;"></div>
        <div class="star" style="left: 50%; top: 90%; animation-delay: 0.8s;"></div>
        <div class="star" style="left: 60%; top: 20%; animation-delay: 1.1s;"></div>
        <div class="star" style="left: 70%; top: 30%; animation-delay: 1.4s;"></div>
        <div class="star" style="left: 80%; top: 40%; animation-delay: 1.7s;"></div>
        <div class="star" style="left: 90%; top: 50%; animation-delay: 2s;"></div>
        <div class="star" style="left: 5%; top: 25%; animation-delay: 2.3s;"></div>
        <div class="star" style="left: 15%; top: 45%; animation-delay: 2.6s;"></div>
        <div class="star" style="left: 25%; top: 65%; animation-delay: 2.9s;"></div>
        <div class="star" style="left: 35%; top: 85%; animation-delay: 0.4s;"></div>
        <div class="star" style="left: 95%; top: 15%; animation-delay: 0.7s;"></div>
        <div class="star" style="left: 85%; top: 35%; animation-delay: 1s;"></div>
        <div class="star" style="left: 75%; top: 55%; animation-delay: 1.3s;"></div>
        <div class="star" style="left: 65%; top: 75%; animation-delay: 1.6s;"></div>
    </div>
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>
    <div class="orb orb4"></div>

    <div class="login-container">
        <div class="login-card">
        <div class="logo-circle"></div>
            <h1>Selamat Datang</h1>
            <p class="subtitle">Silakan masuk untuk melanjutkan</p>
            
            <form method="POST" action="{{ route('login') }}">
    @csrf
    
    <!-- Pesan Error -->
    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    
    <div class="form-group">
        <label for="email">Alamat Email</label>
        <div class="input-wrapper">
            <input type="email" id="email" name="email" 
                   class="@error('email') input-error @enderror"
                   value="{{ old('email') }}"
                   placeholder="nama@email.com" required>
        </div>
        @error('email')
            <span class="error-text">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Kata Sandi</label>
        <div class="input-wrapper">
            <input type="password" id="password" name="password" 
                   class="@error('password') input-error @enderror"
                   placeholder="Masukkan kata sandi" required>
        </div>
        @error('password')
            <span class="error-text">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn-login">Masuk</button>
    


                <div class="divider"></div>

                <div class="extra-links">
                    <span style="color: rgba(255, 255, 255, 0.5); font-size: 14px;">Belum punya akun? </span>
                    <a href="{{ route('register.form') }}">Daftar Sekarang</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>