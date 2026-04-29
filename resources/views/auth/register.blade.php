<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SanguineDonor — Register</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
    --bg:#0f0a0a;--surface:#1a1010;--surface2:#221515;
    --border:#2e1e1e;--border2:#3d2525;
    --text:#f0e8e8;--muted:#8a7070;--muted2:#6a5555;
    --red:#c0392b;--red-l:#e74c3c;
}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;flex-direction:column}
.topnav{height:44px;background:rgba(15,10,10,.9);border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 20px;position:fixed;top:0;left:0;right:0;z-index:100;backdrop-filter:blur(8px);}
.topnav-brand{display:flex;align-items:center;gap:8px;font-size:.85rem;font-weight:600;color:var(--text)}
.dot{width:10px;height:10px;background:var(--red-l);border-radius:50%}
.split{display:flex;min-height:100vh;padding-top:44px}
.hero{flex:1;position:relative;overflow:hidden;background:linear-gradient(135deg,#1a0808 0%,#2d0f0f 50%,#0f0a0a 100%);display:flex;flex-direction:column;justify-content:flex-end;padding:48px;}
.hero-overlay{position:absolute;inset:0;background:linear-gradient(to right,rgba(10,5,5,.7),rgba(10,5,5,.3));z-index:1}
.hero-bg{position:absolute;inset:0;z-index:0;background:radial-gradient(ellipse at 20% 50%,rgba(192,57,43,.12) 0%,transparent 60%)}
.hero-content{position:relative;z-index:2}
.hero-headline{font-size:2.6rem;font-weight:700;line-height:1.15;margin-bottom:12px;color:#fff}
.hero-headline span{color:var(--red-l)}
.hero-sub{font-size:.85rem;color:rgba(240,232,232,.6);max-width:340px;margin-bottom:36px;line-height:1.6}
.hero-stats{display:flex;gap:32px}
.hero-stat-val{font-size:1.2rem;font-weight:700;color:#fff}
.hero-stat-label{font-size:.62rem;text-transform:uppercase;letter-spacing:.1em;color:rgba(240,232,232,.4)}
.panel{width:420px;flex-shrink:0;background:var(--surface);border-left:1px solid var(--border);display:flex;flex-direction:column;justify-content:center;padding:40px 36px;overflow-y:auto;}
.panel-title{font-size:1.5rem;font-weight:700;color:var(--red-l);margin-bottom:4px}
.panel-sub{font-size:.78rem;color:var(--muted);margin-bottom:24px}
.tabs{display:flex;gap:0;border-bottom:1px solid var(--border);margin-bottom:24px}
.tab{padding:8px 0;font-size:.82rem;font-weight:500;color:var(--muted2);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-1px;margin-right:20px;background:none;border-top:none;border-left:none;border-right:none;font-family:'Inter',sans-serif;transition:color .15s,border-color .15s;}
.tab.active{color:var(--text);border-bottom-color:var(--red-l)}
.form-group{display:flex;flex-direction:column;gap:5px;margin-bottom:12px}
.form-group label{font-size:.65rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);font-weight:500}
.form-group input,.form-group select{padding:9px 12px;background:var(--bg);border:1px solid var(--border2);border-radius:4px;font-size:.85rem;font-family:'Inter',sans-serif;color:var(--text);outline:none;transition:border-color .15s;}
.form-group input:focus,.form-group select:focus{border-color:var(--red)}
.form-group input::placeholder{color:var(--muted2)}
.form-group select option{background:var(--surface2)}
.role-label{font-size:.65rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);font-weight:500;margin-bottom:8px}
.role-options{display:flex;gap:8px;margin-bottom:16px}
.role-opt{flex:1;padding:9px 14px;background:var(--bg);border:1px solid var(--border2);border-radius:4px;font-size:.82rem;color:var(--muted);cursor:pointer;transition:background .15s,border-color .15s,color .15s;text-align:center;}
.role-opt.selected{background:var(--red);border-color:var(--red);color:#fff}
.role-radio{display:none}
.btn-register{width:100%;padding:10px;background:var(--red);color:#fff;border:none;border-radius:4px;font-size:.85rem;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;transition:background .15s;margin-top:4px;}
.btn-register:hover{background:var(--red-l)}
.signin-link{text-align:center;margin-top:14px;font-size:.72rem;color:var(--muted)}
.signin-link a{color:var(--red-l);text-decoration:none}
.error-msg{background:rgba(231,76,60,.1);border:1px solid rgba(231,76,60,.3);color:#e74c3c;padding:8px 12px;border-radius:4px;font-size:.78rem;margin-bottom:14px;}
</style>
</head>
<body>

<div class="topnav">
    <div class="topnav-brand">
        <div class="dot"></div>
        Blood Donation Management System
    </div>
</div>

<div class="split">
    <div class="hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-headline">Every <span>drop</span><br>saves a life.</div>
            <div class="hero-sub">SanguineDonor connects donors, recipients, and admins in one unified platform.</div>
            <div class="hero-stats">
                <div><div class="hero-stat-val">1,248</div><div class="hero-stat-label">Active Donors</div></div>
                <div><div class="hero-stat-val">3,872</div><div class="hero-stat-label">Units Collected</div></div>
                <div><div class="hero-stat-val">98%</div><div class="hero-stat-label">Match Rate</div></div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-title">SanguineDonor</div>
        <div class="panel-sub">Create your account to get started</div>

        <div class="tabs">
            <button class="tab" type="button" onclick="window.location='{{ route('login') }}'">Sign In</button>
            <button class="tab active" type="button">Register</button>
        </div>

        @if($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="e.g. Maria Santos" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Choose a username" value="{{ old('username') }}" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="your@email.com" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Min. 6 characters" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Repeat password" required>
            </div>

            <div class="role-label">Register As</div>
            <div class="role-options">
                @foreach(['donor' => 'Donor', 'recipient' => 'Recipient'] as $val => $label)
                <label style="flex:1">
                    <input type="radio" name="role" value="{{ $val }}" class="role-radio"
                        {{ old('role', 'donor') === $val ? 'checked' : '' }}
                        onchange="toggleDonorFields(this.value)">
                    <div class="role-opt {{ old('role','donor') === $val ? 'selected':'' }}"
                         onclick="this.previousElementSibling.checked=true;toggleDonorFields('{{ $val }}')">{{ $label }}</div>
                </label>
                @endforeach
            </div>

            <div id="donor-fields" style="{{ old('role','donor') === 'donor' ? '' : 'display:none' }}">
                <div style="border-top:1px solid var(--border);margin:12px 0 14px;padding-top:14px;font-size:.65rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);font-weight:500">Donor Information</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" placeholder="First name" value="{{ old('first_name') }}">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" placeholder="Last name" value="{{ old('last_name') }}">
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select gender</option>
                            @foreach(['Male','Female','Other'] as $g)
                            <option value="{{ $g }}" {{ old('gender') === $g ? 'selected':'' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" placeholder="e.g. 09XX-XXX-XXXX" value="{{ old('contact_number') }}">
                    </div>
                    <div class="form-group">
                        <label>Blood Type</label>
                        <select name="blood_type">
                            <option value="">Select type</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                            <option value="{{ $bt }}" {{ old('blood_type') === $bt ? 'selected':'' }}>{{ $bt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" placeholder="Full address" value="{{ old('address') }}">
                </div>
            </div>

            <button type="submit" class="btn-register">Create Account &rarr;</button>
        </form>

        <script>
        function toggleDonorFields(role) {
            const fields = document.getElementById('donor-fields');
            const opts = document.querySelectorAll('.role-opt');
            const radios = document.querySelectorAll('.role-radio');
            opts.forEach(e => e.classList.remove('selected'));
            radios.forEach(r => { if (r.value === role) r.closest('label').querySelector('.role-opt').classList.add('selected'); });
            fields.style.display = role === 'donor' ? '' : 'none';
        }
        </script>

        <div class="signin-link">Already have an account? <a href="{{ route('login') }}">Sign in here</a></div>
    </div>
</div>

</body>
</html>