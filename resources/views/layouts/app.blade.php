<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'SanguineDonor')</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

:root {
    --bg:#0f0a0a;
    --surface:#1a1010;
    --surface2:#221515;
    --border:#2e1e1e;
    --border2:#3d2525;
    --text:#f0e8e8;
    --muted:#8a7070;
    --muted2:#6a5555;
    --red:#c0392b;
    --red-l:#e74c3c;
    --red-dim:rgba(192,57,43,0.15);
    --red-dim2:rgba(192,57,43,0.25);
    --green:#22c55e;
    --amber:#f59e0b;
    --nav-w:220px;
    --top-h:48px;
}

html, body { height:100%; }

body {
    font-family:'Inter',sans-serif;
    background:var(--bg);
    color:var(--text);
    min-height:100vh;
}

/* ── Topbar ── */
.topbar {
    position:fixed;
    top:0; left:0; right:0;
    height:var(--top-h);
    background:var(--surface);
    border-bottom:1px solid var(--border);
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 20px;
    z-index:300;
}
.topbar-brand { font-size:.95rem; font-weight:700; color:var(--red-l); letter-spacing:.02em; }
.topbar-right { display:flex; align-items:center; gap:12px; }
.topbar-date  { font-size:.72rem; color:var(--muted); }
.topbar-user  { font-size:.78rem; color:var(--muted); }
.avatar {
    width:30px; height:30px; border-radius:50%;
    background:var(--red);
    display:flex; align-items:center; justify-content:center;
    font-size:.7rem; font-weight:700; color:#fff; flex-shrink:0;
}

/* ── Sidebar ── */
.sidebar {
    position:fixed;
    top:var(--top-h); left:0; bottom:0;
    width:var(--nav-w);
    background:var(--surface);
    border-right:1px solid var(--border);
    display:flex;
    flex-direction:column;
    overflow-y:auto;
    z-index:200;
}

.nav-section {
    padding:16px 16px 4px;
    font-size:.6rem;
    text-transform:uppercase;
    letter-spacing:.12em;
    color:var(--muted2);
}

.sidebar a {
    display:flex;
    align-items:center;
    gap:8px;
    padding:10px 16px;
    font-size:.82rem;
    color:var(--muted);
    text-decoration:none;
    border-left:2px solid transparent;
    transition:background .15s, color .15s;
    cursor:pointer;
}
.sidebar a:hover  { background:var(--red-dim);  color:var(--text); }
.sidebar a.active { background:var(--red-dim2); color:var(--red-l); border-left-color:var(--red-l); }

.sidebar-icon { width:16px; text-align:center; font-style:normal; flex-shrink:0; }

.sidebar-bottom {
    margin-top:auto;
    padding:12px 0;
    border-top:1px solid var(--border);
}

.sidebar-bottom form { margin:0; }

.logout-btn {
    display:flex;
    align-items:center;
    gap:8px;
    padding:10px 16px;
    font-size:.82rem;
    color:var(--muted);
    background:none;
    border:none;
    cursor:pointer;
    width:100%;
    font-family:'Inter',sans-serif;
    transition:background .15s, color .15s;
    text-align:left;
}
.logout-btn:hover { background:var(--red-dim); color:var(--red-l); }

/* ── Main content ── */
.main {
    margin-left:var(--nav-w);
    margin-top:var(--top-h);
    padding:28px 32px;
    min-height:calc(100vh - var(--top-h));
}

/* ── Typography ── */
.page-title { font-size:1.3rem; font-weight:700; color:var(--text); margin-bottom:4px; }
.page-sub   { font-size:.78rem; color:var(--muted); margin-bottom:24px; }

/* ── Stat grid ── */
.stat-grid {
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(180px,1fr));
    gap:12px;
    margin-bottom:24px;
}
.stat-card {
    background:var(--surface2);
    border:1px solid var(--border);
    border-radius:6px;
    padding:18px 20px;
}
.stat-label { font-size:.65rem; text-transform:uppercase; letter-spacing:.1em; color:var(--muted); margin-bottom:6px; }
.stat-value { font-size:2rem; font-weight:700; color:var(--text); line-height:1; margin-bottom:6px; }
.stat-badge { display:inline-block; padding:2px 8px; border-radius:20px; font-size:.65rem; font-weight:600; }
.badge-green { background:rgba(34,197,94,.15); color:var(--green); }
.badge-red   { background:rgba(231,76,60,.15);  color:var(--red-l); }
.badge-amber { background:rgba(245,158,11,.15); color:var(--amber); }

/* ── Card ── */
.card {
    background:var(--surface2);
    border:1px solid var(--border);
    border-radius:6px;
    padding:20px;
    margin-bottom:16px;
}
.card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
.card-title  { font-size:.82rem; font-weight:600; color:var(--text); }
.view-all    { font-size:.72rem; color:var(--red-l); text-decoration:none; }

