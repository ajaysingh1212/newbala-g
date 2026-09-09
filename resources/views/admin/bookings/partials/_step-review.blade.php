<div class="bw-panel" data-panel="3">
    <div class="bw-card">
        <div class="bw-card-eyebrow">Step 03</div>
        <div class="bw-card-title"><i class="fas fa-receipt"></i> Review Booking</div>
        <p class="bw-card-subtitle">Double-check the details before moving to payment.</p>

        <div class="bw-review-grid">
            <div class="bw-review-item">
                <div class="label">Group Name</div>
                <div class="value" id="reviewGroupName">—</div>
            </div>
            <div class="bw-review-item">
                <div class="label">Main Person</div>
                <div class="value" id="reviewMainPerson">—</div>
            </div>
            <div class="bw-review-item">
                <div class="label">Visiting Date</div>
                <div class="value" id="reviewDate">—</div>
            </div>
            <div class="bw-review-item">
                <div class="label">Slot / Time</div>
                <div class="value" id="reviewSlot">—</div>
            </div>
        </div>

        <div class="bw-total-card">
            <div id="totalAmountDetails">
                <p class="mb-0" style="opacity:0.85;">No pilgrims added yet</p>
            </div>
            <div class="grand">
                <span class="label">Total Amount</span>
                <span class="amt">₹ <span id="totalAmount">0.00</span></span>
            </div>
        </div>
    </div>

    <div class="bw-nav">
        <button type="button" class="bw-btn bw-btn-ghost" onclick="bwGoToStep(2)">
            <i class="fas fa-arrow-left"></i> Back
        </button>
        <button type="button" class="bw-btn bw-btn-primary" onclick="bwGoToStep(4)">
            Next: Payment <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>
