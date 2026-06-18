<x-layouts.head title="Reset Password">
    <div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-zinc-50 py-12 sm:px-6 lg:px-8 dark:bg-zinc-950">
        {{-- Decorative background gradients --}}
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(99,102,241,0.06),transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(6,182,212,0.06),transparent_50%)]"></div>

        <div class="relative sm:mx-auto sm:w-full sm:max-w-md z-10">
            {{-- Logo / Header --}}
            <div class="text-center">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-zinc-900 text-lg font-semibold tracking-wider text-white dark:bg-zinc-100 dark:text-zinc-900 shadow-lg transition-transform hover:scale-105 duration-300">
                    P
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold tracking-tight text-zinc-900 dark:text-white">
                    Reset your password
                </h2>
                <p class="mt-2 text-center text-sm text-zinc-600 dark:text-zinc-400">
                    Create a new secure password for your account.
                </p>
            </div>

            {{-- Form Card --}}
            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md py-8 px-4 shadow-xl border border-zinc-150 dark:border-zinc-800/80 sm:rounded-2xl sm:px-10">
                    <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        @if ($errors->any())
                            <div class="rounded-lg bg-red-50 p-4 dark:bg-red-950/20 border border-red-150 dark:border-red-900/30">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <flux:icon name="x-circle" class="h-5 w-5 text-red-500 dark:text-red-500" />
                                    </div>
                                    <div class="ml-3">
                                        <ul class="list-disc list-inside text-xs text-red-700 dark:text-red-400/85 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <flux:field>
                            <flux:label>Email Address</flux:label>
                            <flux:input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="name@example.com" />
                        </flux:field>

                        <flux:field>
                            <flux:label>New Password</flux:label>
                            <flux:input type="password" name="password" required placeholder="••••••••" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Confirm New Password</flux:label>
                            <flux:input type="password" name="password_confirmation" required placeholder="••••••••" />
                        </flux:field>

                        <div>
                            <flux:button type="submit" variant="primary" class="w-full justify-center">
                                Reset Password
                            </flux:button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.head>
