<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Say</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="w-full lg:max-w-2xl max-w-[335px]">
        <h1 class="text-2xl font-medium mb-6">Say Something</h1>
        
        <form method="POST" action="{{ route('say.submit') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="text" class="block text-sm font-medium mb-2">Enter your text:</label>
                <input 
                    type="text" 
                    id="text" 
                    name="text" 
                    required
                    class="w-full px-4 py-2 border border-[#19140035] dark:border-[#3E3E3A] rounded-sm bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:outline-none focus:ring-2 focus:ring-[#f53003] dark:focus:ring-[#FF4433]"
                    placeholder="Type something here..."
                >
            </div>
            
            <button 
                type="submit" 
                class="px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm hover:bg-black dark:hover:bg-white transition-colors"
            >
                Submit
            </button>
        </form>
    </div>
</body>
</html>

