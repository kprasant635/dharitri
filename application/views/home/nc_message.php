<style>
    :root{
      --marquee-speed: 18s; /* lower = faster */
      --marquee-gap: 3rem;
      --marquee-height: 72px;
    }

    /* Container styling */
    .marquee-wrap{
      overflow: hidden;
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(16,24,40,0.12);
      --g1: #7c3aed; /* purple */
      --g2: #06b6d4; /* teal */
      --g3: #f97316; /* orange */
      background: linear-gradient(90deg, var(--g1), var(--g2), var(--g3));
      background-size: 300% 300%;
      animation: bgwave 8s linear infinite;
      border-bottom: 2px;
      padding: 2px;
    }

    @keyframes bgwave{
      0%{background-position:0% 50%;}
      50%{background-position:100% 50%;}
      100%{background-position:0% 50%;}
    }

    /* Marquee track */
    .marquee{
      display:flex;
      align-items:center;
      height: var(--marquee-height);
      white-space:nowrap;
      gap: var(--marquee-gap);
      will-change: transform;
      padding: 0 1rem;
    }

    /* This inner element is duplicated (to create seamless loop) and animated */
    .marquee__inner{
      display:inline-flex;
      align-items:center;
      gap: var(--marquee-gap);
      animation: marqueeAnim linear infinite;
      animation-duration: var(--marquee-speed);
    }

    @keyframes marqueeAnim{
      0%{transform:translateX(0);} 
      100%{transform:translateX(-50%);} /* -50% because we duplicate content */
    }

    /* Pause on hover or focus for accessibility */
    .marquee__inner:hover,
    .marquee__inner:focus-within{
      animation-play-state: paused;
    }

    /* Individual item styling */
    .marquee-item{
      display:inline-flex;
      align-items:center;
      gap:.6rem;
      padding:.5rem 1rem;
      border-radius:999px;
      background: rgba(255,255,255,0.12);
      backdrop-filter: blur(4px);
      color: #fff;
      font-weight:600;
      box-shadow: 0 2px 8px rgba(2,6,23,0.12);
      border: 1px solid rgba(255,255,255,0.06);
    }

    .marquee-item small{
      opacity:0.95;
      font-weight:700;
      letter-spacing:0.02em;
    }

    /* Responsive: reduce height on small screens */
    @media (max-width:576px){
      :root{--marquee-speed: 12s; --marquee-height:56px;}
      .marquee-item{padding:.4rem .8rem}
    }

    /* Utility: icon circle */
    .mi-icon{
      width:34px;height:34px;border-radius:50%;display:inline-grid;place-items:center;
      background: linear-gradient(180deg, rgba(255,255,255,0.18), rgba(255,255,255,0.06));
      border: 1px solid rgba(255,255,255,0.08);
      font-size:16px;
    }
  </style>
<?php
if(isset($nc_port_village) && $nc_port_village){
?>
<div class="marquee-wrap p-2 p-md-3 mt-3">
  <div class="marquee" role="marquee">
    <div class="marquee__inner">
      <div class="marquee-item">
        <span class="mi-icon">📢</span>
        <small>
          You have <kbd><?=$nc_port_village?></kbd> no.s newly notified cadastral villages from Department. 
          Please ensure the process of <strong>IEC</strong> and inviting application from eligible citizens.
        </small>
      </div>
    </div>

    <!-- Duplicate for seamless scroll -->
    <div class="marquee__inner" aria-hidden="true">
      <div class="marquee-item">
        <span class="mi-icon">📢</span>
        <small>
          You have <kbd><?=$nc_port_village?></kbd> no.s newly notified cadastral villages from Department. 
          Please ensure the process of <strong>IEC</strong> and inviting application from eligible citizens.
        </small>
      </div>
    </div>
  </div>
</div>

<?php
}
?>
