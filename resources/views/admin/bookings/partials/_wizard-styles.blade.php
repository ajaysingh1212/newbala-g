<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ============ Scoped tokens — VIP Darshan ticket theme ============ */
.booking-wizard {
    --ink: #1B1B3A;
    --ink-2: #2E2A5C;
    --gold: #D4AF37;
    --gold-light: #F1D889;
    --gold-deep: #B8912A;
    --page: #F4F2FA;
    --paper: #FFFFFF;
    --paper-soft: #FAFAFD;
    --line: #E4E1F2;
    --text: #1F1B3A;
    --muted: #6B6A85;
    --success: #157F4B;
    --success-bg: #E9F7EF;
    --danger: #C0392B;
    --danger-bg: #FDEDEB;

    font-family: 'Inter', -apple-system, sans-serif;
    color: var(--text);
    background: var(--page);
    border-radius: 22px;
    padding: 26px;
}

.booking-wizard h1, .booking-wizard h2, .booking-wizard h3,
.booking-wizard h4, .booking-wizard h5, .booking-wizard .bw-heading,
.booking-wizard .bw-card-title, .booking-wizard .bw-progress-title {
    font-family: 'Fraunces', Georgia, serif;
    color: var(--text);
}

/* ============ Progress card (ticket header) ============ */
.bw-progress-card {
    background: linear-gradient(135deg, var(--ink) 0%, var(--ink-2) 100%);
    border-radius: 20px;
    padding: 30px 32px 0;
    color: #fff;
    max-width: 860px;
    margin: 0 auto 26px;
    position: relative;
    overflow: hidden;
}

.bw-progress-card::before {
    content: '';
    position: absolute;
    top: -60px;
    right: -60px;
    width: 220px;
    height: 220px;
    background: radial-gradient(circle, rgba(212,175,55,0.18) 0%, transparent 70%);
}

.bw-progress-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 22px;
    position: relative;
    z-index: 1;
}

.bw-progress-eyebrow {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.6px;
    color: var(--gold-light);
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 8px;
}

.bw-progress-eyebrow i { color: var(--gold); }

.bw-progress-title {
    font-size: 19px;
    font-weight: 600;
    color: #fff;
}

.bw-progress-title span { color: var(--gold-light); }

.bw-progress-pct {
    font-family: 'Fraunces', serif;
    font-size: 30px;
    font-weight: 700;
    color: var(--gold-light);
    line-height: 1;
    text-align: right;
}

.bw-progress-pct small {
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    font-weight: 600;
    color: rgba(255,255,255,0.55);
    display: block;
    margin-top: 2px;
    letter-spacing: 0.4px;
}

.bw-progress-track {
    height: 6px;
    background: rgba(255,255,255,0.14);
    border-radius: 999px;
    overflow: hidden;
    position: relative;
    z-index: 1;
}

.bw-progress-fill {
    height: 100%;
    width: 25%;
    background: linear-gradient(90deg, var(--gold-deep), var(--gold-light));
    border-radius: 999px;
    transition: width 0.5s cubic-bezier(.4,0,.2,1);
}

.bw-progress-dots {
    display: flex;
    justify-content: space-between;
    margin-top: 16px;
    padding-bottom: 22px;
    position: relative;
    z-index: 1;
}

.bw-dot {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 7px;
    flex: 1;
}

.bw-dot .dot-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    border: 1.5px solid rgba(255,255,255,0.28);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12.5px;
    font-weight: 700;
    color: rgba(255,255,255,0.6);
    transition: all 0.3s ease;
}

.bw-dot .dot-label {
    font-size: 11.5px;
    font-weight: 600;
    color: rgba(255,255,255,0.5);
    text-align: center;
    transition: color 0.3s ease;
}

.bw-dot.active .dot-circle {
    background: linear-gradient(135deg, var(--gold-light), var(--gold-deep));
    border-color: transparent;
    color: var(--ink);
    box-shadow: 0 0 0 5px rgba(212,175,55,0.18);
}

.bw-dot.active .dot-label { color: var(--gold-light); }

.bw-dot.completed .dot-circle {
    background: rgba(212,175,55,0.9);
    border-color: transparent;
    color: var(--ink);
}

.bw-dot.completed .dot-label { color: rgba(255,255,255,0.85); }

