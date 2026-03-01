{{-- resources/views/invitations/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Invitation
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap');
        .inv-root { font-family: 'Sora', sans-serif; }

        .inv-wrapper {
            max-width: 480px;
            margin: 60px auto;
        }
        .inv-card {
            background: #fff;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            border: 1px solid #f1f5f9;
            text-align: center;
        }
        .dark .inv-card { background: #1e293b; border-color: #334155; }

        .inv-icon {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
        }
        .inv-from {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            margin-bottom: 6px;
        }
        .inv-sender {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
        }
        .dark .inv-sender { color: #f1f5f9; }
        .inv-message {
            font-size: 0.95rem;
            color: #64748b;
            margin: 16px 0 8px;
        }
        .inv-coloc-name {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.03em;
            margin-bottom: 28px;
        }
        .dark .inv-coloc-name { color: #f1f5f9; }

        .inv-actions {
            display: flex;
            gap: 12px;
        }
        .btn-accept {
            flex: 1;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-accept:hover { opacity: 0.9; transform: translateY(-2px); box-shadow: 0 10px 25px rgba(34,197,94,0.35); }

        .btn-refuse {
            flex: 1;
            background: transparent;
            color: #ef4444;
            border: 1.5px solid #fecaca;
            padding: 14px;
            border-radius: 12px;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-refuse:hover { background: #fef2f2; border-color: #ef4444; }

        .status-box {
            border-radius: 12px;
            padding: 16px 20px;
            font-weight: 600;
        }
        .status-accepted { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .status-refused { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .status-expired { background: #fefce8; color: #854d0e; border: 1px solid #fef08a; }
        .status-pending { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }

        .divider {
            height: 1px;
            background: #f1f5f9;
            margin: 24px 0;
        }
        .dark .divider { background: #334155; }
    </style>

    <div class="py-8 px-4 inv-root">
        <div class="inv-wrapper">
            <div class="inv-card">
                <div class="inv-icon">📩</div>

                <div class="inv-from">Invitation de</div>
                <div class="inv-sender">{{ $invitation->sender->name }}</div>

                <div class="divider"></div>

                <div class="inv-message">Vous êtes invité(e) à rejoindre</div>
                <div class="inv-coloc-name">{{ $invitation->colocation->name }}</div>

                @if($invitation->status !== 'pending')
                    <div class="status-box status-{{ $invitation->status }}">
                        @if($invitation->status === 'accepted') ✓ Invitation acceptée
                        @elseif($invitation->status === 'refused') ✗ Invitation refusée
                        @elseif($invitation->status === 'expired') ⏰ Invitation expirée
                        @else {{ ucfirst($invitation->status) }}
                        @endif
                    </div>
                @else
                    @if($invitation->expire_at)
                        <p style="font-size:0.78rem; color:#94a3b8; margin-bottom:20px;">
                            ⏱ Expire le {{ \Carbon\Carbon::parse($invitation->expire_at)->format('d/m/Y à H:i') }}
                        </p>
                    @endif

                    <div class="inv-actions">
                        <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}" style="flex:1;">
                            @csrf
                            <button type="submit" class="btn-accept" style="width:100%;">✓ Accepter</button>
                        </form>
                        <form method="POST" action="{{ route('invitations.refuse', $invitation->token) }}" style="flex:1;">
                            @csrf
                            <button type="submit" class="btn-refuse" style="width:100%;">✗ Refuser</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>