<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DailyTask - Task & Reminder via WhatsApp">
    <title>@yield('title', 'DailyTask') - Task & Reminder</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Lordicon -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    

    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .checkbox-custom {
            appearance: none;
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid #667eea;
            border-radius: 0.375rem;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .checkbox-custom:checked {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .checkbox-custom:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
        }
        
        /* Line clamp utilities */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Responsive text utilities */
        @media (max-width: 640px) {
            .text-responsive {
                font-size: 0.875rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @if(session('success'))
    <div class="fixed top-4 right-4 z-50 animate-fade-in">
        <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3">
            <div class="flex-shrink-0">
                <lord-icon
                    src="https://cdn.lordicon.com/egiwmiit.json"
                    trigger="in"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:24px;height:24px">
                </lord-icon>
            </div>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    <script>
        setTimeout(() => {
            document.querySelector('.fixed.top-4').style.opacity = '0';
            setTimeout(() => {
                document.querySelector('.fixed.top-4').remove();
            }, 300);
        }, 3000);
    </script>
    @endif

    @yield('content')

    @stack('scripts')
</body>
</html>