/* Ticket perforation strip at the bottom edge of the progress card */
.bw-progress-perforation {
    height: 16px;
    margin: 0 -32px;
    background-image: radial-gradient(circle 7px, var(--page) 7px, transparent 7.5px);
    background-size: 26px 16px;
    background-position: center;
    background-repeat: repeat-x;
}

/* ============ Step / form card ============ */
.bw-panel { display: none; }
.bw-panel.active {
    display: block;
    animation: bwPanelIn 0.4s cubic-bezier(.25,.8,.25,1);
}

@keyframes bwPanelIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.bw-card {
    background: var(--paper);
    border: 1px solid var(--line);
    border-radius: 18px;
    padding: 32px;
    box-shadow: 0 10px 34px rgba(27, 27, 58, 0.06);
    max-width: 860px;
    margin: 0 auto;
}

.bw-card-eyebrow {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    color: var(--gold-deep);
    margin-bottom: 6px;
}

.bw-card-title {
    font-size: 23px;
    font-weight: 600;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.bw-card-title i {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    background: var(--ink);
    color: var(--gold-light);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
}

.bw-card-subtitle {
    color: var(--muted);
    font-size: 13.5px;
    margin-bottom: 8px;
    padding-bottom: 20px;
    border-bottom: 1px dashed var(--line);
}

/* ============ Form fields — always light, never dark ============ */
.bw-field { margin-top: 20px; }

.bw-field label {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 6px;
    display: block;
    letter-spacing: 0.2px;
}

.bw-field label .req { color: var(--gold-deep); }

.bw-field .form-control,
.bw-field .form-control:focus {
    background: var(--paper-soft) !important;
    color: var(--text) !important;
    border: 1.5px solid var(--line);
    border-radius: 10px;
    padding: 11px 14px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    box-shadow: none;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.bw-field .form-control:focus {
    border-color: var(--gold-deep);
    box-shadow: 0 0 0 3px rgba(212,175,55,0.18);
}

.bw-field .form-control.is-invalid { border-color: var(--danger); }
.bw-field .form-control::placeholder { color: #A7A5BE; }

/* ============ Pilgrim cards — styled as ticket stubs ============ */
.bw-pilgrim-card {
    background: var(--paper-soft);
    border: 1.5px dashed var(--line);
    border-radius: 14px;
    padding: 22px 22px 22px 30px;
    margin-top: 20px;
    position: relative;
    animation: bwCardIn 0.35s cubic-bezier(.25,.8,.25,1);
}

.bw-pilgrim-card::before {
    content: '';
    position: absolute;
    left: -9px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--page);
    border: 1.5px dashed var(--line);
}

@keyframes bwCardIn {
    from { opacity: 0; transform: translateY(-8px) scale(0.985); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.bw-pilgrim-card.removing { animation: bwCardOut 0.22s ease forwards; }

@keyframes bwCardOut {
    to { opacity: 0; transform: scale(0.96); max-height: 0; padding: 0; margin: 0; }
}

.bw-pilgrim-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 4px;
}

.bw-pilgrim-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    font-family: 'Fraunces', serif;
    color: var(--ink);
    font-size: 15.5px;
}

.bw-pilgrim-badge .num {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: var(--ink);
    color: var(--gold-light);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-family: 'Inter', sans-serif;
    font-weight: 700;
}

.bw-remove-btn {
    border: none;
    background: var(--danger-bg);
    color: var(--danger);
    width: 30px;
    height: 30px;
    border-radius: 8px;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease;
}

.bw-remove-btn:hover { background: #FADBD8; }

/* Booking type description */
.bw-type-desc {
    margin-top: 10px;
    padding: 12px 14px;
    background: #FBF6E9;
    border-left: 3px solid var(--gold-deep);
    border-radius: 8px;
    font-size: 13px;
    color: #6B5416;
    display: none;
}

.bw-type-desc.show { display: block; animation: bwFadeIn 0.3s ease; }

@keyframes bwFadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
}

.bw-add-pilgrim-btn {
    background: var(--paper);
    border: 1.5px dashed var(--gold-deep);
    color: var(--gold-deep);
    font-weight: 700;
    font-size: 13.5px;
    border-radius: 12px;
    padding: 13px;
    width: 100%;
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.bw-add-pilgrim-btn:hover { background: #FBF6E9; }

/* ============ Review step — printed ticket look ============ */
.bw-review-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 14px;
    margin-top: 20px;
    margin-bottom: 24px;
}

.bw-review-item {
    background: var(--paper-soft);
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 13px 15px;
}

.bw-review-item .label {
    font-size: 10.5px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: var(--muted);
    font-weight: 700;
}

.bw-review-item .value {
    font-size: 14.5px;
    font-weight: 600;
    margin-top: 3px;
    color: var(--text);
}

.bw-total-card {
    background: linear-gradient(135deg, var(--ink) 0%, var(--ink-2) 100%);
    border-radius: 14px;
    padding: 24px 26px;
    color: #fff;
    position: relative;
}

.bw-total-card .row-line {
    display: flex;
    justify-content: space-between;
    padding: 7px 0;
    font-size: 13.5px;
    border-bottom: 1px dashed rgba(255,255,255,0.18);
    color: rgba(255,255,255,0.85);
}

.bw-total-card .grand {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-top: 14px;
    padding-top: 14px;
    border-top: 1px solid rgba(212,175,55,0.4);
}

.bw-total-card .grand .label {
    font-family: 'Fraunces', serif;
    font-size: 14px;
    color: var(--gold-light);
    letter-spacing: 0.4px;
    text-transform: uppercase;
}

.bw-total-card .grand .amt {
    font-family: 'Fraunces', serif;
    font-size: 28px;
    font-weight: 700;
    color: #fff;
}

/* ============ Payment status cards ============ */
.bw-status-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-top: 20px;
}

.bw-status-card {
    border: 1.5px solid var(--line);
    background: var(--paper-soft);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s ease;
    position: relative;
}

.bw-status-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(27,27,58,0.08); }

.bw-status-card i { font-size: 22px; margin-bottom: 8px; display: block; color: var(--muted); }
.bw-status-card .title { font-weight: 600; font-family: 'Fraunces', serif; font-size: 15.5px; }

.bw-status-card.selected {
    border-color: var(--gold-deep);
    background: #FBF6E9;
}

.bw-status-card.selected i,
.bw-status-card.selected .title { color: var(--gold-deep); }

.bw-status-card .check {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--gold-deep);
    color: #fff;
    font-size: 11px;
    display: none;
    align-items: center;
    justify-content: center;
}

