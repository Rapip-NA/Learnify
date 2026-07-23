<div class="flex justify-center items-center min-h-[calc(100vh-140px)] sm:min-h-[calc(100vh-200px)]">
    <div class="w-full max-w-md mx-4 sm:mx-0 slide-in">
        <div class="auth-card backdrop-blur-xl rounded-3xl shadow-2xl border p-6 sm:p-10 relative overflow-hidden">
            <!-- Decorative gradient top -->
            <div class="absolute top-0 left-0 w-full h-2 gradient-primary"></div>

            <div class="text-center mb-6 sm:mb-10">
                <h1 class="text-2xl sm:text-3xl font-bold text-secondary mb-2">Selamat Datang! 👋</h1>
                <p class="text-muted text-sm sm:text-base">Masuk untuk melanjutkan pembelajaran Anda.</p>
            </div>

            <form wire:submit.prevent="login" class="space-y-4 sm:space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium form-label mb-1.5 sm:mb-2">Email
                        Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 icon-color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                </path>
                            </svg>
                        </div>
                        <input wire:model="email" type="email" id="email"
                            class="form-input w-full pl-11 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors outline-none text-sm sm:text-base @error('email') border-red-500 ring-red-500 @enderror"
                            placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 icon-color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <input wire:model="password" type="password" id="password"
                            class="form-input w-full pl-11 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors outline-none text-sm sm:text-base @error('password') border-red-500 ring-red-500 @enderror"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full btn-gradient text-white font-bold py-3 sm:py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 text-sm sm:text-base">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-6 sm:mt-8 text-center">
                <p class="text-muted text-sm sm:text-base">Belum punya akun?
                    <a href="{{ route('register') }}"
                        class="font-bold text-indigo-400 hover:text-indigo-300 transition-colors">Daftar Gratis</a>
                </p>
            </div>

            <!-- Quick Login for testing -->
            <div class="mt-6 pt-6 border-t border-slate-700/50">
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider text-center mb-3">Quick Login (Testing)</p>
                <div class="grid grid-cols-3 gap-2">
                    <button wire:click="loginAs('admin')" type="button"
                        class="px-3 py-2 text-xs font-semibold rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500/30 border border-red-500/30 transition text-center">
                        Admin
                    </button>
                    <button wire:click="loginAs('qualifier')" type="button"
                        class="px-3 py-2 text-xs font-semibold rounded-lg bg-pink-500/20 text-pink-400 hover:bg-pink-500/30 border border-pink-500/30 transition text-center">
                        Qualifier
                    </button>
                    <button wire:click="loginAs('peserta')" type="button"
                        class="px-3 py-2 text-xs font-semibold rounded-lg bg-indigo-500/20 text-indigo-400 hover:bg-indigo-500/30 border border-indigo-500/30 transition text-center">
                        Peserta
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
