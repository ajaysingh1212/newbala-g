@php
    $currentStatus = old('payment_status', $booking->payment_status ?? '');
@endphp
<div class="bw-panel" data-panel="4">
    <div class="bw-card">
        <div class="bw-card-eyebrow">Step 04</div>
        <div class="bw-card-title"><i class="fas fa-credit-card"></i> Payment Status</div>
        <p class="bw-card-subtitle">Mark whether the payment is already confirmed or still pending.</p>

        <input type="hidden" id="payment_status" name="payment_status" value="{{ $currentStatus }}">

        <div class="bw-status-options">
            <div class="bw-status-card {{ $currentStatus === 'confirmed' ? 'selected' : '' }}" data-status="confirmed" onclick="bwSelectPaymentStatus('confirmed')">
                <span class="check"><i class="fas fa-check"></i></span>
                <i class="fas fa-check-circle"></i>
                <div class="title">Confirmed</div>
            </div>
            <div class="bw-status-card {{ $currentStatus === 'pending' ? 'selected' : '' }}" data-status="pending" onclick="bwSelectPaymentStatus('pending')">
                <span class="check"><i class="fas fa-check"></i></span>
                <i class="fas fa-clock"></i>
                <div class="title">Pending</div>
            </div>
        </div>
        @error('payment_status')
            <span class="invalid-feedback d-block mb-3">{{ $message }}</span>
        @enderror

        <div id="paymentFields" style="display: {{ $currentStatus === 'confirmed' ? 'block' : 'none' }}; margin-top: 20px;">
            <div class="bw-field">
                <label for="payment_screenshot">Payment Screenshot</label>

                @if(isset($booking) && $booking->payment_screenshot)
                    <div class="bw-existing-file">
                        <i class="fas fa-file-image"></i>
                        <a href="{{ Storage::url($booking->payment_screenshot) }}" target="_blank" style="color:#047857;">View current screenshot</a>
                    </div>
                @endif

                <label class="bw-upload-zone" for="payment_screenshot" id="uploadZone">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <div>Click to {{ isset($booking) && $booking->payment_screenshot ? 'replace' : 'upload' }} payment screenshot</div>
                    <div class="file-name" id="fileNameDisplay"></div>
                </label>
                <input type="file" class="@error('payment_screenshot') is-invalid @enderror"
                    id="payment_screenshot" name="payment_screenshot" accept="image/*">
                <small class="form-text text-muted">Optional — leave empty to keep the existing screenshot.</small>
                @error('payment_screenshot')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="bw-field">
                <label for="ref_utr">Reference / UTR</label>
                <input type="text" class="form-control @error('ref_utr') is-invalid @enderror"
                    id="ref_utr" name="ref_utr" placeholder="Enter transaction reference or UTR"
                    value="{{ old('ref_utr', $booking->ref_utr ?? '') }}">
                <small class="form-text text-muted">Optional — enter the transaction reference number.</small>
                @error('ref_utr')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="bw-nav">
        <button type="button" class="bw-btn bw-btn-ghost" onclick="bwGoToStep(3)">
            <i class="fas fa-arrow-left"></i> Back
        </button>
        <button type="submit" class="bw-btn bw-btn-success">
            <i class="fas fa-save"></i> {{ isset($booking) ? 'Update Booking' : 'Save Booking & Generate Ticket' }}
        </button>
    </div>
</div>
