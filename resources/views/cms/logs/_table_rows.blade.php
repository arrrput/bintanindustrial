@forelse($logs as $log)
<tr>
    <td class="ps-4 py-3">
        <div class="d-flex align-items-center">
            <div class="avatar-sm me-2" style="width: 30px; height: 30px; background: #eee; color: #555; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 11px;">
                {{ $log->user ? substr($log->user->name, 0, 1) : '?' }}
            </div>
            <div>
                <div class="fw-bold text-dark small">{{ $log->user->name ?? 'System' }}</div>
                <div class="text-muted" style="font-size: 10px;">{{ $log->user->email ?? '' }}</div>
            </div>
        </div>
    </td>
    <td class="py-3">
        @php
            $badgeClass = match($log->action) {
                'CREATE' => 'bg-success',
                'UPDATE' => 'bg-primary',
                'DELETE' => 'bg-danger',
                'LOGIN' => 'bg-info',
                'LOGOUT' => 'bg-secondary',
                default => 'bg-dark'
            };
        @endphp
        <span class="badge {{ $badgeClass }} rounded-pill px-2 py-1 small" style="font-size: 10px;">
            {{ $log->action }}
        </span>
    </td>
    <td class="py-3 small fw-bold text-dark">{{ $log->module }}</td>
    <td class="py-3 text-muted small">{{ $log->description }}</td>
    <td class="py-3 text-muted small">{{ $log->ip_address }}</td>
    <td class="py-3 text-muted small">{{ $log->created_at->format('M d, Y H:i:s') }}</td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center py-5 text-muted">No activities recorded yet.</td>
</tr>
@endforelse
