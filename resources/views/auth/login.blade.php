<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SanguineDonor — Sign In</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
    --bg:#0f0a0a;--surface:#1a1010;--surface2:#221515;
    --border:#2e1e1e;--border2:#3d2525;
    --text:#f0e8e8;--muted:#8a7070;--muted2:#6a5555;
    --red:#c0392b;--red-l:#e74c3c;--red-dim:rgba(192,57,43,.15);
}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;flex-direction:column}

/* Top nav bar */
.topnav{
    height:44px;background:rgba(15,10,10,.9);border-bottom:1px solid var(--border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 20px;position:fixed;top:0;left:0;right:0;z-index:100;
    backdrop-filter:blur(8px);
}
.topnav-brand{display:flex;align-items:center;gap:8px;font-size:.85rem;font-weight:600;color:var(--text)}
.dot{width:10px;height:10px;background:var(--red-l);border-radius:50%}
.topnav-right{display:flex;align-items:center;gap:8px}
.avatar-sm{width:28px;height:28px;background:var(--red);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:#fff}
.topnav-label{font-size:.72rem;color:var(--muted)}

/* Split layout */
.split{display:flex;min-height:100vh;padding-top:44px}

/* Left hero */
.hero{
    flex:1;position:relative;overflow:hidden;
    background:linear-gradient(135deg,#1a0808 0%,#2d0f0f 50%,#0f0a0a 100%);
    display:flex;flex-direction:column;justify-content:flex-end;padding:48px;
}
.hero-overlay{position:absolute;inset:0;background:linear-gradient(to right,rgba(10,5,5,.7),rgba(10,5,5,.3));z-index:1}
.hero-bg{
    position:absolute;inset:0;z-index:0;
    background:
        radial-gradient(ellipse at 20% 50%,rgba(192,57,43,.12) 0%,transparent 60%),
        radial-gradient(ellipse at 80% 20%,rgba(192,57,43,.08) 0%,transparent 50%);
}
.hero-content{position:relative;z-index:2}
.hero-headline{font-size:2.6rem;font-weight:700;line-height:1.15;margin-bottom:12px;color:#fff}
.hero-headline span{color:var(--red-l)}
.hero-sub{font-size:.85rem;color:rgba(240,232,232,.6);max-width:340px;margin-bottom:36px;line-height:1.6}
.hero-stats{display:flex;gap:32px}
.hero-stat-val{font-size:1.2rem;font-weight:700;color:#fff}
.hero-stat-label{font-size:.62rem;text-transform:uppercase;letter-spacing:.1em;color:rgba(240,232,232,.4)}

/* Right panel */
.panel{
    width:380px;flex-shrink:0;
    background:var(--surface);border-left:1px solid var(--border);
    display:flex;flex-direction:column;justify-content:center;
    padding:48px 40px;
}
.panel-title{font-size:1.5rem;font-weight:700;color:var(--red-l);margin-bottom:4px}
.panel-sub{font-size:.78rem;color:var(--muted);margin-bottom:28px}

/* Tabs */
.tabs{display:flex;gap:0;border-bottom:1px solid var(--border);margin-bottom:24px}
.tab{
    padding:8px 0;font-size:.82rem;font-weight:500;color:var(--muted2);
    cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-1px;
    margin-right:20px;background:none;border-top:none;border-left:none;border-right:none;
    font-family:'Inter',sans-serif;transition:color .15s,border-color .15s;
}
.tab.active{color:var(--text);border-bottom-color:var(--red-l)}

/* Form */
.form-group{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
.form-group label{font-size:.65rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);font-weight:500}
.form-group input{
    padding:9px 12px;background:var(--bg);border:1px solid var(--border2);
    border-radius:4px;font-size:.85rem;font-family:'Inter',sans-serif;
    color:var(--text);outline:none;transition:border-color .15s;
}
.form-group input:focus{border-color:var(--red)}
.form-group input::placeholder{color:var(--muted2)}

/* Role selector */
.role-label{font-size:.65rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);font-weight:500;margin-bottom:8px}
.role-options{display:flex;flex-direction:column;gap:6px;margin-bottom:20px}
.role-opt{
    padding:9px 14px;background:var(--bg);border:1px solid var(--border2);
    border-radius:4px;font-size:.82rem;color:var(--muted);cursor:pointer;
    transition:background .15s,border-color .15s,color .15s;text-align:center;
}
.role-opt:hover{border-color:var(--border2);color:var(--text);background:var(--surface2)}
.role-opt.selected{background:var(--red);border-color:var(--red);color:#fff}

/* Hidden radio */
.role-radio{display:none}

.btn-signin{
    width:100%;padding:10px;background:var(--red);color:#fff;
    border:none;border-radius:4px;font-size:.85rem;font-weight:600;
    font-family:'Inter',sans-serif;cursor:pointer;transition:background .15s;
    margin-top:4px;
}
.btn-signin:hover{background:var(--red-l)}

.forgot{text-align:center;margin-top:14px;font-size:.72rem;color:var(--muted)}
.forgot a{color:var(--red-l);text-decoration:none}

.error-msg{
    background:rgba(231,76,60,.1);border:1px solid rgba(231,76,60,.3);
    color:#e74c3c;padding:8px 12px;border-radius:4px;font-size:.78rem;margin-bottom:14px;
}
</style>
</head>
<body>

<div class="topnav">
    <div class="topnav-brand">
        <div class="dot"></div>
        Blood Donation Management System
    </div>
    <div class="topnav-right">
        <div class="avatar-sm">AC</div>
        <span class="topnav-label">Admin Console &mdash; Blood Donation Center - Davao</span>
    </div>
</div>

<div class="split">
    <!-- Hero -->
    <div class="hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-headline">Every <span>drop</span><br>saves a life.</div>
            <div class="hero-sub">SanguineDonor connects donors, recipients, and admins in one unified platform.</div>
            <div class="hero-stats">
                <div>
                    <div class="hero-stat-val">1,248</div>
                    <div class="hero-stat-label">Active Donors</div>
                </div>
                <div>
                    <div class="hero-stat-val">3,872</div>
                    <div class="hero-stat-label">Units Collected</div>
                </div>
                <div>
                    <div class="hero-stat-val">98%</div>
                    <div class="hero-stat-label">Match Rate</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel -->
    <div class="panel">
        <div class="panel-title">SanguineDonor</div>
        <div class="panel-sub">Sign in to your account to continue</div>

        <div class="tabs">
            <button class="tab active" type="button">Sign In</button>
            <button class="tab" type="button" onclick="window.location='#'">Register</button>
        </div>

        @if($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" value="{{ old('username') }}" required autofocus>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="role-label">Login As</div>
            <div class="role-options">
                @foreach(['admin' => 'Admin', 'donor' => 'Donor', 'recipient' => 'Recipient'] as $val => $label)
                <label>
                    <input type="radio" name="role" value="{{ $val }}" class="role-radio"
                        {{ old('role', 'admin') === $val ? 'checked' : '' }}
                        onchange="document.querySelectorAll('.role-opt').forEach(e=>e.classList.remove('selected'));this.closest('label').querySelector('.role-opt').classList.add('selected')">
                    <div class="role-opt {{ old('role','admin') === $val ? 'selected':'' }}">{{ $label }}</div>
                </label>
                @endforeach
            </div>

            <button type="submit" class="btn-signin">Sign In &rarr;</button>
        </form>

        <div class="forgot">Forgot password? <a href="#">Reset here</a></div>
    </div>
</div>

</body>
</html>
