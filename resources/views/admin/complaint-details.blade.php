<!-- نموذج تغيير الحالة -->
<form action="{{ route('complaints.updateStatus', $complaint->id) }}" method="POST" class="mb-3">
    @csrf
    <div class="card">
        <div class="card-header">
            <h5>Status Bijwerken</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="status" class="form-label">Nieuwe Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="new" {{ $complaint->status == 'new' ? 'selected' : '' }}>Ontvangen</option>
                        <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>In Behandeling</option>
                        <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Opgelost</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label for="message" class="form-label">Bericht aan klager (optioneel)</label>
                    <textarea name="message" id="message" class="form-control" rows="2" 
                              placeholder="Optionele toelichting voor de klager..."></textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sync-alt"></i> Status Bijwerken en Notificeren
                </button>
            </div>
        </div>
    </div>
</form>

<!-- نموذج إرسال رسالة مخصصة -->
<form action="{{ route('complaints.sendMessage', $complaint->id) }}" method="POST" class="mb-3">
    @csrf
    <div class="card">
        <div class="card-header">
            <h5>Bericht Sturen naar Klager</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="customMessage" class="form-label">Bericht</label>
                <textarea name="message" id="customMessage" class="form-control" rows="4" 
                          placeholder="Typ hier uw bericht aan de klager..." required></textarea>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-paper-plane"></i> Bericht Verzenden
            </button>
        </div>
    </div>
</form>