/* ── Table ── */
.table-wrap { overflow-x:auto; }
table { width:100%; border-collapse:collapse; font-size:.8rem; }
th {
    text-align:left; padding:8px 12px;
    font-size:.65rem; text-transform:uppercase; letter-spacing:.08em;
    color:var(--muted); border-bottom:1px solid var(--border); font-weight:600;
}
td { padding:10px 12px; border-bottom:1px solid var(--border); color:var(--text); vertical-align:middle; }
tr:last-child td { border-bottom:none; }
tr:hover td { background:var(--red-dim); }

/* ── Status ── */
.status { display:inline-block; padding:2px 10px; border-radius:20px; font-size:.65rem; font-weight:600; text-transform:uppercase; }
.status-active    { background:rgba(34,197,94,.15); color:var(--green); }
.status-pending   { background:rgba(245,158,11,.15); color:var(--amber); }
.status-confirmed { background:rgba(34,197,94,.15); color:var(--green); }
.status-completed { background:rgba(34,197,94,.15); color:var(--green); }
.status-cancelled { background:rgba(138,112,112,.15); color:var(--muted); }
.status-inactive  { background:rgba(138,112,112,.15); color:var(--muted); }
.status-approved  { background:rgba(34,197,94,.15); color:var(--green); }
.status-rejected  { background:rgba(231,76,60,.15); color:var(--red-l); }

/* ── Donor cell ── */
.donor-cell { display:flex; align-items:center; gap:10px; }

/* ── Buttons ── */
.btn {
    display:inline-block; padding:8px 18px; font-size:.8rem;
    font-family:'Inter',sans-serif; font-weight:500;
    border:1px solid transparent; border-radius:4px;
    cursor:pointer; text-decoration:none;
    transition:background .15s, color .15s; line-height:1.4;
}
.btn-red     { background:var(--red);  color:#fff; border-color:var(--red); }
.btn-red:hover { background:var(--red-l); border-color:var(--red-l); }
.btn-outline { background:transparent; color:var(--text); border-color:var(--border2); }
.btn-outline:hover { background:var(--border2); }
.btn-danger  { background:transparent; color:var(--red-l); border-color:var(--red-l); }
.btn-danger:hover { background:var(--red-l); color:#fff; }
.btn-ghost   { background:transparent; color:var(--muted); border-color:transparent; }
.btn-ghost:hover { color:var(--red-l); }
.btn-sm { padding:4px 10px; font-size:.72rem; }

/* ── Forms ── */
.form-section {
    background:var(--surface2); border:1px solid var(--border);
    border-radius:6px; padding:20px; margin-bottom:16px;
}
.form-section-title {
    font-size:.7rem; font-weight:600; text-transform:uppercase;
    letter-spacing:.1em; color:var(--red-l);
    margin-bottom:16px; padding-bottom:8px; border-bottom:1px solid var(--border);
}
.form-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:14px; }
.form-group { display:flex; flex-direction:column; gap:5px; }
.form-group label {
    font-size:.68rem; text-transform:uppercase; letter-spacing:.08em;
    color:var(--muted); font-weight:500;
}
.form-group input,
.form-group select,
.form-group textarea {
    padding:8px 10px; background:var(--bg);
    border:1px solid var(--border2); border-radius:4px;
    font-size:.82rem; font-family:'Inter',sans-serif;
    color:var(--text); outline:none; transition:border-color .15s;
}
.form-group input::placeholder { color:var(--muted2); }
.form-group input:focus,
.form-group select:focus { border-color:var(--red); }
.form-group select option { background:var(--surface2); }
.form-actions { display:flex; gap:10px; margin-top:20px; }

/* ── Alert ── */
.alert { padding:10px 14px; border-radius:4px; font-size:.8rem; margin-bottom:16px; border-left:3px solid; }
.alert-success { background:rgba(34,197,94,.1);  border-color:var(--green); color:var(--green); }
.alert-error   { background:rgba(231,76,60,.1); border-color:var(--red-l); color:var(--red-l); }

/* ── Blood inventory ── */
.blood-grid { display:flex; flex-direction:column; gap:12px; }
.blood-card { background:var(--surface2); border:1px solid var(--border); border-radius:6px; padding:20px 24px; }
.blood-type-label { font-size:2rem; font-weight:700; color:var(--text); text-align:center; margin-bottom:2px; }
.blood-units { font-size:.75rem; color:var(--muted); text-align:center; margin-bottom:12px; }
.progress-bar-wrap { background:var(--border); border-radius:3px; height:6px; margin-bottom:8px; overflow:hidden; }
.progress-bar { height:100%; border-radius:3px; transition:width .4s; }
.blood-status { display:inline-block; padding:3px 12px; border-radius:20px; font-size:.65rem; font-weight:600; }
</style>
</head>
<body>

<header class="topbar">
    <span class="topbar-brand">SanguineDonor</span>
    <div class="topbar-right">
        <span class="topbar-date">{{ now()->format('D, M j, Y') }}</span>
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</div>
        <span class="topbar-user">{{ auth()->user()->name ?? '' }}</span>
    </div>
</header>

<aside class="sidebar">
    @yield('sidebar')
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="sidebar-icon">&#x2192;</i> Logout
            </button>
        </form>
    </div>
</aside>

<main class="main">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    @yield('content')
</main>

</body>
</html>
