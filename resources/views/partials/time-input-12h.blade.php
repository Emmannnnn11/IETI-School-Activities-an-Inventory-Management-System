@php
    $fieldName = $fieldName ?? $name;
    $initial = old($fieldName, $value ?? '');
    $isRequired = !isset($required) || $required;
@endphp
<div class="time-input-12h" data-time-12h>
    <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ $initial }}">
    <div class="d-flex flex-wrap align-items-center gap-2">
        <select id="{{ $id }}_hour" class="form-select @error($fieldName) is-invalid @enderror time-12h-hour"
            style="max-width: 4.75rem;" aria-label="Hour" @if($isRequired) required @endif></select>
        <span class="text-muted user-select-none">:</span>
        <select class="form-select @error($fieldName) is-invalid @enderror time-12h-minute"
            style="max-width: 4.75rem;" aria-label="Minute" @if($isRequired) required @endif></select>
        <select class="form-select @error($fieldName) is-invalid @enderror time-12h-ampm"
            style="max-width: 5rem;" aria-label="AM or PM" @if($isRequired) required @endif>
            <option value="AM">AM</option>
            <option value="PM">PM</option>
        </select>
    </div>
    @error($fieldName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

@once
<script>
(function () {
    if (window.__initTimeInputs12h) return;
    window.__initTimeInputs12h = true;

    function pad2(n) { return String(n).padStart(2, '0'); }

    function parseTo24(hour12, minute, ampm) {
        var h = parseInt(hour12, 10);
        var m = parseInt(minute, 10);
        if (Number.isNaN(h) || Number.isNaN(m)) return '';
        if (ampm === 'AM') {
            if (h === 12) h = 0;
        } else {
            if (h !== 12) h += 12;
        }
        return pad2(h) + ':' + pad2(m);
    }

    function parseFrom24(hhmm) {
        var s = String(hhmm || '').trim();
        if (!s) return null;
        var parts = s.split(':');
        var hh = parseInt(parts[0], 10);
        var mm = parseInt(parts[1] !== undefined ? parts[1] : '0', 10);
        if (Number.isNaN(hh) || Number.isNaN(mm)) return null;
        var ap = hh >= 12 ? 'PM' : 'AM';
        var h12 = hh % 12;
        if (h12 === 0) h12 = 12;
        return { h: h12, m: mm, ap: ap };
    }

    function fillHours(sel) {
        if (sel.options.length) return;
        var o0 = document.createElement('option');
        o0.value = '';
        o0.textContent = '—';
        sel.appendChild(o0);
        for (var i = 1; i <= 12; i++) {
            var o = document.createElement('option');
            o.value = String(i);
            o.textContent = String(i);
            sel.appendChild(o);
        }
    }

    function fillMinutes(sel) {
        if (sel.options.length) return;
        var o0 = document.createElement('option');
        o0.value = '';
        o0.textContent = '—';
        sel.appendChild(o0);
        for (var i = 0; i < 60; i++) {
            var o = document.createElement('option');
            var v = pad2(i);
            o.value = v;
            o.textContent = v;
            sel.appendChild(o);
        }
    }

    function syncToHidden(root) {
        var hidden = root.querySelector('input[type="hidden"]');
        var hour = root.querySelector('.time-12h-hour');
        var minute = root.querySelector('.time-12h-minute');
        var ampm = root.querySelector('.time-12h-ampm');
        if (!hour.value || minute.value === '') {
            hidden.value = '';
        } else {
            hidden.value = parseTo24(hour.value, minute.value, ampm.value);
        }
        hidden.dispatchEvent(new Event('input', { bubbles: true }));
        hidden.dispatchEvent(new Event('change', { bubbles: true }));
    }

    function syncFromHidden(root) {
        var hidden = root.querySelector('input[type="hidden"]');
        var hour = root.querySelector('.time-12h-hour');
        var minute = root.querySelector('.time-12h-minute');
        var ampm = root.querySelector('.time-12h-ampm');
        var p = parseFrom24(hidden.value);
        if (!p) {
            hour.value = '';
            minute.value = '';
            ampm.value = 'AM';
            return;
        }
        hour.value = String(p.h);
        minute.value = pad2(p.m);
        ampm.value = p.ap;
    }

    function initRoot(root) {
        var hour = root.querySelector('.time-12h-hour');
        var minute = root.querySelector('.time-12h-minute');
        var ampm = root.querySelector('.time-12h-ampm');
        fillHours(hour);
        fillMinutes(minute);
        syncFromHidden(root);
        [hour, minute, ampm].forEach(function (el) {
            el.addEventListener('change', function () { syncToHidden(root); });
        });
        syncToHidden(root);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-time-12h]').forEach(initRoot);
    });
})();
</script>
@endonce
