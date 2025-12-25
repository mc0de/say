<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Say</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0d150d] text-[#EDEDEC] flex items-center justify-center min-h-screen">
    <!-- Confetti canvas -->
    <canvas id="confetti-canvas" class="fixed top-0 left-0 w-full h-full pointer-events-none z-50" style="display: none;"></canvas>

    <div class="w-full max-w-4xl px-6">
        <form method="POST" action="{{ route('say.submit') }}" class="relative">
            @csrf

            <!-- Success message - positioned absolutely above input -->
            @if(session('success'))
                <div id="success-message" class="absolute bottom-full left-0 right-0 mb-4 flex items-center justify-between gap-3 px-5 py-3 bg-emerald-950 text-[#10b981] rounded-2xl backdrop-blur-sm transition-all duration-150 opacity-100">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <span id="countdown-timer" class="text-xs font-medium text-[#10b981]/70">5s</span>
                </div>
            @endif

            <!-- Error message - positioned absolutely above input -->
            @if(session('error'))
                <div id="error-message" class="absolute bottom-full left-0 right-0 mb-4 flex items-center gap-3 px-5 py-3 bg-[#161615] border border-red-500/40 text-red-400 rounded-2xl backdrop-blur-sm transition-all duration-150 opacity-100">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="relative group">
                <!-- Spotlight input container -->
                <div class="relative">
                    <!-- Glow effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-[#10b981]/20 via-[#059669]/20 to-[#10b981]/20 rounded-2xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-150"></div>

                    <!-- Input wrapper -->
                    <div class="relative bg-[#161615] border border-[#3E3E3A] rounded-2xl p-2 shadow-[0_8px_32px_rgba(0,0,0,0.4)] backdrop-blur-sm transition-all duration-150 group-hover:border-[#62605b] group-focus-within:border-[#10b981] group-focus-within:shadow-[0_8px_32px_rgba(16,185,129,0.3)]">
                        <div class="flex items-center gap-4 px-6 py-5">
                            <!-- Chat icon (Heroicons solid chat-bubble-left) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-[#A1A09A] group-focus-within:text-[#10b981] transition-colors duration-150 flex-shrink-0">
                              <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97-1.94.284-3.916.455-5.922.505a.39.39 0 0 0-.266.112L8.78 21.53A.75.75 0 0 1 7.5 21v-3.955a48.842 48.842 0 0 1-2.652-.316c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97Z" clip-rule="evenodd" />
                            </svg>

                            <!-- Input field -->
                            <input
                                type="text"
                                id="text"
                                name="text"
                                required
                                autocomplete="off"
                                class="flex-1 bg-transparent text-[#EDEDEC] text-xl placeholder:text-[#706f6c] focus:outline-none focus:placeholder:text-[#A1A09A] transition-colors duration-150"
                                placeholder="What's on your mind?"
                            />

                            <!-- Submit button integrated -->
                            <button
                                type="submit"
                                class="px-6 py-2.5 bg-[#10b981] hover:bg-[#059669] text-white rounded-xl font-medium transition-all duration-150 hover:scale-105 active:scale-95 shadow-lg hover:shadow-[#10b981]/50"
                            >
                                Say
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
