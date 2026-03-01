<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Inviter un membre — {{ $colocation->name }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

        .invite-page { font-family: 'Sora', sans-serif; }

        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            color: #64748b; text-decoration: none; font-size: 0.875rem;
            font-weight: 500; margin-bottom: 28px; transition: color 0.2s;
        }
        .back-link:hover { color: #18181b; }

        .invite-section {
            max-width: 560px;
            margin: 0 auto;
        }

        /* ── Card ── */
        .invite-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #e8eaf0;
            overflow: hidden;
            box-shadow: 0 4px 32px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04);
            transition: box-shadow 0.3s;
        }
        .invite-card:hover {
            box-shadow: 0 8px 48px rgba(0,0,0,0.1), 0 2px 8px rgba(0,0,0,0.05);
        }

        /* ── Card header ── */
        .invite-card-header {
            background: linear-gradient(135deg, #18181b 0%, #27272a 60%, #1c1917 100%);
            padding: 28px 32px 24px;
            position: relative;
            overflow: hidden;
        }
        .invite-card-header::before {
            content: '';
            position: absolute; top: -40px; right: -40px;
            width: 160px; height: 160px;
            background: radial-gradient(circle, rgba(250,204,21,0.12) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }
        .invite-card-header::after {
            content: '';
            position: absolute; bottom: -30px; left: 30%;
            width: 120px; height: 120px;
            background: radial-gradient(circle, rgba(99,102,241,0.10) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }
        .ich-top {
            display: flex; align-items: center; gap: 12px;
            position: relative; z-index: 1;
        }
        .ich-icon {
            width: 44px; height: 44px;
            background: rgba(250,204,21,0.12);
            border: 1px solid rgba(250,204,21,0.25);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; flex-shrink: 0;
        }
        .ich-title { font-size: 1.1rem; font-weight: 700; color: #fafaf9; letter-spacing: -0.03em; }
        .ich-sub { font-size: 0.75rem; color: #71717a; margin-top: 2px; font-weight: 300; }

        /* ── Card body ── */
        .invite-card-body { padding: 28px 32px 32px; }

        /* ── Input group ── */
        .invite-input-group { position: relative; margin-bottom: 16px; }
        .invite-input-icon {
            position: absolute; left: 16px; top: 50%;
            transform: translateY(-50%);
            font-size: 1rem; pointer-events: none;
            color: #a1a1aa; transition: color 0.2s;
        }
        .invite-email-input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 1.5px solid #e4e4e7; border-radius: 14px;
            font-family: 'Sora', sans-serif; font-size: 0.9rem;
            outline: none; background: #fafafa; color: #18181b;
            box-sizing: border-box;
            transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
        }
        .invite-email-input::placeholder { color: #a1a1aa; }
        .invite-email-input:focus {
            border-color: #facc15; background: #fff;
            box-shadow: 0 0 0 3px rgba(250,204,21,0.12);
        }
        .error-msg { color: #ef4444; font-size: 0.78rem; margin-top: 6px; }

        /* ── Submit button ── */
        .invite-btn {
            width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            background: #18181b; color: #fafaf9; border: none;
            padding: 14px 24px; border-radius: 14px;
            font-family: 'Sora', sans-serif; font-weight: 700; font-size: 0.9rem;
            cursor: pointer; transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
            letter-spacing: -0.01em; position: relative; overflow: hidden;
        }
        .invite-btn::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(250,204,21,0.08), transparent);
            opacity: 0; transition: opacity 0.2s;
        }
        .invite-btn:hover { background: #27272a; transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,0,0,0.18); }
        .invite-btn:hover::before { opacity: 1; }
        .invite-btn:active { transform: translateY(0); box-shadow: none; }
        .invite-btn-arrow {
            display: inline-flex; align-items: center; justify-content: center;
            width: 22px; height: 22px;
            background: rgba(250,204,21,0.15); border-radius: 6px; font-size: 0.85rem;
            transition: transform 0.2s;
        }
        .invite-btn:hover .invite-btn-arrow { transform: translateX(3px); }

        /* ── Divider ── */
        .invite-divider {
            display: flex; align-items: center; gap: 12px; margin: 24px 0 20px;
        }
        .invite-divider::before, .invite-divider::after {
            content: ''; flex: 1; height: 1px; background: #f0f0f0;
        }
        .invite-divider span {
            font-size: 0.7rem; color: #a1a1aa; text-transform: uppercase;
            letter-spacing: 0.1em; font-family: 'DM Mono', monospace; white-space: nowrap;
        }

        /* ── Pending list ── */
        .pending-title {
            font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.12em;
            color: #a1a1aa; font-weight: 600; font-family: 'DM Mono', monospace;
            margin-bottom: 14px; display: flex; align-items: center; gap: 8px;
        }
        .pending-count {
            background: #f4f4f5; color: #71717a; font-size: 0.65rem;
            padding: 2px 8px; border-radius: 20px; font-weight: 700;
        }
        .pending-list { display: flex; flex-direction: column; gap: 8px; }
        .pending-row {
            display: flex; align-items: center; justify-content: space-between;
            background: #fafafa; border: 1px solid #f0f0f0; border-radius: 12px;
            padding: 11px 16px; transition: all 0.2s;
            animation: slideIn 0.3s ease both;
        }
        @keyframes slideIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
        .pending-row:hover { background: #f4f4f5; border-color: #e4e4e7; }

        .pr-left { display: flex; align-items: center; gap: 10px; }
        .pr-avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #e4e4e7, #d4d4d8);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 700; color: #71717a;
            font-family: 'DM Mono', monospace; flex-shrink: 0;
        }
        .pr-email { font-size: 0.85rem; color: #27272a; font-weight: 500; }
        .pr-badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 0.68rem; font-family: 'DM Mono', monospace; font-weight: 500;
            padding: 4px 10px; border-radius: 20px;
            background: #fefce8; color: #854d0e; border: 1px solid #fef08a;
        }
        .pr-dot {
            width: 5px; height: 5px; background: #eab308; border-radius: 50%;
            animation: pulse 1.8s ease-in-out infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:0.5;transform:scale(0.8);} }

        .empty-pending { text-align: center; padding: 20px; color: #a1a1aa; font-size: 0.82rem; }
        .empty-pending .ep-icon { font-size: 1.6rem; margin-bottom: 6px; }

        .flash-success, .flash-error {
            border-radius: 12px; padding: 12px 16px; font-size: 0.83rem; font-weight: 500;
            display: flex; align-items: center; gap: 9px; margin-bottom: 18px;
        }
        .flash-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
        .flash-error   { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
    </style>

    <div class="py-8 px-4 sm:px-6 lg:px-8 invite-page">
        <div class="invite-section">

            <a href="{{ route('colocations.show', $colocation) }}" class="back-link">
                ← Retour à {{ $colocation->name }}
            </a>

            @if(session('error'))
                <div class="flash-error">⚠️ {{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="flash-success">✓ {{ session('success') }}</div>
            @endif

            <div class="invite-card">

                <div class="invite-card-header">
                    <div class="ich-top">
                        <div class="ich-icon">✉️</div>
                        <div>
                            <div class="ich-title">Inviter un membre</div>
                            <div class="ich-sub">{{ $colocation->name }}</div>
                        </div>
                    </div>
                </div>

                <div class="invite-card-body">

                    <form method="POST" action="{{ route('invitations.store', $colocation) }}">
                        @csrf
                        <div class="invite-input-group">
                            <span class="invite-input-icon">@</span>
                            <input
                                type="email"
                                name="invited_email"
                                class="invite-email-input"
                                placeholder="colocataire@exemple.com"
                                required
                                autocomplete="off"
                                value="{{ old('invited_email') }}"
                                autofocus
                            >
                        </div>
                        @error('invited_email')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="invite-btn" style="margin-top: 14px;">
                            Envoyer l'invitation
                            <span class="invite-btn-arrow">→</span>
                        </button>
                    </form>

                    @php $pendingInvs = $colocation->invitations->where('status', 'pending'); @endphp

                    <div class="invite-divider"><span>invitations en attente</span></div>

                    <div class="pending-title">
                        En attente
                        <span class="pending-count">{{ $pendingInvs->count() }}</span>
                    </div>

                    @if($pendingInvs->isEmpty())
                        <div class="empty-pending">
                            <div class="ep-icon">📭</div>
                            Aucune invitation en attente
                        </div>
                    @else
                        <div class="pending-list">
                            @foreach($pendingInvs as $inv)
                                <div class="pending-row">
                                    <div class="pr-left">
                                        <div class="pr-avatar">{{ strtoupper(substr($inv->invited_email, 0, 2)) }}</div>
                                        <span class="pr-email">{{ $inv->invited_email }}</span>
                                    </div>
                                    <span class="pr-badge">
                                        <span class="pr-dot"></span>
                                        En attente
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>