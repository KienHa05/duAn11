@php
    $success = session('success');
    $error = session('error');
@endphp

<div class="fixed top-4 right-4 z-50 space-y-2 w-[min(92vw,420px)]">
    @if($success)
        <div role="alert" class="alert alert-success shadow-lg">
            <x-heroicon-o-check-circle class="w-5 h-5" />
            <div class="min-w-0">
                <div class="font-semibold">Thành công</div>
                <div class="text-sm opacity-90 break-words">{{ $success }}</div>
            </div>
        </div>
    @endif

    @if($error)
        <div role="alert" class="alert alert-error shadow-lg">
            <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
            <div class="min-w-0">
                <div class="font-semibold">Có lỗi</div>
                <div class="text-sm opacity-90 break-words">{{ $error }}</div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div role="alert" class="alert alert-warning shadow-lg">
            <x-heroicon-o-exclamation-circle class="w-5 h-5" />
            <div class="min-w-0">
                <div class="font-semibold">Vui lòng kiểm tra lại</div>
                <ul class="text-sm opacity-90 list-disc ml-5">
                    @foreach($errors->all() as $e)
                        <li class="break-words">{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
