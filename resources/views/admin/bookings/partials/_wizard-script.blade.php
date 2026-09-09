<script>
// Wizard ka pura logic yahan hai — create aur edit dono pages isi file ko use karte hain.
// existingPilgrims empty hoga to ek blank pilgrim card add ho jayega (create page), warna DB se pilgrims prefill honge (edit page).
(function () {
    const bookingTypes = @json($bookingTypes);
    const existingPilgrims = @json($existingPilgrims ?? []);

    let currentStep = 1;
    let pilgrimCount = 0;
    const totalSteps = 4;
    const stepNames = ['Booking Details', 'Pilgrim Details', 'Review', 'Payment'];

    /* ---------------- Stepper / progress-bar navigation ---------------- */
    function bwUpdateStepperUI() {
        const pct = Math.round((currentStep / totalSteps) * 100);

        document.getElementById('bwStepNum').textContent = currentStep;
        document.getElementById('bwStepName').textContent = stepNames[currentStep - 1];
        document.getElementById('bwStepPct').textContent = pct + '%';
        document.getElementById('bwProgressFill').style.width = pct + '%';

        document.querySelectorAll('.bw-dot').forEach((dot) => {
            const step = parseInt(dot.dataset.step, 10);
            dot.classList.remove('active', 'completed');
            if (step < currentStep) dot.classList.add('completed');
            if (step === currentStep) dot.classList.add('active');
        });

        document.querySelectorAll('.bw-panel').forEach((panel) => {
            panel.classList.toggle('active', parseInt(panel.dataset.panel, 10) === currentStep);
        });
    }

    window.bwGoToStep = function (target) {
        if (target > currentStep && !bwValidateStep(currentStep)) return;
        if (target === 3) bwPopulateReview();
        currentStep = target;
        bwUpdateStepperUI();
        document.querySelector('.booking-wizard').scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    function bwToast(message, icon = 'warning') {
        if (window.Swal) {
            Swal.fire({ toast: true, position: 'top-end', icon, title: message, showConfirmButton: false, timer: 2800 });
        } else {
            alert(message);
        }
    }

    function bwValidateStep(step) {
        if (step === 1) {
            const ids = ['group_name', 'main_person_name', 'email', 'visiting_date', 'slot_time'];
            for (const id of ids) {
                const el = document.getElementById(id);
                if (!el.checkValidity()) {
                    el.classList.add('is-invalid');
                    el.reportValidity();
                    return false;
                }
                el.classList.remove('is-invalid');
            }
            return true;
        }

        if (step === 2) {
            const cards = document.querySelectorAll('.bw-pilgrim-card');
            if (cards.length === 0) {
                bwToast('Please add at least one pilgrim');
                return false;
            }
            let valid = true;
            cards.forEach((card) => {
                card.querySelectorAll('input[required], select[required]').forEach((field) => {
                    if (!field.checkValidity()) {
                        field.classList.add('is-invalid');
                        valid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
            });
            if (!valid) bwToast('Please fill all required pilgrim fields');
            return valid;
        }

        if (step === 4) {
            const status = document.getElementById('payment_status').value;
            if (!status) {
                bwToast('Please select a payment status');
                return false;
            }
            const hasExistingScreenshot = document.querySelector('.bw-existing-file') !== null;
            const fileInput = document.getElementById('payment_screenshot');
            if (status === 'confirmed' && !hasExistingScreenshot && fileInput.files.length === 0) {
                bwToast('Please upload a payment screenshot');
                return false;
            }
        }

        return true;
    }

    function bwPopulateReview() {
        document.getElementById('reviewGroupName').textContent = document.getElementById('group_name').value || '—';
        document.getElementById('reviewMainPerson').textContent = document.getElementById('main_person_name').value || '—';
        document.getElementById('reviewDate').textContent = document.getElementById('visiting_date').value || '—';
        document.getElementById('reviewSlot').textContent = document.getElementById('slot_time').value || '—';
    }

    /* ---------------- Payment status cards ---------------- */
    window.bwSelectPaymentStatus = function (status) {
        document.getElementById('payment_status').value = status;
        document.querySelectorAll('.bw-status-card').forEach((c) => {
            c.classList.toggle('selected', c.dataset.status === status);
        });
        const fields = document.getElementById('paymentFields');
        const screenshot = document.getElementById('payment_screenshot');
        if (status === 'confirmed') {
            fields.style.display = 'block';
        } else {
            fields.style.display = 'none';
            screenshot.value = '';
            document.getElementById('fileNameDisplay').textContent = '';
        }
    };

    /* ---------------- Pilgrim cards ---------------- */
    function bwBookingTypeOptions(selectedId) {
        return bookingTypes.map((type) => {
            const sel = String(type.id) === String(selectedId) ? 'selected' : '';
            return `<option value="${type.id}" data-amount="${type.amount}" data-description="${(type.description || '').replace(/"/g, '&quot;')}" ${sel}>${type.title} (₹${parseFloat(type.amount).toFixed(2)})</option>`;
        }).join('');
    }

    window.addPilgrim = function (existing) {
        pilgrimCount++;
        const p = existing || {};
        const idField = p.id ? `<input type="hidden" name="pilgrims[${pilgrimCount}][id]" value="${p.id}">` : '';

        const html = `
            <div class="bw-pilgrim-card" id="pilgrim-${pilgrimCount}">
                ${idField}
                <div class="bw-pilgrim-head">
                    <span class="bw-pilgrim-badge"><span class="num">${pilgrimCount}</span> Pilgrim Details</span>
                    <button type="button" class="bw-remove-btn" onclick="removePilgrim(${pilgrimCount})" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="bw-field">
                            <label>Name <span class="req">*</span></label>
                            <input type="text" class="form-control pilgrim-name" name="pilgrims[${pilgrimCount}][name]" placeholder="Enter pilgrim name" value="${p.name || ''}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bw-field">
                            <label>Age <span class="req">*</span></label>
                            <input type="number" class="form-control" name="pilgrims[${pilgrimCount}][age]" min="1" max="120" placeholder="Age" value="${p.age || ''}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bw-field">
                            <label>Gender <span class="req">*</span></label>
                            <select class="form-control" name="pilgrims[${pilgrimCount}][gender]" required>
                                <option value="">Select</option>
                                <option value="male" ${p.gender === 'male' ? 'selected' : ''}>Male</option>
                                <option value="female" ${p.gender === 'female' ? 'selected' : ''}>Female</option>
                                <option value="other" ${p.gender === 'other' ? 'selected' : ''}>Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="bw-field">
                            <label>Phone Number <span class="req">*</span></label>
                            <input type="text" class="form-control" name="pilgrims[${pilgrimCount}][phone_number]" placeholder="Enter phone number" value="${p.phone_number || ''}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="bw-field">
                            <label>ID Type <span class="req">*</span></label>
                            <select class="form-control" name="pilgrims[${pilgrimCount}][id_type]" required>
                                <option value="">Select</option>
                                <option value="aadhar" ${p.id_type === 'aadhar' ? 'selected' : ''}>Aadhar</option>
                                <option value="pan" ${p.id_type === 'pan' ? 'selected' : ''}>PAN</option>
                                <option value="other" ${p.id_type === 'other' ? 'selected' : ''}>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="bw-field">
                            <label>ID Number <span class="req">*</span></label>
                            <input type="text" class="form-control" name="pilgrims[${pilgrimCount}][id_number]" placeholder="Enter ID number" value="${p.id_number || ''}" required>
                        </div>
                    </div>
                </div>

                <div class="bw-field mb-0">
                    <label>Booking Type <span class="req">*</span></label>
                    <select class="form-control pilgrim-booking-type" name="pilgrims[${pilgrimCount}][booking_type_id]" onchange="bwOnBookingTypeChange(this)" required>
                        <option value="">Select Booking Type</option>
                        ${bwBookingTypeOptions(p.booking_type_id)}
                    </select>
                    <div class="bw-type-desc"></div>
                </div>
            </div>
        `;

        document.getElementById('pilgrimsContainer').insertAdjacentHTML('beforeend', html);

        if (p.booking_type_id) {
            const select = document.querySelector(`#pilgrim-${pilgrimCount} .pilgrim-booking-type`);
            bwOnBookingTypeChange(select);
        }
    };

    window.removePilgrim = function (id) {
        const el = document.getElementById('pilgrim-' + id);
        if (!el) return;
        el.classList.add('removing');
        setTimeout(() => {
            el.remove();
            updateTotal();
        }, 220);
    };

    window.bwOnBookingTypeChange = function (select) {
        const wrapper = select.closest('.bw-field').querySelector('.bw-type-desc');
        const opt = select.options[select.selectedIndex];
        const desc = opt ? opt.getAttribute('data-description') : '';
        if (desc) {
            wrapper.textContent = desc;
            wrapper.classList.add('show');
        } else {
            wrapper.classList.remove('show');
            wrapper.textContent = '';
        }
        updateTotal();
    };

    window.updateTotal = function () {
        let total = 0;
        let details = '';

        document.querySelectorAll('.pilgrim-booking-type').forEach((select, index) => {
            const opt = select.options[select.selectedIndex];
            if (opt && opt.value) {
                const amount = parseFloat(opt.getAttribute('data-amount'));
                const name = select.closest('.bw-pilgrim-card').querySelector('.pilgrim-name').value || `Pilgrim ${index + 1}`;
                total += amount;
                details += `<div class="row-line"><span>${name}</span><span>₹${amount.toFixed(2)}</span></div>`;
            }
        });

        document.getElementById('totalAmount').textContent = total.toFixed(2);
        document.getElementById('totalAmountDetails').innerHTML = details || '<p class="mb-0" style="opacity:0.85;">No pilgrims added yet</p>';
    };

    /* ---------------- Upload zone filename preview ---------------- */
    document.addEventListener('change', function (e) {
        if (e.target && e.target.id === 'payment_screenshot') {
            const display = document.getElementById('fileNameDisplay');
            display.textContent = e.target.files.length ? e.target.files[0].name : '';
        }
    });

    document.getElementById('addPilgrimBtn').addEventListener('click', () => addPilgrim());

    document.getElementById('bookingForm').addEventListener('submit', (e) => {
        if (!bwValidateStep(4)) {
            e.preventDefault();
        }
    });

    window.addEventListener('DOMContentLoaded', () => {
        if (existingPilgrims && existingPilgrims.length) {
            existingPilgrims.forEach((p) => addPilgrim(p));
        } else {
            addPilgrim();
        }
        bwUpdateStepperUI();
    });
})();
</script>
