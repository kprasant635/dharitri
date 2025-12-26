<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>403 • Forbidden</title>
  <meta name="description" content="403 Forbidden – You don't have permission to access this resource." />
  <style>
    :root{
      --bg: #0b0f19;
      --bg-soft: #0f1424;
      --fg: #e6e8ee;
      --muted: #a7b0c0;
      --accent: #7aa2ff;
      --accent-2: #8affc1;
      --card: rgba(255,255,255,0.04);
      --border: rgba(255,255,255,0.12);
      --shadow: 0 10px 30px rgba(0,0,0,0.35);
    }

    @media (prefers-color-scheme: light) {
      :root{
        --bg: #f6f7fb;
        --bg-soft: #eef1f7;
        --fg: #0c1222;
        --muted: #5d6472;
        --accent: #365cff;
        --accent-2: #07b383;
        --card: rgba(255,255,255,0.8);
        --border: rgba(0,0,0,0.08);
        --shadow: 0 10px 30px rgba(0,0,0,0.10);
      }
    }

    * { box-sizing: border-box; }
    html, body { height: 100%; }
    body{
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      color: var(--fg);
      background: radial-gradient(1200px 800px at 80% -10%, rgba(122,162,255,0.20), transparent 60%),
                  radial-gradient(1000px 600px at -10% 110%, rgba(138,255,193,0.18), transparent 60%),
                  linear-gradient(160deg, var(--bg-soft), var(--bg));
      display: grid;
      place-items: center;
      overflow: hidden;
    }

    .wrapper{
      width: min(720px, 92vw);
      text-align: center;
      position: relative;
      padding: 32px;
    }

    .card{
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 24px;
      box-shadow: var(--shadow);
      padding: clamp(1.75rem, 1.5rem + 2vw, 3rem);
      backdrop-filter: saturate(140%) blur(8px);
      position: relative;
      overflow: hidden;
      isolation: isolate;
    }

    .ring{
      position: absolute;
      inset: -2px;
      border-radius: 24px;
      padding: 2px;
      background: linear-gradient(135deg, var(--accent), var(--accent-2));
      -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
      -webkit-mask-composite: xor;
              mask-composite: exclude;
      pointer-events: none;
    }

    .icon{
      width: 72px; height: 72px; margin-inline: auto; display: block;
      filter: drop-shadow(0 6px 18px rgba(0,0,0,0.25));
      animation: float 3.6s ease-in-out infinite;
    }
    @keyframes float { 0%,100%{ transform: translateY(0) } 50%{ transform: translateY(-6px) } }

    .code{
      font-size: clamp(52px, 8vw, 112px);
      line-height: 0.9;
      letter-spacing: -0.02em;
      margin: 12px 0 8px;
      font-weight: 800;
      background: linear-gradient(135deg, var(--accent), var(--accent-2));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    h1{ font-size: clamp(20px, 2.4vw, 28px); margin: 8px 0 0; font-weight: 700; }
    p{ color: var(--muted); margin: 10px 0 28px; font-size: clamp(14px, 1.6vw, 16px); }

    .actions{ display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
    .btn{
      appearance: none; border: 1px solid var(--border);
      background: transparent; color: var(--fg);
      padding: 12px 18px; border-radius: 999px; font-weight: 600; text-decoration: none;
      transition: transform .12s ease, box-shadow .12s ease, background .2s ease, border-color .2s ease;
      box-shadow: 0 6px 16px rgba(0,0,0,0.10);
      display: inline-flex; align-items: center; gap: 8px;
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: 0 12px 26px rgba(0,0,0,0.16); }

    .btn.primary{
      background: linear-gradient(135deg, var(--accent), var(--accent-2));
      color: #0b0f19; border-color: transparent;
    }

    .hint{ font-size: 12px; color: var(--muted); margin-top: 18px; }

    .shimmer::after{
      content: ""; position: absolute; inset: 0; pointer-events: none; border-radius: inherit;
      background: linear-gradient(180deg, transparent 0%, rgba(255,255,255,0.12) 50%, transparent 100%);
      mix-blend-mode: overlay; opacity: 0; animation: shimmer 4.5s ease-in-out infinite;
    }
    @keyframes shimmer{ 0%, 100% { opacity: 0 } 15% { opacity: .5 } 50% { opacity: 0 } }

    .watermark{
      position: fixed; inset-inline: 0; bottom: 10px; text-align: center; font-size: 12px; color: var(--muted);
      opacity: 0.7; pointer-events: none;
    }

    @media (prefers-reduced-motion: reduce) {
      .icon{ animation: none; }
      .shimmer::after{ animation: none; }
      .btn{ transition: none; }
    }
  </style>
</head>
<body>
  <main class="wrapper">
    <section class="card shimmer" role="group" aria-label="403 Forbidden">
      <span class="ring" aria-hidden="true"></span>

      <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M7 10V8a5 5 0 1 1 10 0v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        <rect x="4.75" y="10" width="14.5" height="9.5" rx="2.25" stroke="currentColor" stroke-width="1.5"/>
        <circle cx="12" cy="14.75" r="1.25" fill="currentColor"/>
      </svg>

      <div class="code" aria-hidden="true">403</div>
      <h1>Forbidden</h1>
      <p>You don't have permission to access this resource. If you believe this is a mistake, contact the site administrator.</p>


      <div class="hint">Error code: 403 • Request ID: <span id="rid">auto</span></div>
    </section>
  </main>

  <script>
    (function(){
      var rid = (Date.now().toString(36)+Math.random().toString(36).slice(2,7)).toUpperCase();
      var el = document.getElementById('rid'); if(el) el.textContent = rid;
    })();
  </script>
</body>
</html>
