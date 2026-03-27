@php
    $success = session('success');
    $error = session('error');
    $validationErrors = $errors->any() ? $errors->all() : [];
@endphp

@if($success || $error || count($validationErrors))
    <div id="app-toast-root" class="toast toast-top toast-end z-50">
        @if($success)
            <div class="alert alert-success shadow-lg" data-toast data-timeout="3500">
                <x-heroicon-o-check-circle class="w-5 h-5" />
                <div class="min-w-0">
                    <div class="font-semibold">Thành công</div>
                    <div class="text-sm opacity-90 break-words">{{ $success }}</div>
                </div>
                <button type="button" class="btn btn-ghost btn-sm" data-toast-close aria-label="Close">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>
        @endif

        @if($error)
            <div class="alert alert-error shadow-lg" data-toast data-timeout="4500">
                <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                <div class="min-w-0">
                    <div class="font-semibold">Có lỗi</div>
                    <div class="text-sm opacity-90 break-words">{{ $error }}</div>
                </div>
                <button type="button" class="btn btn-ghost btn-sm" data-toast-close aria-label="Close">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>
        @endif

        @if(count($validationErrors))
            <div class="alert alert-warning shadow-lg" data-toast data-timeout="6000">
                <x-heroicon-o-exclamation-circle class="w-5 h-5" />
                <div class="min-w-0">
                    <div class="font-semibold">Vui lòng kiểm tra lại</div>
                    <ul class="text-sm opacity-90 list-disc ml-5">
                        @foreach($validationErrors as $e)
                            <li class="break-words">{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn btn-ghost btn-sm" data-toast-close aria-label="Close">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>
        @endif
    </div>

    <script>
        (function () {
            const root = document.getElementById('app-toast-root');
            if (!root) return;

            root.querySelectorAll('[data-toast]').forEach((toast) => {
                const timeout = Number(toast.getAttribute('data-timeout') || '3500');

                const close = () => {
                    toast.remove();
                    if (root.children.length === 0) root.remove();
                };

                const closeBtn = toast.querySelector('[data-toast-close]');
                if (closeBtn) closeBtn.addEventListener('click', close, { once: true });

                window.setTimeout(close, timeout);
            });
        })();
    </script>
@endif
