@extends('dashboard.master')

@section('content')
    <main class="page-content">

        @php
            $user = $user ?? auth()->user();
            $profile = $profile ?? ($user->profile ?? null);

            $fallback = asset('dashboard/assets/images/avatars/avatar-1.png');

            $avatar = $profile?->image ? asset('storage/' . $profile->image) : $fallback;
        @endphp

        <div class="container-fluid">

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                    <h4 class="mb-0">My Profile</h4>
                    <small class="text-muted">Your account & profile details</small>
                </div>

                @if (!$editMode)
                    <a href="{{ route('dash.profile.view', ['edit' => 1]) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>
                @endif
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form id="profileForm" method="POST" action="{{ route('dash.profile.update') }}" enctype="multipart/form-data">
                @csrf
             

                <div class="row g-3">
                    <div class="col-12">
                        <div class="card prof-card">
                            <div class="card-header bg-white">
                                <strong>Profile Details</strong>
                            </div>

                            <div class="card-body">

                                {{-- Avatar --}}
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ $avatar }}" class="prof-avatar js-avatar-preview"
                                            alt="User Avatar" onerror="this.onerror=null;this.src='{{ $fallback }}';">

                                        @if ($editMode)
                                            <label for="avatarInput" class="avatar-edit-btn" title="Change photo">
                                                <i class="bi bi-camera-fill"></i>
                                            </label>
                                            
                                            <input type="file" id="avatarInput" name="image" class="d-none"
                                                accept="image/*">
                                        @endif
                                    </div>


                                </div>

                                {{-- Fields --}}
                                <div class="row g-3">

                                    {{-- Name --}}
                                    <div class="col-12 col-md-6">
                                        <div class="prof-field">
                                            <div class="prof-label">Name</div>
                                            @if ($editMode)
                                                <input name="name" value="{{ old('name', $user->name) }}"
                                                    class="form-control @error('name') is-invalid @enderror">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            @else
                                                <div class="prof-value">{{ $user->name }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-12 col-md-6">
                                        <div class="prof-field">
                                            <div class="prof-label">Email</div>
                                            @if ($editMode)
                                                <input name="email" value="{{ old('email', $user->email) }}"
                                                    class="form-control @error('email') is-invalid @enderror">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            @else
                                                <div class="prof-value">{{ $user->email }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Phone --}}
                                    <div class="col-12 col-md-6">
                                        <div class="prof-field">
                                            <div class="prof-label">Phone</div>
                                            @if ($editMode)
                                                <input name="phone" value="{{ old('phone', $user->phone) }}"
                                                    class="form-control @error('phone') is-invalid @enderror">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            @else
                                                <div class="prof-value">{{ $user->phone ?? '-' }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Gender --}}
                                    <div class="col-12 col-md-6">
                                        <div class="prof-field">
                                            <div class="prof-label">Gender</div>
                                            @if ($editMode)
                                                <select name="gender"
                                                    class="form-select @error('gender') is-invalid @enderror">
                                                    <option value="">--</option>
                                                    <option value="m"
                                                        {{ old('gender', $user->gender) === 'm' ? 'selected' : '' }}>Male
                                                    </option>
                                                    <option value="fm"
                                                        {{ old('gender', $user->gender) === 'fm' ? 'selected' : '' }}>
                                                        Female</option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            @else
                                                <div class="prof-value">
                                                    @if ($user->gender === 'm')
                                                        Male
                                                    @elseif($user->gender === 'fm')
                                                        Female
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Date of Birth (users) --}}
                                    <div class="col-12 col-md-6">
                                        <div class="prof-field">
                                            <div class="prof-label">Date of Birth</div>
                                            @if ($editMode)
                                                <input type="date" name="date_of_birth"
                                                    value="{{ old('date_of_birth', $user->date_of_birth) }}"
                                                    class="form-control @error('date_of_birth') is-invalid @enderror">
                                                @error('date_of_birth')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            @else
                                                <div class="prof-value">{{ $user->date_of_birth ?? '-' }}</div>
                                            @endif
                                        </div>
                                    </div>



                                    {{-- City --}}
                                    <div class="col-12 col-md-6">
                                        <div class="prof-field">
                                            <div class="prof-label">City</div>
                                            @if ($editMode)
                                                <input name="city" value="{{ old('city', $profile?->city) }}"
                                                    class="form-control @error('city') is-invalid @enderror">
                                                @error('city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            @else
                                                <div class="prof-value">{{ $profile?->city ?? '-' }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Address --}}
                                    <div class="col-12 col-md-12">
                                        <div class="prof-field">
                                            <div class="prof-label">Address</div>
                                            @if ($editMode)
                                                <input name="address" value="{{ old('address', $profile?->address) }}"
                                                    class="form-control @error('address') is-invalid @enderror">
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            @else
                                                <div class="prof-value">{{ $profile?->address ?? '-' }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Bio --}}
                                    <div class="col-12">
                                        <div class="prof-field">
                                            <div class="prof-label">Bio</div>
                                            @if ($editMode)
                                                <textarea name="bio" rows="4" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $profile?->bio) }}</textarea>
                                                @error('bio')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            @else
                                                <div class="prof-value prof-bio">{{ $profile?->bio ?? '-' }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if ($editMode)
                                    <div class="d-flex justify-content-between align-items-center mt-4">

                                        <a href="{{ route('dash.profile.view') }}"
                                            class="btn btn-outline-secondary px-4 rounded-3">
                                            <i class="bi bi-arrow-left me-1"></i> Cancel
                                        </a>

                                        <button type="submit" class="btn btn-success px-4 rounded-3">
                                            <i class="bi bi-check2 me-1"></i> Save Changes
                                        </button>

                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </main>
@endsection



<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('avatarInput');
        if (!input) return;

        const previews = document.querySelectorAll('.js-avatar-preview');
        if (!previews.length) return;

        // خزن الصورة القديمة عشان زر Cancel يرجعها (اختياري)
        previews.forEach(img => img.dataset.oldsrc = img.getAttribute('src'));

        input.addEventListener('change', (e) => {
            const file = e.target.files && e.target.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('Please choose an image file');
                input.value = '';
                return;
            }

            // ✅ بدّل القديمة مباشرة
            const url = URL.createObjectURL(file);
            previews.forEach(img => img.src = url);

            // تنظيف
            previews[0].onload = () => URL.revokeObjectURL(url);
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('successAlert');
        if (!alert) return;

        // ⏱️ المدة (3 ثواني)
        setTimeout(() => {
            alert.style.transition = 'opacity 0.6s ease';
            alert.style.opacity = '0';

            setTimeout(() => {
                alert.remove();
            }, 600);
        }, 3000);
    });

    
</script>
