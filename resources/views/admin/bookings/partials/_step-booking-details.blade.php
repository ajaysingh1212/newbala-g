<div class="bw-panel active" data-panel="1">
    <div class="bw-card">
        <div class="bw-card-eyebrow">Step 01</div>
        <div class="bw-card-title"><i class="fas fa-info-circle"></i> Booking Details</div>
        <p class="bw-card-subtitle">Basic details about the group and the visit.</p>

        <div class="row">
            <div class="col-md-6">
                <div class="bw-field">
                    <label for="group_name">Group Name <span class="req">*</span></label>
                    <input type="text" class="form-control @error('group_name') is-invalid @enderror"
                        id="group_name" name="group_name" placeholder="Enter group name"
                        value="{{ old('group_name', $booking->group_name ?? '') }}" required>
                    @error('group_name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="bw-field">
                    <label for="main_person_name">Main Person Name <span class="req">*</span></label>
                    <input type="text" class="form-control @error('main_person_name') is-invalid @enderror"
                        id="main_person_name" name="main_person_name" placeholder="Enter main person name"
                        value="{{ old('main_person_name', $booking->main_person_name ?? '') }}" required>
                    @error('main_person_name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="bw-field">
                    <label for="email">Email for Ticket </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" name="email" placeholder="Enter email"
                        value="{{ old('email', $booking->email ?? '') }}" >
                    @error('email')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="bw-field">
                    <label for="visiting_date">Visiting Date <span class="req">*</span></label>
                    <input type="date" class="form-control @error('visiting_date') is-invalid @enderror"
                        id="visiting_date" name="visiting_date"
                        value="{{ old('visiting_date', isset($booking) ? \Carbon\Carbon::parse($booking->visiting_date)->format('Y-m-d') : '') }}" required>
                    @error('visiting_date')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="bw-field">
            <label for="slot_time">Slot / Time <span class="req">*</span></label>
            <input type="text" class="form-control @error('slot_time') is-invalid @enderror"
                id="slot_time" name="slot_time" placeholder="E.g., 10:00 AM - 12:00 PM"
                value="{{ old('slot_time', $booking->slot_time ?? '') }}" required>
            @error('slot_time')
                <span class="invalid-feedback d-block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="bw-nav">
        <span></span>
        <button type="button" class="bw-btn bw-btn-primary" onclick="bwGoToStep(2)">
            Next: Pilgrim Details <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>