.bw-status-card.selected .check { display: flex; }

.bw-upload-zone {
    border: 1.5px dashed var(--line);
    border-radius: 12px;
    padding: 26px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s ease, background 0.2s ease;
    background: var(--paper-soft);
    display: block;
}

.bw-upload-zone:hover { border-color: var(--gold-deep); background: #FBF6E9; }
.bw-upload-zone i { font-size: 24px; color: var(--gold-deep); margin-bottom: 8px; display: block; }
.bw-upload-zone .file-name { font-size: 13px; font-weight: 600; margin-top: 8px; color: var(--gold-deep); }
.bw-upload-zone input[type="file"] { display: none; }

.bw-existing-file {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--success-bg);
    color: var(--success);
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 13px;
    margin-top: 14px;
    margin-bottom: 6px;
}

/* ============ Nav buttons ============ */
.bw-nav {
    display: flex;
    justify-content: space-between;
    max-width: 860px;
    margin: 24px auto 0;
}

.bw-btn {
    border: none;
    border-radius: 10px;
    padding: 12px 28px;
    font-weight: 700;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.bw-btn:active { transform: scale(0.97); }

.bw-btn-primary {
    background: linear-gradient(135deg, var(--gold-light), var(--gold-deep));
    color: var(--ink);
    box-shadow: 0 6px 18px rgba(184, 145, 42, 0.3);
}

.bw-btn-primary:hover { box-shadow: 0 8px 22px rgba(184, 145, 42, 0.4); color: var(--ink); }

.bw-btn-ghost {
    background: var(--paper-soft);
    color: var(--text);
    border: 1px solid var(--line);
}

.bw-btn-ghost:hover { background: #EFEDF9; color: var(--text); }

.bw-btn-success {
    background: var(--ink);
    color: var(--gold-light);
}

.bw-btn-success:hover { color: var(--gold-light); box-shadow: 0 8px 22px rgba(27,27,58,0.3); }

@media (max-width: 576px) {
    .bw-dot .dot-label { display: none; }
    .bw-status-options { grid-template-columns: 1fr; }
    .booking-wizard { padding: 14px; }
    .bw-card { padding: 20px; }
    .bw-progress-card { padding: 24px 20px 0; }
    .bw-progress-perforation { margin: 0 -20px; }
}
</style>
