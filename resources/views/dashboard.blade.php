<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

        .dash-root { font-family: 'Sora', sans-serif; }

        .hero-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f4c75 100%);
            border-radius: 20px;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }
        .hero-banner::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(56,189,248,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .hero-banner::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 20%;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
            border-radius: 50%;
        }
        .hero-greeting {
            font-size: 2rem;
            font-weight: 700;
            color: #f8fafc;
            letter-spacing: -0.03em;
            position: relative; z-index: 1;
        }
        .hero-greeting span { color: #38bdf8; }
        .hero-sub {
            color: #94a3b8;
            font-size: 0.95rem;
            margin-top: 6px;
            position: relative; z-index: 1;
            font-weight: 300;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-top: 24px;
        }
        .stat-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 20px 24px;
            position: relative; z-index: 1;
            backdrop-filter: blur(10px);
        }
        .stat-card .s-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            font-family: 'DM Mono', monospace;
        }
        .stat-card .s-value {
            font-size: 2rem;
            font-weight: 700;
            color: #f1f5f9;
            line-height: 1;
            margin-top: 6px;
        }
        .stat-card .s-icon {
            position: absolute;
            top: 16px; right: 16px;
            font-size: 1.4rem;
            opacity: 0.5;
        }

        .quick-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 32px;
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #38bdf8;
            color: #0f172a;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 11px 22px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
            letter-spacing: -0.01em;
        }
        .btn-primary:hover { background: #7dd3fc; transform: translateY(-1px); box-shadow: 0 8px 20px rgba(56,189,248,0.3); }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.06);
            color: #cbd5e1;
            border: 1px solid rgba(255,255,255,0.1);
            font-weight: 500;
            font-size: 0.875rem;
            padding: 11px 22px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-ghost:hover { background: rgba(255,255,255,0.1); color: #f1f5f9; }

        .alert-box {
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    </style>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto dash-root">

        @if(session('error'))
            <div class="alert-box alert-error">⚠️ {{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert-box alert-success">✓ {{ session('success') }}</div>
        @endif

        <div class="hero-banner">
            <div class="hero-greeting">
                Bonjour, <span>{{ auth()->user()->name }}</span> 👋
            </div>
            <p class="hero-sub">Gérez vos colocations et invitations depuis votre espace personnel.</p>

            @php
                $user = auth()->user();
                $activeColocCount = \App\Models\MemberShip::where('user_id', $user->id)->whereNull('left_at')->count();
                $pendingInvCount  = \App\Models\Invitation::where('invited_email', $user->email)->where('status','pending')->count();
            @endphp

            <div class="stat-grid">
                <div class="stat-card">
                    <div class="s-icon">🏠</div>
                    <div class="s-label">Colocations actives</div>
                    <div class="s-value">{{ $activeColocCount }}</div>
                </div>
                <div class="stat-card">
                    <div class="s-icon">📩</div>
                    <div class="s-label">Invitations reçues</div>
                    <div class="s-value">{{ $pendingInvCount }}</div>
                </div>
                <div class="stat-card">
                    <div class="s-icon">📅</div>
                    <div class="s-label">Membre depuis</div>
                    <div class="s-value" style="font-size:1.1rem; margin-top:10px;">{{ $user->created_at->format('M Y') }}</div>
                </div>
            </div>

            <div class="quick-actions">
                <a href="{{ route('colocations.index') }}" class="btn-primary">
                    🏠 Mes colocations
                </a>
                <a href="{{ route('profile.edit') }}" class="btn-ghost">
                    ⚙️ Mon profil
                </a>
            </div>
        </div>
    </div>
</x-app-layout>