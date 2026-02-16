<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"/>
    <title>Maids DXB – Kiosk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Amiri:wght@400;700&family=Noto+Naskh+Arabic:wght@400;700&family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
    <style>
      :root{
        --g1:linear-gradient(135deg,#2250C5,#22B8CF);
        --g2:linear-gradient(135deg,#6A11CB,#2575FC);
        --g3:linear-gradient(135deg,#FF7A18,#AF002D 70%);
        --bg:#f4f7ff;
        --ink:#0c1b2e;
        --mut:#5d6b83;
        --line:#e0e7ff;
        --card:#fff;
        --r:16px;
        --shadow:0 14px 28px rgba(34,80,197,.16)
      }
      *{box-sizing:border-box}
      html,body{height:100%}
      body{
        margin:0;
        background:var(--bg);
        color:var(--ink);
        font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
        font-size:14px;
        -webkit-font-smoothing:antialiased;
        overflow:hidden
      }
      .button{
        border:0;
        border-radius:12px;
        color:#fff;
        display:inline-flex;
        align-items:center;
        gap:.5rem;
        padding:.6rem 1rem;
        font-weight:800;
        box-shadow:var(--shadow);
        line-height:1;
        min-height:40px;
        transition:transform .12s ease,filter .2s ease,box-shadow .2s ease
      }
      .button:hover{
        filter:brightness(1.05);
        box-shadow:0 18px 32px rgba(15,23,42,.18)
      }
      .button:active{
        transform:scale(.98);
        box-shadow:0 10px 20px rgba(15,23,42,.18)
      }
      .button:focus-visible{
        outline:3px solid #2250c566;
        outline-offset:2px
      }
      .g1{background:var(--g1)}
      .g2{background:var(--g2)}
      .g3{background:var(--g3)}
      .app{
        position:relative;
        height:100vh;
        width:100vw;
        overflow:hidden;
        background:radial-gradient(circle at top,#e0ebff,#f5f7ff)
      }
      .screen{
        position:absolute;
        inset:0;
        display:none;
        background:var(--bg);
        flex-direction:column
      }
      .screen.active{
        display:flex
      }
      .screen-landing{
        justify-content:center;
        align-items:center;
        background:#000
      }
      .bg-img{
        position:absolute;
        inset:0;
        z-index:0;
        overflow:hidden
      }
      .bg-img img{
        position:absolute;
        top:50%;
        left:50%;
        width:120%;
        height:120%;
        object-fit:cover;
        transform:translate(-50%,-50%) scale(1.08);
        filter:blur(1.5px) brightness(.9)
      }
      .overlay-dark{
        position:absolute;
        inset:0;
        background:linear-gradient(180deg,rgba(0,0,0,.75),rgba(0,0,0,.4) 45%,rgba(0,0,0,.85));
        z-index:1
      }
      .center-box{
        position:relative;
        width:100%;
        max-width:420px;
        background:#ffffffee;
        border:1px solid rgba(209,213,230,.9);
        border-radius:22px;
        box-shadow:0 22px 50px rgba(15,23,42,.65);
        z-index:3;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:stretch;
        padding:22px 22px 18px;
        backdrop-filter:blur(14px)
      }
      .center-box .logo{
        height:44px;
        margin-bottom:12px;
        display:block;
        margin-left:auto;
        margin-right:auto
      }
      .center-box h1{
        font-size:1.3rem;
        margin:0 0 6px;
        font-weight:900;
        text-align:center;
        color:#0b1b4a
      }
      .center-box p{
        margin:0 0 16px;
        font-size:.95rem;
        color:#123d86;
        text-align:center
      }
      .lang-choices{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:.7rem;
        width:100%;
        margin:0 0 12px
      }
      .lang-btn{
        position:relative;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:.6rem;
        border:1px solid rgba(203,213,255,.9);
        border-radius:14px;
        padding:.75rem .5rem;
        background:#fff;
        cursor:pointer;
        box-shadow:0 12px 26px rgba(15,23,42,.35);
        font-weight:800;
        transition:transform .12s ease,box-shadow .18s ease,border-color .18s ease
      }
      .lang-btn .flag{
        width:18px;
        height:18px;
        border-radius:3px
      }
      .lang-btn .radio{
        position:absolute;
        right:10px;
        top:10px;
        width:16px;
        height:16px;
        border-radius:50%;
        border:2px solid #a5b4fc;
        background:#fff
      }
      .lang-btn:hover{
        transform:translateY(-1px);
        box-shadow:0 18px 32px rgba(15,23,42,.45)
      }
      .lang-btn.active{
        outline:3px solid #2250c544;
        border-color:#2250c577
      }
      .lang-btn.active .radio{
        background:conic-gradient(from 0deg,#2250C5,#22B8CF)
      }
      .topbar{
        position:sticky;
        top:0;
        z-index:1040;
        background:#fffffff8;
        border-bottom:1px solid var(--line);
        backdrop-filter:blur(12px)
      }
      .topbar-inner{
        max-width:1200px;
        margin:0 auto;
        padding:.5rem .75rem;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:.5rem
      }
      .brand{
        display:flex;
        align-items:center;
        gap:.5rem;
        min-width:0
      }
      .brand img{
        height:22px
      }
      .brand b{
        font-size:.98rem;
        white-space:nowrap
      }
      .brand small{
        font-size:.72rem;
        color:var(--mut);
        margin-left:.25rem;
        white-space:nowrap
      }
      .top-actions{
        display:flex;
        align-items:center;
        gap:.4rem
      }
      .back-only{
        padding:.38rem .55rem
      }
      .back-only span{
        display:none
      }
      @media(min-width:768px){
        .back-only span{display:inline}
      }
      .view{
        flex:1 1 auto;
        min-height:0;
        overflow:auto;
        -webkit-overflow-scrolling:touch;
        padding-bottom:82px
      }
      .view-inner{
        max-width:1200px;
        margin:0 auto;
        padding:10px .75rem 0
      }
      .header{
        padding:4px 0 8px
      }
      .segment{
        display:flex;
        gap:.5rem;
        justify-content:center;
        flex-wrap:wrap
      }
      .segment .button{
        padding:.4rem 1rem;
        min-height:34px
      }
      .segment .active{
        filter:saturate(1.08);
        transform:translateY(-1px)
      }
      .tabs{
        display:flex;
        gap:.45rem;
        overflow:auto;
        scrollbar-width:none;
        padding:.5rem 0 .25rem;
        justify-content:center
      }
      .tabs::-webkit-scrollbar{
        display:none
      }
      .tab{
        display:flex;
        align-items:center;
        gap:.35rem;
        border-radius:999px;
        border:1px solid var(--line);
        background:#fff;
        color:#123d86;
        font-weight:800;
        padding:.28rem .75rem;
        white-space:nowrap;
        transition:transform .12s ease,box-shadow .18s ease,border-color .18s ease,background .18s ease,color .18s ease
      }
      .tab:active{
        transform:scale(.98)
      }
      .tab:hover{
        box-shadow:0 12px 20px rgba(15,23,42,.12)
      }
      .tab.active{
        background:var(--g1);
        color:#fff;
        border-color:transparent;
        box-shadow:var(--shadow)
      }
      .searchRow{
        display:grid;
        grid-template-columns:minmax(0,1.5fr) minmax(150px,.9fr);
        gap:.6rem;
        padding:.5rem 0 .4rem
      }
      .input-group-text{
        background:#fff;
        border-right:0;
        height:40px
      }
      .input-group-text.clear-search{
        border-left:0;
        cursor:pointer
      }
      .input-group-text.clear-search i{
        opacity:.75;
        transition:opacity .15s ease,transform .15s ease
      }
      .input-group-text.clear-search:hover i{
        opacity:1;
        transform:scale(1.05)
      }
      .form-control{
        border-left:0;
        height:40px
      }
      .grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
        gap:1rem;
        padding:.3rem 0 0
      }
      .cardx{
        border-radius:var(--r);
        border:1px solid var(--line);
        overflow:hidden;
        background:var(--card);
        box-shadow:0 10px 22px rgba(13,48,105,.08);
        transition:transform .18s ease,box-shadow .18s ease;
        display:flex;
        flex-direction:column
      }
      .cardx:hover{
        transform:translateY(-2px);
        box-shadow:0 16px 28px rgba(13,48,105,.12)
      }
      .media{
        position:relative;
        background:linear-gradient(135deg,#e9f0ff,#ffffff)
      }
      .thumb{
        width:100%;
        aspect-ratio:3/4;
        display:block;
        object-fit:cover;
        max-height:360px
      }
      .thumb-ph{
        width:100%;
        aspect-ratio:3/4;
        display:grid;
        place-items:center;
        background:var(--g1);
        color:#fff;
        font-weight:900;
        font-size:1.4rem;
        letter-spacing:.5px;
        max-height:360px
      }
      .play{
        position:absolute;
        left:50%;
        top:50%;
        transform:translate(-50%,-50%);
        border:0;
        border-radius:16px;
        width:54px;
        height:54px;
        display:grid;
        place-items:center;
        background:var(--g2);
        color:#fff;
        box-shadow:0 14px 28px rgba(37,117,252,.28);
        transition:transform .12s ease,box-shadow .12s ease
      }
      .play:hover{
        transform:translate(-50%,-50%) scale(1.05);
        box-shadow:0 18px 32px rgba(37,117,252,.35)
      }
      .ref{
        position:absolute;
        left:10px;
        bottom:10px;
        background:#ffd35a;
        color:#263247;
        font-weight:800;
        border-radius:999px;
        padding:.18rem .55rem;
        font-size:.76rem;
        box-shadow:0 8px 14px rgba(15,23,42,.24)
      }
      .card-body{
        padding:10px 12px 12px;
        display:flex;
        flex-direction:column;
        height:100%
      }
      .title{
        margin:0 0 4px;
        font-size:1rem;
        font-weight:900;
        color:#103a88;
        text-align:center
      }
      .title small{
        display:block;
        color:#6a7aa4;
        font-weight:600;
        margin-top:2px
      }
      .meta{
        margin:.25rem 0 0;
        padding:0 0 0 16px;
        font-size:.9rem;
        color:#374151
      }
      .meta li{
        margin:.12rem 0;
        line-height:1.35
      }
      .actions{
        display:flex;
        gap:.4rem;
        flex-wrap:wrap;
        margin-top:.7rem
      }
      .actions .button{
        flex:1 1 100px;
        min-width:0;
        justify-content:center;
        font-size:.82rem;
        padding:.45rem .6rem
      }
      .skeleton{
        height:220px;
        border-radius:var(--r);
        background:linear-gradient(115deg,#eaf1ff,#f7faff 42%,#eaf1ff 60%);
        background-size:200% 100%;
        animation:sk 1.05s linear infinite
      }
      @keyframes sk{
        to{background-position:200% 0}
      }
      .empty{
        grid-column:1/-1;
        text-align:center;
        color:#6c7da5;
        padding:24px 8px;
        font-size:.95rem
      }
      .tabbar{
        position:fixed;
        left:0;
        right:0;
        bottom:0;
        background:var(--g1);
        color:#fff;
        border-top:0;
        display:grid;
        grid-template-columns:repeat(3,1fr);
        align-items:center;
        padding:.15rem 0 calc(env(safe-area-inset-bottom) + .25rem);
        z-index:1030
      }
      .tabbar button{
        padding:.46rem 0;
        border:0;
        background:transparent;
        color:#e9f0ff;
        font-weight:800;
        font-size:.78rem;
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:.05rem;
        transition:transform .12s ease,color .12s ease
      }
      .tabbar .ico{
        display:grid;
        place-items:center;
        width:30px;
        height:30px;
        margin:0 auto .05rem;
        border-radius:10px;
        background:#ffffff22;
        color:#fff;
        box-shadow:inset 0 0 0 1px #ffffff33;
        font-size:.95rem;
        transition:transform .12s ease,box-shadow .12s ease
      }
      .tabbar button.active{
        color:#fff;
        transform:translateY(-1px)
      }
      .tabbar button:hover .ico{
        transform:translateY(-1px);
        box-shadow:0 8px 16px rgba(15,23,42,.3)
      }
      .offcanvas{
        border-top-left-radius:18px;
        border-top-right-radius:18px
      }
      .sheet-hd{
        position:relative;
        padding:1.1rem 1rem .8rem;
        background:var(--g2);
        color:#fff;
        font-weight:900;
        text-align:center
      }
      .center-close{
        position:absolute;
        left:50%;
        top:0;
        transform:translate(-50%,-50%);
        border:0;
        width:46px;
        height:46px;
        border-radius:999px;
        display:grid;
        place-items:center;
        box-shadow:var(--shadow);
        background:conic-gradient(from 0deg,#2250C5,#22B8CF,#6A11CB,#FF7A18,#2250C5);
        color:#fff
      }
      .sheet-ft{
        background:var(--g1);
        color:#fff;
        padding:.5rem 1rem;
        font-size:.82rem;
        text-align:center
      }
      .filters-inner{
        max-width:1200px;
        margin:0 auto;
        padding:12px .75rem 16px
      }
      .fbox{
        border:1px solid var(--line);
        border-radius:16px;
        overflow:hidden;
        background:#fff;
        box-shadow:0 4px 10px rgba(15,23,42,.06)
      }
      .fhd{
        background:var(--g1);
        color:#fff;
        font-weight:900;
        padding:.55rem .9rem
      }
      .fbd{
        padding:.65rem .9rem
      }
      .check{
        display:flex;
        align-items:center;
        gap:.48rem;
        margin:.18rem 0;
        font-size:.9rem
      }
      .check input{
        width:16px;
        height:16px
      }
      .modal-headerX{
        position:relative;
        padding:1.1rem 1rem .9rem;
        background:var(--g1);
        color:#fff;
        font-weight:900;
        text-align:center
      }
      .modal-content{
        border:0;
        border-radius:16px;
        box-shadow:0 18px 40px rgba(15,23,42,.4)
      }
      .profile{
        width:140px;
        height:185px;
        object-fit:cover;
        border-radius:12px;
        border:1px solid var(--line);
        display:block;
        margin:0 auto;
        cursor:pointer;
        transition:transform .12s ease,box-shadow .12s ease
      }
      .profile:hover{
        transform:translateY(-2px);
        box-shadow:0 14px 26px rgba(15,23,42,.4)
      }
      .table-striped-strong tbody tr:nth-child(odd){
        background:linear-gradient(90deg,#f8fbff,#eef5ff)
      }
      .table-striped-strong thead th{
        background:var(--g2);
        color:#fff;
        border-color:transparent
      }
      .table-striped-strong th,.table-striped-strong td{
        font-size:.88rem
      }
      .video-shell{
        background:#000;
        border-radius:12px;
        overflow:hidden;
        box-shadow:0 16px 32px rgba(15,23,42,.6);
        max-width:960px;
        margin:0 auto
      }
      .video-shell video{
        width:100%;
        height:auto;
        max-height:68vh;
        display:block;
        background:#000
      }
      .vbar{
        display:flex;
        align-items:center;
        gap:.5rem;
        padding:.5rem;
        background:#0c1b3a;
        color:#e8f0ff;
        border-bottom-left-radius:12px;
        border-bottom-right-radius:12px;
        flex-wrap:wrap
      }
      .vbar .btn{
        border:0;
        border-radius:8px;
        background:#1a2f63;
        color:#e8f0ff;
        padding:.25rem .55rem;
        font-size:.82rem;
        display:inline-flex;
        align-items:center;
        gap:.25rem
      }
      .vbar .btn:hover{
        background:#223b78
      }
      .vbar select,.vbar input[type=range]{
        background:#1a2f63;
        border:0;
        color:#e8f0ff;
        border-radius:8px;
        padding:.2rem .45rem;
        font-size:.8rem
      }
      .vbar input[type=range]{
        flex:1 1 120px
      }
      .nostate{
        display:grid;
        place-items:center;
        height:60vh;
        color:#5f6f94
      }
      .cv-wrap{
        padding:14px;
        max-height:72vh;
        overflow:auto;
        background:#f3f6fc
      }
      .cv-paper{
        background:#fff;
        color:#000;
        border-radius:10px;
        border:1px solid #d0d7ec;
        overflow:hidden;
        box-shadow:0 12px 28px rgba(15,23,42,.25);
        max-width:980px;
        margin:0 auto
      }
      .cv-paper *{
        font-family:'Noto Sans',Arial,Helvetica,sans-serif
      }
      .cv-header{
        display:flex;
        justify-content:center;
        align-items:center;
        padding:14px 16px 10px;
        background:linear-gradient(135deg,#1d4ed8,#22b8cf);
        color:#fff;
        text-align:center
      }
      .cv-header-inner{
        max-width:100%
      }
      .cv-main-title-en{
        font-weight:800;
        font-size:16px;
        letter-spacing:.4px
      }
      .cv-main-title-ar{
        font-family:'Amiri','Noto Naskh Arabic',serif;
        font-weight:700;
        font-size:14px;
        margin-top:2px
      }
      .cv-name-row{
        margin-top:0;
        padding:10px 16px;
        border-bottom:1px solid #e0e4f4;
        display:flex;
        justify-content:space-between;
        gap:10px;
        font-size:13px;
        background:#f8fafc
      }
      .cv-grid{
        display:flex;
        flex-wrap:wrap;
        gap:0
      }
      .cv-col{
        flex:1 1 280px;
        padding:12px 14px
      }
      .cv-col-info{
        flex:1 1 340px
      }
      .cv-col-photo{
        flex:0 0 260px;
        max-width:320px;
        border-left:1px solid #e5e7f0;
        background:#f9fafb
      }
      .cv-section-title{
        font-weight:800;
        font-size:13px;
        margin-bottom:6px;
        border-bottom:1px solid #d0d7ec;
        padding-bottom:3px;
        display:flex;
        justify-content:space-between
      }
      .cv-section-title span:last-child{
        font-family:'Amiri','Noto Naskh Arabic',serif
      }
      .cv-photo-layout{
        display:flex;
        flex-direction:column;
        gap:16px;
        align-items:center
      }
      .cv-passport-section,.cv-fullbody-section{
        width:100%;
        max-width:240px;
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:8px
      }
      .cv-passport-caption,.cv-fullbody-caption{
        font-size:12px;
        font-weight:600;
        text-transform:uppercase;
        letter-spacing:.04em;
        color:#475569
      }
      .cv-pic{
        border:1px solid #bbb;
        border-radius:8px;
        width:190px;
        height:240px;
        object-fit:cover;
        background:#f3f4f6;
        cursor:pointer
      }
      .cv-fullbody{
        border:1px solid #bbb;
        border-radius:8px;
        width:220px;
        height:auto;
        object-fit:cover;
        background:#f3f4f6;
        cursor:pointer
      }
      .cv-table{
        width:100%;
        border-collapse:collapse;
        font-size:12px;
        margin-bottom:8px
      }
      .cv-table th,.cv-table td{
        border:1px solid #cfd5e8;
        padding:5px 6px;
        vertical-align:middle
      }
      .cv-table th{
        background:#eef2ff;
        font-weight:700
      }
      .cv-table-striped tbody tr:nth-child(odd) td{
        background:#f9fafb
      }
      .cv-footer-bar{
        padding:6px 10px 8px;
        background:#f8fafc;
        border-top:1px solid #d0d7ec;
        font-size:11px;
        text-align:center;
        color:#4b5563
      }
      .modal-footer-slim{
        padding:10px 14px 12px;
        display:flex;
        justify-content:space-between;
        gap:8px
      }
      .modal-footer-slim .button{
        min-width:110px;
        justify-content:center
      }
      .detail-actions-row{
        display:flex;
        gap:.5rem;
        flex-wrap:nowrap;
        justify-content:space-between;
        align-items:center
      }
      .detail-actions-row .button{
        flex:1 1 0;
        justify-content:center;
        white-space:nowrap
      }
      .search-modal .modal-headerX{
        background:var(--g2)
      }
      .search-wrap{
        padding:1rem
      }
      .search-wrap .input-group-text{
        background:#fff;
        border-right:0;
        height:42px
      }
      .search-wrap .input-group-text.clear-search{
        border-left:0;
        cursor:pointer
      }
      .search-wrap .form-control{
        border-left:0;
        height:42px
      }
      .search-ft{
        background:var(--g1);
        color:#fff;
        padding:.5rem 1rem;
        border-bottom-left-radius:16px;
        border-bottom-right-radius:16px;
        font-size:.82rem;
        text-align:center
      }
      .lang-modal .modal-headerX{
        background:var(--g2)
      }
      .lang-picker{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:.8rem;
        padding:1rem
      }
      .lang-pick{
        display:flex;
        align-items:center;
        justify-content:center;
        gap:.6rem;
        border:2px solid var(--line);
        border-radius:14px;
        padding:.8rem;
        background:#fff;
        font-weight:900;
        box-shadow:var(--shadow);
        transition:transform .12s ease,box-shadow .18s ease,border-color .18s ease
      }
      .lang-pick.active{
        outline:3px solid #2250c533;
        border-color:#2250c555
      }
      .lang-pick:hover{
        transform:translateY(-1px);
        box-shadow:0 18px 32px rgba(15,23,42,.18)
      }
      .flag-lg{
        width:24px;
        height:24px;
        border-radius:4px
      }
      .clear-btn{
        border:0;
        border-radius:10px;
        background:#fff;
        color:#2250c5;
        display:inline-flex;
        align-items:center;
        gap:.35rem;
        padding:.35rem .6rem;
        font-weight:800;
        box-shadow:inset 0 0 0 1px #dbe6f5;
        font-size:.75rem;
        white-space:nowrap
      }
      .clear-btn:hover{
        background:#edf2ff
      }
      .img-modal-body{
        display:flex;
        justify-content:center;
        align-items:center;
        background:#020617
      }
      .img-modal-body img{
        max-width:100%;
        max-height:78vh;
        object-fit:contain;
        border-radius:12px;
        box-shadow:0 20px 40px rgba(0,0,0,.8)
      }
      .pre{
        position:fixed;
        inset:0;
        display:none;
        place-items:center;
        background:radial-gradient(circle at top,#0b112033,#020617ee);
        z-index:2000
      }
      .pre-inner{
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:12px;
        padding:22px 26px;
        border-radius:20px;
        background:linear-gradient(135deg,#ffffff,#e5edff);
        box-shadow:0 22px 48px rgba(15,23,42,.65)
      }
      .pre .spin{
        width:70px;
        height:70px;
        border-radius:50%;
        background:conic-gradient(from 0deg,#22B8CF,#2250C5,#6A11CB,#FF7A18,#22B8CF);
        animation:spin2 1s linear infinite;
        -webkit-mask:radial-gradient(circle 27px at center,transparent 26px,#000 27px);
        mask:radial-gradient(circle 27px at center,transparent 26px,#000 27px)
      }
      .pre-text{
        font-weight:700;
        font-size:.9rem;
        color:#0f172a;
        text-align:center;
        min-width:190px
      }
      @keyframes spin2{
        to{transform:rotate(360deg)}
      }
      .loadmore-wrap{
        padding:1.1rem 0 4.8rem;
        text-align:center
      }
      .loadmore-btn{
        border:0;
        border-radius:999px;
        background:var(--g2);
        color:#fff;
        display:inline-flex;
        align-items:center;
        gap:.55rem;
        padding:.5rem 1.1rem;
        font-weight:800;
        box-shadow:var(--shadow);
        min-width:200px;
        justify-content:center;
        transition:transform .12s ease,box-shadow .16s ease
      }
      .loadmore-btn .lm-circle{
        width:32px;
        height:32px;
        border-radius:999px;
        display:grid;
        place-items:center;
        background:#ffffff22;
        box-shadow:inset 0 0 0 1px #ffffff44;
        font-size:1.2rem
      }
      .loadmore-btn .lm-text{
        display:flex;
        flex-direction:column;
        align-items:flex-start;
        line-height:1.2
      }
      #loadMoreLabel{
        font-size:.9rem
      }
      #loadMoreCount{
        font-size:.78rem;
        opacity:.85
      }
      .loadmore-btn:hover{
        transform:translateY(-1px);
        box-shadow:0 18px 32px rgba(15,23,42,.3)
      }
      .loadmore-btn.loading{
        opacity:.9
      }
      .loadmore-btn.loading .lm-circle i{
        animation:bounce 1s infinite
      }
      @keyframes bounce{
        0%,100%{transform:translateY(0)}
        50%{transform:translateY(-3px)}
      }
      @media(max-width:480px){
        .center-box{
          padding:18px 16px 14px;
          border-radius:18px
        }
        .cv-col-photo{
          max-width:100%;
          flex:1 1 260px;
          border-left:0;
          border-top:1px solid #e5e7f0
        }
        .cv-pic{
          width:160px;
          height:210px
        }
        .cv-fullbody{
          width:200px
        }
        .cv-header{
          flex-direction:column;
          gap:6px
        }
        .cv-col{
          flex:1 1 100%
        }
        .cv-photo-layout{
          align-items:center
        }
        .thumb,
        .thumb-ph{
          max-height:300px
        }
        .detail-actions-row{
          overflow-x:auto;
          padding-bottom:4px
        }
      }
    </style>
  </head>
  <body>
    <div class="app">
      <section id="s1" class="screen screen-landing active">
        <div class="bg-img">
          <img src="https://lh3.googleusercontent.com/p/AF1QipMePRJuF7RTY3UI3R51eIadKTGufgQL9S0ho8jE=s1360-w1360-h1020-rw" loading="lazy" alt="">
        </div>
        <div class="overlay-dark"></div>
        <div class="center-box text-center">
          <img class="logo" src="https://maids-dxb.com/storage/logos/K173gH2QID8p1EOxtwrB0LxWD5oJ87NXKZje7pCk.png" loading="lazy" alt="">
          <h1 id="s1Title">Welcome to Maids DXB</h1>
          <p id="s1Sub">Choose your language to start.</p>
          <div class="lang-choices">
            <button class="lang-btn active" data-lang="en">
              <img class="flag" src="https://flagcdn.com/w20/gb.png" loading="lazy" alt="">
              <span>English</span>
              <span class="radio"></span>
            </button>
            <button class="lang-btn" data-lang="ar">
              <img class="flag" src="https://flagcdn.com/w20/ae.png" loading="lazy" alt="">
              <span>العربية</span>
              <span class="radio"></span>
            </button>
          </div>
          <button id="goStep2" class="button g1 w-100 justify-content-center">
            <i class="bi bi-arrow-right-circle"></i>
            <span id="proceedLbl">Proceed</span>
          </button>
        </div>
      </section>
      <section id="s2" class="screen screen-landing">
        <div class="bg-img">
          <img src="https://lh3.googleusercontent.com/p/AF1QipMePRJuF7RTY3UI3R51eIadKTGufgQL9S0ho8jE=s1360-w1360-h1020-rw" loading="lazy" alt="">
        </div>
        <div class="overlay-dark"></div>
        <div class="center-box text-center">
          <img class="logo" src="https://maids-dxb.com/storage/logos/K173gH2QID8p1EOxtwrB0LxWD5oJ87NXKZje7pCk.png" loading="lazy" alt="">
          <h1 id="s2Title">Choose Service Type</h1>
          <p id="s2Sub">Select Inside or Outside maids.</p>
          <div class="d-flex flex-column flex-md-row gap-2 w-100 mb-2 mt-1">
            <button class="button g1 flex-fill justify-content-center" id="chooseInside">
              <i class="bi bi-house-door"></i>
              <span id="insideLbl">Inside Maids</span>
            </button>
            <button class="button g2 flex-fill justify-content-center" id="chooseOutside">
              <i class="bi bi-tree"></i>
              <span id="outsideLbl">Outside Maids</span>
            </button>
          </div>
          <div class="d-flex w-100 justify-content-center">
            <button class="button g2" id="backToS1">
              <i class="bi bi-arrow-left"></i>
            </button>
          </div>
        </div>
      </section>
      <section id="s3" class="screen">
        <div class="topbar">
          <div class="topbar-inner">
            <button class="button g2 back-only" id="backToS2">
              <i class="bi bi-arrow-left"></i>
              <span>Back</span>
            </button>
            <div class="brand">
              <img src="https://maids-dxb.com/storage/logos/K173gH2QID8p1EOxtwrB0LxWD5oJ87NXKZje7pCk.png" loading="lazy" alt="">
              <div>
                <b>Maids DXB</b>
              </div>
            </div>
            <div class="top-actions">
              <button class="clear-btn" id="clearCache">
                <i class="bi bi-arrow-counterclockwise"></i>
                <span id="clearLbl"></span>
              </button>
              <button class="button g1" id="langToggleBtn">
                <img id="langToggleFlag" style="width:16px;height:16px;border-radius:3px" src="https://flagcdn.com/w20/ae.png" loading="lazy" alt="">
                <span id="langToggleText">العربية</span>
              </button>
            </div>
          </div>
        </div>
        <div class="view" id="view">
          <div class="view-inner">
            <div class="header">
              <div class="segment">
                <button class="button g1" id="segInside">
                  <i class="bi bi-house-door"></i>
                  <span id="segInLbl">Inside</span>
                </button>
                <button class="button g2 active" id="segOutside">
                  <i class="bi bi-tree"></i>
                  <span id="segOutLbl">Outside</span>
                </button>
              </div>
            </div>
            <div class="tabs" id="countryTabs">
              <button class="tab active" data-country="">
                <i class="bi bi-globe"></i>
                <span id="tabAll">All</span>
              </button>
              <button class="tab" data-country="philippines">
                <img style="width:16px;height:16px;border-radius:2px" src="https://flagcdn.com/w20/ph.png" loading="lazy" alt="">
                <span>Filipino</span>
              </button>
              <button class="tab" data-country="ethiopia">
                <img style="width:16px;height:16px;border-radius:2px" src="https://flagcdn.com/w20/et.png" loading="lazy" alt="">
                <span>Ethiopian</span>
              </button>
              <button class="tab" data-country="uganda">
                <img style="width:16px;height:16px;border-radius:2px" src="https://flagcdn.com/w20/ug.png" loading="lazy" alt="">
                <span>Ugandan</span>
              </button>
            </div>
            <div class="searchRow">
              <div class="input-group input-group-sm">
                <span class="input-group-text">
                  <i class="bi bi-search"></i>
                </span>
                <input id="q" class="form-control" placeholder="Search by name · passport no · reference no">
                <span class="input-group-text clear-search" id="clearSearchMain">
                  <i class="bi bi-x-circle"></i>
                </span>
              </div>
              <button class="button g1 w-100 justify-content-center" id="openFilters">
                <i class="bi bi-sliders"></i>
                <span id="filtersLbl">Filters</span>
              </button>
            </div>
            <div id="grid" class="grid">
              <div class="skeleton"></div>
              <div class="skeleton"></div>
              <div class="skeleton"></div>
            </div>
            <div class="loadmore-wrap">
              <button id="loadMoreBtn" class="loadmore-btn d-none">
                <span class="lm-circle">
                  <i class="bi bi-arrow-down-short"></i>
                </span>
                <div class="lm-text">
                  <span id="loadMoreLabel">Load More...</span>
                  <small id="loadMoreCount">0 / 0</small>
                </div>
              </button>
            </div>
          </div>
        </div>
        <div class="tabbar">
          <button id="tabBrowse">
            <span class="ico">
              <i class="bi bi-people"></i>
            </span>
            <span id="tabBrowseLbl">Browse</span>
          </button>
          <button id="tabFilter">
            <span class="ico">
              <i class="bi bi-funnel"></i>
            </span>
            <span id="tabFilterLbl">Filter</span>
          </button>
          <button id="tabLang">
            <span class="ico">
              <i class="bi bi-translate"></i>
            </span>
            <span id="tabLangLbl">Language</span>
          </button>
        </div>
      </section>
    </div>
    <div class="offcanvas offcanvas-bottom" id="filters" style="height:78vh" data-bs-scroll="true">
      <div class="sheet-hd" id="filtersTitle">
        <button class="center-close" data-bs-dismiss="offcanvas">
          <i class="bi bi-x-lg"></i>
        </button>
        <div>Filters</div>
      </div>
      <div class="offcanvas-body pt-2">
        <div class="filters-inner">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <div class="fbox">
                <div class="fhd" id="ageTitle">Age</div>
                <div class="fbd">
                  <label class="check">
                    <input type="checkbox" class="f-age" value="18-25">
                    <span>18-25</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-age" value="26-30">
                    <span>26-30</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-age" value="31-35">
                    <span>31-35</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-age" value="36-45">
                    <span>36-45</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-age" value="46+">
                    <span>46+</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="fbox">
                <div class="fhd" id="expTitle">Experience</div>
                <div class="fbd">
                  <label class="check">
                    <input type="checkbox" class="f-exp" value="first">
                    <span id="firstTimeLbl">First Time Worker</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-exp" value="united arab emirates">
                    <span>United Arab Emirates</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-exp" value="saudi arabia">
                    <span>Saudi Arabia</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-exp" value="oman">
                    <span>Oman</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-exp" value="bahrain">
                    <span>Bahrain</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-exp" value="qatar">
                    <span>Qatar</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-exp" value="lebanon">
                    <span>Lebanon</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-exp" value="others">
                    <span id="othersLbl">Others</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="fbox">
                <div class="fhd" id="langFilterTitle">Language</div>
                <div class="fbd">
                  <label class="check">
                    <input type="checkbox" class="f-lang" value="arabic">
                    <span>Arabic</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-lang" value="english">
                    <span>English</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="fbox">
                <div class="fhd" id="relTitle">Religion</div>
                <div class="fbd">
                  <label class="check">
                    <input type="checkbox" class="f-rel" value="christian">
                    <span>Christian</span>
                  </label>
                  <label class="check">
                    <input type="checkbox" class="f-rel" value="muslim">
                    <span>Muslim</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="col-12" id="sponBox" style="display:none">
              <div class="fbox">
                <div class="fhd" id="sponTitle">Sponsorship (Inside)</div>
                <div class="fbd d-flex flex-wrap gap-3">
                  <label class="check m-0">
                    <input type="radio" name="spon" class="f-spon" value="" checked>
                    <span id="sponAll">All</span>
                  </label>
                  <label class="check m-0">
                    <input type="radio" name="spon" class="f-spon" value="personal">
                    <span id="sponPer">Personal</span>
                  </label>
                  <label class="check m-0">
                    <input type="radio" name="spon" class="f-spon" value="company">
                    <span id="sponCom">Company</span>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sheet-ft small" id="filtersFt">Swipe down or tap close to dismiss</div>
    </div>
    <div class="modal fade search-modal" id="searchModal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-headerX">
            <button class="center-close" data-bs-dismiss="modal">
              <i class="bi bi-x-lg"></i>
            </button>
            <div id="searchTitle">Search</div>
          </div>
          <div class="search-wrap">
            <div class="input-group">
              <span class="input-group-text">
                <i class="bi bi-search"></i>
              </span>
              <input id="qModal" class="form-control" placeholder="Search by name · passport no · reference no">
              <span class="input-group-text clear-search" id="clearSearchModal">
                <i class="bi bi-x-circle"></i>
              </span>
            </div>
            <div class="d-grid mt-3">
              <button id="doSearch" class="button g2 justify-content-center w-100">
                <span id="applySearchLbl">Apply Search</span>
              </button>
            </div>
          </div>
          <div class="search-ft small" id="searchFt">Tap close to cancel</div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="detailModal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-headerX">
            <button class="center-close" data-bs-dismiss="modal">
              <i class="bi bi-x-lg"></i>
            </button>
            <div id="infoTitle">Info</div>
          </div>
          <div class="p-3">
            <div class="row g-3">
              <div class="col-12">
                <img id="dmPhoto" class="profile" src="" loading="lazy" alt="">
                <div class="mt-2 text-center">
                  <span class="badge text-bg-warning px-2 py-1" id="dmRef">—</span>
                </div>
              </div>
              <div class="col-12">
                <div class="table-responsive">
                  <table class="table table-sm table-striped table-striped-strong mb-0">
                    <thead>
                      <tr>
                        <th style="width:50%">Field</th>
                        <th>Value</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td id="tName">Name</td>
                        <td id="dmName"></td>
                      </tr>
                      <tr>
                        <td id="tType">Type</td>
                        <td id="dmType"></td>
                      </tr>
                      <tr>
                        <td id="tNat">Nationality</td>
                        <td id="dmNat"></td>
                      </tr>
                      <tr>
                        <td id="tAge">Age</td>
                        <td id="dmAge"></td>
                      </tr>
                      <tr>
                        <td id="tRel">Religion</td>
                        <td id="dmRel"></td>
                      </tr>
                      <tr>
                        <td id="tSpeak">Speaks</td>
                        <td id="dmLangs"></td>
                      </tr>
                      <tr>
                        <td id="tPass">Passport No.</td>
                        <td id="dmPassport"></td>
                      </tr>
                      <tr>
                        <td id="tMar">Marital Status</td>
                        <td id="dmMarital"></td>
                      </tr>
                      <tr>
                        <td id="tChild">Children</td>
                        <td id="dmChildren"></td>
                      </tr>
                      <tr>
                        <td id="tExp">Total Experience</td>
                        <td id="dmExp"></td>
                      </tr>
                      <tr>
                        <td id="tSalary">Expected Salary</td>
                        <td id="dmSalary"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-12">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered mb-0">
                    <thead>
                      <tr>
                        <th style="background:var(--g2);color:#fff">Country</th>
                        <th style="width:160px;background:var(--g2);color:#fff">Years</th>
                      </tr>
                    </thead>
                    <tbody id="dmExpRows"></tbody>
                  </table>
                </div>
              </div>
              <div class="detail-actions-row mt-3">
                <button class="button g2" id="dmPrev">
                  <i class="bi bi-arrow-left-circle"></i>
                  <span id="dmPrevLbl"></span>
                </button>
                <button class="button g2" id="dmNext">
                  <span id="dmNextLbl"></span>
                  <i class="bi bi-arrow-right-circle"></i>
                </button>
                <button class="button g3" id="dmOpenCV">
                  <i class="bi bi-file-earmark-pdf"></i>
                  <span id="btnViewCV">CV</span>
                </button>
                <button class="button g2" id="dmOpenVideo">
                  <i class="bi bi-play-circle"></i>
                  <span id="btnViewVideo">Video</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="cvModal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-headerX">
            <button class="center-close" data-bs-dismiss="modal">
              <i class="bi bi-x-lg"></i>
            </button>
            <div id="cvTitle">Candidate CV</div>
          </div>
          <div id="cvBody" class="cv-wrap"></div>
          <div class="modal-footer-slim">
            <button id="cvPrev" class="button g2">
              <i class="bi bi-arrow-left-circle"></i>
              <span id="cvPrevLbl"></span>
            </button>
            <button id="cvNext" class="button g2">
              <span id="cvNextLbl"></span>
              <i class="bi bi-arrow-right-circle"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="videoModal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-headerX">
            <button class="center-close" data-bs-dismiss="modal">
              <i class="bi bi-x-lg"></i>
            </button>
            <div id="videoTitle">Candidate Video</div>
          </div>
          <div class="p-3">
            <div id="videoContainer" class="video-shell">
              <video id="pv" playsinline preload="metadata" controls></video>
              <div class="vbar">
                <button class="btn" id="vPlay">
                  <i class="bi bi-play-fill"></i>
                </button>
                <button class="btn" id="vBack">
                  <i class="bi bi-skip-backward"></i>
                </button>
                <button class="btn" id="vFwd">
                  <i class="bi bi-skip-forward"></i>
                </button>
                <label class="ms-1 me-1" id="speedLbl">Speed</label>
                <select id="vRate">
                  <option>0.5</option>
                  <option>0.75</option>
                  <option selected>1</option>
                  <option>1.25</option>
                  <option>1.5</option>
                  <option>1.75</option>
                  <option>2</option>
                </select>
                <label class="ms-2 me-1" id="volLbl">Volume</label>
                <input id="vVol" type="range" min="0" max="1" step="0.05" value="1">
                <button class="btn ms-auto" id="vMute">
                  <i class="bi bi-volume-up"></i>
                </button>
                <button class="btn" id="vPip">
                  <i class="bi bi-window-stack"></i>
                </button>
                <button class="btn" id="vPrevCandidate">
                  <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn" id="vNextCandidate">
                  <i class="bi bi-chevron-right"></i>
                </button>
              </div>
            </div>
            <div id="videoEmpty" class="nostate" style="display:none">
              <div class="text-center">
                <i class="bi bi-file-play fs-1 d-block mb-2"></i>
                <span id="noVideoLbl">No video available</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade lang-modal" id="langModal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-headerX">
            <button class="center-close" data-bs-dismiss="modal">
              <i class="bi bi-x-lg"></i>
            </button>
            <div id="langModalTitle">Language</div>
          </div>
          <div class="lang-picker">
            <button class="lang-pick" data-choose="en">
              <img class="flag-lg" src="https://flagcdn.com/w40/gb.png" loading="lazy" alt="">
              <span>English</span>
            </button>
            <button class="lang-pick" data-choose="ar">
              <img class="flag-lg" src="https://flagcdn.com/w40/ae.png" loading="lazy" alt="">
              <span>العربية</span>
            </button>
          </div>
          <div class="search-ft small" id="langFt">Tap a language to apply</div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="imgModal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-headerX">
            <button class="center-close" data-bs-dismiss="modal">
              <i class="bi bi-x-lg"></i>
            </button>
            <div id="imgModalTitle">Photo</div>
          </div>
          <div class="img-modal-body p-2">
            <img id="imgModalSrc" src="" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="pre" id="pre">
      <div class="pre-inner">
        <div class="spin"></div>
        <div class="pre-text" id="preText">Loading...</div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      const DATA_ENDPOINT="{{ route('candidates.outlet.data') }}";
      const STORAGE_KEY="MDXB_STATE";
      const qs=s=>document.querySelector(s);
      const qsa=s=>Array.from(document.querySelectorAll(s));
      const pre=qs("#pre");
      const preText=qs("#preText");
      const preOn=msg=>{if(msg)preText.textContent=msg;pre.style.display="grid"};
      const preOff=()=>{pre.style.display="none"};
      const I18N={
        en:{
          welcome:"Welcome to Maids DXB",
          startsub:"Choose your language to start.",
          proceed:"Proceed",
          choose:"Choose Service Type",
          chooseSub:"Select Inside or Outside maids.",
          inside:"Inside Maids",
          outside:"Outside Maids",
          insideTab:"Inside",
          outsideTab:"Outside",
          all:"All",
          filters:"Filters",
          loading:"Loading...",
          browse:"Browse",
          filter:"Filter",
          language:"Language",
          filtersHd:"Filters",
          filtersFt:"Swipe down or tap close to dismiss",
          ageHd:"Age",
          expHd:"Experience",
          first:"First Time Worker",
          others:"Others",
          langHd:"Language",
          relHd:"Religion",
          sponHd:"Sponsorship (Inside)",
          sponAll:"All",
          sponPer:"Personal",
          sponCom:"Company",
          search:"Search",
          applySearch:"Apply Search",
          searchFt:"Tap close to cancel",
          cand:"Info",
          tName:"Name",
          tType:"Type",
          tNat:"Nationality",
          tAge:"Age",
          tRel:"Religion",
          tSpeak:"Speaks",
          tPass:"Passport No.",
          tMar:"Marital Status",
          tChild:"Children",
          tExp:"Total Experience",
          tSalary:"Expected Salary",
          btnInfo:"Info",
          btnVideo:"Video",
          btnCV:"CV",
          btnHire:"Hire Me",
          cvHd:"Candidate CV",
          videoHd:"Candidate Video",
          speed:"Speed",
          volume:"Volume",
          noVideo:"No video available",
          langModal:"Language",
          langFt:"Tap a language to apply",
          noMore:"No more candidates",
          noCandidates:"No candidates found",
          searchPH:"Search by name · passport no · reference no",
          clear:"",
          cvPrev:"Previous CV",
          cvNext:"Next CV",
          nextVideoLoading:"Loading next video...",
          prevVideoLoading:"Loading previous video...",
          noNextVideo:"Sorry, there is no next video.",
          noPrevVideo:"Sorry, there is no previous video.",
          nextCVLoading:"Loading next CV...",
          prevCVLoading:"Loading previous CV...",
          noNextCV:"Sorry, there is no next CV.",
          noPrevCV:"Sorry, there is no previous CV.",
          loadingMore:"Loading more...",
          loadMore:"Load More...",
          insideYes:"In Office",
          insideNo:"Not In Office",
          marSingle:"Single",
          marMarried:"Married",
          marDivorced:"Divorced",
          marWidowed:"Widowed",
          detailPrev:"Previous",
          detailNext:"Next"
        },
        ar:{
          welcome:"مرحباً بكم في Maids DXB",
          startsub:"اختر اللغة للبدء.",
          proceed:"متابعة",
          choose:"اختر نوع الخدمة",
          chooseSub:"اختر عاملات داخليات أو خارجيات.",
          inside:"عاملات داخليات",
          outside:"عاملات خارجيات",
          insideTab:"داخل",
          outsideTab:"خارج",
          all:"الكل",
          filters:"المرشحات",
          loading:"جاري التحميل...",
          browse:"تصفح",
          filter:"تصفية",
          language:"اللغة",
          filtersHd:"المرشحات",
          filtersFt:"اسحب للأسفل أو أغلق للإلغاء",
          ageHd:"العمر",
          expHd:"الخبرة",
          first:"عاملة لأول مرة",
          others:"أخرى",
          langHd:"اللغة",
          relHd:"الديانة",
          sponHd:"الكفالة (للداخلي)",
          sponAll:"الكل",
          sponPer:"شخصية",
          sponCom:"شركة",
          search:"بحث",
          applySearch:"تطبيق البحث",
          searchFt:"اضغط إغلاق للإلغاء",
          cand:"المعلومات",
          tName:"الاسم",
          tType:"النوع",
          tNat:"الجنسية",
          tAge:"العمر",
          tRel:"الديانة",
          tSpeak:"اللغات",
          tPass:"رقم الجواز",
          tMar:"الحالة الاجتماعية",
          tChild:"الأطفال",
          tExp:"إجمالي الخبرة",
          tSalary:"الراتب المتوقع",
          btnInfo:"المعلومات",
          btnVideo:"الفيديو",
          btnCV:"السيرة",
          btnHire:"توظيف",
          cvHd:"السيرة الذاتية",
          videoHd:"فيديو المرشحة",
          speed:"السرعة",
          volume:"الصوت",
          noVideo:"لا يوجد فيديو متاح",
          langModal:"اللغة",
          langFt:"اضغط على اللغة للتطبيق",
          noMore:"لا مزيد من المرشحات",
          noCandidates:"لا توجد مرشحات متاحة",
          searchPH:"ابحث بالاسم · رقم الجواز · رقم المرجع",
          clear:"مسح التخزين",
          cvPrev:"السيرة السابقة",
          cvNext:"السيرة التالية",
          nextVideoLoading:"جاري تحميل الفيديو التالي...",
          prevVideoLoading:"جاري تحميل الفيديو السابق...",
          noNextVideo:"عذراً، لا يوجد فيديو تالي.",
          noPrevVideo:"عذراً، لا يوجد فيديو سابق.",
          nextCVLoading:"جاري تحميل السيرة التالية...",
          prevCVLoading:"جاري تحميل السيرة السابقة...",
          noNextCV:"عذراً، لا توجد سيرة تالية.",
          noPrevCV:"عذراً، لا توجد سيرة سابقة.",
          loadingMore:"جاري تحميل المزيد...",
          loadMore:"تحميل المزيد...",
          insideYes:"في المكتب",
          insideNo:"ليست في المكتب",
          marSingle:"عزباء",
          marMarried:"متزوجة",
          marDivorced:"مطلقة",
          marWidowed:"أرملة",
          detailPrev:"السابق",
          detailNext:"التالي"
        }
      };
      let state={
        lang:"en",
        cat:"outside",
        country:"",
        q:"",
        page:0,
        per:20,
        filters:{ages:[],langs:[],rels:[],exp:[],spon:""},
        busy:false,
        lastPage:1,
        total:0,
        items:[],
        onboarded:false
      };
      let currentRef=null;
      let loadMoreBtn=null;
      let loadMoreLabel=null;
      let loadMoreCount=null;
      function saveState(){
        const toSave={
          lang:state.lang,
          cat:state.cat,
          country:state.country,
          q:state.q,
          filters:state.filters,
          onboarded:state.onboarded
        };
        sessionStorage.setItem(STORAGE_KEY,JSON.stringify(toSave));
      }
      function loadState(){
        const raw=sessionStorage.getItem(STORAGE_KEY);
        if(!raw)return null;
        try{return JSON.parse(raw)}catch(e){return null}
      }
      function applyLang(){
        const L=I18N[state.lang];
        qs("#s1Title").textContent=L.welcome;
        qs("#s1Sub").textContent=L.startsub;
        qs("#proceedLbl").textContent=L.proceed;
        qs("#s2Title").textContent=L.choose;
        qs("#s2Sub").textContent=L.chooseSub;
        qs("#insideLbl").textContent=L.inside;
        qs("#outsideLbl").textContent=L.outside;
        qs("#segInLbl").textContent=L.insideTab;
        qs("#segOutLbl").textContent=L.outsideTab;
        qs("#tabAll").textContent=L.all;
        qs("#filtersLbl").textContent=L.filters;
        qs("#tabBrowseLbl").textContent=L.browse;
        qs("#tabFilterLbl").textContent=L.filter;
        qs("#tabLangLbl").textContent=L.language;
        qs("#filtersTitle").querySelector("div").textContent=L.filtersHd;
        qs("#filtersFt").textContent=L.filtersFt;
        qs("#ageTitle").textContent=L.ageHd;
        qs("#expTitle").textContent=L.expHd;
        qs("#firstTimeLbl").textContent=L.first;
        qs("#othersLbl").textContent=L.others;
        qs("#langFilterTitle").textContent=L.langHd;
        qs("#relTitle").textContent=L.relHd;
        qs("#sponTitle").textContent=L.sponHd;
        qs("#sponAll").textContent=L.sponAll;
        qs("#sponPer").textContent=L.sponPer;
        qs("#sponCom").textContent=L.sponCom;
        qs("#searchTitle").textContent=L.search;
        qs("#applySearchLbl").textContent=L.applySearch;
        qs("#searchFt").textContent=L.searchFt;
        qs("#q").placeholder=L.searchPH;
        qs("#qModal").placeholder=L.searchPH;
        qs("#infoTitle").textContent=L.cand;
        qs("#cvTitle").textContent=L.cvHd;
        qs("#videoTitle").textContent=L.videoHd;
        qs("#speedLbl").textContent=L.speed;
        qs("#volLbl").textContent=L.volume;
        qs("#noVideoLbl").textContent=L.noVideo;
        qs("#clearLbl").textContent=L.clear;
        qs("#langModalTitle").textContent=L.langModal;
        qs("#langFt").textContent=L.langFt;
        qs("#tName").textContent=L.tName;
        qs("#tType").textContent=L.tType;
        qs("#tNat").textContent=L.tNat;
        qs("#tAge").textContent=L.tAge;
        qs("#tRel").textContent=L.tRel;
        qs("#tSpeak").textContent=L.tSpeak;
        qs("#tPass").textContent=L.tPass;
        qs("#tMar").textContent=L.tMar;
        qs("#tChild").textContent=L.tChild;
        qs("#tExp").textContent=L.tExp;
        qs("#tSalary").textContent=L.tSalary;
        qs("#cvPrevLbl").textContent=L.cvPrev;
        qs("#cvNextLbl").textContent=L.cvNext;
        qs("#btnViewCV").textContent=L.btnCV;
        qs("#btnViewVideo").textContent=L.btnVideo;
        qs("#dmPrevLbl").textContent=L.detailPrev;
        qs("#dmNextLbl").textContent=L.detailNext;
        if(loadMoreLabel)loadMoreLabel.textContent=L.loadMore;
        document.documentElement.dir=state.lang==="ar"?"rtl":"ltr";
        qs("#langToggleText").textContent=state.lang==="en"?"العربية":"EN";
        qs("#langToggleFlag").src=state.lang==="en"?"https://flagcdn.com/w20/ae.png":"https://flagcdn.com/w20/gb.png";
        saveState();
      }
      function switchScreen(sel){
        qsa(".screen").forEach(s=>{
          if(s.id===sel.replace("#",""))s.classList.add("active");
          else s.classList.remove("active");
        });
        window.scrollTo({top:0,left:0,behavior:"instant"});
      }
      function initials(s){
        return(s||"").trim().split(/\s+/).slice(0,2).map(x=>x[0]?.toUpperCase()||"").join("")||"—";
      }
      function sumYears(m){
        const base=m.experience_years;
        if(base!=null)return base;
        return(m.experiences||[]).map(x=>x.years||0).reduce((a,b)=>a+b,0);
      }
      function maritalText(m){
        const L=I18N[state.lang];
        const v=m.marital_status;
        if(v===1||v==="1"||String(v).toLowerCase()==="single")return L.marSingle;
        if(v===2||v==="2"||String(v).toLowerCase()==="married")return L.marMarried;
        if(v===3||v==="3"||String(v).toLowerCase()==="divorced")return L.marDivorced;
        if(v===4||v==="4"||String(v).toLowerCase()==="widowed")return L.marWidowed;
        return v||"—";
      }
      function li(label,val){
        return`<li><b>${label}:</b> ${val||"—"}</li>`;
      }
      function card(m){
        const L=I18N[state.lang];
        const hasImg=!!m.photo;
        const thumb=hasImg?`<img class="thumb" src="${m.photo}" loading="lazy" onerror="this.replaceWith(Object.assign(document.createElement('div'),{className:'thumb-ph',textContent:'${initials(m.name)}'}));" alt="">`:`<div class="thumb-ph">${initials(m.name)}</div>`;
        const salaryText=m.salary_text||(m.salary?`${Number(m.salary).toLocaleString()} AED / month`:"—");
        const relText=m.religion||"";
        const speaks=m.speaks&&m.speaks.length?` · <b>${L.tSpeak}</b>: ${m.speaks.map(x=>x[0].toUpperCase()+x.slice(1)).join(", ")}`:"";
        const marital=maritalText(m);
        const children=m.children_count??"—";
        const years=sumYears(m);
        const expText=years?`${years} Years`:"—";
        const typeLabel=m.type==="outside"?L.outsideTab:L.insideTab;
        return`
          <div class="cardx">
            <div class="media">
              ${thumb}
              ${m.video?`<button class="play" data-vref="${m.ref}"><i class="bi bi-play-fill"></i></button>`:""}
              ${m.ref?`<span class="ref">${m.ref}</span>`:""}
            </div>
            <div class="card-body">
              <div class="title">
                ${m.name||"—"}
                <small>${m.nationality||""}${typeLabel?" · "+typeLabel:""}</small>
              </div>
              <ul class="meta">
                ${li(L.tRel,relText+speaks)}
                ${li(L.tMar,`${marital} · <b>${L.tChild}</b>: ${children}`)}
                ${li(L.tExp,expText)}
                ${li(L.tSalary,salaryText)}
              </ul>
              <div class="actions mt-auto">
                <button class="button g3" data-detail="${m.ref}"><i class="bi bi-info-circle"></i>${L.btnInfo}</button>
                <button class="button g2" data-video="${m.ref}"><i class="bi bi-play-circle"></i>${L.btnVideo}</button>
                <button class="button g1" data-cvref="${m.ref}"><i class="bi bi-file-earmark-pdf"></i>${L.btnCV}</button>
              </div>
            </div>
          </div>`;
      }
      function byRef(ref){
        return state.items.find(x=>String(x.ref)===String(ref))||null;
      }
      function getIndexByRef(ref){
        return state.items.findIndex(x=>String(x.ref)===String(ref));
      }
      function openDetail(m){
        if(!m)return;
        currentRef=m.ref||null;
        const L=I18N[state.lang];
        qs("#infoTitle").textContent=m.name||L.cand;
        qs("#dmName").textContent=m.name||"";
        qs("#dmRef").textContent=m.ref||"—";
        let typeText;
        if(m.type==="outside"){
          typeText=L.outsideTab;
        }else{
          const base=L.insideTab;
          if(m.sponsorship==="company")typeText=base+" · "+L.sponCom;
          else if(m.sponsorship==="personal")typeText=base+" · "+L.sponPer;
          else typeText=base;
        }
        qs("#dmType").textContent=typeText;
        qs("#dmNat").textContent=m.nationality||"—";
        qs("#dmAge").textContent=m.age??"—";
        qs("#dmRel").textContent=m.religion||"—";
        qs("#dmLangs").textContent=m.speaks&&m.speaks.length?m.speaks.map(x=>x[0].toUpperCase()+x.slice(1)).join(", "):"—";
        qs("#dmPassport").textContent=m.passport_no||"—";
        qs("#dmMarital").textContent=maritalText(m);
        qs("#dmChildren").textContent=m.children_count??"—";
        const yrs=sumYears(m);
        qs("#dmExp").textContent=yrs?yrs+" Years":"—";
        const salaryText=m.salary_text||(m.salary?`${Number(m.salary).toLocaleString()} AED / month`:"—");
        qs("#dmSalary").textContent=salaryText;
        const im=qs("#dmPhoto");
        if(m.photo){
          im.style.display="block";
          im.src=m.photo;
          im.onerror=()=>{im.style.display="none"};
        }else{
          im.style.display="none";
        }
        const rows=(m.experiences||[]).length?m.experiences.map(x=>`<tr><td>${x.country||"—"}</td><td>${x.years??"—"}</td></tr>`).join(""):`<tr><td colspan="2" class="text-center text-muted">No data</td></tr>`;
        qs("#dmExpRows").innerHTML=rows;
        new bootstrap.Modal("#detailModal").show();
      }
      function safe(v){
        return v==null||v===""?"N/A":v;
      }
      function titleCase(s){
        return(s||"").toLowerCase().replace(/\b\w/g,m=>m.toUpperCase());
      }
      function buildCVHtml(m){
        const salaryText=m.salary_text||(m.salary?`${Number(m.salary).toLocaleString()} AED / month`:"N/A");
        const langs=m.speaks||[];
        const hasEn=langs.includes("english");
        const hasAr=langs.includes("arabic");
        const expRows=(m.experiences||[]).length?m.experiences.map(e=>`<tr><td>${safe(e.country)}</td><td>${safe(e.years)} Years</td></tr>`).join(""):`<tr><td colspan="2" style="text-align:center">N/A</td></tr>`;
        const passportPhoto=m.photo?`<img src="${m.photo}" class="cv-pic" loading="lazy" onerror="this.style.display='none'">`:`<div class="cv-pic" style="display:flex;align-items:center;justify-content:center;font-weight:bold">${initials(m.name)}</div>`;
        const fullBodyPhoto=m.full_body?`<img src="${m.full_body}" class="cv-fullbody" loading="lazy" onerror="this.style.display='none'">`:`<div class="cv-fullbody" style="display:flex;align-items:center;justify-content:center;font-weight:bold">${initials(m.name)}</div>`;
        const mar=maritalText(m);
        return`
          <div class="cv-paper">
            <div class="cv-header">
              <div class="cv-header-inner">
                <div class="cv-main-title-en">Application For Employment</div>
                <div class="cv-main-title-ar">استمارة طلب عمل</div>
              </div>
            </div>
            <div class="cv-name-row">
              <span><strong>Name:</strong> ${safe(m.name)}</span>
              <span style="font-family:'Amiri','Noto Naskh Arabic',serif"><strong>الاسم:</strong> ${safe(m.name)}</span>
            </div>
            <div class="cv-grid">
              <div class="cv-col cv-col-info">
                <div class="cv-section-title">
                  <span>Candidate Information</span>
                  <span>بيانات المرشحة</span>
                </div>
                <table class="cv-table cv-table-striped">
                  <tbody>
                    <tr>
                      <th>Reference No</th>
                      <td>${safe(m.ref)}</td>
                    </tr>
                    <tr>
                      <th>Post Applied For</th>
                      <td>${safe(m.position||"N/A")}</td>
                    </tr>
                    <tr>
                      <th>Monthly Salary</th>
                      <td>${salaryText}</td>
                    </tr>
                    <tr>
                      <th>Contract Period</th>
                      <td>${safe(m.contract_duration||"N/A")}</td>
                    </tr>
                    <tr>
                      <th>Nationality</th>
                      <td>${safe(m.nationality)}</td>
                    </tr>
                    <tr>
                      <th>Religion</th>
                      <td>${safe(m.religion)}</td>
                    </tr>
                    <tr>
                      <th>Age</th>
                      <td>${safe(m.age)}</td>
                    </tr>
                    <tr>
                      <th>Marital Status</th>
                      <td>${safe(mar)}</td>
                    </tr>
                    <tr>
                      <th>No. Of Children</th>
                      <td>${safe(m.children_count)}</td>
                    </tr>
                    <tr>
                      <th>Weight</th>
                      <td>${m.weight?safe(m.weight)+" kg":"N/A"}</td>
                    </tr>
                    <tr>
                      <th>Height</th>
                      <td>${m.height?safe(m.height)+" cm":"N/A"}</td>
                    </tr>
                    <tr>
                      <th>Education Level</th>
                      <td>${safe(m.education_level)}</td>
                    </tr>
                  </tbody>
                </table>
                <div class="cv-section-title">
                  <span>Passport Information</span>
                  <span>بيانات جواز السفر</span>
                </div>
                <table class="cv-table">
                  <tbody>
                    <tr>
                      <th>Passport No.</th>
                      <td>${safe((m.passport_no||"").toString().toUpperCase())}</td>
                    </tr>
                    <tr>
                      <th>Issue Date</th>
                      <td>${safe(m.passport_issue_date||"N/A")}</td>
                    </tr>
                    <tr>
                      <th>Place of Issue</th>
                      <td>${safe(titleCase(m.passport_issue_place))}</td>
                    </tr>
                    <tr>
                      <th>Expiry Date</th>
                      <td>${safe(m.passport_expiry_date||"N/A")}</td>
                    </tr>
                  </tbody>
                </table>
                <div class="cv-section-title">
                  <span>Languages</span>
                  <span>اللغات</span>
                </div>
                <table class="cv-table">
                  <tr>
                    <th>Language</th>
                    <th>Level</th>
                  </tr>
                  <tr>
                    <td>English</td>
                    <td>${hasEn?"Good":"N/A"}</td>
                  </tr>
                  <tr>
                    <td>Arabic</td>
                    <td>${hasAr?"Good":"N/A"}</td>
                  </tr>
                </table>
                <div class="cv-section-title">
                  <span>Previous Employment Abroad</span>
                  <span>الخبرة خارج البلد</span>
                </div>
                <table class="cv-table">
                  <tr>
                    <th>Country</th>
                    <th>Years</th>
                  </tr>
                  ${expRows}
                </table>
              </div>
              <div class="cv-col cv-col-photo">
                <div class="cv-photo-layout">
                  <div class="cv-passport-section">
                    <div class="cv-passport-caption">Passport Photo</div>
                    ${passportPhoto}
                  </div>
                  <div class="cv-fullbody-section">
                    <div class="cv-fullbody-caption">Full Body Photo</div>
                    ${fullBodyPhoto}
                  </div>
                </div>
              </div>
            </div>
            <div class="cv-footer-bar">
              ${safe(m.partner?("Partner: "+m.partner.toUpperCase()):"")}
            </div>
          </div>`;
      }
      function openCVFromModel(m){
        if(m)currentRef=m.ref;
        const model=m||byRef(currentRef);
        if(!model)return;
        const body=qs("#cvBody");
        body.innerHTML=buildCVHtml(model);
        qs("#cvTitle").textContent=model.name||I18N[state.lang].cvHd;
        const d=bootstrap.Modal.getInstance(qs("#detailModal"));
        if(d)d.hide();
        new bootstrap.Modal("#cvModal").show();
      }
      function openVideoForModel(m){
        if(!m)return;
        currentRef=m.ref||currentRef;
        const L=I18N[state.lang];
        const v=qs("#pv");
        const box=qs("#videoContainer");
        const empty=qs("#videoEmpty");
        qs("#videoTitle").textContent=m.name||L.videoHd;
        const url=m.video||null;
        if(!url){
          empty.style.display="grid";
          box.style.display="none";
          try{
            v.pause();
            v.removeAttribute("src");
            v.load();
          }catch(e){}
          preOn(L.noVideo);
          setTimeout(preOff,1200);
          new bootstrap.Modal("#videoModal").show();
          return;
        }
        empty.style.display="none";
        box.style.display="block";
        try{
          v.pause();
          v.removeAttribute("src");
          v.load();
        }catch(e){}
        v.src=url;
        v.load();
        setTimeout(()=>{try{v.play()}catch(e){}},600);
        const d=bootstrap.Modal.getInstance(qs("#detailModal"));
        if(d)d.hide();
        new bootstrap.Modal("#videoModal").show();
      }
      function renderGrid(){
        const grid=qs("#grid");
        const L=I18N[state.lang];
        if(!state.items.length){
          grid.innerHTML=`<div class="empty">${L.noCandidates}</div>`;
          if(loadMoreCount)loadMoreCount.textContent=`0 / ${state.total||0}`;
          if(loadMoreBtn)loadMoreBtn.classList.add("d-none");
          return;
        }
        grid.innerHTML=state.items.map(card).join("");
        const shown=state.items.length;
        const total=state.total||shown;
        if(loadMoreCount)loadMoreCount.textContent=`${shown} / ${total}`;
        const hasMore=state.page<state.lastPage;
        if(loadMoreBtn){
          const showBtn=hasMore&&state.items.length>=state.per;
          loadMoreBtn.classList.toggle("d-none",!showBtn);
          loadMoreBtn.disabled=!hasMore;
        }
      }
      function getTypeParam(){
        if(state.cat==="outside")return"outside";
        const s=state.filters.spon||"";
        if(s==="company")return"inside-company";
        if(s==="personal")return"inside-personal";
        return"inside";
      }
      async function fetchItems(reset){
        if(state.busy)return;
        const L=I18N[state.lang];
        state.busy=true;
        const grid=qs("#grid");
        const beforeShown=state.items.length;
        const beforeTotal=state.total||0;
        if(reset){
          preOn(L.loading);
        }else{
          preOn(L.loadingMore);
        }
        if(loadMoreBtn){
          loadMoreBtn.disabled=true;
          loadMoreBtn.classList.add("loading");
        }
        if(loadMoreLabel){
          loadMoreLabel.textContent=reset?L.loading:L.loadingMore;
        }
        if(loadMoreCount){
          const tTotal=beforeTotal||0;
          loadMoreCount.textContent=`${beforeShown} / ${tTotal} ${L.loading}`;
        }
        if(reset){
          state.page=0;
          state.lastPage=1;
          state.items=[];
          state.total=0;
          grid.innerHTML=`<div class="skeleton"></div><div class="skeleton"></div><div class="skeleton"></div>`;
          if(loadMoreCount)loadMoreCount.textContent="0 / 0";
        }
        const nextPage=reset?1:state.page+1;
        const params=new URLSearchParams();
        params.set("type",getTypeParam());
        if(state.country)params.set("country",state.country);
        if(state.q)params.set("q",state.q);
        state.filters.ages.forEach(a=>params.append("ages[]",a));
        state.filters.langs.forEach(a=>params.append("langs[]",a));
        state.filters.rels.forEach(a=>params.append("rels[]",a));
        state.filters.exp.forEach(a=>params.append("exp[]",a));
        if(state.cat==="inside"&&state.filters.spon!=="")params.set("spon",state.filters.spon);
        params.set("page",nextPage);
        params.set("per_page",state.per);
        try{
          const res=await fetch(`${DATA_ENDPOINT}?${params.toString()}`,{headers:{"Accept":"application/json"}});
          const json=await res.json();
          const items=Array.isArray(json.items)?json.items:[];
          state.page=Number(json.page||nextPage);
          state.lastPage=Number(json.last_page||state.page);
          state.total=Number(json.total||items.length);
          state.items=reset?items:state.items.concat(items);
          renderGrid();
        }catch(e){
          if(reset){
            state.items=[];
            renderGrid();
          }
        }finally{
          state.busy=false;
          const L2=I18N[state.lang];
          const hasMore=state.page<state.lastPage;
          if(loadMoreBtn){
            loadMoreBtn.classList.remove("loading");
            loadMoreBtn.disabled=!hasMore;
            const showBtn=hasMore&&state.items.length>=state.per;
            loadMoreBtn.classList.toggle("d-none",!showBtn);
          }
          if(loadMoreLabel){
            loadMoreLabel.textContent=hasMore?L2.loadMore:L2.noMore;
          }
          if(loadMoreCount){
            const shown=state.items.length;
            const total=state.total||shown;
            loadMoreCount.textContent=`${shown} / ${total}`;
          }
          preOff();
        }
      }
      function syncCategoryUI(){
        if(state.cat==="outside"){
          qs("#segOutside").classList.add("active");
          qs("#segInside").classList.remove("active");
          qs("#sponBox").style.display="none";
        }else{
          qs("#segInside").classList.add("active");
          qs("#segOutside").classList.remove("active");
          qs("#sponBox").style.display="block";
        }
      }
      function syncFiltersFromState(){
        qsa(".f-age").forEach(cb=>cb.checked=state.filters.ages.includes(cb.value));
        qsa(".f-exp").forEach(cb=>cb.checked=state.filters.exp.includes(cb.value));
        qsa(".f-lang").forEach(cb=>cb.checked=state.filters.langs.includes(cb.value));
        qsa(".f-rel").forEach(cb=>cb.checked=state.filters.rels.includes(cb.value));
        qsa(".f-spon").forEach(rb=>rb.checked=state.filters.spon===rb.value);
      }
      function syncLangUI(){
        qsa(".lang-btn").forEach(b=>b.classList.toggle("active",b.dataset.lang===state.lang));
        qsa(".lang-pick").forEach(b=>b.classList.toggle("active",b.dataset.choose===state.lang));
      }
      function syncTabsUI(){
        qsa("#countryTabs .tab").forEach(t=>t.classList.toggle("active",t.dataset.country===state.country));
      }
      function openSiblingCV(step){
        const L=I18N[state.lang];
        if(!currentRef){
          preOn(step>0?L.noNextCV:L.noPrevCV);
          setTimeout(preOff,1400);
          return;
        }
        const idx=getIndexByRef(currentRef);
        if(idx===-1){
          preOn(step>0?L.noNextCV:L.noPrevCV);
          setTimeout(preOff,1400);
          return;
        }
        const nextIdx=idx+step;
        if(nextIdx<0||nextIdx>=state.items.length){
          preOn(step>0?L.noNextCV:L.noPrevCV);
          setTimeout(preOff,1400);
          return;
        }
        const m=state.items[nextIdx];
        if(!m){
          preOn(step>0?L.noNextCV:L.noPrevCV);
          setTimeout(preOff,1400);
          return;
        }
        preOn(step>0?L.nextCVLoading:L.prevCVLoading);
        setTimeout(()=>{
          preOff();
          openCVFromModel(m);
        },450);
      }
      function openSiblingVideo(step){
        const L=I18N[state.lang];
        if(!currentRef){
          preOn(step>0?L.noNextVideo:L.noPrevVideo);
          setTimeout(preOff,1400);
          return;
        }
        let idx=getIndexByRef(currentRef);
        if(idx===-1){
          preOn(step>0?L.noNextVideo:L.noPrevVideo);
          setTimeout(preOff,1400);
          return;
        }
        let nextIdx=idx+step;
        while(nextIdx>=0&&nextIdx<state.items.length){
          const m=state.items[nextIdx];
          if(m&&m.video){
            preOn(step>0?L.nextVideoLoading:L.prevVideoLoading);
            setTimeout(()=>{
              preOff();
              openVideoForModel(m);
            },450);
            return;
          }
          nextIdx+=step;
        }
        preOn(step>0?L.noNextVideo:L.noPrevVideo);
        setTimeout(preOff,1400);
      }
      function openSiblingDetail(step){
        const L=I18N[state.lang];
        if(!currentRef){
          preOn(step>0?L.detailNext:L.detailPrev);
          setTimeout(preOff,800);
          return;
        }
        const idx=getIndexByRef(currentRef);
        if(idx===-1){
          preOn(step>0?L.detailNext:L.detailPrev);
          setTimeout(preOff,800);
          return;
        }
        const nextIdx=idx+step;
        if(nextIdx<0||nextIdx>=state.items.length){
          preOn(step>0?L.noNextCV:L.noPrevCV);
          setTimeout(preOff,1200);
          return;
        }
        const m=state.items[nextIdx];
        if(!m){
          preOn(step>0?L.noNextCV:L.noPrevCV);
          setTimeout(preOff,1200);
          return;
        }
        openDetail(m);
      }
      function openImageModal(src,title){
        if(!src)return;
        const img=qs("#imgModalSrc");
        img.src=src;
        qs("#imgModalTitle").textContent=title||"Photo";
        new bootstrap.Modal("#imgModal").show();
      }
      document.addEventListener("DOMContentLoaded",()=>{
        preOff();
        loadMoreBtn=qs("#loadMoreBtn");
        loadMoreLabel=qs("#loadMoreLabel");
        loadMoreCount=qs("#loadMoreCount");
        const saved=loadState();
        if(saved){
          state.lang=saved.lang||state.lang;
          state.cat=saved.cat||state.cat;
          state.country=saved.country||state.country;
          state.q=saved.q||state.q;
          state.filters=Object.assign({ages:[],langs:[],rels:[],exp:[],spon:""},saved.filters||{});
          state.onboarded=!!saved.onboarded;
        }
        applyLang();
        syncCategoryUI();
        syncFiltersFromState();
        syncLangUI();
        syncTabsUI();
        qs("#q").value=state.q;
        qs("#qModal").value=state.q;
        qsa(".lang-btn").forEach(btn=>{
          btn.addEventListener("click",()=>{
            const lang=btn.dataset.lang;
            if(!lang||lang===state.lang)return;
            state.lang=lang;
            applyLang();
            syncLangUI();
            renderGrid();
          });
        });
        qsa(".lang-pick").forEach(btn=>{
          btn.addEventListener("click",()=>{
            const lang=btn.dataset.choose;
            if(!lang)return;
            state.lang=lang;
            applyLang();
            syncLangUI();
            renderGrid();
            const lm=bootstrap.Modal.getInstance(qs("#langModal"));
            if(lm)lm.hide();
          });
        });
        qs("#langToggleBtn").addEventListener("click",()=>{
          state.lang=state.lang==="en"?"ar":"en";
          applyLang();
          syncLangUI();
          renderGrid();
        });
        qs("#goStep2").addEventListener("click",()=>switchScreen("#s2"));
        qs("#backToS1").addEventListener("click",()=>switchScreen("#s1"));
        qs("#backToS2").addEventListener("click",()=>switchScreen("#s2"));
        function setCategory(cat){
          state.cat=cat;
          state.onboarded=true;
          syncCategoryUI();
          state.page=0;
          state.lastPage=1;
          state.items=[];
          fetchItems(true);
          saveState();
        }
        qs("#chooseInside").addEventListener("click",()=>{
          setCategory("inside");
          switchScreen("#s3");
        });
        qs("#chooseOutside").addEventListener("click",()=>{
          setCategory("outside");
          switchScreen("#s3");
        });
        qs("#segInside").addEventListener("click",()=>setCategory("inside"));
        qs("#segOutside").addEventListener("click",()=>setCategory("outside"));
        qsa("#countryTabs .tab").forEach(tab=>{
          tab.addEventListener("click",()=>{
            const c=tab.dataset.country||"";
            if(c===state.country)return;
            state.country=c;
            syncTabsUI();
            state.page=0;
            state.lastPage=1;
            state.items=[];
            fetchItems(true);
            saveState();
          });
        });
        const mainSearchInput=qs("#q");
        const modalSearchInput=qs("#qModal");
        function applySearchFromMain(){
          state.q=mainSearchInput.value.trim();
          modalSearchInput.value=state.q;
          state.page=0;
          state.lastPage=1;
          state.items=[];
          fetchItems(true);
          saveState();
        }
        qs("#q").addEventListener("keydown",e=>{
          if(e.key==="Enter"){
            applySearchFromMain();
          }
        });
        qs("#q").addEventListener("blur",()=>{
          if(state.q!==mainSearchInput.value.trim()){
            applySearchFromMain();
          }
        });
        qs("#doSearch").addEventListener("click",()=>{
          state.q=qs("#qModal").value.trim();
          qs("#q").value=state.q;
          state.page=0;
          state.lastPage=1;
          state.items=[];
          fetchItems(true);
          saveState();
          const sm=bootstrap.Modal.getInstance(qs("#searchModal"));
          if(sm)sm.hide();
        });
        qs("#qModal").addEventListener("keydown",e=>{
          if(e.key==="Enter"){
            e.preventDefault();
            qs("#doSearch").click();
          }
        });
        qs("#clearSearchMain").addEventListener("click",()=>{
          state.q="";
          mainSearchInput.value="";
          modalSearchInput.value="";
          state.page=0;
          state.lastPage=1;
          state.items=[];
          fetchItems(true);
          saveState();
        });
        qs("#clearSearchModal").addEventListener("click",()=>{
          state.q="";
          mainSearchInput.value="";
          modalSearchInput.value="";
        });
        qsa(".f-age,.f-exp,.f-lang,.f-rel").forEach(el=>{
          el.addEventListener("change",()=>{
            state.filters.ages=qsa(".f-age:checked").map(i=>i.value);
            state.filters.exp=qsa(".f-exp:checked").map(i=>i.value);
            state.filters.langs=qsa(".f-lang:checked").map(i=>i.value);
            state.filters.rels=qsa(".f-rel:checked").map(i=>i.value);
            state.page=0;
            state.lastPage=1;
            state.items=[];
            fetchItems(true);
            saveState();
          });
        });
        qsa(".f-spon").forEach(rb=>{
          rb.addEventListener("change",()=>{
            const c=qsa(".f-spon").find(r=>r.checked);
            state.filters.spon=c?c.value:"";
            if(state.cat==="inside"){
              state.page=0;
              state.lastPage=1;
              state.items=[];
              fetchItems(true);
              saveState();
            }
          });
        });
        const filtersOff=new bootstrap.Offcanvas("#filters");
        qs("#openFilters").addEventListener("click",()=>filtersOff.show());
        qs("#tabFilter").addEventListener("click",()=>filtersOff.show());
        qs("#tabBrowse").addEventListener("click",()=>{
          const sm=new bootstrap.Modal("#searchModal");
          sm.show();
          setTimeout(()=>{modalSearchInput.focus()},200);
        });
        qs("#tabLang").addEventListener("click",()=>{
          new bootstrap.Modal("#langModal").show();
        });
        qs("#clearCache").addEventListener("click",()=>{
          sessionStorage.removeItem(STORAGE_KEY);
          location.reload();
        });
        if(loadMoreBtn){
          loadMoreBtn.addEventListener("click",()=>{
            if(state.busy)return;
            fetchItems(false);
          });
        }
        const grid=qs("#grid");
        grid.addEventListener("click",e=>{
          const detailBtn=e.target.closest("[data-detail]");
          const videoBtn=e.target.closest("[data-video]");
          const cvBtn=e.target.closest("[data-cvref]");
          const playBtn=e.target.closest(".play");
          if(detailBtn){
            const ref=detailBtn.getAttribute("data-detail");
            openDetail(byRef(ref));
          }else if(videoBtn){
            const ref=videoBtn.getAttribute("data-video");
            const m=byRef(ref);
            if(m)openVideoForModel(m);
          }else if(cvBtn){
            const ref=cvBtn.getAttribute("data-cvref");
            openCVFromModel(byRef(ref));
          }else if(playBtn){
            const ref=playBtn.getAttribute("data-vref");
            const m=byRef(ref);
            if(m)openVideoForModel(m);
          }
        });
        qs("#dmOpenCV").addEventListener("click",()=>{
          const m=byRef(currentRef);
          if(m)openCVFromModel(m);
        });
        qs("#dmOpenVideo").addEventListener("click",()=>{
          const m=byRef(currentRef);
          if(m)openVideoForModel(m);
        });
        qs("#dmPrev").addEventListener("click",()=>openSiblingDetail(-1));
        qs("#dmNext").addEventListener("click",()=>openSiblingDetail(1));
        qs("#cvPrev").addEventListener("click",()=>openSiblingCV(-1));
        qs("#cvNext").addEventListener("click",()=>openSiblingCV(1));
        const vid=qs("#pv");
        const vPlay=qs("#vPlay");
        const vBack=qs("#vBack");
        const vFwd=qs("#vFwd");
        const vRate=qs("#vRate");
        const vVol=qs("#vVol");
        const vMute=qs("#vMute");
        const vPip=qs("#vPip");
        const vPrevCandidate=qs("#vPrevCandidate");
        const vNextCandidate=qs("#vNextCandidate");
        vPlay.addEventListener("click",()=>{
          if(vid.paused){vid.play()}else{vid.pause()}
        });
        vid.addEventListener("play",()=>{
          vPlay.querySelector("i").className="bi bi-pause-fill";
        });
        vid.addEventListener("pause",()=>{
          vPlay.querySelector("i").className="bi bi-play-fill";
        });
        vBack.addEventListener("click",()=>{
          try{vid.currentTime=Math.max(0,(vid.currentTime||0)-10)}catch(e){}
        });
        vFwd.addEventListener("click",()=>{
          try{
            const dur=isNaN(vid.duration)?0:vid.duration;
            vid.currentTime=Math.min(dur,(vid.currentTime||0)+10);
          }catch(e){}
        });
        vRate.addEventListener("change",()=>{
          const r=parseFloat(vRate.value)||1;
          vid.playbackRate=r;
        });
        vVol.addEventListener("input",()=>{
          const vol=parseFloat(vVol.value)||0;
          vid.volume=vol;
          if(vol===0){
            vid.muted=true;
            vMute.querySelector("i").className="bi bi-volume-mute";
          }else{
            vid.muted=false;
            vMute.querySelector("i").className="bi bi-volume-up";
          }
        });
        vMute.addEventListener("click",()=>{
          vid.muted=!vid.muted;
          vMute.querySelector("i").className=vid.muted?"bi bi-volume-mute":"bi bi-volume-up";
        });
        vPip.addEventListener("click",async()=>{
          if(!document.pictureInPictureEnabled||vid.disablePictureInPicture)return;
          try{
            if(document.pictureInPictureElement){
              await document.exitPictureInPicture();
            }else{
              await vid.requestPictureInPicture();
            }
          }catch(e){}
        });
        vPrevCandidate.addEventListener("click",()=>openSiblingVideo(-1));
        vNextCandidate.addEventListener("click",()=>openSiblingVideo(1));
        qs("#videoModal").addEventListener("hidden.bs.modal",()=>{
          try{
            vid.pause();
            vid.removeAttribute("src");
            vid.load();
          }catch(e){}
        });
        document.addEventListener("hidden.bs.modal",()=>{
          if(!document.querySelector(".modal.show")){
            document.querySelectorAll(".modal-backdrop").forEach(el=>el.remove());
            document.body.classList.remove("modal-open");
            document.body.style.removeProperty("overflow");
            document.body.style.removeProperty("paddingRight");
          }
        });
        document.addEventListener("hidden.bs.offcanvas",()=>{
          if(!document.querySelector(".offcanvas.show")){
            document.querySelectorAll(".offcanvas-backdrop").forEach(el=>el.remove());
            document.body.style.removeProperty("overflow");
          }
        });
        qs("#dmPhoto").addEventListener("click",()=>{
          const src=qs("#dmPhoto").src;
          if(src)openImageModal(src,qs("#infoTitle").textContent);
        });
        qs("#cvBody").addEventListener("click",e=>{
          const img=e.target.closest(".cv-pic,.cv-fullbody");
          if(img&&img.src)openImageModal(img.src,qs("#cvTitle").textContent);
        });
        if(state.onboarded){
          switchScreen("#s3");
        }else{
          switchScreen("#s1");
        }
        fetchItems(true);
      });
    </script>
  </body>
</html>
