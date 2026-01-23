<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Portfolio — Nama Kamu</title>
  <style>
    /* Minimal style */
    :root{--bg:#f7f7f9;--card:#ffffff;--muted:#6b7280;--accent:#2563eb}
    *{box-sizing:border-box}
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto; background:var(--bg); color:#111}
    .wrap{max-width:880px;margin:48px auto;padding:20px}
    header{display:flex;justify-content:space-between;align-items:center}
    h1{margin:0;font-size:26px}
    p.lead{color:var(--muted);margin:6px 0 18px}
    .hero{display:flex;gap:20px;align-items:center;flex-wrap:wrap}
    .card{background:var(--card);padding:16px;border-radius:10px;box-shadow:0 6px 18px rgba(16,24,40,0.06)}
    .intro{flex:1;min-width:240px}
    .cta{display:inline-block;background:var(--accent);color:white;padding:10px 14px;border-radius:8px;text-decoration:none}
    .projects{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:18px}
    .proj{padding:12px;border-radius:8px;background:linear-gradient(180deg,rgba(0,0,0,0.02),transparent);text-align:center}
    .proj img{width:100%;height:80px;object-fit:cover;border-radius:6px;margin-bottom:8px}
    footer{margin-top:28px;color:var(--muted);font-size:13px;text-align:center}
    @media(max-width:720px){.projects{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:420px){.projects{grid-template-columns:1fr}}
  </style>
</head>
<body>
  <div class="wrap">
    <header>
      <div>
        <h1>Nama Kamu</h1>
        <div style="color:var(--muted);font-size:13px">Desainer & Pengembang Frontend</div>
      </div>
      <nav style="font-size:14px">
        <a href="#work" style="color:var(--muted);text-decoration:none;margin-right:12px">Work</a>
        <a href="#contact" class="cta">Contact</a>
      </nav>
    </header>

    <main style="margin-top:22px">
      <section class="hero">
        <div class="intro card">
          <h2 style="margin:0 0 8px">Halo — saya Nama Kamu</h2>
          <p class="lead">Saya membuat antarmuka sederhana, cepat, dan mudah dipakai. Berikut beberapa proyek singkat saya.</p>
          <a href="#work" class="cta">Lihat Portofolio</a>
        </div>

        <div style="width:260px" class="card">
          <strong>Quick info</strong>
          <div style="color:var(--muted);margin-top:8px;font-size:14px">
            Email: <a href="mailto:email@domain.com">email@domain.com</a><br>
            Lokasi: Kota, Negara
          </div>
        </div>
      </section>

      <section id="work">
        <h3 style="margin-top:20px">Selected projects</h3>
        <div class="projects">
          <div class="proj card">
            <img src="https://picsum.photos/seed/a/400/200" alt="P1">
            <strong>Project A</strong>
            <div style="color:var(--muted);font-size:13px">Landing page sederhana</div>
          </div>
          <div class="proj card">
            <img src="https://picsum.photos/seed/b/400/200" alt="P2">
            <strong>Project B</strong>
            <div style="color:var(--muted);font-size:13px">Dashboard kecil</div>
          </div>
          <div class="proj card">
            <img src="https://picsum.photos/seed/c/400/200" alt="P3">
            <strong>Project C</strong>
            <div style="color:var(--muted);font-size:13px">Toko online minimal</div>
          </div>
        </div>
      </section>

      <section id="contact" style="margin-top:20px">
        <h3>Contact</h3>
        <div class="card" style="margin-top:8px">
          <form onsubmit="event.preventDefault(); alert('Terima kasih — ini demo. Email: email@domain.com');">
            <div style="display:flex;gap:8px;flex-wrap:wrap">
              <input required placeholder="Nama" style="flex:1;padding:8px;border-radius:6px;border:1px solid #e6e9ef">
              <input required type="email" placeholder="Email" style="flex:1;padding:8px;border-radius:6px;border:1px solid #e6e9ef">
            </div>
            <textarea required placeholder="Pesan singkat" style="width:100%;margin-top:8px;padding:8px;border-radius:6px;border:1px solid #e6e9ef"></textarea>
            <div style="text-align:right;margin-top:8px">
              <button class="cta" type="submit">Kirim</button>
            </div>
          </form>
        </div>
      </section>
    </main>

    <footer>
      © <span id="y"></span> Nama Kamu — simple portfolio
    </footer>
  </div>

  <script>document.getElementById('y').textContent = new Date().getFullYear();</script>
</body>
</html>